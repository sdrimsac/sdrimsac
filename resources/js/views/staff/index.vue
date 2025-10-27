<!-- Listado de Vendedores -->
<template>
  <div>

    <div class="container-fluid p-l-0 p-r-0">
      <div class="card">
        <div class="card-header bg-primary d-flex align-items-center" style="padding: 10px;">
          <h3 class="my-0 text-white d-flex align-items-center" style="font-size: 1rem; font-weight: bold;">
            <i class="fas fa-user-tie" style="font-size: 1rem; margin-right: 1rem;"></i>
            LISTADO DE PERSONAL
          </h3>
        </div>
        <div class="data-table-visible-columns">
          <el-button type="button" class="btn_buscar" style="margin-right: 5px;"
            @click.prevent="clickDownloadExcel">
            Import Excel del personal
          </el-button>
          <!-- <button type="button" class="btn btn-success" @click="clickDownloadExcel">
            <i class="fa fa-download"></i>
            Import Excel del personal
          </button> -->
        </div>
        <div class="card-body">
          <data-table :resource="resource">
            <tr slot="heading" class="bg-primary">
              <th class="text-white" style="width: 40px;">#</th>
              <th class="text-white" style="width: 180px;">Vendedor</th>
              <!-- <th class="text-white">Documento</th> -->
              <th class="text-white" style="width: 120px;">Creador</th>
              <!-- <th class="text-white">Fecha</th> -->
              <th class="text-white" style="width: 150px;">Establecimiento</th>
              <th class="text-white" style="width: 100px;">Ventas CPE</th>
              <th class="text-white" style="width: 100px;">Ventas NV</th>
              <th class="text-white" style="width: 120px;">Total Ventas</th>
              <th class="text-white" style="width: 120px;">% de Comisión</th>
              <th class="text-white" style="width: 140px;">Total S/ Comisión</th>
              <th class="text-white" style="width: 70px;">Productos</th>
              <th class="text-white text-center" style="width: 100px;">Acciones</th>
            </tr>


            <tr slot-scope="{ index, row }">
              <td>{{ index + 1 }}</td>
              <td>{{ row.document }}
                <br />
                {{ row.name }}
              </td>
              <!-- <td></td> -->
              <td>{{ row.user_name }}
                <br />
                {{ row.created_at }}
              </td>

              <td>{{ row.establishment_description }}</td>
              <td>{{ Number(row.documents_total).toFixed(2) }}</td>
              <td>{{ Number(row.sale_notes_total).toFixed(2) }}</td>
              <td>{{ Number(row.total_sales).toFixed(2) }}</td>
              <td>{{ Number(row.commission_percentage).toFixed(2) }} %</td>
              <td>{{ Number(row.commission_earned).toFixed(2) }}</td>
              <td>
                <el-tooltip content="Visualizar producto vendidos" placement="bottom">
                  <vs-button gradient success animation-type="scale" style="min-width: 32px; height: 32px; padding: 0;"
                    @click.prevent="getProd(row.id)">
                    <i class="fas fa-eye" style="color: #fff;"></i>
                  </vs-button>
                </el-tooltip>
              </td>
              <td class="text-center">
                <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                  <vs-button gradient primary animation-type="scale" style="min-width: 32px; height: 32px; padding: 0;"
                    @click.prevent="clickCreate(row.id)">
                    <i class="fa fa-edit"></i>
                  </vs-button>

                  <!-- <vs-button
                    gradient
                    danger
                    animation-type="scale"
                    style="min-width: 32px; height: 32px; padding: 0;"
                    @click.prevent="clickDelete(row.id)"
                    >
                    <i class="fa fa-trash"></i>
                    </vs-button> -->

                  <vs-button gradient warn animation-type="scale" style="min-width: 32px; height: 32px; padding: 0;"
                    @click.prevent="clickDisable(row.id)" v-if="row.active">
                    <i class="fa fa-ban"></i>
                  </vs-button>
                  <vs-button gradient success animation-type="scale" style="min-width: 32px; height: 32px; padding: 0;"
                    @click.prevent="clickEnable(row.id)" v-else>
                    <i class="fa fa-check"></i>
                  </vs-button>
                </div>


              </td>
            </tr>


            <template v-slot:footer>
              <tr style="background: #f5f5f5; font-weight: bold;">
                <td colspan="4" class="text-right" style="font-weight: bold; font-size: 1.1rem;">Totales:</td>
                <td style="font-weight: bold; font-size: 1.1rem;">{{ totals.cpe }}</td>
                <td style="font-weight: bold; font-size: 1.1rem;">{{ totals.nv }}</td>
                <td style="font-weight: bold; font-size: 1.1rem;">{{ totals.totalVentas }}</td>
                <td></td>
                <td style="font-weight: bold; font-size: 1.1rem;">{{ totals.totalComision }}</td>
                <td colspan="2"></td>
              </tr>
            </template>
          </data-table>
        </div>
      </div>
    </div>
    <import-excel :showDialog.sync="showDialogImportExcel"></import-excel>
  </div>
