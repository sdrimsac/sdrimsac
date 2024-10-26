<template>
  <el-dialog
    @open="open"
    @close="close"
    append-to-body
    :visible="showDialog"
    title="Historial De Registro De Vehiculo"
    close-on-click-modal
    width="60%"
  >
    <form action>
      <div class="form-body">
        <div class="row">
          <div class="col-md-4">
            <label for="vehiculo">Vehiculo</label>
            <el-input></el-input>
          </div>
          <div class="col-md-4">
            <label for="vehiculo">Documento</label>
            <el-input></el-input>
          </div>
        </div>
        <br />
      </div>
      <div class="form-body">
        <div class="row">
          <table class="table table-striped table-responsive col-md-12">
            <thead>
              <tr class="bg-primary">
                <th class="text-white">%%</th>
                <th class="text-white">Fecha</th>
                <th class="text-white">Vehiculo</th>
                <th class="text-white">Personal</th>
                <th class="text-white">Motivo de Ingreso</th>
                <th class="text-white">Trabajos Realizados</th>
                <th class="text-white">Establecimiento</th>
                <th class="text-white">Productos Cuenta</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in historial" :key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ item.fecha}}</td>
                <td>{{ item.vehiculo_placa }} - {{ item.vehiculo_marca }}</td>
                <td>{{ item.personal_name }}</td>
                <td>{{ item.observacion}}</td>
                <td>{{ item.motive}}</td>
                <td>{{ item.establishment_description }}</td>
                <td class="text-center">
                  <el-popover placement="right" width="400" trigger="click">
                    <!-- Tabla de items dentro del popover -->
                    <el-table :data="item.item" style="width: 100%">
                      <el-table-column width="50" label="#"></el-table-column>
                      <el-table-column label="Nombre" width="200">
                        <template v-slot="scope">{{ scope.row.description }}</template>
                      </el-table-column>
                      <el-table-column label="Cantidad" width="100">
                        <template v-slot="scope">{{ scope.row.cantidad }}</template>
                      </el-table-column>
                      <el-table-column label="Precio" width="100">
                        <template v-slot="scope">{{ scope.row.price }}</template>
                      </el-table-column>
                    </el-table>
                    <el-button slot="reference">
                      <i class="fa fa-eye"></i>
                    </el-button>
                  </el-popover>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </form>
  </el-dialog>
</template>
<script>
export default {
  props: ["showDialog", "vehiculo_id"],
  data() {
    return {
      resource: "workshop",
      historial: []
    };
  },
  methods: {
    getData() {
      this.$http

        .get(
          `/${this.resource}/historial/records?vehiculo_id=${
            this.vehiculo_id ? this.vehiculo_id : ""
          }`
        )
        .then(response => {
          this.historial = response.data.data;
        })
        .catch(error => {
          console.error("Servicios Detallados:", error);
        });
    },
    open() {
      this.getData();
    },
    close() {
      this.$emit("update:showDialog", false);
    }
  }
};
</script>