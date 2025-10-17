<template>
    <el-dialog
        title="Cotización"
        :visible="showDialog"
        @open="open"
        @close="close"
        v-loading="loading"
    >
        <div class="row">
            <div class="col-md-6">
                <label for="customer_id">Cliente</label>
                <el-select
                    ref="cliente"
                    v-model="form.customer_id"
                    filterable
                    clearable
                    remote
                    popper-class="el-select-customers"
                    dusk="customer_id"
                    placeholder="Escriba el nombre o número de documento del cliente"
                    :remote-method="searchRemoteCustomers"
                    @keyup.enter.native="keyupCustomer"
                    :loading="loading_search"
                    @change="changeCustomer"
                >
                    <el-option
                        v-for="option in customers"
                        :key="option.id"
                        :value="option.id"
                        :label="option.description"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-md-3">
                <label for="date_of_issue">Fecha</label>
                <el-date-picker
                    v-model="form.date_of_issue"
                    type="date"
                    placeholder="Fecha"
                    value-format="yyyy-MM-dd"
                    format="yyyy-MM-dd"
                    clearable
                ></el-date-picker>
            </div>
            <div class="col-md-3">
                <br>
                <el-button
                    type="primary"
                    @click="getRecords"
                    :loading="loading"
                >
                    Buscar
                </el-button>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="ttable" class="table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Cotizacion</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(record, index) in records" :key="index">
                                <td>{{ record.date_of_issue }}</td>
                                <td>{{ record.customer_name }}</td>
                                <td>{{ record.identifier }}</td>
                                <td>{{ record.total }}</td>
                                <td>
                                    <el-button
                                        type="primary"
                                        icon="el-icon-printer"
                                        @click="directPrint(record.external_id)"
                                    >
                                        Imprimir
                                    </el-button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <el-pagination
                    @current-change="getRecords"
                    layout="total, prev, pager, next"
                    :total="pagination.total"
                    :current-page.sync="pagination.current_page"
                    :page-size="pagination.per_page"
                >
                </el-pagination>
            </div>
        </div>

        <div slot="footer" class="dialog-footer">
            <el-button @click="close">Cerrar</el-button>
        </div>
    </el-dialog>
</template>
<style>
@media (max-width: 500px) {
    #ttable {
        width: 150%;
    }
}
</style>
<script>
export default {
    props: ["showDialog"],
    data() {
        return {
            quotationNewId: null,
            form: {
                customer_id: null
            },
            showDialogNewPerson: false,
            customers: [],
            resource: "quotations",
            loading_search: false,
            percentage_igv: 18,
            loading: false,
            showDialogOptions: false,
            records: [],
            pagination: {
                total: 0,
                current_page: 1,
                per_page: 20
            },
            customers: [],
            loading_search: false,
            input_person: {
                number: null
            }
        };
    },
    created() {},
    watch: {},
    methods: {
        changeCustomer() {
            this.getRecords();
        },
        searchRemoteCustomers(input) {
            if (input.length > 0) {
                // if (input!="") {
                let parameters = `input=${input}`;
                this.loading_search = true;
                this.$http
                    .get(`/documents/search/customers?${parameters}`)
                    .then(response => {
                        this.customers = response.data.customers;
                        this.loading_search = false;
                        this.input_person.number = null;
                    });
            } else {
                this.input_person.number = null;
            }
        },
        async directPrint(external_id) {
            let typePrint = "3";

            let url = "";
            //colocar una condicion para cada caso desde impresira de 80mm hasta las a4 y a5
            if (typePrint == "1") {
                url = `/quotations/print/${external_id}/a4`;
            }
            if (typePrint == "2") {
                url = `/quotations/print/${external_id}/a5`;
            }
            if (typePrint == "3" || typePrint == null) {
                url = `/quotations/print/${external_id}/ticket`;
            }
            if (typePrint == "4") {
                url = `/quotations/print/${external_id}/ticket_50`;
            }
            //console.log(config.direct_printing)

            await this.$http.post(`/caja/re-print`, {
                url
            });
        },
        async getRecords() {
            try {
                this.loading = true;
                let url = `/quotations/records-current-user?customer_id=${this
                    .form.customer_id || ""}&date_of_issue=${this.form
                    .date_of_issue || ""}`;
                let response = await this.$http.get(url);
                this.records = response.data.data;
                this.pagination = response.data.meta;
                this.pagination.per_page = parseInt(
                    response.data.meta.per_page
                );
            } catch (err) {
                console.log(err);
            } finally {
                this.loading = false;
            }
        },

        open() {
            this.getRecords();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
