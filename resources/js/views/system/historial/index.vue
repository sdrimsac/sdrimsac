<template>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Historial de Acciones</h4>
                            <div class="right-wrapper pull-right">
                                <button
                                    type="button"
                                    class="btn btn-custom btn-sm  mt-2 mr-2 bg-secondary"
                                    @click.prevent="clickCreate()"
                                >
                                    <i class="fa fa-plus-circle"></i> Nuevo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr class="bg-secondary">
                                    <th class="text-white">ACCIONES</th>
                                    <th class="text-white">CLIENTE</th>
                                    <th class="text-white">NEGOCIO</th>
                                    <th class="text-white">DNI</th>
                                    <th class="text-white">DIRECION CLIENTE</th>
                                    <th class="text-white">
                                        DIRECION DE ESTABLECIMIENTO
                                    </th>
                                    <th class="text-white">CORREO</th>
                                    <th class="text-white">TELEFONO</th>
                                    <th class="text-white">RUC DE NEGOCIO</th>
                                    <th class="text-white">USUARIO SUNAT</th>
                                    <th class="text-white">CLAVE SUNAT</th>
                                    <th class="text-white">
                                        USUARIO SECUNDARIO SUNAT
                                    </th>
                                    <th class="text-white">
                                        CLAVE SECUNDARIO SUNAT
                                    </th>
                                    <th class="text-white">
                                        CLAVE DE CERTIFICADO DIGITAL
                                    </th>
                                    <th class="text-white">
                                        FECHA DE SOLICITUD CERTIFICADO DIGITAL
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(record, index) in records"
                                    :key="index"
                                >
                                    <td>
                                        <div class="dropdown">
                                            <!-- <div
                                                class="dropdown-menu dropdown-menu-end"
                                            > -->
                                                <!-- Editar -->
                                                <button
                                                    class="dropdown-item text-white bg-warning"
                                                    @click.prevent="
                                                        clickCreate(record.id)
                                                    "
                                                >
                                                    <i
                                                        class="fa fa-edit fa-lg me-2"
                                                    ></i>
                                                    Editar
                                                </button>
                                                <!-- Eliminar -->
                                                <!-- <button
                                                    class="dropdown-item text-danger"
                                                    @click.prevent="
                                                        clickDelete(record.id)
                                                    "
                                                >
                                                    <i
                                                        class="fa fa-trash fa-lg me-2"
                                                    ></i>
                                                    Eliminar
                                                </button> -->
                                            <!-- </div> -->
                                        </div>
                                    </td>
                                    <td>{{ record.name }}</td>
                                    <td>{{ record.business_id }}</td>
                                    <td>{{ record.number }}</td>
                                    <td>{{ record.direccion }}</td>
                                    <td>{{ record.direccion_secondary }}</td>
                                    <td>{{ record.email }}</td>
                                    <td>{{ record.telephone }}</td>
                                    <td>{{ record.ruc }}</td>
                                    <td>{{ record.user }}</td>
                                    <td>{{ record.password }}</td>
                                    <td>{{ record.user_secondary }}</td>
                                    <td>{{ record.password_secondary }}</td>
                                    <td>{{ record.password_certificate }}</td>
                                    <td>{{ record.date_certificate }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <HistoryForm
            :showDialog.sync="showDialog"
            :records="records"
            :recordId="recordId"
            :business="business"
        ></HistoryForm>
    </div>
</template>
<script>
import HistoryForm from "./form.vue";

export default {
    components: { HistoryForm },
    data() {
        return {
            showDialog: false,
            resource: "historial",
            recordId: null,
            records: [],
            business: []
        };
    },
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getData();
        });
        this.getData();
        this.getBusiness();
    },
    methods: {
        getBusiness() {
            this.$http.get(`/${this.resource}/tables`).then(response => {
                this.business = response.data.business;
            });
        },
        getData() {
            this.$http.get(`/${this.resource}/records`).then(response => {
                this.records = response.data.data;
            });
        },
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        }
        /* clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        } */
    }
};
</script>
