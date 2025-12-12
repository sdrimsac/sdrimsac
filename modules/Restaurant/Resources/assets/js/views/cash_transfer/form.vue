<template>
    <el-dialog
        title="Transferencia de caja"
        :visible="showDialog"
        append-to-body
        @close="close"
        @open="open"
        v-loading="loading"
    >
        <div class="row m-2">
            <div class="col-md-6">
                <label for="cash_origin_id">Caja destino</label>
                <el-select
                    v-model="form.cash_destination_id"
                    placeholder="Seleccione una caja"
                >
                    <el-option
                        v-for="cash in cashes"
                        :key="cash.id"
                        :label="cash.description"
                        :value="cash.id"
                    >
                        <el-tooltip
                            effect="dark"
                            :content="cash.user_name + ' - ' + cash.description"
                            placement="top"
                        >
                            <span style="float: left">{{
                                cash.description
                            }}</span>
                        </el-tooltip>
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-6">
                <label for="amount">Monto</label>
                <el-input-number
                    class="w-100"
                    v-model="form.amount"
                    :min="0"
                    :step="0.01"
                ></el-input-number>
            </div>
            <div class="col-12">
                <label for="observation">Observación</label>
                <el-input v-model="form.observation" type="textarea"></el-input>
            </div>
        </div>

        <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="save">Guardar</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: {
        cashAvailable: {
            type: Number,
            default: 0
        },
        showDialog: {
            type: Boolean,
            default: false
        },
        recordId: {
            type: Number,
            default: null
        }
    },
    data() {
        return {
            loading: false,
            form: {},
            cashes: [],
            resource: "caja/cash-transfer"
        };
    },
    methods: {
        verifyForm() {
            if(this.form.amount > this.cashAvailable){
                this.$message.error("El monto a transferir no puede ser mayor al monto disponible en caja");
                return false;
            }
            if (!this.form.cash_destination_id) {
                this.$message.error("Debe seleccionar una caja destino");
                return false;
            }
            if (!this.form.amount) {
                this.$message.error("Debe ingresar un monto");
                return false;
            }
            return true;
        },
        getCashes() {
            this.$http.get(`/${this.resource}/cashes`).then(response => {
                let { data } = response;
                this.cashes = data.cashes;
            });
        },
        initForm() {
            this.form = {
                amount: 0,
                observation: "",
                cash_destination_id: null
            };
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        getTables() {},
        open() {
            this.getCashes();
            this.initForm();
        },
        save() {
            if (!this.verifyForm()) {
                return;
            }
            let cash = this.cashes.find(
                cash => cash.id == this.form.cash_destination_id
            );
            let {user_name} = cash;
            this.$confirm(
                `¿Está seguro de realizar la transferencia de caja de ${this.form.amount} a la caja de ${user_name}?`,
                "Confirmación",
                {
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar",
                    type: "warning"
                }
            )
                .then(() => {
                    this.loading = true;
                    this.$http
                        .post(`/${this.resource}`, this.form)
                        .then(response => {
                            if (response.data.success) {
                                this.$toast.success(
                                    "Transferencia realizada con éxito"
                                );
                                this.$eventHub.$emit("reloadData");
                                this.$emit("updateCash");
                                this.close();
                            } else {
                                this.$toast.error(response.data.message);
                            }
                        })
                        .catch(error => {
                            this.$toast.error(
                                "Error al realizar la transferencia"
                            );
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                })
                .catch(() => {});
        }
    }
};
</script>
