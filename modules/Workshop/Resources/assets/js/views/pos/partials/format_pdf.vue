<template>
  <el-dialog
    @open="open"
    @close="close"
    append-to-body
    :visible="showDialog"
    title="Ingresos Anteriores PDF"
    close-on-click-modal
    width="40%"
  >
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-6 col-md-6 pb-6">
            <div class="form-group">
              <label class="control-label w-100">Selecciona Fecha</label>
              <el-date-picker
                type="date"
                style="width: 100%;"
                placeholder="Buscar por día"
                v-model="date"
                value-format="yyyy-MM-dd"
              ></el-date-picker>
            </div>
          </div>
          <div class="form-actions text-right mt-4">
            <el-button @click.prevent="close">Cancelar</el-button>
            <el-button @click.prevent="clickFormat" type="primary">Generar</el-button>
          </div>
        </div>
      </div>
    </div>
  </el-dialog>
</template>

<script>
export default {
  props: ["showDialog", "vehiculoId"],
  data() {
    return {
      date: null,
      resource: "workshop"
    };
  },
  methods: {
    /* clickFormat() {
      if (!this.selectedDate) {
        alert("Por favor, selecciona una fecha.");
        return;
      }

      const pdfUrl = `/vehiculo/view_pdf/${this.vehiculoId}_${this.selectedDate}`;
      window.open(pdfUrl, "_blank");
    }, */
    clickFormat() {
      // Llama al backend para verificar si el PDF existe
      axios
        .get(`/${this.resource}/vehiculo/check_pdf/${this.vehiculoId}_${this.date}`)
        .then(response => {
          if (response.data.exists) {
            const pdfUrl = `/${this.resource}/vehiculo/view_pdf/${this.vehiculoId}_${this.date}`;
            window.open(pdfUrl, "_blank");
          } else {
            this.$showSAlert("error", "No se encontró un PDF para la fecha seleccionada.", "error");
          }
        })
        .catch(error => {
          console.error(error);
          alert("Ocurrió un error al verificar el PDF.");
        });
    },
    open() {
      console.log("Abriendo diálogo con vehiculoId:", this.vehiculoId);
    },
    close() {
      this.$emit("update:showDialog", false);
    }
  }
};
</script>