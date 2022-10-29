<template>
    <section class="border-bottom-gray-100">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav>
                        <ul>
                            <li>
                                <router-link :to="{ name: 'climbing-cards', params: {} }">
                                    <svg-vue icon="carabiner" height="20" />
                                    <span>{{ $gettext('Climbing Cards') }}</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'stats' }">
                                    <BarChart2 size="20" />
                                    <span>{{ $gettext('Statistics') }}</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'settings' }">
                                    <Settings size="20" />
                                    <span>{{ $gettext('Settings') }}</span>
                                </router-link>
                            </li>
                            <li v-if="isAdministrator">
                                <router-link :to="{ name: 'admin' }">
                                    <Lock size="20" />
                                    <span>{{ $gettext('Admin') }}</span>
                                </router-link>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
    import { computed } from 'vue';
    import { useStore } from 'vuex';
    import { BarChart2, Settings, Lock } from 'lucide-vue-next';

    const store = useStore();

    if (!store.getters['user/roles']) {
        await store.dispatch('user/getRoles');
    }

    const isAdministrator = computed(() => {
        return store.getters['user/roles'].includes('administrator') ? true : false;
    });
</script>

<style scoped lang="scss">
    @import '../../../../sass/mixins';

    $breakpoints: (
        'small': 767px,
        'medium': 992px,
        'large': 1200px,
    ) !default;

    ul {
        display: flex;
        margin: 0;

        li {
            display: flex;
            margin: 0;

            a {
                display: flex;
                align-content: center;
                justify-content: center;
                box-shadow: none;
                outline: none;
                position: relative;
                padding: 15px 20px;
                text-decoration: none;
                transition: color 500ms ease-in-out;
                color: var(--cc-gray-500);
                font-weight: 400;

                svg {
                    margin-right: 10px;
                }

                @include respond-to('small') {
                    svg {
                        margin: 0;
                    }

                    span {
                        display: none;
                    }
                }
            }

            a::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                height: 2px;
                width: 0%;
                background-color: var(--cc-red);
                transition: width 200ms ease-in-out;
            }
        }

        li:hover a {
            color: var(--cc-red);
        }

        li:first-child:hover a::after {
            width: calc(100% - 10px);
        }

        li:hover a::after {
            width: 100%;
        }
    }

    .router-link-active {
        color: var(--cc-red);

        &:after {
            width: calc(100%);
        }
    }
</style>
