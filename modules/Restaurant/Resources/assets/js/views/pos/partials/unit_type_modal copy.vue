<template>
  <el-dialog
    :visible="showDialog"
    width="40%"
    :title="title"
    @open="open"
    @close="close"
    append-to-body
  >
    <div class="table-responsive">
      <br />
      <div class="col-lg-5 col-md-5 col-sm-12 pb-2">
        <el-input
          placeholder
          v-model="search"
          style="width: 100%;"
          prefix-icon="el-icon-search"
          @input="filter"
        ></el-input>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Precio Total</th>
            <th>Seleccione</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(unit,idx) in unit_types" :key="idx">
            <td>{{idx+1}}</td>
            <td>{{unit.description}}</td>
            <td>{{Number(unit.price2).toFixed(2)}}</td>
            <td>{{Number(unit.total).toFixed(2)}}</td>
            <td>
              <!-- <el-button type="success" @click="selectUnit(unit.id)">
                <i class="fas fa-check" />
              </el-button>-->
              <el-checkbox v-model="unit.selected"></el-checkbox>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="form-actions text-end pt-2 pb-2">
      <el-button @click="selectUnit" class="bg-primary text-white">
        <i class="fas fa-times fa-lg"></i>
        Agregar
      </el-button>
    </div>
  </el-dialog>
</template>
<style scoped>
.swal2-popup-z-index {
  z-index: 9999 !important; /* Asegura que esté por encima del modal de Element UI */
}
</style>

<script>
import Swal from "sweetalert2";
export default {
  props: ["showDialog", "item",],
  data() {
    return {
      search: "",
      title: "Politica Precios",
      unit_type_selected: null,
      unit_types: [],
      has_unit_types: [],
      filteredUnits: []
    };
  },
  methods: {
    filter() {
      if (this.search) {
        this.filteredUnits = this.unit_types.filter(unit =>
          unit.description.toUpperCase().includes(this.search.toUpperCase())
        );
      } else {
        this.filteredUnits = this.unit_types;
      }
    },
    /* selectUnit(id) {
      this.unit_type_selected = this.unit_types.find(i => i.id == id);
      /* this.$emit("addUnitType", this.unit_type_selected); */
    /* const selectedUnits = this.unit_types.filter(unit => unit.selected); */
    /* this.$emit("addUnitType", this.selectedUnits.id);
      if (this.selectUnit == false){
        Swal.fire({
          title: 'Error',
          text: 'debe de seleccionar una politica ',
          icon: 'error',

        })
      }
      this.$emit("addUnitType", this.selectedUnits);
      this.close();
    }, */

    selectUnit() {
      // Filtrar los ítems seleccionados
      const selectedUnits = this.unit_types.filter(unit => unit.selected);

      // Verificar si no hay ningún ítem seleccionado
      if (selectedUnits.length === 0) {
        // Mostrar alerta si no hay selección
        Swal.fire({
          title: "Error",
          text: "Debe seleccionar al menos una política",
          icon: "error",
          customClass: {
            popup: 'swal2-popup-z-index'
          }
        });
      } else {
        // Emitir los ítems seleccionados
        this.$emit("addUnitType", selectedUnits);
        // Cerrar el modal
        this.close();
      }
    },
    open() {
      console.log(this.item);
      let {
        item: { item_unit_types }
      } = this.item;
      this.unit_types = item_unit_types.map(unit => ({
        ...unit,
        select: false
      }));
      this.filteredUnits = this.unit_types;
    },
    close() {
      this.$emit("update:showDialog", false);
    }
  }
};
</script>

