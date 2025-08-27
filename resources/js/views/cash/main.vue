<template>
    <div>
        <template>
            <div
                v-if="!has_cash && !configuration.health_network"
                class="col-md- d-flex justify-content-end"
            >
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
                <div class="d-flex justify-content-end align-items-center">
                    <el-button
                        class="btn_excelsmallmetthod"
                        style="font-weight: bold; font-size: 1.1rem; background-color: #00bfff; border-color: #00bfff; color: #fff !important;"
                    >
                        <span>
                            Transferencia: S/ {{ payment_methods.Transferencia }}
                        </span>
                    </el-button>
                    <el-button
                      v-if="payment_methods['TARJETA: IZYPAY'] > 0"
                        class="btn_excelsmallmetthod"
                        style="font-weight: bold; font-size: 1.1rem; background-color: #ff0000; border-color: #ff0000; color: #fff !important;"
                    >
                        <span> Izipay: S/ {{ payment_methods['TARJETA: IZYPAY'] }} </span>
                    </el-button>
                    <el-button
                    v-if="payment_methods['TARJETA: OPENPAY'] > 0"
                        class="btn_excelsmallmetthod"
                        style="font-weight: bold; font-size: 1.1rem; background: linear-gradient(135deg, #2196f3 50%, #2ecc71 50%); border-color: #2196f3; color: #fff !important;"
                    >
                        <span> OpenPay: S/ {{ payment_methods['TARJETA: OPENPAY'] }} </span>
                    </el-button>
                    <el-button
                    v-if="payment_methods['TARJETA: NIUBIZ'] > 0"
                        class="btn_excelsmallmetthod"
                        style="font-weight: bold; font-size: 1.1rem; background-color: #2196f3; border-color: #2196f3; color: #fff !important;"
                    >
                        <span> Niubiz: S/ {{ payment_methods['TARJETA: NIUBIZ'] }} </span>
                    </el-button>
                    <el-button
                    v-if="payment_methods.Efectivo > 0"
                        class="btn_excelsmallmetthod"
                        style="font-weight: bold; font-size: 1.1rem; background-color: #4caf50; border-color: #4caf50; color: #fff !important;"
                    >
                        <span>
                            Efectivo: S/ {{ payment_methods.Efectivo }}
                        </span>
                    </el-button>
                    <el-button
                    v-if="payment_methods.Culqui > 0"
                        class="btn_excelsmallmetthod"
                        style="font-weight: bold; font-size: 1.1rem; background-color: #ff9800; border-color: #ff9800; color: #fff !important;"
                    >
                        <span> Culqui: S/ {{ payment_methods.Culqui }} </span>
                    </el-button>
                    <el-button
                    v-if="payment_methods.Plin > 0"
                        class="btn_excelsmallmetthod"
                        style="font-weight: bold; font-size: 1.1rem; background-color: #00bfff; border-color: #00bfff; color: #fff !important;"
                    >
                        <span> Plin: S/ {{ payment_methods.Plin }} </span>
                    </el-button>
                    <el-button
                    v-if="payment_methods.Yape > 0"
                        type="secondary"
                        class="btn_excelsmallmetthod"
                        style="font-weight: bold; font-size: 1.1rem; background-color: #8e44ad; border-color: #8e44ad; color: #fff !important;"
                    >
                        <i class="fas fa-wallet"></i>
                        Yape: S/ {{ payment_methods.Yape }}
                    </el-button>
                    <el-button
                        class="bg-primary btn_excelsmallmetthod"
                        style="font-size: 1.5rem; font-weight: bold;"
                    >
                        <span> Disponible: S/ {{ formattedTotal }} </span>
                    </el-button>
                    &nbsp;&nbsp;
                    <button
                        v-if="!configuration.health_network"
                        type="button"
                        class="btn btn-danger btn-icon btn-icon-start w-100 w-md-auto me-3"
                        style="color: #fff;"
                        @click.prevent="clickCloseCash()"
                    >
                        <span>Cerrar caja</span>
                    </button>
                </div>
            </template>
        </template>
        <cash-form
            :showDialog.sync="showDialogCash"
            :recordId="cash_id"
            @updateCashId="updateCashId"
            :principal="true"
            :configuration="configuration"
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
                                v-for="(item, key) in [
                                    { id: 1, description: 'Pendiente' },
                                    { id: 2, description: 'Observado' },
                                    { id: 3, description: 'Aceptado' }
                                ]"
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
                                    <th>FECHA DE APERTURA</th>
                                    <th>CODIGO PRINCIPAL</th>
                                    <th>CAJA</th>
                                    <th>USUARIO</th>
                                    <th>METODO DE PAGO</th>
                                    <th>MONTO</th>
                                    <th>OBS.</th>
                                    <th>TOTAL</th>
                                    <th>ESTADO</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(record, idx) in records"
                                    :key="idx"
                                    :style="{
                                        background:
                                            groupColors[
                                                record.cash_id ||
                                                    (record.cash &&
                                                        record.cash.id)
                                            ] || 'transparent'
                                    }"
                                >
                                    <td>{{ customIndex(idx) }}</td>
                                    <!-- FECHA DE APERTURA: show only on first row of the cash group and span rows -->
                                    <template
                                        v-if="
                                            firstIndexByCash[
                                                record.cash_id ||
                                                    (record.cash && record.cash.id)
                                            ] === idx
                                        "
                                    >
                                        <td
                                            class="group-cell"
                                            :rowspan="
                                                groupCounts[
                                                    record.cash_id ||
                                                        (record.cash && record.cash.id)
                                                ] || 1
                                            "
                                        >
                                            {{ record.cash.date_opening }}
                                        </td>
                                    </template>
                                    <template
                                        v-else-if="!(record.cash_id || (record.cash && record.cash.id))"
                                    >
                                        <td>{{ record.cash.date_opening }}</td>
                                    </template>

                                    <!-- CODIGO PRINCIPAL: grouped like total, preserve class binding -->
                                    <template
                                        v-if="
                                            firstIndexByCash[
                                                record.cash_id ||
                                                    (record.cash && record.cash.id)
                                            ] === idx
                                        "
                                    >
                                        <td
                                            class="group-cell"
                                            :rowspan="
                                                groupCounts[
                                                    record.cash_id ||
                                                        (record.cash && record.cash.id)
                                                ] || 1
                                            "
                                            :class="references_principal.findIndex(item => item == record.ref_principal) % 2 == 0 ? 'text-secondary' : 'text-success'"
                                        >
                                            {{ record.ref_principal }}
                                        </td>
                                    </template>
                                    <template
                                        v-else-if="!(record.cash_id || (record.cash && record.cash.id))"
                                    >
                                        <td :class="references_principal.findIndex(item => item == record.ref_principal) % 2 == 0 ? 'text-secondary' : 'text-success'">
                                            {{ record.ref_principal }}
                                        </td>
                                    </template>

                                    <!-- CAJA (reference_number): grouped -->
                                    <template
                                        v-if="
                                            firstIndexByCash[
                                                record.cash_id ||
                                                    (record.cash && record.cash.id)
                                            ] === idx
                                        "
                                    >
                                        <td
                                            class="group-cell"
                                            :rowspan="
                                                groupCounts[
                                                    record.cash_id ||
                                                        (record.cash && record.cash.id)
                                                ] || 1
                                            "
                                        >
                                            {{ record.cash.reference_number }}
                                        </td>
                                    </template>
                                    <template
                                        v-else-if="!(record.cash_id || (record.cash && record.cash.id))"
                                    >
                                        <td>{{ record.cash.reference_number }}</td>
                                    </template>

                                    <!-- USUARIO (user_name): grouped -->
                                    <template
                                        v-if="
                                            firstIndexByCash[
                                                record.cash_id ||
                                                    (record.cash && record.cash.id)
                                            ] === idx
                                        "
                                    >
                                        <td
                                            class="group-cell"
                                            :rowspan="
                                                groupCounts[
                                                    record.cash_id ||
                                                        (record.cash && record.cash.id)
                                                ] || 1
                                            "
                                        >
                                            {{ record.user_name }}
                                        </td>
                                    </template>
                                    <template
                                        v-else-if="!(record.cash_id || (record.cash && record.cash.id))"
                                    >
                                        <td>{{ record.user_name }}</td>
                                    </template>
                                    <td>{{ record.method }}</td>
                                    <td>{{ record.amount }}</td>
                                    <td>{{ record.comment }}</td>
                                    <!-- TOTAL: show only on first row of the cash group and span rows -->
                                    <template
                                        v-if="
                                            firstIndexByCash[
                                                record.cash_id ||
                                                    (record.cash &&
                                                        record.cash.id)
                                            ] === idx
                                        "
                                    >
                                        <td
                                            :rowspan="
                                                groupCounts[
                                                    record.cash_id ||
                                                        (record.cash &&
                                                            record.cash.id)
                                                ] || 1
                                            "
                                            class="cash-total-cell"
                                        >
                                            {{
                                                safeNumber(
                                                    record.total
                                                ).toFixed(2)
                                            }}
                                        </td>
                                    </template>
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
    props: ["configuration", "cashid", "total", "payment_methods"],
    components: {
        CashForm,
        CloseCash
    },
    created() {
        if (this.cashid != null) {
            this.cash_id = this.cashid;
            this.has_cash = true;
        }
        // initialize localTotal from prop without mutating the prop
        if (this.total !== undefined && this.total !== null) {
            const n = Number(this.total);
            this.localTotal = isNaN(n) ? 0 : n;
        }
    },
    mounted() {
        this.getRecords();
        this.getTables();
        this.getColumns();
    },
    data() {
        return {
            // don't mutate incoming `total` prop directly; keep a local copy
            localTotal: 0,
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
                column: "user_id"
            },
            columns: [],
            users: [],
            references_principal: [],
            // counts of records per cash_id
            groupCounts: {},
            // index of first occurrence per cash_id
            firstIndexByCash: {},
            // background color per cash_id
            groupColors: {}
        };
    },
    methods: {
        // helper to safely convert values to numbers
        safeNumber(value) {
            const n = Number(value);
            return isNaN(n) ? 0 : n;
        },
        getAvaibleCash() {
            this.$http("/caja/cash-transfer/available").then(response => {
                // response.data may be a number or an object like { total: 123 }
                let val = 0;
                if (
                    response &&
                    response.data !== undefined &&
                    response.data !== null
                ) {
                    if (typeof response.data === "object") {
                        val = Number(
                            response.data.total || response.data.amount || 0
                        );
                    } else {
                        val = Number(response.data);
                    }
                }
                this.localTotal = isNaN(val) ? 0 : val;
                console.log(
                    "🚀 ~ getAvaibleCash ~ this.localTotal:",
                    this.localTotal
                );
            });
        },
        exportRecords() {
            window.open(
                `/cash/main_cash/records_excel?${this.getQueryParameters()}`,
                "_blank"
            );
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
                console.log(
                    "🚀 ~ file: main.vue:273 ~ this.$http.get ~ this.users:",
                    this.users
                );
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
                    this.$toast.success("Se acepto el ingreso");
                    this.getAvaibleCash();
                    this.getRecords();
                }
            } catch (e) {
                this.$toast.error("Ocurrio un error");
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
                status: this.search.status
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

                // Group by cash_id and sum amounts
                const totalsByCash = data.reduce((acc, item) => {
                    const cashId = item.cash_id || (item.cash && item.cash.id);
                    const amount = parseFloat(item.amount) || 0;
                    if (!cashId) return acc;
                    if (!acc[cashId]) acc[cashId] = 0;
                    acc[cashId] += amount;
                    return acc;
                }, {});

                // Attach total to each record that shares the same cash_id
                this.records = data.map(item => {
                    const cashId = item.cash_id || (item.cash && item.cash.id);
                    return Object.assign({}, item, {
                        total: cashId
                            ? totalsByCash[cashId] || 0
                            : parseFloat(item.amount) || 0
                    });
                });

                // compute group counts and first index per cash_id
                this.groupCounts = this.records.reduce((acc, item, idx) => {
                    const cashId = item.cash_id || (item.cash && item.cash.id);
                    if (!cashId) return acc;
                    acc[cashId] = (acc[cashId] || 0) + 1;
                    return acc;
                }, {});

                this.firstIndexByCash = this.records.reduce(
                    (acc, item, idx) => {
                        const cashId =
                            item.cash_id || (item.cash && item.cash.id);
                        if (!cashId) return acc;
                        if (acc[cashId] === undefined) acc[cashId] = idx;
                        return acc;
                    },
                    {}
                );

                // assign a pastel color per cash group deterministically
                const palette = [
                    "#fbe9e7",
                    "#fff3e0",
                    "#fffde7",
                    "#f1f8e9",
                    "#e8f5e9",
                    "#e8f0f7",
                    "#f3e5f5",
                    "#fce4ec"
                ];
                this.groupColors = Object.keys(this.groupCounts).reduce(
                    (acc, key, index) => {
                        acc[key] = palette[index % palette.length];
                        return acc;
                    },
                    {}
                );

                this.references_principal = Array.from(
                    new Set(this.records.map(item => item.ref_principal))
                );
                console.log(
                    "🚀 ~ getRecords ~ this.references_principal:",
                    this.references_principal
                );
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
        },

        // Accept an optional payload to directly close the cash without opening the dialog
        // payload: { id, difference, final_balance, counter }
        async clickCloseCash(payload = null) {
            // If a payload is provided, call the close endpoint directly
            if (payload && payload.id) {
                return await this.postClose(payload);
            }

            const h = this.$createElement;
            this.$msgbox({
                title: "Cerrar caja",
                type: "warning",
                message: h("p", null, [
                    h(
                        "p",
                        { style: "text-align: justify; font-size:15px" },
                        `${
                            this.difference == 0
                                ? "¿Está seguro de cerrar la caja?"
                                : "¿Está seguro de cerrar la caja,  sin realizar el conteo en efectivo?"
                        }`
                    )
                ]),

                showCancelButton: true,
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                beforeClose: async (action, instance, done) => {
                    if (action === "confirm") {
                        instance.confirmButtonLoading = true;
                        instance.confirmButtonText = "Cerrando...";
                        // gather data from this component (if available)
                        const body = {
                            id: this.cash_id || this.recordId,
                            final_balance: this.final_balance || 0,
                            counter: this.count || {},
                            difference: this.difference || 0
                        };
                        await this.postClose(body, instance, done);
                        instance.confirmButtonLoading = false;
                    } else {
                        done();
                    }
                }
            })
                .then(action => {})
                .catch(action => {});
        },

        async createRegister(instance, done) {
            // kept for compatibility: delegate to postClose using current component data
            const body = {
                id: this.recordId || this.cash_id,
                final_balance: this.final_balance || 0,
                counter: this.count || {},
                difference: this.difference || 0
            };
            await this.postClose(body, instance, done);
        },

        // centralised close logic used both when a payload is provided or via the dialog
        async postClose(body, instance = null, done = null) {
            try {
                this.loading = true;
                const response = await this.$http.post(
                    `/caja/worker/cash/close`,
                    body
                );

                if (response.data && response.data.success) {
                    this.$eventHub.$emit("reloadData");
                    this.open_cash = true;
                    this.$toast.success(
                        response.data.message || "Caja cerrada"
                    );
                    // try to hide button if component supports it
                    if (this.ocultarBoton) this.ocultarBoton();
                    if (this.fromBox) {
                        this.$emit("updateCashId", null);
                    }
                } else {
                    console.log(response);
                }
            } catch (error) {
                console.log(error);
                this.$toast.error("Ocurrió un error al cerrar la caja");
            } finally {
                if (instance) {
                    instance.confirmButtonLoading = false;
                    instance.confirmButtonText = "Iniciar prueba";
                }
                this.loading = false;
                if (done) done();
            }

            if (body && body.id) {
                window.open(
                    `/caja/report-boxes/reports_resumen_type?cash_id=${body.id}`,
                    "_blank"
                );
            }
            console.log("Recargando..");
            location.reload();
            this.closeDialog();
        }
    },
    computed: {
        formattedTotal() {
            return this.safeNumber(this.localTotal).toFixed(2);
        }
    }
};
</script>

<style scoped>
.cash-total-cell {
    font-weight: 700;
    text-align: center;
    vertical-align: middle;
    border-left: 3px solid rgba(0, 0, 0, 0.08);
}
/* group-cell: used for grouped cells (rowspan) to center content */
.group-cell {
    text-align: center;
    vertical-align: middle;
    font-weight: 600;
    padding: 0.75rem; /* match table cell padding */
}
</style>
