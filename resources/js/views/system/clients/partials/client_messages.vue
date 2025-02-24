<template>
    <el-dialog
        :title="title"
        :visible="showDialog"
        @close="closeDialog"
        @open="openDialog"
        width="80%"
        append-to-body
        v-loading="loading"
    >
        <div class="row">
            <div class="col-md-12 mt-2">
                <label for="message_client_before_end"
                    >Mensaje antes de vencer</label
                >
                <textarea
                    class="form-control w-100"
                    rows="5"
                    v-model="form.message_client_before_end"
                    placeholder="Mensaje antes de vencer"
                ></textarea>
            </div>
            <div class="col-md-12 mt-2">
                <label for="message_client_after_end"
                    >Mensaje después de vencer</label
                >
                <textarea
                    class="form-control w-100"
                    rows="5"
                    v-model="form.message_client_after_end"
                    placeholder="Mensaje después de vencer"
                ></textarea>
            </div>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button type="primary" @click="save">Guardar</el-button>
            <el-button @click="closeDialog">Cancelar</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["client_payment_id", "showDialog"],
    data() {
        return {
            loading: false,
            title: "Mensajes del cliente",
            form: {
                message_client_before_end: null,
                message_client_after_end: null
            }
        };
    },
    methods: {
        initForm() {
            this.form = {
                message_client_before_end: null,
                message_client_after_end: null
            };
        },
        getData() {
            this.$http
                .get(`/client_payments/record/${this.client_payment_id}`)
                .then(response => {
                    this.form = response.data;
                    this.form.message_client_before_end = this.form.message_client_before_end.replace(/<br>/g, "\n");
                    this.form.message_client_after_end = this.form.message_client_after_end.replace(/<br>/g, "\n");
                    console.log(this.form);
                });
        },
        openDialog() {
            this.initForm();
            this.getData();
        },
        closeDialog() {
            this.$emit("update:showDialog", false);
        },
        save() {
            this.loading = true;
            this.form.message_client_before_end = this.form.message_client_before_end.replace(/\n/g, "<br>");
            this.form.message_client_after_end = this.form.message_client_after_end.replace(/\n/g, "<br>");
            this.$http
                .post(`/client_payments/messages/${this.client_payment_id}`, this.form)
                .then(response => {
                    this.$message.success("Mensajes guardados con éxito");
                    this.closeDialog();
                }).catch(error => {
                    this.$message.error("Error al guardar los mensajes");
                }).finally(() => {
                    this.loading = false;
                });
        }
    }
};
</script>
