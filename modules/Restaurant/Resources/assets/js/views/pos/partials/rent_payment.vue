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
                            <tr class="bg-primary">
                                <th></th>
                                <th class="text-white">Periodo</th>
                                <th class="text-end text-white">Mensualidad</th>
                                <th class="text-end text-white">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(payment, idx) in payments" :key="idx">
                                <td class="text-center">
                                    <el-checkbox
                                        v-model="payment.select"
                                    ></el-checkbox>
                                </td>
                                <td>{{ payment.period }}</td>
                                <td class="text-end">
                                    {{ payment.amount }}
                                </td>
                                <td>
                                    <el-input
                                        v-model="payment.editable_amount"
                                        type="number"
                                        size="mini"
                                        class="amount-input"
                                    ></el-input>
                                </td>
                            </tr>
                            <tr
                                v-for="(penalty, idx) in penalties"
                                :key="'pen-' + idx"
                            >
                                <td class="text-center">
                                    <el-checkbox
                                        v-model="penalty.select"
                                    ></el-checkbox>
                                </td>
                                <td colspan="2">
                                    Días de atraso: {{ penalty.days_late }}
                                </td>
                                <td class="text-end">
                                    <el-input
                                        v-model="penalty.amount"
                                        type="number"
                                        size="mini"
                                        class="amount-input"
                                    ></el-input>
                                </td>
                            </tr>
                            <tr
                                v-for="(infraction, idx) in infractions"
                                :key="'inf-' + idx"
                            >
                                <td class="text-center">
                                    <el-checkbox
                                        v-model="infraction.select"
                                    ></el-checkbox>
                                </td>
                                <td colspan="2">
                                    {{ infraction.description }}
                                </td>
                                <td class="text-end">
                                    <el-input
                                        v-model="infraction.amount"
                                        type="number"
                                        size="mini"
                                        class="amount-input"
                                    ></el-input>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">Total</td>
                                <td class="text-end">{{ total }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="submit">Pagar</el-button>
        </span> -->
        <span slot="footer" class="dialog-footer">
            <el-button
                @click="close"
                style="background-color: red; color: white; font-size: 18px; padding: 12px 24px;"
            >
                Cancelar
            </el-button>

            <el-button
                
                @click="submit"
                style="background-color: green; color: white; font-size: 18px; padding: 12px 24px;"
            >
                Pagar
            </el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["rentId", "showDialog"],
    data() {
        return {
            infractions: [],
            penalties: [],
            dialogVisible: false,
            loading: false,
            payments: [],
            newInfraction: {
                description: "",
                amount: "",
                paid: false
            }
        };
    },
    computed: {
        total() {
            const infractionTotal = this.infractions
                .filter(infraction => infraction.select)
                .reduce(
                    (acc, infraction) => acc + Number(infraction.amount),
                    0
                );

            const paymentTotal = this.payments
                .filter(payment => payment.select)
                .reduce(
                    (acc, payment) => acc + Number(payment.editable_amount),
                    0
                );

            const penaltyTotal = this.penalties
                .filter(penalty => penalty.select)
                .reduce((acc, penalty) => acc + Number(penalty.amount), 0);

            return (infractionTotal + paymentTotal + penaltyTotal).toFixed(2);
        }
    },
    methods: {
        submit() {
            if(this.total == 0){
                this.$showSAlert("Alerta", "No hay ningún pago para realizar", "warning");
                return;
            }
            let penalties = this.penalties.filter(penalty => penalty.select);
            let infractions = this.infractions.filter(
                infraction => infraction.select

            );
            let payments = this.payments.filter(payment => payment.select);
            this.$http
                .post(`/caja/rent/prepare-payment`, {
                    hotel_rent_id: this.rentId,
                    infractions: infractions,
                    payments: payments,
                    penalties: penalties
                })
                .then(response => {
                    let items = response.data.items;
                    let customer_number = response.data.customer_number;
                    this.$emit("paymentsOrden", {
                        items: items,
                        is_room: true,
                        hotel_rent_id: this.rentId,
                        is_rent_payment: true,
                        customer_number
                    });
                    this.close();
                })
                .catch(error => {
                    this.$toast.error("Error al preparar el pago");
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        getRentAmount() {
            this.$http
                .get(`/caja/rent/get-amount/${this.rentId}`)
                .then(response => {
                    console.log(response.data);
                    this.payments = response.data.payments.map(payment => ({
                        ...payment,
                        select: false
                    }));
                    this.penalties = response.data.penalties.map(penalty => ({
                        ...penalty,
                        select: false
                    }));
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

<style>
.amount-input .el-input__inner {
    text-align: right;
}
</style>
