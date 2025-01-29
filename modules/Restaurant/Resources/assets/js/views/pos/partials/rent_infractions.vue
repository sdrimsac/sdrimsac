<template>
    <el-dialog
        title="Infracciones"
        :visible="showDialog"
        @close="close"
        @open="open"
    >
        <div v-loading="loading">
            <div class="row mt-2">
                <div class="col-6">
                    <el-input
                        v-model="newInfraction.description"
                        placeholder="Descripción"
                    />
                </div>
                <div class="col-6">
                    <el-input
                        v-model="newInfraction.amount"
                        placeholder="Monto"
                    />
                </div>
                <div class="col-12 mt-2 text-end">
                    <el-button type="primary" @click="storeInfraction"
                        >Guardar</el-button
                    >
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 table-responsive w-100">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Monto</th>
                                <th>Pagado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(infraction, idx) in infractions"
                                :key="idx"
                            >
                                <td>{{ infraction.description }}</td>
                                <td>{{ infraction.amount }}</td>
                                <td>{{ infraction.paid ? "Si" : "No" }}</td>
                                <td>
                                    <el-button
                                        type="danger"
                                        @click="removeInfraction(infraction.id)"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </el-button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["rentId", "showDialog"],
    data() {
        return {
            infractions: [],
            dialogVisible: false,
            loading: false,
            newInfraction: {
                description: "",
                amount: "",
                paid: false
            }
        };
    },
    methods: {
        removeInfraction(id) {
            this.$confirm(
                "¿Estás seguro de querer eliminar esta infracción?",
                "Eliminar infracción",
                {
                    confirmButtonText: "Si",
                    cancelButtonText: "No",
                    type: "warning"
                }
            )
                .then(() => {
                    this.loading = true;
                    this.$http
                        .delete(`/caja/rent/remove-infraction/${id}`)
                        .then(response => {
                            this.getinfractions();
                        })
                        .catch(error => {
                            this.$toast.error(
                                "Error al eliminar la infracción"
                            );
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                })
                .catch(() => {
                    this.$message.error("Infracción no eliminada");
                });
        },

        initForm() {
            this.newInfraction = {
                description: "",
                amount: "",
                paid: false
            };
        },
        storeInfraction() {
            this.loading = true;
            this.newInfraction.hotel_rent_id = this.rentId;
            this.$http
                .post(`/caja/rent/store-infraction`, this.newInfraction)
                .then(response => {
                    this.initForm();
                    this.getinfractions();
                })
                .catch(error => {
                    this.$toast.error("Error al crear la infracción");
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        getinfractions() {
            this.loading = true;
            this.$http
                .get(`/caja/rent/get-infractions/${this.rentId}`)
                .then(response => {
                    this.infractions = response.data.infractions;
                })
                .catch(error => {
                    this.$toast.error("Error al obtener los infractionos");
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        open() {
            this.initForm();
            this.getinfractions();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>

<style></style>
