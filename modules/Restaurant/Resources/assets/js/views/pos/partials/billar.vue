<template>
  <el-dialog
    :visible="showBillar"
    v-loading="loading"
    @open="open"
    @close="close"
    width="70%"
    title="ZONA DE ATENCIÓN BILLAR"
    :close-on-click-modal="false"
    :class="{ top }"
  >
  <br>
    <div class="" v-if="ordens.length == 0 || hasSelectedOrdenToChange">
      <div class="d-flex justify-content-end p-2">
        <button
          type="button"
          style="margin-left:15px;"
          :class="`btn ${isDisabling ? 'btn-danger' : 'btn-warning'}`"
          @click="disablingTable"
        >{{ isDisabling ? "Cancelar" : "Deshabilitar" }}</button>
        <button
          v-if="hasTableOcuped"
          type="button"
          :class="
                        `btn ${changingOrden ? 'btn-warning' : 'btn-primary'}`
                    "
          @click="changeOrden"
        >
          {{
          changingOrden
          ? hasSelectedOrdenToChange
          ? "Seleccione a la mesa destino"
          : "Seleccionar mesa"
          : "Cambiar orden"
          }}
        </button>
        <button
          type="button"
          style="margin-left:15px;"
          :class="`btn ${addingOrden ? 'btn-danger' : 'btn-primary'}`"
          @click="addOrden"
        >{{ addingOrden ? "Seleccione mesa" : "Nueva orden" }}</button>
        <button type="button" style="margin-left:15px;" class="btn btn-light" @click="close">Cerrar</button>
      </div>
      <div v-if="tables.length > 0" class="d-flex flex-wrap justify-content-center">
        <div
          v-for="(table, idx) in filteredTables"
          :class="
                        `${
                            table.enabled == false
                                ? 'btn-light'
                                : table.status_table_id == 1
                                ? 'btn-primary'
                                : table.status_table_id == 2
                                ? 'btn-danger'
                                : 'btn-warning'
                        }`
                    "
          class="col-2 btn m-1 d-flex flex-column justify-content-center align-items-center"
          :key="idx"
          @click="selectTable(table)"
          style="max-height: 170px;    max-width: 140px;"
        >
          <strong class="h3 text-white">Mesa</strong>
          <i class="icofont-billiard-ball icofont-4x"></i>
          <span class="h2 text-white">{{ table.number }}</span>
          <div v-if="table.timer">
            <span class="h4 text-white">{{ formatTime(table.elapsedTime) }}</span>
          </div>
          <div style="display: flex; gap: 10px; margin-top: 10px;">
            <button class="btn btn-success btn-sm" @click.stop="showTableTime(table)">
              <i class="iconfont-clock-time"></i> Iniciar
            </button>
            <button class="btn btn-warning btn-sm" @click.stop="startTableTimer(table)">
              <i class="fa fas-stopwatch"></i> Hora
            </button>
          </div>
        </div>
      </div>
      <div v-else class="h-25 d-flex justify-content-center align-items-center">
        <span>Sin mesas</span>
      </div>
    </div>
    <br>
    <div class="card-body p-2" v-if="ordens.length > 0 && !hasSelectedOrdenToChange">
      <div class="row" v-if="hasSelectedTableToChange">
        <h3>Seleccione la orden a cambiar</h3>
      </div>
      <div class="d-flex flex-wrap justify-content-left">
        <div class="col-3" v-for="(ord, idx) in ordens" :key="idx">
          <button @click="sendOrdens(ord)" type="button" class="btn btn-primary p-1 m-1">
            <span class="h3 text-white">#{{ ord.id }}</span>
            <br />
            <span class="h4 text-white">
              {{
              ord.ref ? ord.ref : "Sin referencia"
              }}
            </span>
          </button>
        </div>
      </div>
      <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-light" @click="closeOrden">Regresar</button>
      </div>
    </div>
    <timer :showDialog.sync="showDialogTimer"></timer>
    <click :showDialog.sync="showDialogClick"></click>
  </el-dialog>
</template>
<style scoped>
.circular-btn {
  width: 70px;
  height: 70px;
  font-size: 20px;
  line-height: 50px;
}
</style>

