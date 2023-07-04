<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Registros de consignación</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashbodard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Consignación</span>
                            </li>
                        </ol>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end">
                        <div class="bookmark">
                            <button
                                type="button"
                                class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                                @click.prevent="clickCreate()"
                            >
                                <i class="icofont-plus-circle"></i>
                                <span>Nuevo</span>
                            </button>
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading">
                            <th>#</th>
                            <th class="text-center">Fecha de consignación</th>
                            <th class="text-center">Fecha de liquidación</th>
                            <th class="text-center">Vendedor</th>
                            <th class="text-center">Productos</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Estado</th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td class="text-center">{{row.date_of_issue}}</td>
                            <td class="text-center">{{row.date_of_end}}</td>
                            <td class="text-center">{{row.person.name}}
                                <br>
                                <small>{{row.person.number}}</small>
                            </td>
                            <td class="text-center">
                                <el-button
                                @click="clickDetail(row)"
                                size="mini"
                                >
                                    <i class="icofont-eye-alt">
                                        {{row.stock}}
                                    </i>
                                </el-button>

                            </td>
                            <td class="text-center">{{row.total}}</td>
                            <td class="text-center">{{row.active ? 'Activo' : 'Desactivado'}}</td>
                        </tr>
                    </data-table>
                </div>
            </div>
        </div>
    <consignment-form
    :showDialog.sync="showDialog"
    ></consignment-form>
    <consignment-items
    :recordId="recordId"
    :showDialog.sync="showDialogDetail"
    ></consignment-items>
    </div>
</template>
<style>
td {
    color: #000;
}
</style>
<script>
// import DataTable from "./partials/DataTable.vue";
import DataTable from "./partials/datatable.vue";
import ConsignmentForm from "./partials/form.vue"
import ConsignmentItems from "./partials/items.vue"
import { deletable } from "../../../../../../resources/js/mixins/deletable";

export default {
    props: ["configuration"],
    mixins: [deletable],
    components: {
        DataTable,
        ConsignmentForm,
        ConsignmentItems
    },
    data() {
        return {
            showDialogDetail:false,
            recordId:null,
            showDialog:false,
            resource: "consignment",
            showDialogDetail: false,
            showDialogPayments: false,
            showDialogOptions: false,
            showDialogGenerate: false,
            saleNotesNewId: null,
            recordId: null,
            currentNumber: null,
            boxes: [],
            editSale: false,
            showDialogOptions: false,
            
         
        };
    },
    created() {},
    filters: {
        
    },
    methods: {
     clickDetail(row){
        this.recordId = row.id;
        this.showDialogDetail = true;
     },
        clickDownload(external_id) {
            window.open(
                `/sale-notes/downloadExternal/${external_id}`,
                "_blank"
            );
        },
        clickOptions(recordId) {
            this.saleNotesNewId = recordId;
            this.showDialogOptions = true;
        },
        clickDetail(record) {
            this.recordId = record.id;
            this.currentNumber = record.full_number;
            this.boxes = record.boxes;
            this.showDialogDetail = true;
        },
        clickGenerate(recordId) {
            this.recordId = recordId;
            this.showDialogGenerate = true;
        },
        clickPayment(recordId) {
            this.recordId = recordId;
            this.showDialogPayments = true;
        },
        clickSchedule(recordId) {
            window.open(`/sale-notes/schedule/${recordId}`, "_blank");
        },
        clickContract(recordId) {
            window.open(`/sale-notes/contract/${recordId}`, "_blank");
        },
        clickCreate(id = "") {
            this.showDialog = true
            // location.href = `/${this.resource}/create/${id}`;
            console.log("crear consignación");
        },

        changeConcurrency(row) {
            // console.log(row)
            this.$http
                .post(`/${this.resource}/enabled-concurrency`, row)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .then(() => {});
        },
        clickVoided(id) {
            this.anular(`/${this.resource}/anulate/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    },
    mounted() {
      
    }
};
</script>
