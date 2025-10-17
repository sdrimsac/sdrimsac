<template>
    <el-dialog
        :visible="showDialog"
        :title="title"
        @close="close"
        @open="open"
        append-to-body
        v-loading="loading"
    >
        <div class="row">
            <div class="col-md-6">
                editar
            </div>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "document"],
    data() {
        return {
            title: "Editar documento",
            loading: false
        };
    },
    methods: {
        getDocument() {
            this.loading = true;
            let { sale_note_id, document_id } = this.document;
            this.$http
                .post(`/quotations/consolidateds/edit-document`, {
                    sale_note_id,
                    document_id
                })
                .then(response => {
                    this.loading = false;
                });
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        open() {
            this.getDocument();
            console.log(this.document);
        }
    }
};
</script>

<style></style>
