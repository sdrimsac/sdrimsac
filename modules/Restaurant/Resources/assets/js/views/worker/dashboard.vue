<template>
  <div v-loading="loading" class="container">
    <!-- Title and Top Buttons Start -->
    <div class="page-title-container mb-0">
      <div class="row">
        <div class="col-12 col-sm-5">
          <h1 class="mb-1 pb-0 display-4 user_online">
            <div class="btn-group">
              <div class="dropdown">
                <a
                  class="dropdown-toggle mb-1"
                  href="javascript:void(0)"
                  role="button"
                  id="dropdownMenuLink"
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <i class="icofont-waiter icofont-2x"></i>
                  {{ user.name }}
                </a>
                <el-button
                  v-if="show != 'tables'"
                  @click="
                                        selectOption = 1;
                                    tables_row_select = null;
                                    show = 'tables';"
                  class="fw-bold"
                >
                  <i class="icofont icofont-dining-table"></i>
                  Visualizar mesas
                </el-button>
              </div>
            </div>
          </h1>
          <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
            <ul class="breadcrumb pt-0">
              <template v-if="!currentTable">
                <li class="breadcrumb-item">
                  <a href="javascript:void(0)" class="fw-bold">SELECCIONE UNA MESA</a>
                </li>
              </template>
              <template v-if="currentTable != null">
                <li class="breadcrumb-item">
                  <h1 class="fw-bold">
                    <a
                      href="javascript:void(0)"
                      class="text-danger font-weight-bold"
                      @click="
                                        selectOption = 1;
                                        tables_row_select = null;
                                        show = 'tables';
                                        "
                    >
                      Mesa N°{{
                      currentTable.number
                      }}
                    </a>
                  </h1>
                </li>
                <!-- <li class="breadcrumb-item">
                                <a href="javascript:void(0)" class="text-info font-weight-bold" @click="createOrden()">
                                    Nueva Orden
                                </a>
                </li>-->
              </template>
            </ul>
          </nav>
        </div>
        <div class="col-12 col-sm-6 pt-2 pb-2" v-if="show == 'create'&& screenWidth > 678">
          <template>
            <span slot="label">
              <i class="fas fa-list"></i>
              <template v-if="optionsSelected == 0">Buscar por Nombre del Producto</template>
              <template v-else>Buscar por Codigo Interno Producto</template>
            </span>
            <el-input
              v-model="item"
              @focus="clearinput()"
              @input="searchOrden()"
              ref="item"
              placeholder="Buscar Producto"
            >
              <i slot="prefix" class="el-input__icon el-icon-search"></i>
              <el-button
                :class="
                                optionsSelected == 0
                                    ? 'bg-secondary text-white'
                                    : ''
                            "
                slot="append"
                icon="el-icon-tickets"
                @click="selectSearch(0)"
              ></el-button>
              <el-button
                :class="
                                optionsSelected == 1
                                    ? 'bg-secondary text-white'
                                    : ''
                            "
                slot="append"
                icon="el-icon-s-order"
                @click="selectSearch(1)"
              ></el-button>
            </el-input>
          </template>
        </div>
        <div class="col-12 col-sm-6 pt-2 pb-2" v-if="show == 'create' && screenWidth > 678">
          <template>
            <span slot="label">
              <i class="fas fa-list"></i> Categoria de
              Producto
            </span>
            <el-select
              v-model="category"
              filterable
              placeholder="Selecionar aqui...."
              @change="select_category(category)"
            >
              <el-option
                v-for="item in categories"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              ></el-option>
            </el-select>
          </template>
        </div>
      </div>
      <div
        class="d-flex justify-content-center p-2"
        v-if="show == 'tables' && configuration.cambiar_mesa_mozo"
      >
        <button
          type="button"
          class="btn me-2"
          :class="`btn ${isDisabling ? 'btn-danger' : 'btn-warning'}`"
          @click="disablingTable"
        >{{ isDisabling ? "Cancelar" : "Deshabilitar" }}</button>

        <button
          type="button"
          class="mx-2"
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
      </div>
    </div>
    <div class="row p-2" v-show="show == 'tables'">
      <div class="d-flex flex-wrap justify-content-center">
        <div
          :class="[ data.enabled == false ? 'btn-light':
                    data.status_table.id == 1 ? 'btn-primary' : 'btn-danger'
                ]"
          class="col-xl-2 col-md-3 col-4 btn m-1 d-flex flex-column justify-content-center align-items-center"
          v-for="(data, index) in tables"
          :key="index"
          @click="selectedTable(data.id, data)"
        >
          <strong class="h3 text-white">{{data.is_room ? 'Habitación':'Mesa' }}</strong>
          <i class="icofont-dining-table icofont-4x"></i>

          <span class="h2 text-white">{{ data.full_name }}</span>
          <span
            :class="
                        `${ 
                            data.enabled == false ? 'text-light' :
                            data.status_table.id == 1
                            ? 'text-white'
                            : 'text-black'
                        }`
                    "
          >{{ data.status_table.description }}</span>
        </div>
      </div>
    </div>

    <!-- v-show="show == 'ordens'" -->
    <!-- <ListOrden :configuration="configuration" v-if="selectOption == '2'">
    </ListOrden>-->
    <template v-if="currentTable && show == 'create'">
      <detail-orden
        @changeOrdenEvent="changeOrdenEvent"
        :changingOrden.sync="changingOrden"
        ref="detailRef"
        :configuration="configuration"
        :table.sync="currentTable"
        :categories="categories"
        :showMenu.sync="showMenu"
        :tables_row_select.sync="tables_row_select"
        :foods.sync="foods"
        :pagination="pagination"
        @addenfoque="focus"
        @add="tablesrowselect"
        @changePage="changePage"
        @searchOrden="searchitem_modal"
        :category.sync="category"
      ></detail-orden>
    </template>
  </div>
