<template>
    <el-dialog
        :visible="showDialog"
        append-to-body
        @close="close"
        @open="open"
        width="75%"
        v-loading="loading"
        :title="`${activeName == 'expenses' ? 'GASTOS' : 'INGRESOS'}`"
    >
        <div>
            <el-button
                @click="addExpenseIncome"
                type="primary"
                style="margin:8px 0px;"
            >
                Crear {{ `${activeName == "expenses" ? "Gasto" : "Ingreso"}` }}
            </el-button>
            <el-tabs v-model="activeName" @tab-click="handleClick">
                <el-tab-pane label="Gastos" name="expenses">
                    <expenses-incomes-detail
                        :company="company"
                        @getRecords="getRecords"
                        :records.sync="expenses"
                        :pagination.sync="pagination.expenses"
                        :type="'expenses'"
                    >
                    </expenses-incomes-detail>
                </el-tab-pane>
                <el-tab-pane label="Ingresos" name="incomes">
                    <expenses-incomes-detail
                        :company="company"
                        @getRecords="getRecords"
                        :records.sync="incomes"
                        :pagination.sync="pagination.incomes"
                        :type="'incomes'"
                    >
                    </expenses-incomes-detail>
                    <template v-if="activeName == 'expenses'">
                        <expenses-incomes-form
                            :items_detail.sync="items_detail"
                            :unitTypes.sync="unitTypes"
                            activeName="expenses"
                            :cashid="cash_id"
                            :showDialog.sync="showForm"
                            @getRecords="getRecords"
                            @getItemsDetail="getItemsDetail"
                        >
                        </expenses-incomes-form>
                    </template>
                    <template v-else>
                        <expenses-incomes-form
                            :items_detail.sync="items_detail"
                            :unitTypes="unitTypes"
                            activeName="incomes"
                            :cashid="cash_id"
                            :showDialog.sync="showForm"
                            @getRecords="getRecords"
                            @getItemsDetail="getItemsDetail"
                        >
                        </expenses-incomes-form>
                    </template>
                </el-tab-pane>
            </el-tabs>
        </div>
    </el-dialog>
</template>

<script>
import ExpensesIncomesDetail from "./expenses_incomes_detail.vue";
import ExpensesIncomesForm from "./expenses_incomes_form.vue";
import queryString from "query-string";
export default {
    components: { ExpensesIncomesDetail, ExpensesIncomesForm },
    props: ["showDialog", "company", "cash_id"],
    data() {
        return {
            time: null,
            loading: false,
            value: null,
            typeSearch: "document",
            type: "expenses",
            expenses: [],
            items_detail: [],
            unitTypes: [],
            incomes: [],
            pagination: {
                incomes: {},
                expenses: {}
            },
            printer: null,
            lastDocument: null,
            showForm: false,
            activeName: "expenses"
        };
    },
    async created() {
        await this.getCashRecords();
        await this.getPrinter();
        await this.getItemsDetail();
        await this.getUnitTypes();
    },
    watch: {
        activeName(oldVal, newVal) {
            this.type = newVal;
        }
    },
    methods: {
        async getUnitTypes() {
            this.loading = true;
            try {
                const response = await this.$http(`/unit_types/records`);
                const {
                    data: { data }
                } = response;
                this.unitTypes = data;
            } catch (e) {
                this.$toast.error("Error al traer las unidades de medidas");
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        async getItemsDetail(query = null) {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/caja/items_detail?description=${query ?? ""}`
                );
                if (response.status == 200) {
                    const {
                        data: { data }
                    } = response;
                    this.items_detail = data;
                }
            } catch (e) {
                this.$toast.error("Error al traer los items detalles");
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        addExpenseIncome() {
            this.showForm = true;
        },
        getRecordsInput() {
            this.getRecords();
        },
        async printEvent(url) {
            try {
                let config = qz.configs.create(this.printer, {
                    scaleContent: false
                });
                if (!qz.websocket.isActive()) {
                    await qz.websocket.connect(config);
                }
                let data = [
                    {
                        type: "pdf",
                        format: "file",
                        data: url
                    }
                ];
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });
            } catch (e) {}
        },

        async getPrinter() {
            this.loading = true;
            const response = await this.$http(
                `/caja/worker/cash/get_printer/${this.area_id}`
            );

            let {
                data: { printer }
            } = response;
            this.printer = printer;
            this.loading = false;
        },
        getRecords(page = 1) {
            if (this.activeName == "expenses") {
                this.pagination.expenses.current_page = Number(page);
            } else {
                this.pagination.incomes.current_page = Number(page);
            }
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                await this.getCashRecords();
            }, 500);
        },
        getQueryParameters(form = {}) {
            return queryString.stringify({
                page:
                    this.activeName == "expenses"
                        ? this.pagination.expenses.current_page
                        : this.pagination.incomes.current_page,
                isExpenses: this.activeName == "expenses",
                cashId: this.cash_id

                // limit: this.limit
            });
        },
        handleClick() {
            this.type = this.activeName;

            if (this.expenses.length == 0 || this.incomes.length == 0) {
                this.getCashRecords();
            }
        },
        async open() {
            this.getCashRecords();
        },
        close() {
            this.$emit("update:showDialog", false);
        },

        async getCashRecords() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/caja/worker/cash/incomes_expenses?${this.getQueryParameters()}`
                );

                if (response.status != 200) {
                    this.$toast.error("No se pudo obtener los registros");
                } else {
                    const { data, meta } = response.data;
                    if (this.activeName == "expenses") {
                        this.expenses = data;
                        this.pagination.expenses = meta;
                    } else {
                        this.incomes = data;
                        this.pagination.incomes = meta;
                    }
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("Error");
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
