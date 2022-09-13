<template>
    <section class="header-section border-bottom-gray-100">
        <div class="container">
            <div class="row">
                <div class="col">
                    <Header :title="$gettext('Settings')" :description="$gettext('Manage your climbing card settings')" />
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
                            <Settings />
                        </template>
                        <template #fallback>
                            <PulseLoader />
                        </template>
                    </Suspense>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import Settings from '../components/settings/Settings.vue';
    import Header from '../components/partials/Header';
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue';

    export default {
        name: 'SettingsPage',
        components: { Header, Settings, PulseLoader },
    };
</script>
