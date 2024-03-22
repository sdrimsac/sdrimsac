<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>
                            <span>Penalidades de nota de venta crédito</span>
                        </h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashbodard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Penalidades de nota de venta crédito</span
                                >
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading">
                            <th>#</th>
                            <th class="text-end">Tipo</th>
                            <th class="text-center">Monto</th>
                            <th></th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td class="text-end">{{ row.type }}</td>
                            <td class="text-center">{{ row.amount_by_day }}</td>
                            <td>
                                <button
                                    class="btn btn-primary"
                                    @click="clickEdit(row.id,row.type)"
                                >
                                    Editar
                                </button>
                            </td>
                        </tr>
                    </data-table>
                </div>
            </div>
            <el-dialog
                :title="`Actualizar penalidad ${currentPenalty}`"
                :visible.sync="showDialogPenaltyDetail"
                width="30%"
                append-to-body
            >
                <div class="row m-2">
                    <label class="col-12">Monto</label>
                    <el-input
                        v-model="form.amount_by_day"
                        placeholder="Monto"
                        class="col-12"
                    ></el-input>
                </div>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="showDialogPenaltyDetail = false"
                        >Cancelar</el-button
                    >
                    <el-button
                        type="primary"
                        @click="updatePenalty"
                        >Guardar</el-button
                    >
                </span>
            </el-dialog>
        </div>
    </div>
</template>
<style>
td {
    color: #000;
}
</style>
<script>
import DataTable from "../../components/DataTable.vue";

import { deletable } from "../../mixins/deletable";
export default {
    props: [
        "just_sale_notes",
        "soapCompany",
        "company",
        "configuration",
        "user_type"
    ],
    mixins: [deletable],
    components: {
        DataTable
    },
    data() {
        return {
            currentPenalty: null,
            showDialogPenaltyDetail: false,
            showModalGenerateCPE: false,
            resource: "sale-notes/penalties",
            showDialogDetail: false,
            showDialogPayments: false,
            showDialogOptions: false,
            showDialogGenerate: false,
            form: {
                amount_by_day: null
            },
            saleNotesNewId: null,
            recordId: null,
            currentNumber: null,
            boxes: [],
            editSale: false,
            showDialogOptions: false,
            columns: {
                total_free: {
                    title: "T.Gratuito",
                    visible: false
                },
                total_exportation: {
                    title: "T.Exportación",
                    visible: false
                },
                total_unaffected: {
                    title: "T.Inafecto",
                    visible: false
                },
                total_exonerated: {
                    title: "T.Exonerado",
                    visible: false
                },
                total_taxed: {
                    title: "T.Gravado",
                    visible: false
                },
                total_igv: {
                    title: "T.IGV",
                    visible: false
                },
                paid: {
                    title: "Estado de Pago",
                    visible: false
                },
                type_period: {
                    title: "Tipo Periodo",
                    visible: true
                },
                quantity_period: {
                    title: "Cantidad Periodo",
                    visible: true
                },
                license_plate: {
                    title: "Placa",
                    visible: true
                },
                total_paid: {
                    title: "Pagado",
                    visible: false
                },
                total_pending_paid: {
                    title: "Por pagar",
                    visible: false
                }
            }
        };
    },
    created() {},
    filters: {
        period(name) {
            let res = "";
            switch (name) {
                case "month":
                    res = "Mensual";
                    break;
                case "year":
                    res = "Anual";
                    break;
                default:
                    break;
            }

            return res;
        }
    },
    methods: {
        updatePenalty() {
            this.form.id = this.recordId;
            this.$http
                .post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.showDialogPenaltyDetail = false;
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
        clickEdit(id,penalty) {
            this.currentPenalty = penalty;
            this.recordId = id;
            this.showDialogPenaltyDetail = true;
        },
        onOpenModalGenerateCPE() {
            this.showModalGenerateCPE = true;
        },
        teclasInit() {
            document.onkeydown = e => {
                const key = e.key;
                if (key == "F3") {
                    //Agregar cliente
                    location.href = `/${this.resource}/create`;
                }
            };
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
            location.href = `/${this.resource}/create/${id}`;
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
        this.teclasInit();
    }
};
</script>
