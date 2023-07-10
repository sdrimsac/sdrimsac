<template>
  <div>
    <div class="container-fluid p-l-0 p-r-0">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h6><span>Reporte de Series Vendidas</span></h6>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/dashboard">Dashboard</a>
              </li>
              <li class="breadcrumb-item active">
                <span class="text-muted">Reporte de Series Vendidas</span>
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid p-l-0 p-r-0">
      <div class="card mb-0">
        <div class="card-header bg-primary">
          <h6 class="my-0 text-white">Series Vendidas</h6>
        </div>
        <div class="card-body">
          <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="row mt-2">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label">Almacen</label>
                  <el-select
                    v-model="form.establishment_id"
                    clearable
                    filterable
                  >
                    <el-option
                      v-for="option in warehouses"
                      :key="option.id"
                      :value="option.id"
                      :label="option.description"
                    ></el-option>
                  </el-select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="control-label">Fecha Inicio</label>
                  <el-date-picker
                    style="width: 100%"
                    v-model="form.date_start"
                    value-format="yyyy-MM-dd"
                    
                  >
                  </el-date-picker>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="control-label">Fecha Final</label>
                  <el-date-picker
                    style="width: 100%"
                    v-model="form.date_end"
                    value-format="yyyy-MM-dd"
                    
                  >
                  </el-date-picker>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="control-label">Cliente</label>
                  <el-select
                        v-model="form.personas"
                        clearable
                        filterable>
                        <el-option
                            v-for="option in ListPersonas"
                            :key="option.id"
                            :value="option.id"
                            :label="option.degres_desc"
                        ></el-option>
                    </el-select>
                  
                  
                </div>
              </div>

              <div
                class="
                  col-lg-8 col-md-8 col-md-8 col-sm-12
                  d-flex
                  align-items-end
                "
              >
                <el-button
                  class="submit"
                  type="primary"
                  @click.prevent="getRecordsByFilter"
                  :loading="loading_submit"
                  icon="el-icon-search"
                  >Buscar</el-button
                >
                <template v-if="records.length > 0 || NotasDeventas.length > 0 ">
                 
                  <el-button
                  style="background-color: #217346;"
                    class="submit"
                    
                    @click.prevent="clickDownload('excel')"
                    ><i class="fa fa-file-excel" style="color: white;" ></i> <span style="color: white;">EXCEL</span></el-button
                  >
                  <el-button
                    class="submit"
                    type="success"
                    @click.prevent="openWhastappForm()"
                    ><i class="icofont-brand-whatsapp"></i> WHATSAPP</el-button
                  >
                </template>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <el-tabs v-model="activeName" type="card" tab-position="top">
              <el-tab-pane
                        label="Facturas - Boletas"
                        name="documents"
                    >
                    <div class="row">
                      <el-pagination
                              @current-change="getRecordsByFilter"
                              layout="total, prev, pager, next"
                              :total="pagination.documents.total"
                              :current-page.sync="pagination.documents.current_page"
                              :page-size="pagination.documents.per_page">
                      </el-pagination>
                
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-condensed  table-responsive" style="width: 100%; white-space: nowrap;">
                        <thead>
                          <tr slot="heading">
                            <th>#</th>
                            <th>Almacen</th>
                            <th>COD. INTERNO</th>
                            <th>PRODUCTO</th>
                            <th>SERIE</th>
                            <th>CLIENTE</th>
                            <th>NR. DOC.</th>
                            <th>F. VENTA</th>
                            <th>P. VENTA</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(row, index) in records" :key="index">
                            <td>{{ index + 1 }}</td>
                            <td>
                              
                                {{ row.establish_description }}
                              
                            </td>
                            <td>
                              {{ row.codigoInterno }}
                              
                            </td>
                            
                            <td>
                              
                                {{ row.descripcion }}
                              
                            </td>
                            <td>
                              {{
                                row.series
                              }}
                            </td>
                            <td>
                              {{row.pers_name  }}
                            </td>
                            <td>
                              {{ row.docSeries }}
                            </td>
                            
                            <td>
                              {{
                                row.docDate
                              }}
                            </td>
                            <td class="text-center">
                              {{
                                Number(row.itemValue).toFixed(2)
                              }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <div></div>
                    </div>  
              </el-tab-pane>
              <el-tab-pane
                        label="Notas De ventas "
                        name="SalesNotes"
                    >
                    <div class="row">
                      <el-pagination
                              @current-change="getRecordsByFilter"
                              layout="total, prev, pager, next"
                              :total="pagination.saleNotes.total"
                              :current-page.sync="pagination.saleNotes.current_page"
                              :page-size="pagination.saleNotes.per_page">
                      </el-pagination>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-condensed  table-responsive" style="width: 100%; white-space: nowrap;">
                        <thead>
                          <tr slot="heading">
                            <th>#</th>
                            <th>Almacen</th>
                            <th>COD. INTERNO</th>
                            <th>PRODUCTO</th>
                            <th>SERIE</th>
                            <th>CLIENTE</th>
                            <th>NR. DOC.</th>
                            <th>F. VENTA</th>
                            <th>P. VENTA</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(row, index) in NotasDeventas" :key="index">
                            <td>{{ index + 1 }}</td>
                            <td>
                              {{ row.establish_description }}
                            </td>
                            <td>
                              {{ row.codigoInterno }}
                            </td>
                            <td>
                              {{ row.descripcion }}
                            </td>
                            <td>
                              {{ row.series }}
                            </td>
                            <td>
                              {{ row.pers_name }}
                            </td>
                            <td>
                             {{  row.sale_notes_series }}
                            </td>
                            <td>
                              {{ row.docDate }}
                            </td>
                            <td class="text-center">
                              {{ Number(row.itemValue).toFixed(2) }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <div></div>
                    </div> 
              </el-tab-pane>
            </el-tabs>
            
            
            
          </div>
        </div>
      </div>
    </div>
    
  </div>
</template>

<script>
import queryString from "query-string";
import moment from "moment";

export default {
  props: [],
  data() {
    return {
      activeName: documents, 
      totalGeneral: null,
      totalGain: 0,
      warehouses: [],
      loading_submit: false,
      showDialog: false,
      showDialogClose: false,
      messageReport: null,
      resourceReport: null,
      open_cash: true,
      resource: "series",
      recordId: null,
      data_closed: moment().format("YYYY-MM-DD"),
      date_start: moment().format("YYYY-MM-DD"),
      month_start: moment().format("YYYY-MM"),
      cash: null,
      otroNombre: false,
      form: {},
      records: [],
      categories: [],
      pagination: { 
        saleNotes: {},
        documents: {},
      },
      showWhatsappForm: false,
      ListPersonas: [],
      NotasDeventas: [],
    };
  },
  async created() {
    await this.$http.get(`/reports/inventory/tables`).then((response) => {
      this.warehouses = response.data.warehouses;
      this.categories = response.data.categories;
      
    });
  },
  mounted(){
    this.getPersonas();
  },
  methods: {
    async getPersonas(){
            
            try {
                const response = await this.$http.get(`${this.resource}/getPersonas`)
                const{data , status} = response
                 
                if(status == 200) {
                    this.ListPersonas = [...data.personas.map(s =>{
                            s.degres_desc = `${s.name} - ${s.number} `
                             
                            return {
                             ...s              
                              };
                    })];         
                }else{
                    console.log(response)
                }
                
            } catch (error) {
                console.log(error);
            }
        },
    async getRecordsByFilter(){
        
        try {
            if(this.activeName === 'documents'){
              const response = await axios.post(`${this.resource}/getDataSeries?page=${this.pagination.documents.current_page}`,{
                form : this.form
                });

                const {data , status } = response; 
                if (status == 200) {
                  
                    this.records = data.datosSeries 
                    this.pagination.documents.total = data.dataPaginated.total
                    this.pagination.documents.current_page = data.dataPaginated.current_page
                    this.pagination.documents.per_page = data.dataPaginated.per_page
                }

                
            }
            if(this.activeName === 'SalesNotes'){
              const response = await axios.post(`${this.resource}/getDataSeriesSalesnotes?page=${this.pagination.saleNotes.current_page}`,{
                form : this.form
                });

                const {data , status } = response; 
                if (status == 200) {
                  this.NotasDeventas = data.datosSeries;
                  this.pagination.saleNotes.total = data.dataPaginated.total
                    this.pagination.saleNotes.current_page = data.dataPaginated.current_page
                    this.pagination.saleNotes.per_page = data.dataPaginated.per_page
                }

                
            }
                  
        } catch (error) {
            console.log(error)
            
        }
    },
    async clickDownload(){

      
/* 
      try {
            if(this.activeName === 'documents'){
              const response = await axios.post(`${this.resource}reporteexcel`,{
                form : this.form
                });

                const {data , status } = response; 
                if (status == 200) {
                  
                    
                }

                
            }
            if(this.activeName === 'SalesNotes'){
              const response = await axios.post(`${this.resource}/getDataSeriesSalesnotes?page=${this.pagination.saleNotes.current_page}`,{
                form : this.form
                });

                const {data , status } = response; 
                if (status == 200) {
                  this.NotasDeventas = data.datosSeries;
                  this.pagination.saleNotes.total = data.dataPaginated.total
                    this.pagination.saleNotes.current_page = data.dataPaginated.current_page
                    this.pagination.saleNotes.per_page = data.dataPaginated.per_page
                }

                
            }
                  
        } catch (error) {
            console.log(error)
            
        } */
    }
  },
};
</script>
