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
                <div class="table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>juan</td>
                            <td>20/01/2025</td>
                            <td>Saluda</td>
                            <td>para ver el registro de los clientes</td>
                        </tr>
                    </tbody>
                </div>
            </div>
        </div>
        <!-- <system-history-form :showDialog.sync="showDialog"
                            :records="records"
                             :recordId="recordId"></system-history-form> -->

        <HistoryForm
            :showDialog.sync="showDialog"
            :records="records"
            :recordId="recordId"
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
            resource: "history",
            recordId: null,
            records: []
        };
    },
    /* created() {
        this.$eventHub.$on("reloadData", () => {
            this.getData();
        });
        this.getData();
    }, */
    methods: {
        getData() {
            this.$http.get(`/${this.resource}/records`).then(response => {
                this.records = response.data.data;
            });
        },
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },
        /* clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        } */
    }
};
</script>
