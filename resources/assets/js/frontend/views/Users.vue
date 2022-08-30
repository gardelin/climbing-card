
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
                            <UsersTableSkeleton />
                        </template>
                    </Suspense>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import UsersTable from '../components/UsersTable';
    import UsersTableSkeleton from '../components/loading/UsersTableSkeleton';

    export default {
        name: 'Users',
        components: { UsersTable, UsersTableSkeleton },
    };
</script>
