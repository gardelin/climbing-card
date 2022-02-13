<template>
    <div class="header">
        <h1 class="title">{{ title }}</h1>
        <p class="description">{{ description }}</p>
    </div>
</template>

<script>
    export default {
        name: 'Header',
        props: ['title', 'description'],
    };
</script>

<style scoped lang="scss">
    .header {
        padding: 2rem 0;

        .title {
            color: var(--cc-black);
            font-size: 3rem;
            line-height: 3.8rem;
            font-weight: 500;
            margin: 0;
        }

        .description {
            color: var(--cc-gray-500);
            font-size: 1.6rem;
            line-height: 2.4rem;
            font-weight: 300;
        }
    }
</style>
