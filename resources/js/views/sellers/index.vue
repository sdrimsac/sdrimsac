<!-- Listado de Vendedores -->
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

            </div>
        </div>
    </div>
    <div class="container-fluid p-l-0 p-r-0">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white"><i class="fas fa-user-tie"></i> Listado de vendedores</h4>

            </div>
            <div class="data-table-visible-columns">
                    <el-button type="primary" 
                                class="" 
                                href="javascript:void(0)" 
                                @click.prevent="clickCreate()">
                                <i class="fas fa-user-tie fa-lg"></i>
                            <i class="fa fa-plus"></i>
                            Nuevo Vendedor
                    </el-button>
            </div> 
            <div class="card-body">
                
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr slot="heading" class="bg-primary">
                                <th class="text-white">#</th>
                                <th class="text-white">Nombre</th>
                                <th class="text-white">Documento</th>
                                <th class="text-white">Establecimiento</th>
                                <th class="text-white text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in records" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ row.name }}</td>
                                <td>{{ row.document }}</td>
                                <td>{{ row.establishment_description }}</td>
                              

                                <td class="text-end">
                                    <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="btn btn-primary dropdown-toggle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay="0" title="" data-bs-original-title="Item Count" aria-label="Item Count">Acciones</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" style="">
                                        <a type="button" class="dropdown-item text-secondary" @click.prevent=" clickCreate(row.id)"> <i class="fa fa-edit"></i> Editar
                                        </a>
                                        <a type="button" class="dropdown-item text-danger" @click.prevent="
                                            clickDelete(row.id)"> <i class="fa fa-trash"></i> Eliminar
                                        </a>
                                       
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <sellers-form :showDialog.sync="showDialog" :typeUser="typeUser" :establishments="establishments" :document_types="document_types" :recordId="recordId"></sellers-form>
        </div>
    </div>
</div>
</template>

<script>
import SellersForm from "./form.vue";
import {
    deletable
} from "../../mixins/deletable";

export default {
    props: ["typeUser"],
    mixins: [deletable],
    components: {
        SellersForm
    },
    data() {
        return {
            showDialog: false,
            resource: "sellers",
            recordId: null,
            records: [],
            title: null,
            establishments: [],
            document_types: []
        };
    },
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getData();
        });
        this.getData();
        this.getTables();
    },
    methods: {
        async getTables() {
            const response = await this.$http(`${this.resource}/tables`);
            console.log(response);
            const {
                establishments,
                document_types
            } = response.data;
            this.establishments = establishments;
            this.document_types = document_types;
            // this.establishments = response.data.data.establishments;
        },
        getData() {
            this.$http.get(`/${this.resource}/records`).then(response => {
                this.records = response.data.data;
            });
        },
        clickCreate(recordId = null) {
            console.log("sadas");
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/delete/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