<script>
import Swal from "sweetalert2";
import Timer from "./timer.vue";
import click from "./click.vue";
export default {
  //tabla color verde
  props: ["showBillar", "table", "configuration"],
  components: {
    Swal,
    Timer,
    click
  },
  data() {
    return {
      showDialogTimer: false,
      showDialogClick: false,
      addingOrden: false,
      ordens: [],
      loading: false,
      resource: "/caja/billar/tables",
      tables: [],
      showOrdens: false,
      ordensSaved: [],
      top: "rounded-top",
      screenWidth: 0,
      hasTableOcuped: false,
      changingOrden: false,
      hasSelectedTableToChange: false,
      hasSelectedOrdenToChange: false,
      ordenToChange: null,
      isDisabling: false
    };
  },
  computed: {
    filteredTables() {
      return this.tables.filter(table => table && table.has_billar);
    }
  },
  methods: {

    startTableTimer() {
      this.showDialogTimer = true;
    },
    showTableTime() {
      this.showDialogClick = true;
    },
    async disabledTable(id) {
      try {
        await this.$confirm(
          "¿Está seguro de deshabilitar la mesa?",
          "Advertencia",
          {
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            type: "warning"
          }
        );
        const response = await this.$http.post(`/caja/tables/disabled-table`, {
          table_id: id
        });
        console.log(
          "🚀 ~ file: tables.vue:154 ~ disabledTable ~ response:",
          response
        );
      } catch (e) {
        console.log(e);
      }
    },
    async enabledTable(id) {
      try {
        await this.$confirm(
          "¿Está seguro de habilitar la mesa?",
          "Advertencia",
          {
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            type: "warning"
          }
        );
        const response = await this.$http.post(`/caja/tables/enabled-table`, {
          table_id: id
        });
        console.log(
          "🚀 ~ file: tables.vue:169 ~ enabledTable ~ response:",
          response
        );
      } catch (e) {
        console.log(e);
      }
    },
    disablingTable() {
      this.isDisabling = !this.isDisabling;
    },
    changeOrden() {
      console.log("object");
      this.changingOrden = !this.changingOrden;
    },
    handleResize() {
      this.screenWidth = window.innerWidth;
    },
    addOrden() {
      this.addingOrden = !this.addingOrden;
    },
    async sendOrdenToNewTable(orden, table) {
      let orden_id = orden.id;
      let table_id = table.id;
      try {
        this.loading = true;
        const response = await this.$http.post(`change-orden`, {
          orden_id,
          table_id
        });
        if (response.status == 200) {
          this.$toast.success("Orden cambiada con éxito");
        } else {
          this.$toast.error("Ocurrió un error, al cambiar la orden");
        }
      } catch (e) {
        console.log(e);
        this.$toast.error("Ocurrió un error, al cambiar la orden");
      } finally {
        this.loading = false;
        this.close();
      }
    },
    closeOrden() {
      this.ordens = [];
      this.changingOrden = false;
      this.hasSelectedTableToChange = false;
      this.hasSelectedOrdenToChange = false;
      this.ordenToChange = null;
    },
    sendOrdens(orden) {
      if (this.changingOrden && !this.hasSelectedTableToChange) {
        this.hasSelectedTableToChange = true;
      } else if (this.changingOrden && this.hasSelectedTableToChange) {
        this.ordenToChange = orden;
        this.hasSelectedOrdenToChange = true;
        this.hasSelectedTableToChange = false;
      } else {
        this.$emit("sendOrdens", orden);
        this.close();
      }
    },

    async selectTable(table) {
      if (table.enabled == false) {
        this.changingOrden = false;
        await this.enabledTable(table.id);
        await this.getTables();
        return;
      }
      if (this.isDisabling && table.enabled) {
        await this.disabledTable(table.id);
        this.isDisabling = false;
        await this.getTables();
        return;
      }
      if (
        this.changingOrden &&
        !this.hasSelectedTableToChange &&
        this.hasSelectedOrdenToChange
      ) {
        // if (table.status_table_id == 2) {
        //     this.$toast.warning("La mesa no esta libre");
        //     return;
        // } else {
        //     this.sendOrdenToNewTable(this.ordenToChange, table);
        //     return;
        // }

        this.sendOrdenToNewTable(this.ordenToChange, table);
      }

      if (this.addingOrden) {
        this.$emit("creatingOrden", table.number, table.id);
        this.close();
        return;
      }

      if (table.status_table_id == 1) {
        /* Swal.fire({
          title: "MESA",
          text: "La mesa no tiene ordenes",
          icon: "warning"
        }); */
        this.$toast.warning("La mesa billor no tiene ordenes");
        return;
      }

      this.loading = true;

      this.tableSelectedNumber = table.number;
      try {
        const response = await this.$http(`/caja/tables/orden/${table.id}`);
        if (response.status == 200) {
          const { ordens } = response.data;

          this.ordens = ordens;
          if (ordens.length == 1) {
            this.sendOrdens(this.ordens[0]);
          } else {
            if (this.changingOrden) {
              this.hasSelectedTableToChange = true;
            }
          }
        }
        this.loading = false;
      } catch (e) {
        this.loading = false;
        console.log(e);
      }
    },
    async open() {
      this.closeOrden();
      await this.getTables();
    },
    async getTables() {
      try {
        this.loading = true;
        const response = await this.$http(this.resource);
        if (response.status == 200) {
          const { tables } = response.data;
          let { show_caja_table } = this.configuration;
          if (!show_caja_table) {
            this.tables = tables.filter(f => f.number.toLowerCase() != "caja");
          } else {
            this.tables = tables;
          }
          // this.tables = tables;
          this.hasTableOcuped = tables.some(s => s.status_table_id == 2);
        } else {
          this.$toast.warning("Ocurrió un error");
        }
        this.loading = false;
      } catch (e) {
        this.loading = false;
        console.log(e);

        this.$toast.warning("Ocurrió un error");
      }
    },
    close() {
      this.addingOrden = false;
      this.$emit("update:showBillar", false);
    }
  },
  mounted() {
    this.screenWidth = window.innerWidth;
    window.addEventListener("resize", this.handleResize);
  }
};
</script>
