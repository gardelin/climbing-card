<template>
    <div id="climbing-card">
        <section>
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
