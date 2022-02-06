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
                <th class="updated_at">Datum Upisa</th>
                <th class="actions">Akcije</th>
            </tr>
        </thead>
        <tbody>
            <tr class="item" v-for="card in cards" :key="card.id">
                <td class="id">
                    <span>{{card.id}}</span>
                </td>
                <td class="route">
                    <input v-if="card.editmode" v-model="card.route"/>
                    <span v-else>{{card.route}}</span>
                </td>
                <td class="crag">
                    <input v-if="card.editmode" v-model="card.crag"/>
                    <span v-else>{{card.crag}}</span>
                </td>
                <td class="grade">
                    <input v-if="card.editmode" v-model="card.grade"/>
                    <span v-else>{{card.grade}}</span>
                </td>
                <td class="style">
                    <input v-if="card.editmode" v-model="card.style"/>
                    <span v-else :class="card.style.replace(' ','')">{{card.style}}</span>
                </td>
                <td class="comment">
                    <textarea v-if="card.editmode" v-model="card.comment"/>
                    <span v-else>{{card.comment}}</span>
                </td>
                <td class="climbed_at">
                    <input v-if="card.editmode" type="date" v-model="card.climbed_at"/>
                    <span v-else>{{card.climbed_at}}</span>
                </td>
                <td class="updated_at">
                    {{ card.updated_at }}
                </td>
                <td class="actions">
                    <div class="threedots"></div>
                    <div class="dropdown">
                        <span v-if="!card.editmode">
                            <i class="icon-pencil" @click="_edit(card)"></i>
                        </span>
                        <span v-else>
                            <i class="icon-ok" @click="_save(card)"></i>
                        </span>
                        <i class="icon-trash-empty" @click="_delete(card)"></i>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: 'Cards',
    props: ['class'],
    data() {
        return {
            cards: [],
        }
    },
    mounted() {
        fetch(`${window.climbingcards.rest_url}cards/${window.climbingcards.logged_user_id}`)
            .then(response => response.json())
            .then(data => { this.cards = data.data.cards; })
            .catch(error => console.log(error))
    },
    methods: {
        _edit(card) {
            card.editmode = true;
        },
        _save(card){
            card.editmode = false;
        },
        _delete(card) {
            this.cards.splice(card, 1);
        },
        _datetimeToHuman(datetime) {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const parsed = Date.parse(datetime);
            const date = new Date(parsed);
            const localized = date.toLocalizedDateString('hr-HR', options);

            return localized;
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
                color: var(--cc-black); 
                border-bottom: 1px solid var(--cc-gray-bright);
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
            color: var(--cc-black);
            border-bottom: 1px solid var(--cc-gray-bright);
        }

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
            width: 40px;
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
    }
</style>
