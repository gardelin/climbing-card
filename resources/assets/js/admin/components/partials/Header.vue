<template>
    <div class="header">
        <h1 class="title">{{ title }}</h1>
        <p class="description">{{ description }}</p>
    </div>
</template>

<script>
export default {
   name: 'Header',
   props: [
       'title',
       'description',
   ]
}
</script>

<style scoped lang="scss">
    .header {
        padding: 2rem 0;
        border-bottom: 1px solid var(--cc-gray-bright);

        .title {
            color: var(--cc-black);
            font-size: 2.5rem;
            font-weight: 500;
            margin: 0;
        }

        .description {
            color: var(--cc-black);
            margin: 1.5rem 0 0 0;
        }
    }
</style>
