<template>
    <el-dialog
        title="Ofertas de venta"
        :visible.sync="showDialog"
        @close="close"
        @open="open"
        append-to-body
        v-loading="loading"
    >
        <div class="row mt-2">
            <div class="col-md-4">
                <label>Cantidad total</label>
                <el-input
                    v-model="form.quantity_free"
                    placeholder="Cantidad gratis"
                ></el-input>
            </div>
            <div class="col-md-4">
                <label>Cantidad a pagar</label>
                <el-input
                    v-model="form.quantity_total"
                    placeholder="Cantidad total"
                ></el-input>
            </div>

            <div class="col-md-4">
                <br />
                <el-button type="primary" @click="save()">
                    Guardar
                </el-button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Cantidad total</th>
                            <th>Cantidad a pagar</th>
                            <th>Oferta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="record in records" :key="record.id">
                            <td>{{ record.quantity_free }}</td>
                            <td>{{ record.quantity_total }}</td>
                            <td>
                                <h3>
                                    {{ record.quantity_free }} X
                                    {{ record.quantity_total }}
                                </h3>
                            </td>
                            <td>
                                <el-button
                                    type="danger"
                                    @click="deleteRecord(record)"
                                >
                                    <i class="el-icon-delete"></i>
                                </el-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "recordId"],
    data() {
        return {
            records: [],
            loading: false,
            form: {
                id: null,
                quantity_total: 0,
                quantity_free: 0
            }
        };
    },
    created() {
        this.getData();
    },
    methods: {
        clearForm() {
            this.form = {
                id: null,
                quantity_total: 0,
                quantity_free: 0
            };
        },
        deleteRecord(record) {
            this.$confirm(
                "¿Estás seguro de querer eliminar esta oferta de venta?",
                "Eliminar oferta de venta",
                {
                    confirmButtonText: "Eliminar",
                    cancelButtonText: "Cancelar",
                    type: "warning"
                }
            ).then(() => {
                this.$http
                    .post("/items/sale-offert/delete", { id: record.id })
                    .then(response => {
                        this.$message.success(
                            "Oferta de venta eliminada correctamente"
                        );
                        this.getData();
                    });
            });
        },
        open() {
            this.clearForm();
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        getData() {
            this.loading = true;
            this.$http
                .get("/items/sale-offert/get")
                .then(response => {
                    this.records = response.data;
                })
                .catch(error => {
                    this.$message.error(
                        "Error al obtener las ofertas de venta"
                    );
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        save() {
            if (this.form.quantity_total <= 0 || this.form.quantity_free <= 0) {
                this.$message.error(
                    "La cantidad total y la cantidad gratuita deben ser mayores a 0"
                );
                return;
            }

            this.loading = true;
            this.$http
                .post("/items/sale-offert/save", this.form)
                .then(response => {
                    this.$message.success(
                        "Oferta de venta guardada correctamente"
                    );
                    this.clearForm();
                    this.getData();
                })
                .catch(error => {
                    this.$message.error(
                        "Error al guardar la oferta de venta"
                    );
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    }
};
</script>

<style></style>
