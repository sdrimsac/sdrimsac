<template>
  <div>
    <div class="row">
      <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="row" v-if="applyFilter">
          <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
            <label style="width:100%">Filtrar por:</label>
            <el-select v-model="search.column" placeholder="Select" @change="changeClearInput">
              <el-option v-for="(label, key) in columns" :key="key" :value="key" :label="label"></el-option>
            </el-select>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
            <label for="value">Buscar</label>
            <template
              v-if="
                                search.column == 'date_of_issue' ||
                                    search.column == 'date_of_due' ||
                                    search.column == 'date_of_payment' ||
                                    search.column == 'delivery_date' ||
                                    search.column == 'date'
                            "
            >
              <template v-if="resource != 'caja/worker/expenses'">
                <el-date-picker
                  v-model="search.value"
                  type="date"
                  style="width: 100%;"
                  placeholder="Buscar"
                  value-format="yyyy-MM-dd"
                  @change="getRecords"
                ></el-date-picker>
              </template>
              <template v-else>
                <el-date-picker
                  v-model="search.value"
                  type="daterange"
                  range-separator="A"
                  start-placeholder="Desde"
                  value-format="yyyy-MM-dd"
                  end-placeholder="Hasta"
                  @change="getRecords"
                ></el-date-picker>
              </template>
            </template>
            <template v-else-if="search.column == 'district_id'">
              <el-select
                v-model="search.value"
                @change="getRecords"
                placeholder="Seleccione el Distrito"
              >
                <el-option
                  v-for="item in array_district"
                  :key="item.id"
                  :label="item.description"
                  :value="item.id"
                ></el-option>
              </el-select>
            </template>
            <template v-else-if="search.column == 'seller_id'">
              <el-select
                v-model="search.value"
                @change="getRecords"
                placeholder="Seleccione el vendedor"
              >
                <el-option
                  v-for="(item, idx) in sellers"
                  :key="idx"
                  :label="item.name"
                  :value="item.id"
                ></el-option>
              </el-select>
            </template>
            <template v-else-if="search.column == 'active' && resource=='caja/workers-type'">
              <el-select
                v-model="search.value"
                @change="getRecords"
                placeholder="Seleccione el estado"
              >
                <el-option
                  v-for="(item, idx) in [
                                        { id: 1, description: 'Activado' },
                                        { id: 0, description: 'Desactivado' }
                                    ]"
                  :key="idx"
                  :label="item.description"
                  :value="item.description"
                ></el-option>
              </el-select>
            </template>
            <template v-else>
              <el-input
                placeholder="Buscar"
                v-model="search.value"
                style="width: 100%;"
                prefix-icon="el-icon-search"
                @input="getRecords"
              ></el-input>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import queryString from "query-string";

export default {
  props: {
    typeUser: {
      type: String,
      default: "admin"
    },
    sellers: {
      type: Array,
      default: () => []
    },
    resource: String,
    applyFilter: {
      type: Boolean,
      default: true,
      required: false
    },
    fromAdmin: {
      type: Boolean,
      default: false,
      required: false
    },
    config: Object
  },
  data() {
    return {
      cashes: [],
      search: {
        column: null,
        value: null
      },
      columns: [],
      records: [],
      pagination: {},
      array_district: [],
      time: null,
      warehouses: [],
      areas: []
    };
  },
  computed: {},
  created() {
    this.$eventHub.$on("reloadData", () => {
      this.getRecords();
    });
    if (this.resource == "caja/cash-transfer/report") {
      this.getCashes();
    }
    if (this.resource == "items") {
      this.$http.get(`/warehouses/records`).then(response => {
        this.warehouses = response.data.data;
      });

      this.$http.get(`/caja/areas/records`).then(response => {
        this.areas = response.data.data;
      });
    }
  },
  async mounted() {
    let column_resource = this.resource; // _.split(this.resource, '/')
    await this.$http.get(`/${this.resource}/columns`).then(response => {
      this.columns = response.data;
      this.search.column = _.head(Object.keys(this.columns));
    });
    if (this.resource !== "caja/cash-transfer/report") {
      await this.getRecords();
    }
  },
  methods: {
    total_income() {
      return this.records.reduce((acc, item) => acc + Number(item.income), 0);
    },
    total_expense() {
      return this.records.reduce((acc, item) => acc + Number(item.expense), 0);
    },
    getCashes() {
      this.$http.get(`/caja/cash-transfer/cashes-principal`).then(response => {
        this.cashes = response.data.cashes;
        let [cash] = this.cashes;
        if (cash) {
          this.search.cash_id = cash.id;
          this.getRecords();
        }
      });
    },
    clickDownload(type) {
      this.$emit("clickReport", this.search, type);
    },
    clickDownloadForImport() {
      this.$emit("clickReportForImport", this.search);
    },

    customIndex(index) {
      if (this.resource == "caja/cash-transfer/report") {
        return index + 1;
      }
      return (
        this.pagination.per_page * (this.pagination.current_page - 1) +
        index +
        1
      );
    },
    getRecords() {
      if (this.time) {
        clearTimeout(this.time);
      }
      //   this.$http.get(`/filtrar_distritos/records`)
      // .then(response => {
      //     this.array_district = response.data.district

      // })
      this.time = setTimeout(async () => {
        let url = `/${this.resource}/records?${this.getQueryParameters()}`;
        if (this.fromAdmin) {
          url = `/${
            this.resource
          }/records?${this.getQueryParameters()}&fromAdmin=true`;
        }
        return this.$http.get(url).then(response => {
          if (this.resource !== "caja/cash-transfer/report") {
            this.records = response.data.data;
            this.pagination = response.data.meta;
            this.pagination.per_page = parseInt(response.data.meta.per_page);
          } else {
            let data = response.data;
            this.records = data.data;
          }
        });
      }, 350);
    },
    getQueryParameters() {
      if (
        this.search.column == "date" &&
        this.search.value &&
        typeof this.search.value == "object"
      ) {
        this.search.value = this.search.value.join(",");
      }
      return queryString.stringify({
        page: this.pagination.current_page,
        limit: this.limit,
        value: this.search.value,
        column: this.search.column,
        cash_id: this.search.cash_id,
        end_date: this.search.end_date,
        warehouse_id: this.search.warehouse_id,
        area_id: this.search.area_id
      });
    },
    changeClearInput() {
      this.search.value = "";
      this.getRecords();
    }
  }
};
</script>
