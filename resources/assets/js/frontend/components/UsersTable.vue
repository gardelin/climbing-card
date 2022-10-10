<template>
    <div>
        <table id="cards-table">
            <tbody>
                <tr class="card" v-for="user in users">
                    <td>
                        <router-link :to="{ name: 'user', params: { id: user.id } }"> {{ user.firstname }} {{ user.lastname }} </router-link>
                    </td>
                    <td style="text-align: right">
                        {{ user.cardsCount }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import { useStore } from 'vuex';

    const users = ref([]);
    const store = useStore();

    if (store.state.users.length === 0) {
        await store.dispatch('getUsers');
    }

    users.value = store.getters.users;
</script>
