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
                            <div class="wrappers">
                                <div class="wrapper">
                                    <div class="header">
                                        <p class="title">{{ $gettext('General') }}</p>
                                    </div>
                                    <div class="content">
                                        <div class="item">
                                            <div class="item-label">{{ $gettext('Make my card public') }}</div>
                                            <div class="item-content">
                                                <Toggle :name="is_climbing_card_public" v-model="isClimbingCardPublic" :offLabel="$gettext('Off')" :onLabel="$gettext('On')" style="width: 90px" @change="setUserClimbingCardStatus" />
                                                <p class="item-description">{{ $gettext('By turning this option your climbing card data will be visible to all visitors') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template #fallback> loading... </template>
                    </Suspense>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import { ref, computed } from 'vue';
    import { useStore } from 'vuex';
    import Toggle from '../components/Toggle';
    // import CardsSkeleton from '../components/loading/CardsSkeleton';
    import Header from '../components/partials/Header';
    // import { mapActions } from 'vuex';
    // import { Plus, Download } from 'lucide-vue-next';

    export default {
        name: 'Settings',
        components: { Header, Toggle },
        async setup() {
            const store = useStore();
            const isClimbingCardPublic = ref(null);

            const response = await fetch(`${window.climbingcards.rest_url}settings?user_id=${window.climbingcards.logged_user_id}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json;charset=UTF-8',
                    'X-WP-Nonce': window.climbingcards.nonce,
                },
            });
            const json = await response.json();
            isClimbingCardPublic.value = json.data.is_climbing_card_public;

            return {
                isClimbingCardPublic,
                setUserClimbingCardStatus: () => {
                    fetch(`${window.climbingcards.rest_url}settings`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json;charset=UTF-8',
                            'X-WP-Nonce': window.climbingcards.nonce,
                        },
                        body: JSON.stringify({
                            is_climbing_card_public: isClimbingCardPublic.value,
                            user_id: window.climbingcards.logged_user_id,
                        }),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.data.updated) isClimbingCardPublic.value = data.data.is_climbing_card_public;
                        })
                        .catch(error => console.log(error));
                },
            };
        },
    };
</script>
