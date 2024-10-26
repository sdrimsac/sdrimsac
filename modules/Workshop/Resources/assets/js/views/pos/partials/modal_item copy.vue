<template>
  <el-dialog
    @open="open"
    @close="close"
    append-to-body
    :visible="showDialog"
    title="Cargar Productos"
    close-on-click-modal
    width="40%"
  >
    <br />
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-8 col-sm-4">
            <label>Producto/servico</label>
            <el-select
              v-model="selectedProduct"
              filterable
              placeholder="buscar producto"
              @change="handleProductChange"
            >
              <el-option
                v-for="item in filteredProducts"
                :key="item.id"
                :label="item.description"
                :value="item.id"
              ></el-option>
            </el-select>
          </div>
          <div class="col-md-4 col-sm-4"></div>
          <div class="col-md-4 col-sm-4">
            <div class="form-group">
              <label>Cantidad</label>
              <br />
              <el-input-number v-model="cantidad" type="number" :min="0.00" @change="updateTotal"></el-input-number>
            </div>
          </div>
          <div class="col-md-4 col-sm-4">
            <div class="form-group">
              <label class="control-label">Precio Unitario</label>
              <br />
              <el-input-number v-model="precioUnitario" type="number"></el-input-number>
            </div>
          </div>
          <div class="col-md-4 col-sm-4">
            <div class="form-group">
              <label class="control-label">Importe Total</label>
              <br />
              <el-input-number v-model="importeTotal">
                <template slot="prepend"></template>
              </el-input-number>
            </div>
          </div>
        </div>
      </div>
    </div>
    <el-button type="primary" @click="addItem">Agregar Producto</el-button>
    <el-table :data="items">
      <el-table-column prop="id" label="Id Producto"></el-table-column>
      <el-table-column prop="cantidad" label="Cantidad"></el-table-column>
      <el-table-column prop="PrecioUnitario" label="Precio Unitario"></el-table-column>
      <el-table-column prop="total" label="Importe total"></el-table-column>
    </el-table>
    <div class="form-actions text-right mt-4">
      <el-button @click.prevent="close()">Cancelar</el-button>
      <el-button type="primary" native-type="submit" :loading="loading_submit">Agregar</el-button>
    </div>
    <br />
  </el-dialog>
</template>
<script>
export default {
  props: ["showDialog", "vehiculoId", "vehiculoPlaca", "nexItem"],
  data() {
    return {
      selectedProduct: null,
      cantidad: 1,
      precioUnitario: 0,
      importeTotal: 0,
      loading_submit: false,
      items: []
    };
  },
  mounted() {
    console.log("ID del vehículo en modal-item:", this.vehiculoId);
    console.log("Placa del vehículo en modal-item:", this.vehiculoPlaca);
    console.log("item para poder agregar productos", this.nexItem);
  },
  computed: {
    filteredProducts() {
      if (this.searchTerm) {
        return this.nexItem.filter(item => {
          return item.name
            .toLowerCase()
            .includes(this.searchTerm.toLowerCase());
        });
      }
      return this.nexItem;
    }
  },

  methods: {
    handleProductChange(value) {
      this.cantidad = 1;
      this.precioUnitario = 0;
      this.importeTotal = 0;
      const selected = this.nexItem.find(item => item.id === value);
      if (selected) {
        this.precioUnitario = selected.price;
        this.updateTotal();
      }
      console.log("Producto seleccionado:", value);
    },
    updateTotal() {
      this.importeTotal = this.precioUnitario * this.cantidad;
    },
    addItem() {
      if (this.selectedProduct && this.cantidad > 0) {
        const newItem = {
          id: this.selectedProduct,
          cantidad: this.cantidad,
          precioUnitario: this.precioUnitario,
          total: this.importeTotal 
        };
        this.items.push(newItem); 

        this.resetForm();

        console.log("Producto agregado:", newItem);
      } else {
        console.warn("Selecciona un producto y establece una cantidad válida.");
      }
    },
    resetForm() {
      this.selectedProduct = null;
      this.cantidad = 1; 
      this.precioUnitario = 0; 
      this.importeTotal = 0;
    },
    open() {},
    close() {
      this.$emit("update:showDialog", false);
    }
  }
};
</script>