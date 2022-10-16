<template>
    <div v-if="cards.length">
        <table class="cards" :class="classes">
            <thead>
                <tr>
                    <th v-if="shouldShowEmail" class="email">
                        {{ $gettext('Email') }}
                        <ChevronUp :size="15" v-if="sortBy === 'email' && !asc" />
                        <ChevronDown :size="15" v-if="sortBy === 'email' && asc" />
                    </th>
                    <th class="route" @click="sort('route')">
                        {{ $gettext('Route') }}
                        <ChevronUp :size="15" v-if="sortBy === 'route' && !asc" />
                        <ChevronDown :size="15" v-if="sortBy === 'route' && asc" />
                    </th>
                    <th class="crag" @click="sort('crag')">
                        {{ $gettext('Crag') }}
                        <ChevronUp :size="15" v-if="sortBy === 'crag' && !asc" />
                        <ChevronDown :size="15" v-if="sortBy === 'crag' && asc" />
                    </th>
                    <th class="grade" @click="sort('grade')">
                        {{ $gettext('Grade') }}
                        <ChevronUp :size="15" v-if="sortBy === 'grade' && !asc" />
                        <ChevronDown :size="15" v-if="sortBy === 'grade' && asc" />
                    </th>
                    <th class="style" @click="sort('style')">
                        {{ $gettext('Style') }}
                        <ChevronUp :size="15" v-if="sortBy === 'style' && !asc" />
                        <ChevronDown :size="15" v-if="sortBy === 'style' && asc" />
                    </th>
                    <th class="comment">{{ $gettext('Comment') }}</th>
                    <th class="climbed_at" @click="sort('climbed_at')">
                        {{ $gettext('Date') }}
                        <ChevronUp :size="15" v-if="sortBy === 'climbed_at' && !asc" />
                        <ChevronDown :size="15" v-if="sortBy === 'climbed_at' && asc" />
                    </th>
                    <th class="actions"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="item" :class="{ edit: card.editmode === true }" v-for="card in cards" :key="card.id">
                    <td v-if="shouldShowEmail" class="email" :data-name="$gettext('Email')">
                        <span>{{ card.email }}</span>
                    </td>
                    <td class="route" :data-name="$gettext('Route')">
                        <input v-if="card.editmode" v-model="card.route" :placeholder="$gettext('Route Name')" />
                        <span v-else>{{ card.route }}</span>
                        <span v-if="card.errors.route" class="error">{{ card.errors.route }}</span>
                    </td>
                    <td class="crag" :data-name="$gettext('Crag')">
                        <input v-if="card.editmode" v-model="card.crag" :placeholder="$gettext('Crag - Sector')" />
                        <span v-else>{{ card.crag }}</span>
                        <span v-if="card.errors.crag" class="error">{{ card.errors.crag }}</span>
                    </td>
                    <td class="grade" :data-name="$gettext('Grade')">
                        <select v-if="card.editmode" v-model="card.grade">
                            <option value="" disabled selected>{{ $gettext('Select Grade') }}</option>
                            <option v-for="grade in grades(true)" :key="grade">
                                {{ grade }}
                            </option>
                        </select>
                        <span v-else>{{ card.grade }}</span>
                        <span v-if="card.errors.grade" class="error">{{ card.errors.grade }}</span>
                    </td>
                    <td class="style" :data-name="$gettext('Style')">
                        <select v-if="card.editmode" v-model="card.style">
                            <option value="red point">Red Point</option>
                            <option value="flash">Flash</option>
                            <option value="on sight">On Sight</option>
                        </select>
                        <span v-else :class="card.style.replace(' ', '')">{{ card.style }}</span>
                    </td>
                    <td class="comment" :data-name="$gettext('Comment')">
                        <textarea v-if="card.editmode" v-model="card.comment" />
                        <span v-else>{{ card.comment }}</span>
                    </td>
                    <td class="climbed_at" :data-name="$gettext('Date')">
                        <span v-if="card.editmode">
                            <flat-pickr v-model="card.climbed_at" :config="flatPickrDateConfig" :placeholder="$gettext('Select Date')" />
                        </span>
                        <span v-else>{{ datetimeToHuman(card.climbed_at) }}</span>
                        <span v-if="card.errors.climbed_at" class="error">{{ card.errors.climbed_at }}</span>
                    </td>
                    <td class="actions" :data-name="$gettext('Actions')">
                        <Edit2 :size="18" v-if="!card.editmode" @click="card.editmode = true" />
                        <Save :size="18" v-else @click="save(card)" />
                        <Trash2 :size="18" @click="store.dispatch(`user/deleteCard`, card)" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <p v-else>{{ $gettext('No routes found in your cartboard. You can add it using "Add" button above.') }}</p>
</template>

<script setup>
    import { computed, ref } from 'vue';
    import { useStore } from 'vuex';
    import { Edit2, Trash2, Save, ChevronDown, ChevronUp } from 'lucide-vue-next';
    import language from '../../language';
    import flatPickr from 'vue-flatpickr-component';
    import { grades, datetimeToHuman } from '../../utils/Utils';

    const store = useStore();
    let asc = ref(false);
    let sortBy = ref(null);
    const { $gettext } = language;
    const flatPickrDateConfig = {
        altFormat: 'd/m/Y',
        altInput: true,
    };

    const props = defineProps({
        cards: {
            type: Array,
            required: true,
        },
        storeNamespace: {
            type: String,
            required: true,
        },
        classes: {
            type: Array,
            required: false,
        },
    });

    const save = card => {
        if (isValid(card)) {
            if (card.id) {
                store.dispatch(`user/updateCard`, card);
            } else {
                store.dispatch(`user/saveCard`, card);
            }
        }
    };

    const isValid = card => {
        card.errors = {
            route: null,
            crag: null,
            grade: null,
            climbed_at: null,
        };

        if (!card.route) card.errors.route = $gettext('Route required!');
        if (!card.crag) card.errors.crag = $gettext('Crag required!');
        if (!card.grade) card.errors.grade = $gettext('Grade required!');
        if (!card.climbed_at) card.errors.climbed_at = $gettext('Date required!');

        for (let error in card.errors) {
            if (card.errors[error]) return false;
        }

        return true;
    };

    const sort = prop => {
        store.dispatch(`${props.storeNamespace}/sortCards`, { prop, asc: asc.value });

        asc.value = !asc.value;
        sortBy.value = prop;
    };

    const shouldShowEmail = computed(() => {
        return props.storeNamespace === 'admin' ? true : false;
    });
</script>

<style lang="scss">
    @import 'flatpickr/dist/flatpickr.css';

    .date-container {
        position: relative;

        .lucide {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: var(--cc-gray-500);
            cursor: pointer;
        }

        input {
            border: 1px solid var(--cc-gray-300);
            width: 300px;
            padding: 2px 40px 2px 10px;
            box-shadow: var(--cc-box-shadow-sx);
            border-radius: var(--cc-border-radius);
            font-weight: 300;
        }
    }

    .search-container {
        position: relative;

        .lucide {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: var(--cc-gray-500);
        }

        input {
            border: 1px solid var(--cc-gray-300);
            width: 300px;
            padding: 2px 10px 2px 40px;
            box-shadow: var(--cc-box-shadow-sx);
            border-radius: var(--cc-border-radius);
            font-weight: 300;
        }
    }
</style>
