<template>
    <el-dialog
        :visible="showDialog"
        append-to-body
        @close="close"
        @open="open"
        width="60%"
        v-loading="loading"
    >
        <template #title>
            <div style="display: flex; align-items: center; width: 100%; position: relative;">
                <span style="flex:1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ activeName == 'expenses' ? 'Listado de Gastos' : 'Listado de Ingresos' }}</span>
                <el-button
                    :class="['btn_excelsmall', activeName == 'expenses' ? 'btn-expenses' : 'btn-incomes']"
                    @click="addExpenseIncome"
                    type="primary"
                    style="margin-left: 8px; margin-right: 40px;"
                >
                    Generar {{ `${activeName == 'expenses' ? 'Gasto' : 'Ingreso'}` }}
                </el-button>
            </div>
        </template>
        <div>
            <el-tabs v-model="activeName" @tab-click="handleClick" :class="['custom-tabs', activeName == 'expenses' ? 'tab-expenses' : 'tab-incomes']">
                <el-tab-pane label="Gastos" name="expenses" style="padding-top: 1px; padding-bottom: 1px;">
                    <expenses-incomes-detail
                        :company="company"
                        @getRecords="getRecords"
                        :records.sync="expenses"
                        :pagination.sync="pagination.expenses"
                        :type="'expenses'"
                        @editRecord="editRecord"
                        :establishments="establishments"
                    >
                    </expenses-incomes-detail>
                </el-tab-pane>
                <el-tab-pane label="Ingresos" name="incomes" style="padding-top: 1px; padding-bottom: 1px;">
                    <expenses-incomes-detail
                        :company="company"
                        @getRecords="getRecords"
                        :records.sync="incomes"
                        :pagination.sync="pagination.incomes"
                        :type="'incomes'"
                        @editRecord="editRecord"
                        :establishments="establishments"
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
                            :recordId="recordId"
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
                            :recordId="recordId"
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
    props: ["showDialog", "company", "cash_id", "establishments","area_id", "fromPos"],
    data() {
        return {
            recordId:null,
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
        if (this.fromPos) {
            this.open();
        }
    },
    watch: {
        activeName(oldVal, newVal) {
            this.type = newVal;
        }
    },
    methods: {
        editRecord(id,type) {
            this.activeName = type;
            this.recordId = id;
            this.showForm = true;
        },
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
            this.recordId = null;
            this.showForm = true;
        },
        getRecordsInput() {
            this.getRecords();
        },
        // para la impresion del qz directo 
        /* async printEvent(url) {
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
        }, */

        async getPrinter() {
            this.loading = true;
            const response = await this.$http(
                `cash/get_printer/${this.area_id}`
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
            this.$emit("checkCashAvailable");
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
                    `cash/incomes_expenses?${this.getQueryParameters()}`
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

<style scoped>
.btn-expenses {
  background: #e53935 !important;
  border-color: #e53935 !important;
  color: #fff !important;
}
.btn-incomes {
  background: #43a047 !important;
  border-color: #43a047 !important;
  color: #fff !important;
}
.tab-expenses >>> .el-tabs__item.is-active {
  background: #e53935 !important;
  color: #fff !important;
  border-radius: 6px 6px 0 0;
  box-shadow: 0 4px 12px rgba(229,57,53,0.15);
}
.tab-expenses >>> .el-tabs__active-bar {
  background: #e53935 !important;
}
.tab-incomes >>> .el-tabs__item.is-active {
  background: #43a047 !important;
  color: #fff !important;
  border-radius: 6px 6px 0 0;
  box-shadow: 0 4px 12px rgba(67,160,71,0.15);
}
.tab-incomes >>> .el-tabs__active-bar {
  background: #17821c !important;
}
.custom-tabs >>> .el-tabs__nav {
  background: #f5f7fa;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.custom-tabs >>> .el-tabs__item {
  font-weight: 600;
  font-size: 1.1em;
  color: #606266;
  transition: background 0.3s, color 0.3s;
  padding: 18px 32px 18px 32px;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
}
.custom-tabs >>> .el-tab-pane {
  padding-top: 24px;
  padding-bottom: 24px;
}
</style>
