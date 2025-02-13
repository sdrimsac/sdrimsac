<!-- Listado de Bancos -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>
                            Vehiculos
                        </h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Listado Vehiculos</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white">
                   Listado Vehiculos
                </h4>
            </div>
            <div class="data-table-visible-columns">
                <!-- <el-button
                    type="primary"
                    class=""
                    href="javascript:void(0)"
                    @click.prevent="clickCreate()"
                >
                    Nuevo Vehiculo
                </el-button> -->
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <el-button 
                        type="success"
                            @click="listvehiculos"
                         >
                            <i class="el-icon-tickets"></i>
                            exportar a excel
                        </el-button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr slot="heading" class="bg-primary">
                                <th class="text-white">#</th>
                                <th class="text-white">Cliente</th>
                                <th class="text-white">Placa</th>
                                <th class="text-white">Tipo Vehiculo</th>
                                <th class="text-white">Serie</th>
                                <th class="text-white">Modelo</th>
                                <th class="text-white">Marca</th>
                                <th class="text-white">Color</th>
                                <th class="text-white">Año Fabricacion</th>
                                <th class="text-white">Kilometraje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in records" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ row.customer_name }}</td>
                                <td>{{ row.placa }}</td>
                                <td>{{ row.tipo_vehiculo_description }}</td>
                                <td>{{ row.serie }}</td>
                                <td>{{ row.modelo }}</td>
                                <td>{{ row.marca }}</td>
                                <td>{{ row.color }}</td>
                                <td>{{ row.anio_fabricacion }}</td>
                                <td>{{ row.kilometraje }}</td>
                                <!-- <td class="text-end">
                                    <button
                                        class="btn p-0"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        <span
                                            class="btn btn-primary dropdown-toggle"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-delay="0"
                                            title=""
                                            data-bs-original-title="Item Count"
                                            aria-label="Item Count"
                                            >Acciones</span
                                        >
                                    </button>
                                    <div
                                        class="dropdown-menu dropdown-menu-end"
                                        style=""
                                    >
                                        <a
                                            type="button"
                                            class="dropdown-item text-secondary"
                                            @click.prevent="clickCreate(row.id)"
                                        >
                                            <i class="fa fa-edit"></i> Editar
                                        </a>
                                        <template
                                        >
                                            <a
                                                type="button"
                                                class="dropdown-item text-danger"
                                                @click.prevent="
                                                    clickDelete(row.id)
                                                "
                                            >
                                                <i class="fa fa-trash"></i>
                                                Eliminar
                                            </a>
                                        </template>
                                    </div>
                                </td> -->
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <Vehiculo-form
                :showDialog.sync="showDialog"
                :recordId2="recordId2"
            ></Vehiculo-form>
        </div>
    </div>
</template>

<script>
import VehiculoForm from "./form.vue";
import { deletable } from "../../../../../../../resources/js/mixins/deletable";

export default {
    mixins: [deletable],
    props: ["typeUser"],
    components: {
        VehiculoForm
    },
    data() {
        return {
            title: "",
            showDialog: false,
            resource: "workshop/vehiculo",
            recordId2: null,
            records: []
        };
    },
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getData();
        });
        this.getData();
    },
    methods: {
        /* listvehiculos() {
            window.location.href = "/workshop/vehiculo/excel";
        }, */
        listvehiculos() {
            window.open(
                `/${this.resource}/excelVehicle`,
                "_blank"
            );
        },
        
        getData() {
            this.$http.get(`/${this.resource}/records`).then(response => {
                this.records = response.data.data;
            });
        },
        clickCreate(recordId2 = null) {
            this.recordId2 = recordId2;
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
