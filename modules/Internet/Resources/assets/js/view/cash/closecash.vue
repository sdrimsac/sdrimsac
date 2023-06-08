<template>
    <div>
        <div class="row">
            <el-dialog
                title="Cierra de Caja"
                :visible.sync="showDialogClose"
                @open="dateclosed()"
                :before-close="closeDialog"
                width="35%"
            >
                <span>
                    <form autocomplete="off" @submit.prevent="submit">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12"><span>Billetes</span></div>
                                <div
                                    class="col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                                >
                                    <el-input
                                        placeholder="0"
                                        v-model="count['200']"
                                        @input="
                                            updateFinalBalance(
                                                count['200'],
                                                200
                                            )
                                        "
                                    >
                                        <template slot="prepend">200</template>
                                    </el-input>
                                </div>
                                <div
                                    class="col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                                >
                                    <el-input
                                        placeholder="0"
                                        v-model="count['100']"
                                        @input="
                                            updateFinalBalance(
                                                count['100'],
                                                100
                                            )
                                        "
                                    >
                                        <template slot="prepend">100</template>
                                    </el-input>
                                </div>
                                <div
                                    class="col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                                >
                                    <el-input
                                        placeholder="0"
                                        v-model="count['50']"
                                        @input="
                                            updateFinalBalance(count['50'], 50)
                                        "
                                    >
                                        <template slot="prepend">50</template>
                                    </el-input>
                                </div>
                                <div
                                    class="col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                                >
                                    <el-input
                                        placeholder="0"
                                        v-model="count['20']"
                                        @input="
                                            updateFinalBalance(count['20'], 20)
                                        "
                                    >
                                        <template slot="prepend">20</template>
                                    </el-input>
                                </div>
                                <div
                                    class="col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                                >
                                    <el-input
                                        placeholder="0"
                                        v-model="count['10']"
                                        @input="
                                            updateFinalBalance(count['10'], 10)
                                        "
                                    >
                                        <template slot="prepend">10</template>
                                    </el-input>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12"><span>Monedas</span></div>
                                <div
                                    class="col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                                >
                                    <el-input
                                        placeholder="0"
                                        v-model="count['5']"
                                        @input="
                                            updateFinalBalance(count['5'], 5)
                                        "
                                    >
                                        <template slot="prepend">5</template>
                                    </el-input>
                                </div>
                                <div
                                    class="col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                                >
                                    <el-input
                                        placeholder="0"
                                        v-model="count['2']"
                                        @input="
                                            updateFinalBalance(count['2'], 2)
                                        "
                                    >
                                        <template slot="prepend">2</template>
                                    </el-input>
                                </div>
                                <div
                                    class="col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                                >
                                    <el-input
                                        placeholder="0"
                                        v-model="count['1']"
                                        @input="
                                            updateFinalBalance(count['1'], 1)
                                        "
                                    >
                                        <template slot="prepend">1</template>
                                    </el-input>
                                </div>
                                <div
                                    class="col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                                >
                                    <el-input
                                        placeholder="0"
                                        v-model="count['0.5']"
                                        @input="
                                            updateFinalBalance(
                                                count['0.5'],
                                                0.5
                                            )
                                        "
                                    >
                                        <template slot="prepend">0.50</template>
                                    </el-input>
                                </div>
                                <div
                                    class="col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                                >
                                    <el-input
                                        placeholder="0"
                                        v-model="count['0.2']"
                                        @input="
                                            updateFinalBalance(
                                                count['0.2'],
                                                0.2
                                            )
                                        "
                                    >
                                        <template slot="prepend">0.20</template>
                                    </el-input>
                                </div>
                                <div
                                    class="col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                                >
                                    <el-input
                                        placeholder="0"
                                        v-model="count['0.1']"
                                        @input="
                                            updateFinalBalance(
                                                count['0.1'],
                                                0.1
                                            )
                                        "
                                    >
                                        <template slot="prepend">0.10</template>
                                    </el-input>
                                </div>
                            </div>
                            <div
                                style="margin-top:10px;"
                                class="row"
                                v-loading="loading"
                            >
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.date_closed
                                        }"
                                    >
                                        <label class="control-label disabled"
                                            >Fecha </label
                                        ><br />
                                        <el-date-picker
                                            prefix-icon="el-icon"
                                            v-model="date_closed"
                                            type="date"
                                            disabled
                                            format="dd/MM/yyyy"
                                            value-format="yyyy-MM-dd"
                                            @change="dateclosed()"
                                        >
                                        </el-date-picker>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.final_balance
                                        }"
                                    >
                                        <label class="control-label"
                                            >Saldo Final</label
                                        >
                                        <el-input
                                            readonly
                                            v-model="final_balance"
                                        ></el-input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </span>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="closeDialog()">Cerrar</el-button>
                    <el-button type="primary" @click="clickCloseCash()"
                        >Guardar</el-button
                    >
                </span>
            </el-dialog>
        </div>
    </div>
