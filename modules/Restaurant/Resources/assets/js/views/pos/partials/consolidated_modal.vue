<template>
    <el-dialog
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
        v-loading="loading"
        width="90%"
    >
        <template slot="title">
            <div class="row">
                <div class="col-md-6">
                    <span class="text-white h3">
                        Consolidado
                    </span>
                </div>
                <div class="col-md-6">
                    <span
                        class="text-white h3 float-end"
                        style="margin-right: 25px;"
                    >
                        {{ weight_total }} KG
                    </span>
                </div>
            </div>
        </template>
        <div class="row m-2">
            <template v-if="configuration && configuration.consolidated_quotation_details">
                <div class="col-4">
                <label
                    >Vehículo
                    <a href="#" @click.prevent="showDialogTransportForm = true"
                        >[+ Nuevo]</a
                    >
                </label>
                <el-select
                    v-model="form.transport_id"
                    clearable
                    placeholder="Seleccionar vehículo"
                >
                    <el-option
                        v-for="(option, idx) in transports"
                        :key="idx"
                        :label="
                            option.plate_number +
                                ' - ' +
                                option.model +
                                ' - ' +
                                option.brand
                        "
                        :value="option.id"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-4">
                <label
                    >Conductor
                    <a href="#" @click.prevent="showDialogDriverForm = true"
                        >[+ Nuevo]</a
                    >
                </label>
                <el-select
                    v-model="form.driver_id"
                    @change="changeDriver"
                    clearable
                >
                    <el-option
                        v-for="option in drivers"
                        :key="option.id"
                        :label="option.number + ' - ' + option.name"
                        :value="option.id"
                    ></el-option>
                </el-select>
            </div>
            </template>
            <div class="col-4 text-end mt-3">
                <el-button
                    type="primary"
                    @click="consolidate"
                    :disabled="!hasSelected"
                >
                    Consolidar
                </el-button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3">
                <label for="zone">Zona</label>
                <el-select
                    v-model="form.zone_id"
                    filterable
                    clearable
                    placeholder="Seleccione una zona"
                    @change="filterRecords"
                >
                    <el-option
                        v-for="option in zones"
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
                    @change="filterRecords"
                ></el-date-picker>
            </div>

            <div class="col-md-3">
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
                    @change="filterRecords"
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
                <label for="seller_id">Preventa</label>
                <el-select
                    v-model="form.seller_id"
                    filterable
                    clearable
                    placeholder="Seleccione un preventa"
                    @change="filterRecords"
                >
                    <el-option
                        v-for="option in sellers"
                        :key="option.id"
                        :value="option.id"
                        :label="option.name"
                    ></el-option>
                </el-select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <el-checkbox
                                v-model="checkAll"
                                @change="handleCheckAll"
                            ></el-checkbox>
                        </th>
                        <th>
                            Peso
                        </th>
                        <th>
                            Cotización
                        </th>
                        <th>
                            Preventa
                        </th>
                        <th>
                            Fecha
                        </th>

                        <th>
                            Cliente
                        </th>
                        <th>
                            Total
                        </th>
                        <th>
                            Zona
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="record in records" :key="record.id">
                        <td>
                            <el-checkbox
                                v-model="record.checked"
                                @change="handleCheck(record)"
                            ></el-checkbox>
                        </td>

                        <td>{{ record.weight_total }}</td>
                        <td>{{ record.identifier }}</td>
                        <td>{{ record.user_name }}</td>
                        <td>{{ record.date_of_issue }}</td>

                        <td>
                            {{ record.customer_name }}
                            <br />
                            <small>
                                {{ record.customer_number }}
                            </small>
                        </td>
                        <td>{{ record.total }}</td>
                        <td>{{ record.zone }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <driver-form
            :showDialog.sync="showDialogDriverForm"
            @success="successDriver"
        ></driver-form>
        <transport-form
            :showDialog.sync="showDialogTransportForm"
            @success="successTransport"
        ></transport-form>
    </el-dialog>
</template>

<script>
import DriverForm from "../../../../../../../../resources/js/views/dispatches/drivers/form.vue";
import TransportForm from "../../../../../../../../resources/js/views/dispatches/transports/form.vue";
export default {
    components: {
        DriverForm,
        TransportForm
    },
    props: ["showDialog", "configuration"],
    data() {
        return {
            showDialogTransportForm: false,
            showDialogDriverForm: false,
            transports: [],
            drivers: [],
            resource: "quotations",
            records: [],
            all_records: [],
            excludes: [],
            sellers: [],
            zones: [],
            loading: false,
            checkAll: false,
            pagination: {},
            loading: false,
            form: {
                zone_id: null,
                date_of_issue: null,
                customer_id: null,
                seller_id: null,
                transport_id: null,
                driver_id: null
            },
            customers: [],
            input_person: {
                number: null
            },
            loading_search: false
        };
    },
    computed: {
        hasSelected() {
            return this.records.some(record => record.checked);
        },
        weight_total() {
            return this.records
                .filter(record => record.checked)
                .reduce((acc, record) => {
                    return acc + record.weight_total;
                }, 0);
        }
    },
    methods: {
        async successDriver(id) {
            this.form.driver_id = id;
            await this.$http.get(`/drivers/get_options`).then(response => {
                this.drivers = response.data;
            });
        },
        async successTransport(id) {
            this.form.transport_id = id;
            await this.$http.get(`/transports/get_options`).then(response => {
                this.transports = response.data;
            });
        },
        changeDriver() {
            console.log(this.form.driver_id);
        },
        filterRecords() {
            this.records = this.all_records.filter(record => {
                let {
                    seller_id,
                    zone_id,
                    customer_id,
                    date_of_issue
                } = this.form;
                let seller = seller_id ? record.user_id === seller_id : true;
                let zone_filter = zone_id ? record.zone_id === zone_id : true;
                let customer = customer_id
                    ? record.customer_id === customer_id
                    : true;
                let date = date_of_issue
                    ? record.date_of_issue === date_of_issue
                    : true;
                return seller && zone_filter && customer && date;
            });
        },
        getTables() {
            this.$http.get("/quotations/consolidated/tables").then(response => {
                this.zones = response.data.zones;
                this.sellers = response.data.sellers;
                this.transports = response.data.transports;
                this.drivers = response.data.drivers;
            });
        },
        async searchRemoteCustomers(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;
                const response = await this.$http.get(
                    `/documents/search/customers?${parameters}&credit_list=1`
                );
                this.customers = response.data.customers;
                this.loading_search = false;
                this.input_person.number = null;
            }
        },
        handleCheck(record) {
            if (!record.checked) {
                this.excludes.push(record.id);
            } else {
                this.excludes = this.excludes.filter(id => id !== record.id);
            }
        },
        async consolidate() {
            let excludes = this.excludes;
            try {
                this.loading = true;
                const response = await this.$http.post(
                    `/${this.resource}/consolidated`,
                    {
                        excludes,
                        weight: this.weight_total,
                        transport_id: this.form.transport_id,
                        driver_id: this.form.driver_id
                    }
                );
                if (response.data.success) {
                    this.$message.success(response.data.message);
                    this.close();
                } else {
                    this.$message.error(response.data.message);
                }
            } catch (e) {
                this.$message.error("Ocurrió un error al consolidar");
                console.error(e);
            } finally {
                this.loading = false;
            }
        },
        handleCheckAll() {
            this.records.forEach(record => {
                record.checked = this.checkAll;
            });
            if (!this.checkAll) {
                this.excludes = this.records.map(record => record.id);
            } else {
                this.excludes = [];
            }
        },
        open() {
            this.form = {
                zone_id: null,
                date_of_issue: null,
                customer_id: null,
                seller_id: null,
                transport_id: null,
                driver_id: null
            };
            this.checkAll = false;
            this.excludes = [];
            this.getTables();
            this.getRecords();
        },
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/${this.resource}/to-consolidated`
                );

                this.all_records = response.data.data
                    .map(record => {
                        return {
                            ...record,
                            checked: true
                        };
                    })
                    .sort((a, b) => {
                        if (a.id > b.id) return -1;
                        if (a.id < b.id) return 1;
                        if (a.zone < b.zone) return -1;
                        if (a.zone > b.zone) return 1;

                        return 0;
                    });
                this.records = this.all_records;
            } catch (e) {
                console.error(e);
            } finally {
                this.loading = false;
            }
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>

<style></style>
