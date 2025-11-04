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
          <el-button type="button" class="btn_buscar" style="margin-right: 5px;" @click.prevent="clickDownloadExcel">
            Import Excel del personal
          </el-button>
        </div>
        <div class="card-body">
          <data-table :resource="resource">
            <tr slot="heading" class="bg-primary">
              <th class="text-white" style="width: 40px;">#</th>
              <th class="text-white" style="width: 180px;">Personal</th>
              <th class="text-white" style="width: 120px;">Fecha y hora de ingreso</th>
              <th class="text-white" style="width: 150px;">Horas Trabajadas</th>
              <th class="text-white" style="width: 100px;"> Fecha y Hora de salida</th>
              <th class="text-white" style="width: 100px;">Horas Trabajadas</th>
              <th class="text-white" style="width: 120px;">Total Horas Extras</th>
              <th class="text-white" style="width: 120px;">Saldo Extra</th>
              <th class="text-white" style="width: 100px;">Adelantos</th>
              <th class="text-white text-center" style="width: 100px;">Acciones</th>
            </tr>
            <tr slot-scope="{ index, row }">
              <td>{{ index + 1 }}</td>
              <td>{{ row.person_name }}</td>
              <td>{{ row.date_daily }}</td>
              <td>
                <div v-if="row.pairs" style="display:flex; flex-direction:column; gap:6px;">
                  <div
                    v-for="(p, i) in (typeof row.pairs === 'string' ? JSON.parse(row.pairs) : row.pairs)"
                    :key="i"
                    style="display:flex; justify-content:space-between; align-items:center; padding:6px 8px; background:#f7f9fb; border-radius:6px; border:1px solid #e3e7ea;"
                  >
                    <div style="display:flex; flex-direction:column;">
                      <div style="font-size:0.95rem; color:#222;">
                        <strong style="margin-right:6px;">{{ p.entrance }}</strong>
                        <span style="opacity:0.6; margin:0 6px;">→</span>
                        <strong style="margin-left:6px;">{{ p.exit }}</strong>
                      </div>
                      <small style="color:#6b7280;">{{ p.exit_date }}</small>
                    </div>
                    <div style="font-weight:600; white-space:nowrap; color:#111;">
                      {{ Math.floor((p.minutes||0)/60) }}h {{ ('0' + ((p.minutes||0)%60)).slice(-2) }}m
                    </div>
                  </div>

                  <div style="display:flex; justify-content:space-between; padding:6px 8px; margin-top:4px; background:#eef2f6; border-radius:6px; border:1px solid #dde6eb; font-weight:700;">
                    <div>Total</div>
                    <div>
                      {{ Math.floor(((typeof row.pairs === 'string' ? JSON.parse(row.pairs) : row.pairs).reduce((s,p)=>s+(p.minutes||0),0))/60) }}h
                      {{ ('0' + (((typeof row.pairs === 'string' ? JSON.parse(row.pairs) : row.pairs).reduce((s,p)=>s+(p.minutes||0),0))%60)).slice(-2) }}m
                    </div>
                  </div>
                </div>

                <div v-else style="color:#6c757d; text-align:center; padding:8px;">-</div>
              </td>
              <td>{{ row.date_end_daily }}</td>
              <td>{{ row.horas_trabajadas }}</td>
              <td>{{ Number(row.overtime).toFixed(2) }}</td>
              <td>{{ Number(row.amount_extra).toFixed(2) }}</td>
              <td class="text-center">
                <!-- <div style="display: flex; gap: 5px; flex-wrap: wrap;"> -->
                <el-button type="primary" gradient animation-type="scale"
                  style="min-width: 32px; height: 32px; padding: 0; margin-right: 5px;"
                  @click.native.prevent="clickAdelanto(row)">
                  <i class="fa fa-money-bill-wave"></i>
                </el-button>
                <!-- <el-button gradient primary animation-type="scale" style="min-width: 32px; height: 32px; padding: 0;"
                  @click.prevent="clickCreate(row.id)">
                  <i class="fa fa-edit"></i>
                </el-button> -->
              </td>
            </tr>
          </data-table>
        </div>
      </div>
    </div>
    <import-excel :showDialog.sync="showDialogImportExcel"></import-excel>
    <adelanto :showDialog.sync="showDialogAdelanto" :person_id="person_id"></adelanto>
  </div>
</template>
<script>
import DataTable from "../../components/DataTableStaff.vue";
import { deletable } from "../../mixins/deletable";
import ImportExcel from "./partials/import_excel.vue";
import Adelanto from "./partials/adelanto.vue";

export default {
  props: ["typeUser"],
  mixins: [deletable],
  components: {
    DataTable,
    ImportExcel,
    Adelanto
  },
  data() {
    return {
      showDialogAdelanto: false,
      showDialogImportExcel: false,
      showDialog: false,
      person_id: null,
      showDialogProd: false,
      resource: "staff",
      recordId: null,
      records: [],
      staff: [],
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
        console.log("Primer registro de vendedores:", response.data.data && response.data.data.length ? response.data.data[0] : null);
        this.records = response.data.data;
      });
    },

    clickAdelanto(row = null) {
      console.log('clickAdelanto row:', row);
      const person_id = row && (row.person_id || row.person?.id || row.id) ? (row.person_id || row.person?.id || row.id) : null;
      this.person_id = person_id;
      console.log('ver si llega el id', this.person_id);
      this.showDialogAdelanto = true;
    },

    clickCreate(recordId = null) {
      // Open the create/edit dialog for staff records
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
