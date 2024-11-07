<template>
  <div>
    <div class="row">
      <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="row" v-if="applyFilter">
          <div class="col-lg-2 col-md-2 pb-2">
            <div class="form-group">
              <div style="width:100px">Filtrar por:</div>
              <el-select
                v-model="search.column"
                placeholder="Select"
                @change="changeClearInput"
                clearable
              >
                <el-option v-for="(label, key) in columns" :key="key" :value="key" :label="label"></el-option>
              </el-select>
            </div>
          </div>
          <div class="col-lg-2 col-md-2 pb-2">
            <div class="form-group">
              <label class="control-label w-100">Buscar</label>
              <template
                v-if="
                                search.column == 'date_of_issue' ||
                                    search.column == 'date_of_due' ||
                                    search.column == 'date_of_payment' ||
                                    search.column == 'delivery_date'
                            "
              >
                <el-date-picker
                  v-model="search.value"
                  type="date"
                  style="width: 100%;"
                  placeholder="Buscar"
                  value-format="yyyy-MM-dd"
                  @change="getRecords"
                ></el-date-picker>
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
          <div class="col-lg-2 col-md-2 pb-2">
            <div class="form-group">
              <label class="control-label w-100">Por Mes</label>

              <el-date-picker
                v-model="search.month_start"
                type="month"
                style="width: 100%;"
                placeholder="Buscar por mes"
                value-format="yyyy-MM"
                @change="changeClearInput"
              ></el-date-picker>
            </div>
          </div>
          <div class="col-lg-2 col-md-2 pb-2">
            <div class="form-group">
              <label class="control-label w-100">Por dia</label>

              <el-date-picker
                v-model="search.date_of_issue"
                type="date"
                style="width: 100%;"
                placeholder="Buscar por dia"
                value-format="yyyy-MM-dd"
                @change="changeClearInput"
              ></el-date-picker>
            </div>
          </div>
          <div class="col-lg-2 col-md-2 pb-2">
            <div class="form-group">
              <label class="control-label w-100">Estado</label>
              <el-select 
                v-model="search.active" 
                placeholder="Select Estado" 
                @change="changeClearInput" 
                clearable>
                <el-option :value="1" label="Activo"></el-option>
                <el-option :value="0" label="Inactivo"></el-option>
              </el-select>
            </div>
          </div>
          <div class="col-lg-2 col-md-2 pb-2">
            <div class="form-group">
              <el-button
                class="submit"
                type="success"
                icon="el-icon-tickets"
                @click.prevent="clickDownload('excel')"
              >Exportar Excel</el-button>
            </div>
          </div>
        </div>
      </div>
      <br />

      <div class="col-md-12">
        <br />
        <div class="table-responsive">
          <div>
            <el-pagination
              @current-change="getRecords"
              layout="total, prev, pager, next"
              :total="pagination.total"
              :current-page.sync="pagination.current_page"
              :page-size="pagination.per_page"
            ></el-pagination>
          </div>
          <table class="table table-striped">
            <thead>
              <slot name="heading"></slot>
            </thead>
            <tbody>
              <slot v-for="(row, index) in records" :row="row" :index="customIndex(index)"></slot>
            </tbody>
          </table>
          <div>
            <el-pagination
              @current-change="getRecords"
              layout="total, prev, pager, next"
              :total="pagination.total"
              :current-page.sync="pagination.current_page"
              :page-size="pagination.per_page"
            ></el-pagination>
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
    resource: String,
    applyFilter: {
      type: Boolean,
      default: true,
      required: false
    }
    /* typeUser: {
      type: String,
      default: "admin"
    }, */
    /* sellers: {
      type: Array,
      default: () => []
    }, */
    /* fromAdmin: {
      type: Boolean,
      default: false,
      required: false
    } */
  },
  data() {
    return {
      search: {
        column: null,
        value: null,
        date_of_issue: null,
        active: 1
      },
      columns: [],
      records: [],
      pagination: {},
      array_district: []
    };
  },
  computed: {},
  created() {
    this.$eventHub.$on("reloadData", () => {
      this.getRecords();
    });
  },
  async mounted() {
    let column_resource = _.split(this.resource, "/");
    // console.log(column_resource)
    await this.$http
      .get(`/${_.head(column_resource)}/columns`)
      .then(response => {
        this.columns = response.data;
        this.search.column = _.head(Object.keys(this.columns));
      });
    await this.getRecords();
  },
  methods: {
    changeEndDate() {
      this.search.date_of_issue = null;
    },
    changeDisabledDates() {
      this.search.date_of_issue = null;
      if (this.search.d_end < this.search.d_start) {
        this.search.d_end = this.search.d_start;
      }
    },
    /* clickDownload() {
      window.open(`/${this.resource}/ventas-seller`, "_blank");
    }, */
    clickDownload() {
      let parameters = this.getQueryParameters();
      window.open(`/${this.resource}/ventas-seller?${parameters}`, "_blank");
    },
    customIndex(index) {
      return (
        this.pagination.per_page * (this.pagination.current_page - 1) +
        index +
        1
      );
    },
    getRecords() {
      console.log(this.resource);
      return this.$http
        .get(`/${this.resource}/records?${this.getQueryParameters()}`)
        .then(response => {
          console.log(response.data);
          this.records = response.data.data;
          this.pagination = response.data.meta;
          this.pagination.per_page = parseInt(response.data.meta.per_page);
        });
    },
    getQueryParameters() {
      return queryString.stringify({
        page: this.pagination.current_page,
        limit: this.limit,
        ...this.search
      });
    },
    changeClearInput() {
      this.search.value = "";
      this.getRecords();
    }
  }
};
</script>
