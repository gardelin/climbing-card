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
                        <Toggle :name="'is_climbing_card_public'" v-model="isUserCardboardPublic" Label="$gettext('Off')" :onLabel="$gettext('On')" style="width: 90px" @change="handleChange" />
                        <p class="item-description">{{ $gettext('By turning this option your climbing card data will be visible to all visitors') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { computed } from 'vue';
    import { useStore } from 'vuex';
    import Toggle from './Toggle';
    import Header from './partials/Header';

    export default {
        name: 'Settings',
        components: { Header, Toggle },
        async setup() {
            const store = useStore();

            if (store.getters['user/isUserCardboardPublic'] === null) {
                await store.dispatch('user/isUserCardboardPublic');
            }

            return {
                isUserCardboardPublic: computed(() => store.getters['user/isUserCardboardPublic']),
                handleChange: e => {
                    store.dispatch('user/setUserClimbingCardStatus', e.target.checked);
                },
            };
        },
    };
</script>
