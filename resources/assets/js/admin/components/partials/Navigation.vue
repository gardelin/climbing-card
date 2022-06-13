<template>
    <nav>
        <ul>
            <li>
                <router-link :to="{ name: 'climbing-cards', params: {} }">{{ $gettext('Climbing Cards') }}</router-link>
            </li>
            <li>
                <router-link :to="{ name: 'stats' }">{{ $gettext('Statistics') }}</router-link>
            </li>
            <li>
                <router-link :to="{ name: 'settings' }">{{ $gettext('Settings') }}</router-link>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: 'Navigation',
    };
</script>

<style scoped lang="scss">
    ul {
        display: flex;
        margin: 0;

        li {
            display: flex;
            margin: 0;

            a {
                box-shadow: none;
                outline: none;
                position: relative;
                padding: 15px 20px;
                text-decoration: none;
                transition: color 500ms ease-in-out;
                color: var(--cc-gray-500);
                font-weight: 400;
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

        li:first-child a {
            padding-left: 0;
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
