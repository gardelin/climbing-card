<template>
    <div :class="classes.container">
        <input type="checkbox" :id="id" :name="name" v-model="props.modelValue" @change="onChange" :disabled="disabled" />
        <div :class="classes.wrapper">
            <div :class="classes.content" :data-toggle-switch-value-off="offLabel" :data-toggle-switch-value-on="onLabel">
                <span :class="classes.handle"></span>
            </div>
        </div>
    </div>
</template>

<script setup>
    const props = defineProps({
        modelValue: {
            type: Boolean,
            default: false,
        },
        id: {
            type: String,
            default: 'toggle',
        },
        name: {
            type: String,
            default: 'toggle',
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        offLabel: {
            type: String,
            default: 'Off',
        },
        onLabel: {
            type: String,
            default: 'On',
        },
        classes: {
            type: Object,
            default: () => {
                return {
                    container: 'toggle-switch',
                    wrapper: 'toggle-switch-wrapper',
                    content: 'toggle-switch-content',
                    handle: 'toggle-switch-handle',
                };
            },
        },
    });
</script>
