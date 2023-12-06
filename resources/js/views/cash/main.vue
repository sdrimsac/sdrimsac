<template>
    <div>
        <div class="col-md- d-flex justify-content-end">
            <button
                v-if="!cash_id"
                type="button"
                class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                @click.prevent="clickCreate()"
            >
                <i class="icofont-plus-circle"></i>
                <span>Nuevo</span>
            </button>
            <template v-else>
                <div
                class="alert alert-success d-flex justify-content-between align-items-center"
                >
                <span>S/ 1.362</span>
                </div>
                <button
                    type="button"
                    class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                    @click.prevent="clickClose()"
                >
                    <span>Cerrar caja</span>
                </button>
            </template>
            <cash-form
                :showDialog.sync="showDialogCash"
                :recordId="cash_id"
                @updateCashId="updateCashId"
                :principal="true"
            ></cash-form>
            <close-cash
                :recordId.sync="cash_id"
                :showDialogClose.sync="showDialogClose"
                :configuration="configuration"
                @updateCashId="updateCashId"
            >
            </close-cash>
        </div>
        <div class="card">
            <div class="card-header bg-primary">
                <h6 class="my-0 text-white">Ingreso de cierres de caja</h6>
                <div class="card-actions white-text">
                    <a
                        href="#"
                        class="card-action card-action-toggle text-white"
                        data-card-toggle=""
                    ></a>
                    <a
                        href="#"
                        class="card-action card-action-dismiss text-white"
                        data-card-dismiss=""
                    ></a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>CAJA</th>
                                    <th>USUARIO</th>
                                    <th>MONTO</th>
                                    <th>OBS.</th>
                                    <th>ESTADO</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(record, idx) in records" :key="idx">
                                    <td>{{ idx + 1 }}</td>
                                    <td>{{ record.cash.reference_number }}</td>
                                    <td>{{ record.user_name }}</td>
                                    <td>{{ record.amount }}</td>
                                    <td>{{ record.comment }}</td>
                                    <td>{{ record.status_description }}</td>
                                    <td>
                                        <template
                                            v-if="
                                                record.status == 1 ||
                                                    record.status == 2
                                            "
                                        >
                                            <!-- boton succes para aceptar el ingreso -->
                                            <el-tooltip
                                                :content="`Aceptar el ingreso`"
                                                placement="top"
                                            >
                                                <el-button
                                                    type="success"
                                                    icon="el-icon-check"
                                                    size="mini"
                                                    @click="accept(record.id)"
                                                ></el-button>
                                            </el-tooltip>
                                        </template>
                                        <!-- boton danger para mandar a observacion el ingreso -->
                                        <template v-if="record.status == 1">
                                            <el-tooltip
                                                :content="
                                                    `Mandar a observación`
                                                "
                                                placement="top"
                                            >
                                                <el-button
                                                    type="warning"
                                                    icon="el-icon-close"
                                                    size="mini"
                                                    @click="reject(record.id)"
                                                ></el-button>
                                            </el-tooltip>
                                        </template>
                                        <!-- <template v-if="record.status == 2">
                                    <el-button
                                        type="success"
                                        icon="el-icon-check"
                                        size="mini"
                                        @click="accept(record.id)"
                                    ></el-button>
                                </template> -->
                                        <!-- <template
                            v-if-else="record.status == 3"
                            >
                            
                            </template> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <el-dialog
                    :visible.sync="dialogVisible"
                    append-to-body
                    title="Observación"
                >
                    <div class="row m-2">
                        <div class="col-md-12">
                            <el-input
                                type="textarea"
                                :rows="3"
                                placeholder="Ingrese la observación"
                                v-model="form.comment"
                            ></el-input>
                        </div>
                    </div>
                    <span slot="footer" class="dialog-footer">
                        <el-button @click="dialogVisible = false"
                            >Cancelar</el-button
                        >
                        <el-button type="primary" @click="sendToObservation"
                            >Aceptar</el-button
                        >
                    </span>
                </el-dialog>
            </div>
        </div>
    </div>
</template>

<script>
const CashForm = () => import("./partials/form.vue");
const CloseCash = () => import("./partials/closecash.vue");

export default {
    props: ["configuration", "cashid"],
    components: {
        CashForm,
        CloseCash
    },
    created() {
        if (this.cashid != null) {
            this.cash_id = true;
        }
    },
    mounted() {
        this.getRecords();
    },
    data() {
        return {
            showDialogClose: false,
            showDialogCash: false,
            cash_id: null,
            records: [],
            dialogVisible: false,
            form: {},
            currentRegister: null
        };
    },
    methods: {
        initForm() {
            this.form = {
                comment: null
            };
        },
        async accept(id) {
            try {
                await this.$confirm(
                    "¿Está seguro de aceptar el ingreso?",
                    "Advertencia",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );
                const response = await this.$http(
                    `/cash/main_cash/accept/${id}`
                );
                if (response.status == 200) {
                    this.$message({
                        message: "Se acepto el ingreso",
                        type: "success"
                    });
                    this.getRecords();
                }
            } catch (e) {
                this.$message({
                    message: "Ocurrio un error",
                    type: "error"
                });
            }
        },
        async sendToObservation() {
            try {
                const response = await this.$http.post(
                    `/cash/main_cash/observ/${this.currentRegister}`,
                    this.form
                );
                if (response.status == 200) {
                    this.$message({
                        message: "Se envio a observación",
                        type: "success"
                    });
                    this.dialogVisible = false;
                    this.getRecords();
                }
            } catch (e) {
                this.$message({
                    message: "Ocurrio un error",
                    type: "error"
                });
            }
        },
        reject(id) {
            this.currentRegister = id;
            this.initForm();
            this.dialogVisible = true;
        },
        async getRecords() {
            const response = await this.$http.get(`/cash/main_cash/records`);
            if (response.status == 200) {
                let {
                    data: { data }
                } = response;
                this.records = data;
            }
        },
        clickClose() {
            this.showDialogClose = true;
        },
        clickCreate() {
            this.showDialogCash = true;
        },
        updateCashId(id) {
            this.cash_id = id;
        }
    }
};
</script>