</template>

<style scoped>
.ttitle {
  font-size: 20px;
  font-weight: bold;
}

.el-tag--small {
  height: 50px;
  padding: 0 12px;
  line-height: 50px;
}

.font-bold {
  font-weight: bold !important;
  color: #1b4c43;
}

.font-normal {
  font-weight: normal;
}

.mr1 {
  margin-right: 5px !important;
}

.hooper-next,
.hooper-prev {
  padding: 0.2em;
}
</style>

<script>
import { Hooper, Slide, Navigation as HooperNavigation } from "hooper";
import "hooper/dist/hooper.css";
import DetailOrden from "./detail_orden.vue";
import ViewTables from "./tables.vue";
import MenuTable from "./menu.vue";
import ListOrden from "./listar_ordens.vue";
import queryString from "query-string";
import swal from "sweetalert2";
export default {
  components: {
    ViewTables,
    MenuTable,
    DetailOrden,
    ListOrden,
    Hooper,
    Slide,
    HooperNavigation,
    swal
  },
  props: [
    "configuration",
    "user",
    "status_table",
    "areas",
    "tables_area",
    "tables_active",
    "categories"
  ],
  data() {
    return {
      ordenToChange: null,
      hasSelectedTableToChange: false,
      hasSelectedOrdenToChange: false,
      changingOrden: false,
      hasTableOcuped: false,
      isDisabling: false,
      screenWidth: 0,
      allFoods: [],
      listFoods: [],
      pagination: {},
      foods: [],
      show: "tables",
      selectArea: 0,
      selectOption: 1,
      selectedTables: 0,
      item: null,
      input_item: "",
      resource: "dashboard",
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      optionsSelected: this.configuration.search_type,
      showMenu: false,
      currentTable: null,
      loading: false,
      category: 0,
      tables: [],
      printerDefault: null,
      currentArea: null,
      allAreas: [],
      ordens: [],
      tables_row_select: null,
      hooperSettings: {
        centerMode: false,
        trimWhiteSpace: true,
        playSpeed: 3500,
        itemsToShow: 6,
        breakpoints: {
          2400: {
            itemsToShow: 4
          },
          1800: {
            itemsToShow: 4
          },
          1500: {
            itemsToShow: 3
          },
          1100: {
            itemsToShow: 2
          },
          0: {
            itemsToShow: 2
          }
        }
      },
      timer: null
    };
  },

  mounted() {
    this.screenWidth = window.innerWidth;
    window.addEventListener("resize", this.handleResize);

    Echo.channel("orden_delete").listen(
      `.order-delete-${this.configuration.socket_channel}`,
      e => {
        let { order_item } = e;
        this.deleteOrden(order_item);
      }
    );
    Echo.channel("orden_paid").listen(
      `.order-paid-${this.configuration.socket_channel}`,
      e => {
        this.$eventHub.$emit("reloadData");
        this.$refs.detailRef.clean();
      }
    );
    Echo.channel("stock_orden").listen(
      `.stock-order-${this.configuration.socket_channel}`,
      e => {
        let ListFoods = this.foods;
        for (let index = 0; index < e.data.order_item.length; index++) {
          let xFind = _.find(ListFoods, {
            id: e.data.order_item[index].food_id
          });
          let index_find = _.findIndex(ListFoods, {
            id: xFind.id
          });
          if (index_find !== -1) {
            let nSaldo =
              parseInt(ListFoods[index_find].item.stock) -
              e.data.order_item[index].quantity;
            ListFoods[index_find].item.stock = nSaldo;
            this.$emit("update:foods", ListFoods);
          }
        }
      }
    );
  },

  async created() {
    await this.getFoods();
    qz.security.setCertificatePromise((resolve, reject) => {
      this.$http
        .get("/api/qz/crt/override", {
          responseType: "text"
        })
        .then(response => {
          resolve(response.data);
        })
        .catch(error => {
          reject(error.data);
        });
    });
    qz.security.setSignaturePromise(toSign => {
      return (resolve, reject) => {
        this.$http
          .post("/api/qz/signing", {
            request: toSign
          })
          .then(response => {
            resolve(response.data);
          })
          .catch(error => {
            reject(error.data);
          });
      };
    });
    this.categories.unshift({
      id: 0,
      name: "TODOS LAS CATEGORIAS"
    });
    this.currentArea = this.user.area_id;
    this.allAreas = [
      ...this.areas.map(a => {
        if (this.currentArea == a.id) {
          a.selected = true;
        } else {
          a.selected = false;
        }
        return a;
      }),
      {
        id: 0,
        description: "Ver Ordenes",
        selected: false
      }
    ];
    let allAreas_all = _.orderBy(this.allAreas, ["id"], ["asc"]);
    this.allAreas = allAreas_all;
    // this.tables = this.tables_area;
    //this.tables_row_select=this.tables_active
    await this.getTables();
    this.$eventHub.$on("reloadData", () => {
      this.getTables(true);
    });
    this.$notify({
      title: "Sistema de Punto de Venta",
      iconClass: "icofont-waiter icofont-3x",
      message: "Bienvenido " + this.user.name
    });
  },
  methods: {
    async disabledTable(id) {
      try {
        await this.$confirm(
          "¿Está seguro de deshabilitar la mesa?",
          "Advertencia",
          { 
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            icon: "warning"
          }
        );
        const response = await this.$http.post(`/caja/tables/disabled-table`, {
          table_id: id
        });
        console.log(
          "🚀 ~ file: tables.vue:154 ~ disabledTable ~ response:",
          response
        );
        swal.fire(
          "Deshabilitado",
          "la mesa ha sido deshabilitado Exitosamente",
          "success"
        );
      } catch (e) {
        console.log(e);
        swal.fire(
          "warning",
          "deshabilitacion cancelado.",
          "warning"
        );
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
        swal.fire("Habilitado", "La Mesa a Sido ");
      } catch (e) {
        console.log(e);
      }
    },
    disablingTable() {
      this.isDisabling = !this.isDisabling;
    },
    changeOrdenEvent(id) {
      this.hasSelectedOrdenToChange = true;
      this.show = "tables";
      this.ordenToChange = id;
    },
    changeOrden() {
      console.log("object");
      this.changingOrden = !this.changingOrden;
    },
    handleResize() {
      this.screenWidth = window.innerWidth;
    },
    async changePage(currentPage) {
      this.pagination.current_page = currentPage;
      await this.search_items();
    },
    async searchitem_modal(item) {
      if (item == null) {
        item = "";
      }
      let inputitem = item.toLowerCase();
      let form = {
        value: inputitem,
        category: this.category
      };

      await this.getFoods(this.getQueryParameters(form));
    },

    async search_items() {
      if (this.item == null) {
        this.item = "";
      }
      let inputitem = this.item.toLowerCase();
      let form = {
        value: inputitem,
        category: this.category
      };

      await this.getFoods(this.getQueryParameters(form));
    },
    getQueryParameters(form = {}) {
      return queryString.stringify({
        page: this.pagination.current_page,
        ...form

        // limit: this.limit
      });
    },
    async getFoods(query = "") {
      try {
        const response = await this.$http.get(
          `${this.resource}/foods?${query}`
        );
        this.loading = true;
        if (response.status == 200) {
          const {
            data: { data, meta }
          } = response;
          this.allFoods = data;
          this.foods = data;
          this.pagination = meta;
          this.selectOption = 4;
          this.loading = false;
        }
      } catch (e) {
        this.loading = false;
      }
    },
    deleteOrden(id) {
      this.tables = this.tables.map(t => {
        if (t.orden.length > 0) {
          let ordens = t.orden;
          for (let i = 0; i < ordens.length; i++) {
            let orden = ordens[i];
            if (orden.orden_items.some(ot => ot.id == id)) {
              t.orden[i].orden_items = t.orden[i].orden_items.filter(
                o => o.id != id
              );
              break;
            }
          }

          // if (t.orden.orden_items.length == 0) {
          //   t.status_table.id = 1;
          //   t.status_table.description = "disponible";
          // }
        }

        return t;
      });
    },
    async tablesrowselect(value) {
      this.tables_row_select = value;
      this.selectOption = 1;
    },
    clearinput() {
      this.item = null;
    },
    focus() {
      this.$nextTick(() => {
        let input = this.$refs.item;
        input.focus();
        return false;
      });
    },
    createOrden() {
      this.$refs.detailRef.createOrden();
      this.focus();
    },
    select_category(id) {
      this.focus();
      this.$refs.detailRef.filterCategory(id);
      this.searchOrden();
    },
    selectSearch(value) {
      this.optionsSelected = value;
      //this.focus();
    },
    async searchOrden() {
      // this.$refs.detailRef.filter_food(
      //     this.item.toLowerCase(),
      //     this.optionsSelected
      // );
      if (this.time) {
        clearTimeout(this.time);
      }
      this.time = setTimeout(() => {
        this.search_items();
      }, 500);
    },
    async printer() {
      // try {
      //         qz.websocket.connect()
      //             .then(qz.printers.getDefault)
      //             .then(function(printer) {
      //                 console.log("defaultPrinter",printer)
      //                 let config = qz.configs.create(printer, {scaleContent : false},{jobName	:"Pedidos"});
      //                  qz.websocket.connect(config);
      //                  let data = [
      //             {
      //                 type: 'pdf',
      //                 format: 'file',
      //                 data: "http://demo.facturadorpro3.oo/caja/worker/print-ticket?id=40"
      //             }
      //         ];
      //         qz.print(config, data).catch((e) => {
      //             this.$toast.error(e.message);
      //         });
      //             })
      //             .catch(function(e) {
      //                 console.error(e);
      //         });
      //         this.$toast.success("se esta imprimiendo el comprobante con exito");
      //     } catch (e) {
      //         this.$toast.error(e.message);
      //     }
    },
    async ordenReady(id) {
      this.loading = true;
      try {
        const response = await this.$http.get(`ordens-ready/${id}`);

        const { success, message } = response.data;
        success ? this.$toast.success(message) : this.$toast.error(message);
        if (success) {
          this.ordens = this.ordens.filter(o => o.id != id);
        }
      } catch (e) {
        console.log(e);
        this.$toast.error("Ocurrió un error");
      }
      this.loading = false;
    },
    async ordenCancel(id) {},
    setArea(id) {
      this.currentArea = id;
      this.selectArea = id;
      if (id == 0) {
        this.show = "ordens";
        this.getOrdens();
      } else {
        this.getTables();
        this.show = "create";
      }
      this.allAreas = this.allAreas.map(a => {
        if (a.id == id) {
          a.selected = true;
        } else {
          a.selected = false;
        }
        return a;
      });
    },
    calculeTotal(orden = null) {
      if (!orden) return;
      let items = orden.orden_items;
      let prices = items.map(o => Number(o.food.price));
      if (prices.length == 0) return;
      let total = prices.reduce((a, b) => a + b);
      return total;
    },
    async selectedTable(id = null, data = []) {
      let table = this.tables.find(t => t.id == id);
      console.log(table);
      if (this.isDisabling) {
        this.changingOrden = false;
        if (table.enabled) {
          await this.disabledTable(table.id);
        } else {
          await this.enabledTable(table.id);
        }
        await this.getTables();
        this.isDisabling = false;
        return;
      }
      if (!table.enabled == true) {
        await this.enabledTable(table.id);
        await this.getTables();
        return;
      }
      
      if (
        this.changingOrden &&
        this.currentTable &&
        this.hasSelectedOrdenToChange
      ) {
        this.sendOrdenToNewTable(this.ordenToChange, id);
        return;
      }
      if (this.changingOrden && table.status_table.id == 1) {
        
        swal.fire({
          title: "la mesa no tiene ordenes para trasladar",
          icon: "warning"
        });
        return;
      }
      

      this.tables_row_select = id;
      this.selectedTables = id;
      this.currentTable = data;
      this.show = "create";
      // this.focus();
      this.allAreas = this.allAreas.map(a => {
        a.selected = false;
        return a;
      });
    },
    async sendOrdenToNewTable(orden_id, table_id) {
      try {
        this.loading = true;
        const response = await this.$http.post(`change-orden`, {
          orden_id,
          table_id
        });
        if (response.status == 200) {
          swal.fire({
            title: "Orden trasladada con exito",
            icon: "success"
          })
          /* this.$toast.success("Orden cambiada con éxito"); */
          this.changingOrden = false;
          this.currentTable = null;
          this.hasSelectedOrdenToChange = false;
          this.hasSelectedTableToChange = false;
          this.getTables();
        } else {
          this.$toast.error("Ocurrió un error, al cambiar la orden");
        }
      } catch (e) {
        console.log(e);
        this.$toast.error("Ocurrió un error, al cambiar la orden");
      } finally {
        this.loading = false;
      }
    },
    async getOrdens() {
      this.loading = true;

      // try {
      //   const response = await this.$http.get("ordens-list");
      //   this.ordens = response.data.data;
      // } catch (e) {
      //   console.log(e);
      // }
      this.show = "ordens";
      this.loading = false;
    },
    async getTables(change = null) {
      this.loading = true;
      const response = await this.$http.get(
        `tables/records-area/${this.currentArea}`
      );
      console.log(
        "🚀 ~ file: dashboard.vue:599 ~ getTables ~ response:",
        response
      );
      if (response.status == 200) {
        const { data } = response.data;
        this.tables = data;
        if (!change) {
          this.show = "tables";
        }
        if (this.currentTable) {
          let id = this.currentTable.id;
          this.currentTable = this.tables.find(t => t.id == id);
        }
      }
      this.loading = false;
    }
  }
};
</script>
