<template>
    <el-dialog :visible.sync="showDetailDialog" width="600px" :close-on-click-modal="false"
        :title="`Enviar promoción al WhatsApp`" :before-close="handleBeforeClose" append-to-body>
        <div>
            <div class="mb-3">
                <label>Ingrese número de WhatsApp</label>
                <el-input v-model="whatsappNumber" placeholder="Ej: 912345678"></el-input>
            </div>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button type="danger" @click="closeDialog" style="font-size:16px;padding:12px 24px;">Cancelar</el-button>
            <el-button type="primary" round @click="sendWhatsApp" style="font-size:16px;padding:12px 24px;">
                Enviar
            </el-button>
        </span>
    </el-dialog>
</template>
<script>
export default {
    props: ['showDialog', 'customerId'],
    data() {
        return {
            showDetailDialog: this.showDialog,
            whatsappNumber: ''
        };
    },
    watch: {
        showDialog(newVal) {
            this.showDetailDialog = newVal;
        },
        showDetailDialog(newVal) {
            this.$emit('update:showDialog', newVal);
        }
    },
    methods: {
        handleBeforeClose(done) {
            this.closeDialog();
            done && done();
        },
        closeDialog() {
            this.showDetailDialog = false;
            this.whatsappNumber = '';
        },
        async sendWhatsApp() {
            if (!this.whatsappNumber) {
                this.$message.error('Por favor ingrese un número de WhatsApp.');
                return;
            }

            try {
                const response = await this.$http.post(`/whatsapp-promotion`, {
                    number: this.whatsappNumber,
                    customer_id: this.customerId, 
                    message: 'Hola, Estimado cliente tiene promociones disponibles a los cuales puedes acceder ' + this.customerId + '.',
                    file_name: "promotion_report_" + this.customerId + ".pdf",
                    sender: "sdrimsac",
                    resource: "/promotions-document/download-pdf/" + this.customerId
                });

                if (response.data.success) {
                    this.$message.success('Mensaje enviado correctamente.');
                    this.closeDialog();
                } else {
                    this.$message.error('Error al enviar el mensaje.');
                }
            } catch (error) {
                console.error(error);
                this.$message.error('Error al enviar el mensaje.');
            }
        }
    }
};
</script>