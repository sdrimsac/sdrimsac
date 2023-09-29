<template>
    
</template>

<script>
export default {
    props: {
        method: {
            type: Object,
            required: true
        },
        order: {
            type: Object,
            required: true
        },
        payment: {
            type: Object,
            required: true
        },
        isDisabled: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        pay() {
            this.$emit('pay', this.method);
        }
    }
}
</script>