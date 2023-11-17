<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Lista de créditos</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">A cuenta</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid p-l-0 p-r-0">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card mb-0">
                        <div class="card-header bg-primary rounded-top">
                            <h6 class="my-0  text-white">
                                Listado de créditos
                            </h6>
                        </div>
                        <div class="data-table-visible-columns"></div>
                        <div class="card-body">
                            <div class="row m-2">
                                <div class="col-md-3 col-lg-3 col-12">
                                    <label for="client">
                                        Cliente/Personal
                                    </label>
                                    <el-select
                                        ref="cliente"
                                        filterable
                                        remote
                                        popper-class="el-select-customers"
                                        dusk="customer_id"
                                        placeholder="Escriba el nombre o número de documento del cliente"
                                        :remote-method="searchRemoteCustomers"
                                        :loading="loading_search"
                                        @change="changeCustomer"
                                        v-model="form.person_id"
                                    >
                                        <el-option
                                            v-for="option in customers"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.description"
                                        ></el-option>
                                    </el-select>
                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <label for="establishment_id">
                                        Establecimiento
                                    </label>
                                    <el-select
                                        v-model="form.establishment_id"
                                        placeholder="Seleccione"
                                    >
                                        <el-option
                                            v-for="item in establishments"
                                            :key="item.id"
                                            :label="item.description"
                                            :value="item.id"
                                        ></el-option>
                                    </el-select>
                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <label for="date">
                                        Mes
                                    </label>
                                    <el-date-picker
                                        class="w-100"
                                        v-model="form.date"
                                        type="month"
                                        placeholder="Seleccione"
                                        value-format="yyyy-MM"
                                        :picker-options="{
                                            disabledDate(time) {
                                                return (
                                                    time.getTime() > Date.now()
                                                );
                                            }
                                        }"
                                    ></el-date-picker>
                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <label for="state">Estado</label>
                                    <el-select
                                        v-model="form.paid"
                                        placeholder="Seleccione"
                                    >
                                        <el-option
                                            label="Pagado"
                                            value="1"
                                        ></el-option>
                                        <el-option
                                            label="Pendiente"
                                            value="0"
                                        ></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="row m-2 text-end">
                                <div class="col-12">
                                    <!-- boton para buscar -->
                                    <button
                                        v-if="records.length > 0"
                                        type="button"
                                        class="btn btn-success"
                                        @click="clickDownload"
                                    >
                                        <i class="fa fa-download"></i>
                                        Exportar
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-primary"
                                        @click="getRecords"
                                    >
                                        Buscar
                                    </button>
                                </div>
                            </div>

                            <div
                                class="row
                            table-responsive"
                            >
                                <table class="table" v-if="records.length > 0">
                                    <thead>
                                        <th>#</th>
                                        <th>ESTABLECIMIENTO</th>
                                        <th>PRODUCTO</th>
                                        <th>CANTIDAD</th>
                                        <th class="text-end">TOTAL</th>
                                        <th>VENDEDOR</th>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(record, idx) in records"
                                            :key="idx"
                                        >
                                            <td>{{ idx + 1 }}</td>
                                            <td>{{ record.establishment }}</td>
                                            <td>{{ record.product }}</td>
                                            <td>{{ record.quantity }}</td>
                                            <td class="text-end">
                                                {{ record.price }}
                                            </td>
                                            <td>{{ record.seller }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { deletable } from "../../mixins/deletable";
import queryString from "query-string";
export default {
    mixins: [deletable],
    props: [
        "company",
        "isAccountant",
        "isClient",
        "typeUser",
        "import_documents",
        "import_documents_second",
        "configuration"
    ],
    components: {},
    data() {
        return {
            resource: "credit-list",
            records: [],
            establishments: [],
            form: {},
            input_person: {},
            loading_search: false,
            customers: []
        };
    },
    created() {
        
        this.getTables();
        // this.$http.get(`/${this.resource}/tables`)
        //         .then(response => {
        //           this.closeBox=response.data.closebox
        //         })
    },
    methods: {
             getQueryParameters() {
         
            return queryString.stringify(
                {...this.form}
            );
        },
        clickDownload() {
            let parameters = this.getQueryParameters();
            window.open(
                `/${this.resource}/records_by_person/download?${parameters}`,
                "_blank"
            );
        },
        async getRecords() {
            let { person_id } = this.form;
            if (!person_id) {
                this.$toast.error("Debe seleccionar un cliente/personal");
                return;
            }
            const response = await this.$http.post(
                `/${this.resource}/records_by_person`,
                this.form
            );
            console.log(
                "🚀 ~ file: index.vue:182 ~ getRecords ~ response:",
                response
            );
            this.records = response.data.data;
        },
        changeCustomer() {},
        async searchRemoteCustomers(input) {
            if (input.length > 0) {
                // if (input!="") {

                this.loading_search = true;
                let parameters = `input=${input}`;
                const response = await this.$http.get(
                    `/documents/search/customers?${parameters}`
                );
                this.customers = response.data.customers;
                this.loading_search = false;
                this.input_person.number = null;
            }
        },
        async getTables() {
            const response = await this.$http.get(`/${this.resource}/tables`);

            if (response.status == 200) {
                let { data } = response;
                this.establishments = data.establishments;
            }
        },
        search() {}
    }
};
</script>
