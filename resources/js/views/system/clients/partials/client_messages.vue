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
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label for="message_client_before_end">Mensaje antes de vencer</label>
                    <el-button 
                        type="primary" 
                        size="small"
                        :loading="sendingBefore"
                        @click="sendMessage('before')"
                    >
                        <i class="fab fa-whatsapp mr-1"></i> Enviar mensaje
                    </el-button>
                </div>
                <textarea
                    class="form-control w-100"
                    rows="5"
                    v-model="form.message_client_before_end"
                    placeholder="Mensaje antes de vencer"
                ></textarea>
            </div>
            <div class="col-md-12 mt-2">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label for="message_client_after_end">Mensaje después de vencer</label>
                    <el-button 
                        type="primary" 
                        size="small"
                        :loading="sendingAfter"
                        @click="sendMessage('after')"
                    >
                        <i class="fab fa-whatsapp mr-1"></i> Enviar mensaje
                    </el-button>
                </div>
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
            sendingBefore: false,
            sendingAfter: false,
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
                });
        },
        openDialog() {
            this.initForm();
            this.getData();
        },
        closeDialog() {
            this.$emit("update:showDialog", false);
        },
        async sendMessage(type) {
            try {
                // Establecer el estado de carga del botón correspondiente
                if (type === 'before') {
                    this.sendingBefore = true;
                } else {
                    this.sendingAfter = true;
                }

                // Primero guardamos el mensaje actualizado
                await this.save(false); // Pasamos false para que no muestre el mensaje de éxito

                // Preparar el mensaje según el tipo
                const message = type === 'before' ? 
                    this.form.message_client_before_end : 
                    this.form.message_client_after_end;

                // Enviar el mensaje por WhatsApp
                const response = await this.$http.post(`/client_payments/send_whatsapp/${this.client_payment_id}`, {
                    message_type: type,
                    message: message.replace(/\n/g, "<br>")
                });

                if (response.data.success) {
                    this.$message.success(response.data.message);
                } else {
                    this.$message.error(response.data.message || "Error al enviar el mensaje");
                }
            } catch (error) {
                console.error(error);
                this.$message.error("Error al enviar el mensaje");
            } finally {
                // Restablecer el estado de carga del botón
                if (type === 'before') {
                    this.sendingBefore = false;
                } else {
                    this.sendingAfter = false;
                }
            }
        },
        async save(showMessage = true) {
            try {
                this.loading = true;
                const formData = {
                    ...this.form,
                    message_client_before_end: this.form.message_client_before_end.replace(/\n/g, "<br>"),
                    message_client_after_end: this.form.message_client_after_end.replace(/\n/g, "<br>")
                };

                await this.$http.post(`/client_payments/messages/${this.client_payment_id}`, formData);
                
                if (showMessage) {
                    this.$message.success("Mensajes guardados con éxito");
                    this.closeDialog();
                }
            } catch (error) {
                this.$message.error("Error al guardar los mensajes");
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
