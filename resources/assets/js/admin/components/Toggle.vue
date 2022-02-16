<template>
    <div :class="classes.container">
        <input type="checkbox" :id="id" :name="name" v-model="checked" @change="onChange" :disabled="disabled" />
        <div :class="classes.wrapper">
            <div :class="classes.content" :data-toggle-switch-value-off="offLabel" :data-toggle-switch-value-on="onLabel">
                <span :class="classes.handle"></span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Toggle',
        props: {
            modelValue: { type: Boolean, default: false },
            id: { type: String, default: 'toggle' },
            name: { type: String, default: 'toggle' },
            disabled: { type: Boolean, default: false },
            offLabel: { type: String, default: 'Off' },
            onLabel: { type: String, default: 'On' },
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
        },
        emits: ['update:modelValue'],
        data() {
            return {
                checked: this.modelValue,
            };
        },
        methods: {
            onChange() {
                this.$emit('update:modelValue', this.checked);
            },
        },
    };
</script>
