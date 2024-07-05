<template>
    <el-dialog
        class="no-header"
        title="Detracción"
        :visible="showDialog"
        @close="close"
        width="80%"
    >
        <detraction-index></detraction-index>
    </el-dialog>
</template>
<style scoped>
.no-header .el-dialog__wrapper .el-dialog .el-dialog__header {
    display: none;
    margin-bottom: 10px;
}
</style>
<script>
import DetractionIndex from "@views/documents/detractions/index.vue";
export default {
    props: ["showDialog"],
    components: {
        DetractionIndex
    },
    data() {
        return {};
    },
    methods:{
        close(){
            this.$emit('update:showDialog',false);
        }
    }
};
</script>
