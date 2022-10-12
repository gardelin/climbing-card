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
                <div class="col" style="display: flex; flex-direction: column; justify-content: center; align-items: center">
                    <AlertOctagon size="128" style="color: var(--cc-red)" />
                    <h1 style="color: var(--cc-red)">Uppsss not allowed</h1>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
    import { AlertOctagon } from 'lucide-vue-next';
</script>
