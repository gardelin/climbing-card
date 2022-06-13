<template>
    <table class="cards">
        <thead>
            <tr>
                <th class="grade">{{ $gettext('Grade') }}</th>
                <th class="total">{{ $gettext('Total') }}</th>
                <th class="on-sight">{{ $gettext('On Sight') }}</th>
                <th class="flash">{{ $gettext('Flash') }}</th>
                <th class="red-point">{{ $gettext('Red Point') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr class="item" v-for="item in 7">
                <td>
                    <span></span>
                </td>
                <td>
                    <span></span>
                </td>
                <td>
                    <span></span>
                </td>
                <td>
                    <span></span>
                </td>
                <td>
                    <span></span>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script>
    export default {
        name: 'StatisticsSkeleton',
    };
</script>

<style lang="scss" scoped>
    @import '../../../../sass/variables';

    span {
        display: block;
        width: 100%;
        height: 25px;
        border-radius: 4px !important;
        padding: 0 !important;
        background-color: $gray-100;
        animation: pulse-bg 1s infinite;
    }

    @keyframes pulse-bg {
        0% {
            background-color: $gray-100;
        }
        50% {
            background-color: $gray-200;
        }
        100% {
            background-color: $gray-100;
        }
    }
</style>
