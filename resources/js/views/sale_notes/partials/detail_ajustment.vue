<template>
  <el-dialog
    title="Ajuste de inventario"
    :visible.sync="dialogAjustment"
    width="80%"
    :before-close="handleClose"
    >
    </el-dialog>
</template>

<script>
export default {
    props: ["dialogAjustment"],
    data() {
        return {
        };
    },
    methods: {
        handleClose() {
            this.$emit("update:dialogAjustment", false);
        }
    }   
        
}
</script>

