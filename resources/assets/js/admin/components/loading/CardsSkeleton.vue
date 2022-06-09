<template>
    <table class="cards">
        <thead>
            <tr>
                <th class="id">ID</th>
                <th class="route">{{ $gettext('Route') }}</th>
                <th class="crag">{{ $gettext('Crag') }}</th>
                <th class="grade">{{ $gettext('Grade') }}</th>
                <th class="style">{{ $gettext('Style') }}</th>
                <th class="comment">{{ $gettext('Comment') }}</th>
                <th class="climbed_at">{{ $gettext('Date') }}</th>
                <th class="actions">{{ $gettext('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr class="item" v-for="item in 7">
                <td class="id">
                    <span></span>
                </td>
                <td class="route">
                    <span></span>
                </td>
                <td class="crag">
                    <span></span>
                </td>
                <td class="grade">
                    <span></span>
                </td>
                <td class="style">
                    <span></span>
                </td>
                <td class="comment">
                    <span></span>
                </td>
                <td class="climbed_at">
                    <span></span>
                </td>
                <td class="actions">
                    <span></span>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script>
    export default {
        name: 'CardsSkeleton',
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
