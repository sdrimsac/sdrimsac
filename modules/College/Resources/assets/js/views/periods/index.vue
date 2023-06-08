<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>
                            <span>Lista de periodos</span>
                        </h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Lista de periodos</span
                                >
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
                        {{ `Lista de periodos` }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="col-md-12 col-lg-12 col-xl-12 mb-2">
                        <div class="row">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descripción</th>
                                        <th>Ciclos</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(record, idx) in records"
                                        :key="idx"
                                    >
                                        <td>{{ idx + 1 }}</td>
                                        <td>{{ record.description }}</td>
                                        <td>{{ record.default_count }}</td>
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
            resource: "college/periods",
            search: {},
            recordCreateForm: null,
            showCreateForm: false,
            records: []
        };
    },
    async created() {
        // this.getColumns();
        this.getRecords();
    },
    methods: {
        searchItem() {},

        clickCreate(record = null) {
            this.recordCreateForm = record;

            this.showCreateForm = true;
        },
        async desactive(record) {
            try {
                this.loading = true;
                const response = await this.$http.post(`periods/active`, {
                    id: record.id
                });
                const { message, success } = response.data;
                if (success) {
                    this.$toast.success(message);
                    this.getRecords();
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
                const response = await this.$http(`/${this.resource}/records`);
                const { data } = response;
                this.records = data;
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
