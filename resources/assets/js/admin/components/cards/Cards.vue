<template>
    <table class="cards">
        <thead>
            <tr>
                <th class="id">ID</th>
                <th class="route">Smjer</th>
                <th class="crag">Penjaliste</th>
                <th class="grade">Ocjena</th>
                <th class="style">Nacin</th>
                <th class="comment">Komentar</th>
                <th class="climbed_at">Datum</th>
                <th class="actions">Akcije</th>
            </tr>
        </thead>
        <tbody>
            <tr class="item" v-for="card in $store.state.cards" :key="card.id">
                <td class="id">
                    <span>{{card.id}}</span>
                </td>
                <td class="route">
                    <input v-if="card.editmode" v-model="card.route"/>
                    <span v-else>{{card.route}}</span>
                    <span v-if="card.errors.route" class="error">{{card.errors.route}}</span>
                </td>
                <td class="crag">
                    <input v-if="card.editmode" v-model="card.crag"/>
                    <span v-else>{{card.crag}}</span>
                    <span v-if="card.errors.crag" class="error">{{card.errors.crag}}</span>
                </td>
                <td class="grade">
                    <select v-if="card.editmode" v-model="card.grade">
                        <option v-for="grade in grades" :key="grade">{{ grade }}</option>
                    </select>
                    <span v-else>{{card.grade}}</span>
                    <span v-if="card.errors.grade" class="error">{{card.errors.grade}}</span>
                </td>
                <td class="style">
                    <select v-if="card.editmode" v-model="card.style">
                        <option value="red point">Red Point</option>
                        <option value="flash">Flash</option>
                        <option value="on sight">On Sight</option>
                    </select>
                    <span v-else :class="card.style.replace(' ','')">{{card.style}}</span>
                </td>
                <td class="comment">
                    <textarea v-if="card.editmode" v-model="card.comment"/>
                    <span v-else>{{card.comment}}</span>
                </td>
                <td class="climbed_at">
                    <input v-if="card.editmode" type="date" v-model="card.climbed_at"/>
                    <span v-else>{{card.climbed_at}}</span>
                    <span v-if="card.errors.climbed_at" class="error">{{card.errors.climbed_at}}</span>
                </td>
                <td class="actions">
                    <i v-if="!card.editmode" class="icon-pencil" @click="_edit(card)"></i>
                    <i v-else class="icon-ok" @click="_save(card)"></i>
                    <i class="icon-trash-empty" @click="_delete(card)"></i>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import Utils from '../../../utils/Utils';

export default {
    name: 'Cards',
    data() {
        return {
            cards: [],
            grades: Utils.grades(true),
        }
    },
    mounted() {
        fetch(`${window.climbingcards.rest_url}cards/${window.climbingcards.logged_user_id}`)
            .then(response => response.json())
            .then(data => { 
                let cards = data.data.cards.map((card) => {
                    card.errors = {};

                    return card;
                })
                this.$store.commit("setCards", this.$store.state.cards = cards);
            })
            .catch(error => console.log(error))
    },
    methods: {
        /**
         * Set edit mode so user can edit card.
         * 
         * @return {Void}
         */
        _edit(card) {
            card.editmode = true;
        },

        /**
         * Store new card to database
         * 
         * @return {Void}
         */
        _save(card) {
            if (!this._isValid(card)) {
                return;
            }

            let update = card.id ? true : false;

            fetch(`${window.climbingcards.rest_url}cards/${card.id}`, {
                method: update ? 'PUT' : 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=UTF-8',
                    "X-WP-Nonce": window.climbingcards.nonce,
                },
                body: JSON.stringify(card),
            })
            .then(response => response.json())
            .then(data => {
                if (data.data.updated) {
                    card.editmode = false;
                } else if (data.data.created) {
                    card.id = data.data.card.id;
                    card.editmode = false;
                }
            })
            .catch(error => console.log(error));
        },

        /**
         * Delete card entry.
         * 
         * @return {Void}
         */
        _delete(card) {
            let index = this.$store.state.cards.indexOf(card);

            if (!card.id)
                return this.$store.state.cards.splice(index, 1);

            fetch(`${window.climbingcards.rest_url}cards/${card.id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json;charset=UTF-8',
                    "X-WP-Nonce": window.climbingcards.nonce,
                },
                body: JSON.stringify(card),
            })
            .then(response => response.json())
            .then(data => {
                if (data.data.deleted)
                    this.$store.state.cards.splice(index, 1);
            })
            .catch(error => console.log(error));
        },

        /**
         * Convert mysql datetime so it's readable for human.
         * 
         * @return {String}
         */
        _datetimeToHuman(datetime) {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const parsed = Date.parse(datetime);
            const date = new Date(parsed);
            const localized = date.toLocalizedDateString('hr-HR', options);

            return localized;
        },

        /**
         * Validate card inputs.
         * 
         * @return {Void}
         */
        _isValid(card) {
            card.errors = {
                route: null,
                crag: null,
                grade: null,
                climbed_at: null,
            }

            if (!card.route)
                card.errors.route = 'Route required!';
            if (!card.crag)
                card.errors.crag = 'Crag required!';
            if (!card.grade)
                card.errors.grade = 'Grade required!';
            if (!card.climbed_at)
                card.errors.climbed_at = 'Date required!';

            for (let error in card.errors) {
                if (card.errors[error])
                    return false;
            }
            
            return true;
        }
    }
}
</script>

<style lang="scss" scoped>
    @import '../../../../sass/variables';

    .cards {
        width: 100%;
        border-collapse: collapse;
        margin: 2.5rem 0;
        font-size: 0.9em;
        min-width: 400px;
        border-radius: 5px 5px 0 0;
        overflow: hidden;
        box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.05);
        border: 1px solid var(--cc-gray-bright);
        border-collapse: separate;
        border-spacing: 0;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;

        thead tr {
            text-align: left;
            background-color: #f9fafc;

            th {
                font-weight: 500;
                color: var(--cc-gray); 
                border-bottom: 1px solid var(--cc-gray-bright);
                font-size: 1.3rem;
                font-weight: 500;
                padding: 10px;
            }

            th:first-child {
                border-top-right-radius: 5px;
            }

            th:last-child {
                border-top-left-radius: 5px;
            }
        }

        th,
        td {
            padding: 15px 0 15px 15px;
            font-size: 1.4rem;
            font-weight: 300;
            color: var(--cc-gray);
            border-bottom: 1px solid var(--cc-gray-bright);
        }

        td {
            vertical-align: top;
        }

        select,
        textarea,
        input {
            height: 30px;
            border-radius: 5px;
            border: 1px solid var(--cc-gray-bright);
            width: 100%;

            :focus {
                border: 1px solid var(--cc-red);
            }
        }

        .grade,
        .id {
            width: 100px;
        }

        .style {
            width: 100px;
        }

        .actions {
            width: 80px;

            i {
                padding: 5px;
            }
        }

        [class^='icon-'] {
            font-size: 1.6rem;
            cursor: pointer;
        }

        .style span {
            border-radius: 50px;
            padding: 5px 10px;
            text-transform: uppercase;
            font-size: 1rem;
            font-weight: 500;

            &.redpoint {
                background-color: rgba($red-point, 0.1);
                color: darken($red-point, 10%);
            }

            &.onsight {
                background-color: rgba($on-sight, 0.1);
                color: darken($on-sight, 10%);
            }

            &.flash {
                background-color: rgba($flash, 0.1);
                color: darken($flash, 10%);
            }
        }

        .error {
            display: block;
            color: $red;
            margin-top: 10px;
        }
    }
</style>
