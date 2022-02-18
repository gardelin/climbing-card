<template>
    <table class="cards">
        <thead>
            <tr>
                <th class="id">ID</th>
                <th class="route">Smjer</th>
                <th class="crag">Penjaliste</th>
                <th class="grade">Ocjena</th>
                <th class="style">Nacin</th>
                <th class="comment">Komentar</th>
                <th class="climbed_at">Datum</th>
                <th class="actions">Akcije</th>
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
            background-color: #gray-200;
        }
        100% {
            background-color: $gray-100;
        }
    }
</style>
