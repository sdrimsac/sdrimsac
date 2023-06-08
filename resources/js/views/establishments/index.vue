<template>
    <div>
        <!-- <div class="page-title-container mb-0">
            <div class="row">
                 <div class="col-12 col-md-7">
                    <h1 class="mb-0 pb-0 display-4" id="title">Establecimiento</h1>
                    <nav
                        class="breadcrumb-container d-inline-block"
                        aria-label="breadcrumb"
                    >
                        <ul class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Establecimiento</span>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="col-12 col-md-5 d-flex align-items-start justify-content-end">
                    <button
                        type="button"
                        class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto add-datatable"
                        @click.prevent="clickCreate()"
                    >
                        <i data-cs-icon="plus"></i>
                        <span>Nuevo</span>
                    </button>
                 </div>
             </div>
        </div> -->

        <!-- <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
              <div class="row">
                <div class="col-sm-6">
                  <h6><span>Establecimientos</span></h6>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                     <li class="breadcrumb-item active"><span class="text-muted">Establecimientos</span></li>
                  </ol>
                </div>
                <div class="col-sm-6">
                  <div class="bookmark">
                  <ul>
                      <li>
                          <el-tooltip class="item" effect="dark" content="Nuevo" placement="bottom-end">
                            <a href="javascript:void(0)" @click.prevent="clickCreate()" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
                                <i data-feather="plus-circle"></i>
                            </a>
                          </el-tooltip>
                      </li>

                    </ul>
                  </div>
                 </div>
              </div>
            </div>
          </div> -->
        <!-- Container-fluid starts-->
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card">
                <div class="no-radius card-header bg-primary d-flex">
                    <h6 class="my-0 text-white">Listado de establecimientos</h6>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-end">
                        <button
                            type="button"
                            class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto add-datatable"
                            @click.prevent="clickCreate()"
                        >
                            <i data-cs-icon="plus"></i>
                            <span>Nuevo</span>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Descripción</th>
                                    <th class="text-end">Código</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(row, index) in records"
                                    :key="index"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ row.description }}</td>
                                    <td class="text-end">{{ row.code }}</td>
                                    <td class="text-end">
                                        <button
                                            type="button"
                                            class="btn waves-effect waves-light btn-sm btn-info"
                                            @click.prevent="clickCreate(row.id)"
                                        >
                                            Editar
                                        </button>
                                        <button
                                            type="button"
                                            class="btn waves-effect waves-light btn-sm btn-danger"
                                            v-if="typeUser != 'integrator'"
                                            @click.prevent="clickDelete(row.id)"
                                        >
                                            Eliminar
                                        </button>
                                        <button
                                            type="button"
                                            class="btn waves-effect waves-light btn-sm btn-warning"
                                            @click.prevent="clickSeries(row.id)"
                                        >
                                            Series
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-custom btn-sm  mt-2 mr-2" v-if="typeUser != 'integrator'" @click.prevent="clickCreate()"><i class="fa fa-plus-circle"></i> Nuevo</button>
                        </div>
                    </div> -->
                </div>
                <establishments-form
                    :seriesDefault.sync="seriesDefault"
                    :soap_type_id="soap_type_id"
                    :showDialog.sync="showDialog"
                    :number.sync="number"
                    :recordId="recordId"
                    @generateSerie="generateSerie"
                ></establishments-form>
                <establishment-series
                    :showDialog.sync="showDialogSeries"
                    :establishmentId="recordId"
                ></establishment-series>
            </div>
        </div>
    </div>
</template>

<script>
import EstablishmentsForm from "./form1.vue";
import { deletable } from "../../mixins/deletable";
import EstablishmentSeries from "./partials/series.vue";

export default {
    props: ["typeUser", "soap_type_id"],
    mixins: [deletable],
    components: { EstablishmentsForm, EstablishmentSeries },
    data() {
        return {
            showDialog: false,
            resource: "establishments",
            recordId: null,
            records: [],
            showDialogSeries: false,
            seriesDefault: [],
            number: 1
        };
    },
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getData();
        });
        this.getData();
        this.series();
    },
    methods: {
        generateSerie() {
            let num = this.number;
            console.log(this.number, " aa");
            if (num >= 100) {
                console.error("El número es mayor o igual a 100");
                return;
            }
            let numStr = num.toString().padStart(2, "0");
            const fCode = `F0${numStr}`;
            const bCode = `B0${numStr}`;
            const nCode = `NV${numStr}`;
            this.seriesDefault = [
                {
                    id: "01",
                    serie: fCode
                },
                {
                    id: "03",
                    serie: bCode
                },
                {
                    id: "80",
                    serie: nCode
                }
            ];
        },
        async series() {
            const response = await this.$http.get(`/series/records/all`);
            if (response.status == 200) {
                let {
                    data: { data }
                } = response;
                if (data.length != 0) {
                    data = data.map(d => d.number);

                    const onlyNumber = data.map(elemento => {
                        return parseInt(elemento.match(/\d+$/)[0]);
                    });
                    const bigNumber = Math.max(...onlyNumber);
                    const result = bigNumber + 1;
                    this.number = result;
                }

                this.generateSerie(this.number);
                console.log(this.seriesDefault);
            }
        },
        getData() {
            this.$http.get(`/${this.resource}/records`).then(response => {
                this.records = response.data.data;
            });
        },
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickSeries(recordId = null) {
            this.recordId = recordId;
            this.showDialogSeries = true;
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
