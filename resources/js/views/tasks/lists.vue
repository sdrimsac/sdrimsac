<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Tarea</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Tarea Programadas</span
                                >
                            </li>
                        </ol>
                    </div>
                    <div
                        class="col-12 col-md-6 d-flex align-items-start justify-content-end"
                    >
                        <!-- Contact Button Start -->
                        <button
                            type="button"
                            class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                            @click.prevent="clickCreate()"
                        >
                            <i class="icofont-plus-circle"></i>
                            <span>Nuevo</span>
                        </button>
                        <!-- Contact Button End -->
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary">
                <h6 class="my-0 text-white">Tareas programadas</h6>
            </div>
            <div class="card-body">
                <template>
                    <el-table :data="tableData" style="width: 100%">
                        <el-table-column
                            label="Clase"
                            prop="class"
                        ></el-table-column>
                        <el-table-column
                            label="Hora de ejecución"
                            prop="execution_time"
                        ></el-table-column>
                        <el-table-column
                            label="Ultima ejecución"
                            prop="updated_at"
                        ></el-table-column>
                        <el-table-column
                            label="Log"
                            prop="output"
                        ></el-table-column>
                        <el-table-column
                            fixed="right"
                            label="Acciones"
                            width="120"
                        >
                            <template slot-scope="scope">
                                <el-button
                                    block
                                    size="mini"
                                    type="danger"
                                    @click="
                                        handleDelete(scope.$index, scope.row)
                                    "
                                    >Eliminar</el-button
                                >
                            </template>
                        </el-table-column>
                    </el-table>
                </template>
            </div>
            <tenant-tasks-form
                :showDialog.sync="showDialog"
                :tableData.sync="tableData"
                @refresh="refresh"
            ></tenant-tasks-form>
        </div>
    </div>
</template>

<script>
const TenantTasksForm = () => import("./form.vue");

export default {
    components: { TenantTasksForm },
    data() {
        return {
            resource: "tasks",
            showDialog: false,
            tableData: []
        };
    },
    created() {
        this.refresh();
    },
    methods: {
        refresh() {
            axios
                .post(`/${this.resource}/tables`)
                .then(response => {
                    this.tableData = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
                .then(() => {});
        },
        handleDelete(index, row) {
            axios
                .delete(`/${this.resource}/${row.id}`)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.tableData.splice(index, 1);
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                })
                .then(() => {});
        },
        clickCreate() {
            this.showDialog = true;
        }
    }
};
</script>
