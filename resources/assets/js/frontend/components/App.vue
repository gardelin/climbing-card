<template>
    <div id="climbing-card">
        <section class="border-bottom-gray-100">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <Suspense>
                            <router-view />
                        </Suspense>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: 'App',
    };
</script>

<style scoped></style>
