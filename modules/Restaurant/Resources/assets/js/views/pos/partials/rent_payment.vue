<template>
    <el-dialog
        title="Pagar mensualidad"
        :visible="showDialog"
        @close="close"
        @open="open"
    >
        <div v-loading="loading">
            <div class="row mt-2">
                <div class="col-12 table-responsive w-100">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Recargo</th>
                                <th class="text-end">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(infraction, idx) in infractions"
                                :key="idx"
                            >
                                <td class="text-center">
                                    <el-checkbox
                                        v-model="infraction.select"
                                    ></el-checkbox>
                                </td>
                                <td>{{ infraction.description }}</td>
                                <td class="text-end">
                                    {{ infraction.amount }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Mensualidad</th>
                                <th class="text-end">
                                    {{ totalRent }}
                                </th>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td>Total</td>
                                <td class="text-end">{{ total }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="submit">Pagar</el-button>
        </span>
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
            totalRent: 0,
            newInfraction: {
                description: "",
                amount: "",
                paid: false
            }
        };
    },
    computed: {
        total() {
            return (
                (this.infractions
                    .filter(infraction => infraction.select)
                    .reduce(
                        (acc, infraction) => acc + Number(infraction.amount),
                        0
                    ) + Number(this.totalRent)).toFixed(2)
            );
        }
    },
    methods: {
        submit() {
            let infractions = this.infractions.filter(infraction => infraction.select);
            this.$http.post(`/caja/rent/prepare-payment`, {
                hotel_rent_id: this.rentId,
                infractions: infractions
            }).then(response => {
                let items = response.data.items;
                let customer_number = response.data.customer_number;
                this.$emit("paymentsOrden", {
                    items: items,
                    is_room: true,
                    hotel_rent_id: this.rentId,
                    is_rent_payment: true,
                    customer_number,

                });
                
            }).catch(error => {
                this.$toast.error("Error al preparar el pago");
            }).finally(() => {
                this.loading = false;
            });
        },
        getRentAmount() {
            this.$http
                .get(`/caja/rent/get-amount/${this.rentId}`)
                .then(response => {
                    this.totalRent = response.data.total;
                });
        },
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
                .get(`/caja/rent/get-infractions-debt/${this.rentId}`)
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
            this.getRentAmount();
            this.getinfractions();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>

<style></style>
