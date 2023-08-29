<template>
    <el-dialog :visible="showDialog" width="30%"
    @close="close"
    title="Previsualización de imagen"
    append-to-body
    >
        <img v-if="image" :src="image" alt="image" style="width: 100%">
    </el-dialog>
</template>
<script>
export default {
    props: {
        showDialog: {
            type: Boolean,
            default: false
        },
        image: {
            type: String,
            default: ''
        }
    },
    methods: {
        close() {
            this.$emit('update:showDialog', false)
        }
    }
}
</script>