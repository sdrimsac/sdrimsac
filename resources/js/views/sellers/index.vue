<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Lista de vendedores</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Vendedores</span>
                            </li>
                        </ol>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end">
                        <div class="bookmark">
                                     <el-button
                                     type="primary"
                                     @click.prevent="clickCreate()"
                                     >
                                    Crear vendedor
                                     </el-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">Listado de vendedores</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Documento</th>
                                    <th>Establecimiento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(row, index) in records"
                                    :key="index"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ row.name }}</td>
                                    <td>{{ row.document }}</td>
                                    <td>{{ row.establishment_description }}</td>
                                    <td class="text-end">
                                        <button
                                            type="button"
                                            class="btn waves-effect waves-light btn-sm btn-info"
                                            @click.prevent="clickCreate(row.id)"
                                        >
                                            Editar
                                        </button>
                                        <button
                                            type="button"
                                            class="btn waves-effect waves-light btn-sm btn-danger"
                                            @click.prevent="clickDelete(row.id)"
                                            v-if="row.id != 1"
                                        >
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <sellers-form
                    :showDialog.sync="showDialog"
                    :typeUser="typeUser"
              
                    :recordId="recordId"
                ></sellers-form>
            </div>
        </div>
    </div>
</template>

<script>
import SellersForm from "./form.vue";
import { deletable } from "../../mixins/deletable";

export default {
    props: ["typeUser"],
    mixins: [deletable],
    components: { SellersForm },
    data() {
        return {
            showDialog: false,
            resource: "sellers",
            recordId: null,
            records: [],
            title: null
        };
    },
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getData();
        });
        this.getData();
     
    },
    methods: {
        getData() {
            this.$http
                .get(`/${this.resource}/records`)
                .then(response => {
                    this.records = response.data.data;
                });
        },
        clickCreate(recordId = null) {
            console.log("sadas");
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
