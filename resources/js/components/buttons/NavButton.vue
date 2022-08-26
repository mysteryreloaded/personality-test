<template>
    <button @click="triggerClickEvent()" :disabled="disabled" type="button" class="btn rounded w-100 mr-2 shadow-none" :class="button.class">
        <span class="d-flex justify-content-center align-items-center" :class="button.class === 'btn-outline-danger' ? 'flex-row-reverse' : ''">
            <svg width="16" height="16" fill="currentColor" class="m-2" :class="button.svg.class" viewBox="0 0 16 16">
                <path fill-rule="evenodd" :d="button.svg.path.d"/>
            </svg>
            {{ button.label }}
        </span>
    </button>
</template>

<script>
export default {
    name: 'NavButton',
    props: {
        navButton: {
            type: Object,
            default() {
                return null;
            }
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            button: this.navButton
        }
    },
    methods: {
        triggerClickEvent() {
            this.$emit('nav-button-click');
        }
    }
}
</script>
