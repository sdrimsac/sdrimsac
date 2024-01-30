<template>
    <div>
        <div v-if="!has_cash" class="col-md- d-flex justify-content-end">
            <button
                type="button"
                class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                @click.prevent="clickCreate()"
            >
                <i class="icofont-plus-circle"></i>
                <span>Nuevo</span>
            </button>
        </div>

        <template v-else>
            <div class="d-flex justify-content-between">
                <div
                    class="alert alert-success d-flex justify-content-start align-items-center"
                >
                    <span>Efectivo disponible: S/ {{ total.toFixed(2) }}</span>
                </div>
                <button
                    type="button"
                    class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                    @click.prevent="clickClose()"
                >
                    <span>Cerrar caja</span>
                </button>
            </div>
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
                    <div class="col-md-3">
                        <el-select
                            v-model="search.column"
                            placeholder="Seleccione"
                            size="small"
                        >
                            <el-option
                                v-for="(item, key) in columns"
                                :key="key"
                                :label="item"
                                :value="key"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-3">
                        <el-select
                            v-if="search.column !== 'date_closed'"
                            v-model="search.value"
                            placeholder="Seleccione usuario"
                            size="small"
                            filterable
                            clearable
                        >
                            <el-option
                                v-for="(item, key) in users"
                                :key="key"
                                :label="item.name"
                                :value="item.id"
                            ></el-option>
                        </el-select>
                        <el-date-picker
                            v-else
                            class="w-100"
                            v-model="search.value"
                            type="date"
                            value-format="yyyy-MM-dd"
                            placeholder="Seleccione la fecha"
                            size="small"
                            
                        ></el-date-picker>
                    </div>
                    <div class="col-md-3">
                        <el-select
                            v-model="search.status"
                            clearable
                            placeholder="Seleccione el estado"
                            size="small"
                        >
                            <el-option
                                v-for="(item, key) in [{id:1,description:'Pendiente'},{id:2,description:'Observado'},{id:3,description:'Aceptado'}]"
                                :key="key"
                                :label="item.description"
                                :value="item.id"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-3">
                        <el-button
                            type="primary"
                            size="small"
                            @click="getRecords"
                        >
                            Buscar
                        </el-button>
                        <el-button
                            v-if="records.length > 0"
                            type="default"
                            size="small"
                            @click="exportRecords"
                        >
                            Exportar
                        <i class="icofont-file-excel"></i>
                        </el-button>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>FECHA DE CIERRE</th>
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
                                    <td>{{ customIndex(idx) }}</td>
                                    <td>
                                        {{ record.cash.date_closed }}
                                    </td>
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
                        <el-pagination
                            @current-change="getRecords"
                            :current-page.sync="pagination.current_page"
                            :page-size="parseInt(pagination.per_page)"
                            layout="prev, pager, next"
                            :total="pagination.total"
                        ></el-pagination>
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
import queryString from "query-string";
export default {
    props: ["configuration", "cashid", "total"],
    components: {
        CashForm,
        CloseCash
    },
    created() {
        if (this.cashid != null) {
            this.cash_id = this.cashid;
            this.has_cash = true;
        }
    },
    mounted() {
        this.getRecords();
        this.getTables();
        this.getColumns();
    },
    data() {
        return {
            has_cash: false,
            pagination: {},
            showDialogClose: false,
            showDialogCash: false,
            cash_id: null,
            records: [],
            dialogVisible: false,
            form: {},
            currentRegister: null,
            search: {
                column: 'user_id',
            },
            columns: [],
            users: []
        };
    },
    methods: {
        exportRecords(){
            window.open(`/cash/main_cash/records_excel?${this.getQueryParameters()}`, '_blank');
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        getTables() {
            this.$http.get(`/cash/main_cash/tables`).then(response => {
                let data = response.data;
                this.users = data.users;
                console.log("🚀 ~ file: main.vue:273 ~ this.$http.get ~ this.users:", this.users)
            });
        },
        getColumns() {
            this.$http.get(`/cash/main_cash/columns`).then(response => {
                this.columns = response.data;
                console.log(
                    "🚀 ~ file: main.vue:263 ~ this.$http.get ~ this.columns:",
                    this.columns
                );
            });
        },
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
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                value: this.search.value,
                column: this.search.column,
                status: this.search.status,
            });
        },
        async getRecords() {
            const response = await this.$http.get(
                `/cash/main_cash/records?${this.getQueryParameters()}`
            );
            if (response.status == 200) {
                let {
                    data: { data, meta }
                } = response;
                this.records = data;
                this.pagination = meta;
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