</template>
<style>
/* .el-input__inner {
    padding: 0 25px !important;
} */
</style>
<script>
//'../../../../components/DataTable.vue'
import { deletable } from "../../../../../../../resources/js/mixins/deletable";
///mixins/deletable'
import CashForm from "./form.vue";

export default {
    mixins: [deletable],
    props: ["showDialogClose", "recordId", "fromBox"],
    data() {
        return {
            total: 0,
            count: {},
            showDialog: false,
            open_cash: true,
            errors: {},
            resource: "restaurant/worker/cash",
            date_closed: moment().format("YYYY-MM-DD"),
            date_start: moment().format("YYYY-MM-DD"),
            month_start: moment().format("YYYY-MM"),
            final_balance: 0,
            cash: null,
            loading: false
        };
    },

    methods: {
        ocultarBoton() {
            this.$emit("ocultarBoton");
        },
        sumCount() {
            let sum = 0;
            for (const amount in this.count) {
                if (this.count[amount] > 0) {
                    sum +=
                        (Number(this.count[amount]) || 0) *
                        (Number(amount) || 0);
                } else {
                    delete this.count[amount];
                }
            }
            return sum;
        },
        updateFinalBalance(quantity, value) {
            this.count[value.toString()] = quantity;

            this.final_balance = _.round(this.sumCount(), 2);
        },
        clickCloseCash() {
            const h = this.$createElement;
            this.$msgbox({
                title: "Cerrar caja",
                type: "warning",
                message: h("p", null, [
                    h(
                        "p",
                        { style: "text-align: justify; font-size:15px" },
                        "¿Está seguro de cerrar la caja?"
                    )
                ]),

                showCancelButton: true,
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                beforeClose: (action, instance, done) => {
                    if (action === "confirm") {
                        //  console.log(this.count);
                        this.createRegister(instance, done);
                    } else {
                        done();
                    }
                }
            })
                .then(action => {})
                .catch(action => {});
        },
        async dateclosed(date_closed) {
            this.loading = true;
            await this.$http
                .get(`/restaurant/cash/balance-final/${this.date_closed}`)
                .then(response => {
                    //  this.final_balance = response.data.balance_total.toFixed(2);
                    this.loading = false;
                });
        },
        closeDialog() {
            this.$emit("update:showDialogClose", false);
            this.count = {};
            this.final_balance = 0;
        },
        async createRegister(instance, done) {
            const body = {
                id: this.recordId,
                final_balance: this.final_balance,
                counter: this.count
            };
            try {
                const response = await this.$http.post(
                    `/${this.resource}/close`,
                    body
                );

                if (response.data.success) {
                    this.$eventHub.$emit("reloadData");
                    this.open_cash = true;
                    this.$toast.success(response.data.message);
                    this.ocultarBoton();
                    if (this.fromBox) {
                        this.$emit("updateCashId", null);
                    }
                } else {
                    console.log(response);
                }
            } catch (error) {
                console.log(error);
            } finally {
                instance.confirmButtonLoading = false;
                instance.confirmButtonText = "Iniciar prueba";
                done();
            }

            instance.confirmButtonLoading = true;
            instance.confirmButtonText = "Cerrando caja...";
            window.open(
                `/restaurant/report-boxes/reports_resumen_type?cash_id=${this.recordId}`,
                "_blank"
            );
            this.closeDialog();
        }
    }
};
</script>
