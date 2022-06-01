<template>
    <div>
        <section class="header-section border-bottom-gray-100">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <Header :title="$gettext('Statistics')" :description="$gettext('Check your climbing statistics')" />
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <Suspense>
                            <template #default>
                                <table class="cards">
                                    <thead>
                                        <tr>
                                            <th>{{ $gettext('Grade') }}</th>
                                            <th>{{ $gettext('Total') }}</th>
                                            <th>{{ $gettext('On Sight') }}</th>
                                            <th>{{ $gettext('Flash') }}</th>
                                            <th>{{ $gettext('Red Point') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="item" v-for="stat in stats">
                                            <td data-name="{{ $gettext('Grade') }}"><strong>{{ stat.grade }}</strong></td>
                                            <td data-name="{{ $gettext('Total') }}">{{ stat.total }}</td>
                                            <td data-name="{{ $gettext('On Sight') }}">{{ stat.on_sight }}</td>
                                            <td data-name="{{ $gettext('Flash') }}">{{ stat.flash }}</td>
                                            <td data-name="{{ $gettext('Red Point') }}">{{ stat.red_point }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </template>
                            <template #fallback> loading ... </template>
                        </Suspense>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import { ref, computed } from 'vue';
    import { useStore } from 'vuex';
    import Header from '../components/partials/Header';
    import { mapActions } from 'vuex';

    export default {
        name: 'Statistics',
        components: { 
            Header,
        },
        async setup() {
            const stats = ref([]);
            const store = useStore();

            const response = await fetch(`${window.climbingcards.rest_url}stats/${window.climbingcards.logged_user_id}`);
            const json = await response.json();

            store.commit('setStats', (store.state.stats = json.data.stats));

            return {
                stats: computed(() => store.state.stats),
            };
        },
        methods: {},
    };
</script>
