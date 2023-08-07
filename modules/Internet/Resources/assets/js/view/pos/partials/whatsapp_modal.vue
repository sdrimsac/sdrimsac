<template>
    <el-dialog
        append-to-body
        v-loading="loading"
        title="Enviar documento por whatsapp"
        width="40%"
        :visible="showDialog"
    >
        <div class="card ">
            <div class="row d-flex align-items-center">
                <div class="col-8">
                    <el-input v-model="number" placeholder="tlf: 999999999">
                    </el-input>
                </div>
                <div class="col-4">
                    <el-checkbox
                        :disabled="documentTypeId == '80'"
                        v-model="withXml"
                    >
                        Adjuntar XML
                    </el-checkbox>
                </div>
            </div>
            <div class="d-flex justify-content-end p-2">
                <el-button @click="sendFiles" type="primary">Enviar</el-button>
                <el-button @click="close">
                    Cerrar
                </el-button>
            </div>
        </div>
    </el-dialog>
</template>
<script>
export default {
    props: [
        "showDialog",
        "documentId",
        "documentTypeId",
        "company",
        "documentNumber",
        "sender"
    ],
    data() {
        return {
            number: null,
            withXml: false,
            loading: false
        };
    },
    methods: {
        close() {
            this.$emit("update:showDialog", false);
            this.number = null;
            this.withXml = false;
        },
        existNumber() {
            let number = this.number;
            if (!number.startsWith("9")) {
                return false;
            }
            if (number.length != 9) {
                return false;
            }
            if (isNaN(Number(number))) {
                return false;
            }
            return true;
        },
        async sendFiles() {
            if (!this.number) {
                this.$toast.warning("Ingrese un número");
                return;
            }
            if (!this.existNumber()) {
                this.$toast.error("Número para envío whatsapp inválido");
                return;
            }
            let formWhatsapp = {
                document_id: this.documentId,
                document_type_id: this.documentTypeId,
                customer_telephone: this.number,
                sender: this.sender,
                mensaje:
                    "Su comprobante de pago electrónico " +
                    this.documentNumber +
                    " de *" +
                    this.company.name +
                    "*, ha sido generado correctamente a través del facturador electrónico de "+"*"+this.$desarrollador+"*"
            };
            try {
                this.loading = true;
                let response = await this.$http.post(`/whatsapp`, formWhatsapp);
                if (this.withXml) {
                    formWhatsapp.xml = true;
                    response = await this.$http.post(`/whatsapp`, formWhatsapp);
                }
                if (response.status == 200) {
                    this.$toast.success("El mensaje se envió correctamente");
                } else {
                    this.$toast.error("Ocurrió un error en el envio");
                }
            } catch (e) {
                this.$toast.error("Ocurrió un error en el envio");
            } finally {
                this.loading = false;
                this.close();
            }
        }
    }
};
</script>