</template>
<script>
import DataTable from "../../components/DataTableStaff.vue";
import { deletable } from "../../mixins/deletable";
import ImportExcel from "./partials/import_excel.vue";

export default {
  props: ["typeUser"],
  mixins: [deletable],
  components: {
    DataTable,
    ImportExcel
  },
  data() {
    return {
      showDialogImportExcel: false,
      showDialog: false,
      showDialogProd: false,
      resource: "sellers",
      recordId: null,
      records: [],
      sellers: [],
      title: null,
      establishments: [],
      document_types: [],
      ListSoldItems: []
    };
  },

  computed: {
    totals() {
      // Sumar los totales de cada columna relevante
      const cpe = this.sellers.reduce((acc, s) => acc + Number(s.documents_total || 0), 0);
      const nv = this.sellers.reduce((acc, s) => acc + Number(s.sale_notes_total || 0), 0);
      const totalVentas = this.sellers.reduce((acc, s) => acc + Number(s.total_sales || 0), 0);
      const totalComision = this.sellers.reduce((acc, s) => acc + Number(s.commission_earned || 0), 0);
      return {
        cpe: cpe.toFixed(2),
        nv: nv.toFixed(2),
        totalVentas: totalVentas.toFixed(2),
        totalComision: totalComision.toFixed(2)
      };
    }
  },
  created() {
    this.$eventHub.$on("reloadData", () => {
      this.getData();
    });
    this.getData();
    this.getTables();
  },
  methods: {
    clickDownloadExcel() {
      this.showDialogImportExcel = true;
    },

    
    getProd(id) {
      this.ListProdId = id;
      console.log("Ver el id del vendedor:", id);
      this.showDialogProd = true;
    },
    async getTables() {
      const response = await this.$http(`${this.resource}/tables`);
      console.log(response);
      const { establishments, document_types } = response.data;
      this.establishments = establishments;
      this.document_types = document_types;
      // this.establishments = response.data.data.establishments;
    },
    getData() {
      this.$http.get(`/${this.resource}/records`).then(response => {
        console.log("Datos de vendedores:", response.data.data);
        this.records = response.data.data;
        this.sellers = response.data.data;
      });
    },
    clickCreate(recordId = null) {
      console.log("sadas");
      this.recordId = recordId;
      this.showDialog = true;
    },
    clickDelete(id) {
      this.destroy(`/${this.resource}/delete/${id}`).then(() =>
        this.$eventHub.$emit("reloadData")
      );
    },
    clickDisable(id) {
      this.disable(`/${this.resource}/enabled/${0}/${id}`).then(() =>
        this.$eventHub.$emit("reloadData")
      );
    },
    clickEnable(id) {
      this.enable(`/${this.resource}/enabled/${1}/${id}`).then(() =>
        this.$eventHub.$emit("reloadData")
      );
    }
  }
};
</script>
