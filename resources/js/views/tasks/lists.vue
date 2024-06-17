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
                                    >Tarea Programadas
                                </span>
                            </li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white">
                    <i class="fas fa-tasks fa-lg" style="margin-right: 10px;"></i>
                     Tareas Programadas
                </h4>
            </div>
            <div class="data-table-visible-columns">
                    <el-button type="primary" 
                                class="" 
                                href="javascript:void(0)" 
                                @click.prevent="clickCreate()">
                                <i class="fas fa-tasks fa-lg" style="margin-right: 10px;"></i>
                            <i class="fa fa-plus"></i>
                            Nueva Tarea
                    </el-button>
            </div> 

            <div class="card-body">
                <template>
                    <el-table :data="tableData" style="width: 100%">
                        <el-table-column
                            prop="class"
                        >
                            <template v-slot:header>
                                <span style="background-color: #073f68; color: white; display: block; padding: 8px;">Clase</span>
                            </template>
                        </el-table-column>
                        <el-table-column
                            prop="execution_time"
                        >
                            <template v-slot:header>
                                <span style="background-color: #073f68; color: white; display: block; padding: 8px;">Hora de Ejecución</span>
                            </template>
                        </el-table-column>
                        <el-table-column
                            prop="updated_at"
                        >
                            <template v-slot:header>
                                <span style="background-color: #073f68; color: white; display: block; padding: 8px;">Última Ejecución</span>
                            </template>
                        </el-table-column>
                        <el-table-column
                            prop="output"
                        >
                            <template v-slot:header>
                                <span style="background-color: #073f68; color: white; display: block; padding: 8px;">Log</span>
                            </template>
                        </el-table-column>
                        <el-table-column
                            fixed="right"
                            width="120"
                        >
                            <template v-slot:header>
                                <span style="background-color: #073f68; color: white; display: block; padding: 8px;">Acciones</span>
                            </template>
                            <template slot-scope="scope">
                                <el-button
                                    block
                                    size="mini"
                                    type="danger"
                                    @click="handleDelete(scope.$index, scope.row)"
                                >Eliminar</el-button>
                            </template>
                        </el-table-column>
                    </el-table>

                    <!-- <el-table :data="tableData" style="width: 100%">
                        <el-table-column
                            label="Clase"
                            prop="class"
                        ></el-table-column>
                        <el-table-column
                            label="Hora de Ejecución"
                            prop="execution_time"
                        ></el-table-column>
                        <el-table-column
                            label="Ultima Ejecución"
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
                    </el-table> -->
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
