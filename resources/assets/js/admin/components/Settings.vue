<template>
    <div class="wrappers">
        <div class="wrapper">
            <div class="header">
                <p class="title">{{ $gettext('General') }}</p>
            </div>
            <div class="content">
                <div class="item">
                    <div class="item-label">{{ $gettext('Make my card public') }}</div>
                    <div class="item-content">
                        <Toggle :name="'is_climbing_card_public'" v-model="isUserCardboardPublic" :offLabel="$gettext('Off')" :onLabel="$gettext('On')" style="width: 90px" @change="handleChange" />
                        <p class="item-description">{{ $gettext('By turning this option your climbing card data will be visible to all visitors') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { computed } from 'vue';
    import { useStore } from 'vuex';
    import Toggle from './Toggle';

    const store = useStore();

    if (store.getters['isUserCardboardPublic'] === null) {
        await store.dispatch('isUserCardboardPublic');
    }

    const isUserCardboardPublic = computed(() => store.getters['isUserCardboardPublic']);

    const handleChange = e => {
        store.dispatch('setUserClimbingCardStatus', e.target.checked);
    };
</script>
