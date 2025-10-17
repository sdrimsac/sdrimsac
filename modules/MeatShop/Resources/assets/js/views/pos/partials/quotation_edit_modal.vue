<template>
    <el-dialog
        :visible="showDialog"
        append-to-body
        @open="open"
        @close="close"
        title="Editar cotización"
        width="80%"
    >
        <tenant-quotations-edit
        ref="edit"
            @close="close"
            :external="true"
            :resource-id="recordId"
            type-user="seller"
        ></tenant-quotations-edit>
    </el-dialog>
</template>

<script>
const TenantQuotationsEdit = () =>
    import(
        "../../../../../../../../resources/js/views/quotations/form_edit.vue"
    );
export default {
    components: {
        TenantQuotationsEdit
    },
    props: ["showDialog", "recordId"],
    data() {
        return {};
    },
    methods: {
        open() {
            console.log(this.recordId);
        setTimeout(() => {
           this.$refs.edit.initialize(); 
        }, 500);

        },
        close() {
            this.$emit("update:showDialog", false);
        }
    },
    mounted(){
    }
};
</script>
