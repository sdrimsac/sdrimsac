<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>
                            <span
                                >Lista de grados, secciones, turnos y
                                niveles</span
                            >
                        </h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Lista de grados, secciones, turnos y
                                    niveles</span
                                >
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0" v-loading="loading">
            <div class="d-flex flex-wrap justify-content-center">
                <div
                    v-for="(it, idx) in items"
                    :key="idx"
                    class="col-md-5 col-12 card m-2"
                >
                    <div class="card-header bg-primary">
                        <h6 class="my-0 text-white">
                            {{ `Lista de ${it.title}` }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- <el-input
                                    v-model="it.searchValue"
                                    placeholder="Buscar"
                                >
                                    <el-button
                                        slot="append"
                                        :loading="it.loading"
                                        icon="el-icon-search"
                                        @click.prevent="searchItem()"
                                    ></el-button>
                                </el-input> -->
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                                    @click.prevent="clickCreate(it)"
                                >
                                    <i class="icofont-plus-circle"></i>
                                    <span>Nuevo</span>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descripción</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(record, idx) in it.records"
                                        :key="idx"
                                    >
                                        <td>{{ idx + 1 }}</td>
                                        <td>{{ record.description }}</td>
                                        <td>
                                            <div
                                                class="d-flex justify-content-end"
                                            >
                                                <el-button
                                                    size="mini"
                                                    type="primary"
                                                    @click="
                                                        clickCreate(it, record)
                                                    "
                                                    >Editar</el-button
                                                >
                                                <el-button
                                                    @click="
                                                        desactive(it, record)
                                                    "
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
            :name.sync="nameCreateForm"
            :path.sync="pathCreateForm"
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
            nameCreateForm: null,
            pathCreateForm: null,
            recordCreateForm: null,
            levels: [],
            turns: [],
            sections: [],
            degrees: [],
            items: [
                {
                    records: this.levels,
                    title: "niveles",
                    path: "levels",
                    loading: false,
                    pagination: {}
                },
                {
                    records: this.turns,
                    title: "turnos",
                    path: "turns",
                    loading: false,
                    pagination: {}
                },
                {
                    records: this.degrees,
                    title: "grados",
                    path: "degrees",
                    loading: false,
                    pagination: {}
                },

                {
                    records: this.sections,
                    title: "secciones",
                    path: "sections",
                    loading: false,
                    pagination: {}
                }
            ],
            resource: "college/levels",
            search: {},
            showCreateForm: false
        };
    },
    async created() {
        // this.getColumns();
        this.getRecords();
    },
    methods: {
        searchItem() {},
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        clickCreate(item, record = null) {
            this.recordCreateForm = record;
            this.nameCreateForm = item.title;
            this.pathCreateForm = item.path;
            this.showCreateForm = true;
        },
        async desactive(item, record) {
            try {
                this.loading = true;
                const response = await this.$http.post(
                    `levels/active/${item.path}`,
                    {
                        id: record.id
                    }
                );
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
        async getColumns() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/${this.resource}/persons/columns`
                );
                this.columns = response.data;
                console.log(response);
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http(`/${this.resource}/records`);
                const { data } = response;
                this.items.forEach(i => {
                    i.records = data[i.path];
                });
                console.log(this.items);
                // console.log(response);
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
