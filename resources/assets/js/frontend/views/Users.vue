<template>
    <section>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>{{ $gettext('Cards') }}</h1>
                    <Suspense>
                        <template #default>
                            <UsersTable />
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

<script setup>
    import UsersTable from '../components/UsersTable';
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue';
</script>
