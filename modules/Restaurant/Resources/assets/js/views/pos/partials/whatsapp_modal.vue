<template>
  <el-dialog
    append-to-body
    v-loading="loading"
    title="Enviar documento"
    width="30%"
    :visible="showDialog"
    @open="open"
  >
    <template v-slot:title>
      <div class="d-flex align-items-center">
        <i class="fab fa-whatsapp text-white fa-lg" style="margin-right: 10px;"></i>
        <h4 class="text-white mb-0">Enviar Documento</h4>
      </div>
    </template>
    <div class>
      <div class="row d-flex align-items-center">
        <div class="col-8">
          <br />
          <el-input
            v-model="number"
            placeholder="Ingresar número de WhatsApp"
            type="number"
            maxlength="9"
            @input="onNumberInput"
          ></el-input>
        </div>
        <div class="col-4">
          <el-checkbox
            :disabled="
                            documentTypeId == '80' || documentTypeId == 'COT'
                        "
            v-model="withXml"
          >Adjuntar XML</el-checkbox>
        </div>
      </div>
      <div class="d-flex justify-content-end p-2">
        <el-button @click="close">
          <i class="fas fa-times fa-lg"></i>
          Cerrar
        </el-button>
        <el-button @click="sendFiles" type="primary">
          <i class="fas fa-save fa-lg"></i> Enviar
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
    "sender",
    "establishment"
  ],
  data() {
    return {
      number: null,
      withXml: false,
      loading: false
    };
  },
  methods: {
    open() {
      console.log(this.establishment);
    },
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
        /* this.$toast.warning("Ingrese un número"); */
        this.$showSAlert("ALERTA","Ingrese un número", "warning");
        return;
      }
      if (!this.existNumber()) {
        /* this.$toast.error("Número para envío whatsapp inválido"); */
        this.$showSAlert("INVALIDO","Número para envío whatsapp inválido", "error");
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
          (this.establishment
            ? this.establishment.description
            : this.company.name) +
          "*, ha sido generado correctamente a través del facturador electrónico de *" +
          this.$desarrollador +
          "*"
      };
      try {
        this.loading = true;
        let response = await this.$http.post(`/whatsapp`, formWhatsapp);
        if (this.withXml) {
          formWhatsapp.xml = true;
          response = await this.$http.post(`/whatsapp`, formWhatsapp);
        }
        if (response.status == 200) {
          /* this.$toast.success("El mensaje se envió correctamente"); */
          this.$showSAlert("WHATSAPP","El mensaje se envió correctamente");
        } else {
          /* this.$toast.error("Ocurrió un error en el envio"); */
          this.$showSAlert("ERROR","Ocurrió un error en el envio", "error");
        }
      } catch (e) {
        /* this.$toast.error("Ocurrió un error en el envio"); */
        this.$showSAlert("ERROR","Ocurrió un error en el envio", "error");
      } finally {
        this.loading = false;
        this.close();
      }
    },
    onNumberInput() {
      // Mantén solo los números y corta a un máximo de 9 dígitos
      this.number = this.number.replace(/\D/g, "").slice(0, 9);
    }
  }
};
</script>
