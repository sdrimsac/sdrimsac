<template>
  <el-dialog
    @open="open"
    @close="close"
    append-to-body
    :visible="showDialog"
    title="Cargar Productos"
    close-on-click-modal
    width="50%"
  >
    <br />
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-8">
            <label for="item">Producto</label>
            <el-select
              v-model="selectedProduct"
              :remote-method="searchRemoteItems"
              filterable
              placeholder="Buscar"
              remote
              @change="handleProductChange"
            >
              <el-option
                v-for="option in itemsdb"
                :key="option.id"
                :value="option.id"
                :label="option.description"
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
    <br />
    <div class="col-md-12 text-end">
      <el-button type="primary" @click="addItem">Agregar Producto</el-button>
    </div>
    <br />
    <div class="card">
      <el-table :data="items">
        <el-table-column prop="description" label="Descripción"></el-table-column>
        <el-table-column prop="cantidad" label="Cantidad"></el-table-column>
        <el-table-column prop="precioUnitario" label="Precio Unitario"></el-table-column>
        <el-table-column prop="total" label="Importe total"></el-table-column>
        <el-table-column label="Acciones">
          <template #default="scope">
            <el-button type="danger" icon="el-icon-delete" @click="removeItem(scope.$index)"></el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <div style="text-align: right; margin-top: 10px;">
      <strong>TOTAL:</strong>
      {{ totalSum }}
    </div>
    <div class="form-actions text-right mt-4">
      <el-button @click.prevent="close()">Cancelar</el-button>
      <el-button type="primary" @click="submit">Agregar</el-button>
    </div>
    <br />
  </el-dialog>
</template>
<script>
export default {
  props: [
    "showDialog",
    "vehiculoId",
    "vehiculoPlaca",
    "nexItem",
    "vehiculoHistorial"
  ],
  data() {
    return {
      selectedProduct: null,
      cantidad: 1,
      precioUnitario: 0,
      importeTotal: 0,
      loading_submit: false,
      items: [],
      itemsdb: [],
      resource: "workshop"
    };
  },
  mounted() {},
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
    },
    totalSum() {
      return this.items.reduce((sum, item) => sum + item.total, 0);
    }
  },
  methods: {
    ProductEdit() {
      if (this.vehiculoHistorial) {
        this.$http
          .get(
            `/${this.resource}/historialItem/record/${this.vehiculoHistorial}`
          )
          .then(response => {
            console.log("Respuesta completa del servidor:", response);

            if (Array.isArray(response.data) && response.data.length > 0) {
              this.items = response.data.map(item => {
                return {
                  description: item.item.description,
                  cantidad: item.cantidad,
                  precioUnitario: item.price

                }
              }); // Asignar directamente el array de objetos
              console.log("Ítems cargados:", this.items);
            } else {
              console.warn("No hay datos de ítems en la respuesta.");
              this.items = [];
            }
          })
          .catch(error => {
            console.error("Error al obtener los datos del historial:", error);
          });
      } else {
        console.warn("No se ha proporcionado un historial_id válido.");
      }
    },
    handleProductChange(value) {
      this.cantidad = 1;
      this.precioUnitario = 0;
      this.importeTotal = 0;
      const selected = this.itemsdb.find(item => item.id === value);

      if (selected) {
        console.log("fdsdfsdf", selected);
        this.precioUnitario = Number(selected.sale_unit_price);
        this.updateTotal();
      }
      console.log("Producto seleccionado:", value);
    },
    updateTotal() {
      this.importeTotal = this.precioUnitario * this.cantidad;
    },
    addItem() {
      if (this.selectedProduct && this.cantidad > 0) {
        const selected = this.itemsdb.find(
          item => item.id === this.selectedProduct
        );
        const newItem = {
          id: this.selectedProduct,
          description: selected ? selected.description : "",
          cantidad: this.cantidad,
          precioUnitario: this.precioUnitario,
          total: this.importeTotal
        };
        this.items.push(newItem);

        this.resetFormItem();

        console.log("Producto agregado:", newItem);
      } else {
        console.warn("Selecciona un producto y establece una cantidad válida.");
      }
    },
    removeItem(index) {
      this.items.splice(index, 1);
    },
    resetFormItem() {
      this.selectedProduct = null;
      this.cantidad = 1;
      this.precioUnitario = 0;
      this.importeTotal = 0;
    },
    async searchRemoteItems(input) {
      if (input.length > 2) {
        if (this.timer) {
          clearTimeout(this.timer);
        }
        this.timer = setTimeout(async () => {
          try {
            let parameters = `input=${input}`;
            const response = await this.$http.get(
              `/documents/data-table/items?${parameters}`
            );

            this.itemsdb = response.data;
          } catch (e) {
            console.log(e);
          } finally {
          }
        }, 250);
      }
    },
    submit() {
      this.$http
        .post(`/${this.resource}/items`, {
          historial_id: this.vehiculoHistorial,
          items: this.items
        })
        .then(response => {
          this.$emit("update:showDialog", false);
          this.$message({
            message: "Producto agregados con éxito",
            type: "success"
          });
        })
        .catch(error => {
          console.log(error);
          this.$message({
            message: "Error al agregar producto",
            type: "error"
          });
        });
    },
    open() {
      this.resetFormItem();
      this.items = [];
      this.ProductEdit();
    },
    close() {
      this.$emit("update:showDialog", false);
    }
  }
};
</script>