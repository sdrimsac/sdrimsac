<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>
                            <span>Lista de planes</span>
                        </h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Lista de planes</span>
                            </li>
                        </ol>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <button
                            type="button"
                            class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                            @click.prevent="clickCreate()"
                        >
                            <i class="icofont-plus-circle"></i>
                            <span>Nuevo</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card" v-loading="loading">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">
                        {{ `Lista de planes` }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="col-md-12 col-lg-12 col-xl-12 mb-2">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 pb-2">
                                <label
                                    class="label-control"
                                    style="width:100px"
                                >
                                    Filtrar por:
                                </label>
                                <el-select
                                    v-model="search.column"
                                    placeholder="Select"
                                    @change="changeClearInput"
                                >
                                    <el-option
                                        v-for="(label, key) in columns"
                                        :key="key"
                                        :value="key"
                                        :label="label"
                                    ></el-option>
                                </el-select>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-12 pb-2">
                                <template
                                    v-if="
                                        search.column == 'validity_date' ||
                                            search.column == 'payment_date' ||
                                            search.column == 'delivery_date' ||
                                            search.column == 'date'
                                    "
                                >
                                    <br />
                                    <el-date-picker
                                        v-model="search.value"
                                        type="date"
                                        style="width: 100%;"
                                        placeholder="Buscar"
                                        value-format="yyyy-MM-dd"
                                        @change="getRecords"
                                    >
                                    </el-date-picker>
                                </template>

                                <template v-else>
                                    <br />
                                    <el-input
                                        placeholder="Buscar"
                                        v-model="search.value"
                                        style="width: 100%;"
                                        prefix-icon="el-icon-search"
                                        @input="writeSearch"
                                    >
                                    </el-input>
                                </template>
                            </div>
                            <div
                                class="col-lg-3 col-md-4 col-sm-12 pb-2 d-flex align-items-end"
                            >
                                <el-checkbox
                                    @change="writeSearch"
                                    v-model="search.see_all"
                                >
                                    Desactivados/Vencidos
                                </el-checkbox>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Periodo</th>
                                        <th>Vigencia</th>
                                        <th>Fecha Pago</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(record, idx) in records"
                                        :key="idx"
                                    >
                                        <td>{{ idx + 1 }}</td>
                                        <td>{{ record.name }}</td>
                                        <td>{{ record.description }}</td>
                                        <td>
                                            {{ record.period.description }}
                                            <br /><small class="text-muted">
                                                {{
                                                    record.period.default_count
                                                }}
                                                ciclos
                                            </small>
                                        </td>
                                        <td>{{ record.validity_date }}</td>
                                        <td>{{ record.payment_date }}</td>
                                        <td>
                                            {{ record.total }}
                                        </td>
                                        <td>
                                            <div
                                                class="d-flex justify-content-end"
                                            >
                                                <el-button
                                                    size="mini"
                                                    type="primary"
                                                    @click="clickCreate(record)"
                                                    >Editar</el-button
                                                >
                                                <el-button
                                                    @click="desactive(record)"
                                                    size="mini"
                                                    :type="
                                                        record.active
                                                            ? 'danger'
                                                            : 'success'
                                                    "
                                                    >{{
                                                        record.active
                                                            ? "Desactivar"
                                                            : "Activar"
                                                    }}</el-button
                                                >
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <create-form
            :showDialog.sync="showCreateForm"
            :record.sync="recordCreateForm"
            @getRecords="getRecords"
        >
        </create-form>
    </div>
</template>

<script>
const CreateForm = () => import("./form.vue");
export default {
    components: { CreateForm },
    data() {
        return {
            loading: false,
            resource: "college/plans",
            search: {
                see_all: false
            },
            recordCreateForm: null,
            showCreateForm: false,
            records: [],
            columns: [],
            timer: null
        };
    },
    async created() {
        this.getColumns();
        this.getRecords();
    },
    methods: {
        writeSearch() {
            if (this.timer) {
                clearTimeout(this.timer);
            }
            this.timer = setTimeout(async () => {
                await this.getRecords();
            }, 250);
        },
        async getColumns() {
            try {
                this.loading = true;
                const response = await this.$http(`/${this.resource}/columns`);
                this.columns = response.data;
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        searchItem() {},

        clickCreate(record = null) {
            this.recordCreateForm = record;

            this.showCreateForm = true;
        },
        async desactive(record) {
            try {
                this.loading = true;
                const response = await this.$http.post(`plans/active`, {
                    id: record.id
                });
                const { message, success } = response.data;
                if (success) {
                    this.$toast.success(message);
                    await this.getRecords();
                } else {
                    this.$toast.error(message);
                }
                console.log(response);
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un problema");
            } finally {
                this.loading = false;
            }
        },

        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/${this.resource}/records?column=${this.search.column ||
                        ""}&value=${this.search.value || ""}&see_all=${
                        this.search.see_all == false ? 0 : 1
                    }`
                );
                const { data } = response;
                console.log(data);
                this.records = data;
                this.records = this.records.map(r => ({
                    ...r,
                    total: r.services.reduce((a, b) => a + Number(b.price), 0)
                }));
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        changeClearInput() {}
    }
};
</script>
