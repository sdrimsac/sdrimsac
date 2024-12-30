<!-- Ofertas de Venta 3x2 etc -->
<template>
<el-dialog title="Ofertas de venta" :visible.sync="showDialog" @close="close" @open="open" append-to-body v-loading="loading">
    <div class="row mt-2">
        <div class="col-md-5">
            <label>
                Cantidad a Entregar
                <el-tooltip content="Cantidad Total de productos a entregar" placement="top">
                    <i class="el-icon-info"></i>
                </el-tooltip>
            </label>
            <el-input v-model="form.quantity_free" placeholder="Cantidad gratis"></el-input>
        </div>
        <div class="col-md-5">
            <label>
                Cantidad a Pagar
                <el-tooltip content="Cantidad Total de productos a Pagar" placement="top">
                    <i class="el-icon-info"></i>
                </el-tooltip>
            </label>
            <el-input v-model="form.quantity_total" placeholder="Cantidad total"></el-input>
        </div>

        <div class="col-md-2 d-flex justify-content-center">
            <el-button  class="btn-agregar btn-save:hover" 
                        icon="fas fa-plus fa-lg" 
                        type="primary" 
                        @click="save()"
            >
                Agregar
            </el-button>
        </div>
    </div>

    <div class="row mt-2">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr style="background-color: #1e5a85;  text-align: center;">
                        <th style="color: #f1f1f1;">Unidades a Entregar</th>
                        <th style="color: #f1f1f1;">Unidades a pagar</th>
                        <th style="color: #f1f1f1;">Nombre de Oferta</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="record in records" :key="record.id" style="text-align: center;">
                        <td>{{ record.quantity_free }}</td>
                        <td>{{ record.quantity_total }}</td>
                        <td>
                            <h3>
                                {{ record.quantity_free }} x
                                {{ record.quantity_total }}
                            </h3>
                        </td>
                        <td>
                            <el-button type="danger" @click="deleteRecord(record)">
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
            // Mostrar confirmación
            this.$showSConfirm(
                "Eliminar OFERTA DE VENTA",
                "¿Estás seguro de querer eliminar el registro?"
            ).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, realiza la solicitud HTTP
                    this.$http
                        .post("/items/sale-offert/delete", {
                            id: record.id
                        })
                        .then(response => {
                            // Notificación de éxito
                            this.$showSAlert(
                                "CORRECTO",
                                "OFERTA Eliminada Correctamente",
                                "success"
                            );
                            this.getData(); // Actualizar datos
                        })
                        .catch(error => {
                            // Notificación de error
                            this.$showSAlert(
                                "ERROR",
                                "Hubo un problema al eliminar la oferta",
                                "error"
                            );
                        });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Opcional: manejar cancelación
                    console.log("Eliminación cancelada");
                }
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
                    // this.$message.error(
                    //     "Error al obtener las ofertas de venta"
                    // );
                    this.$showSAlert(
                        "ERROR",
                        "Error al obtener las OFERTAS DE VENTA, verifique su conexión a internet",
                        "Warning"
                    );

                })
                .finally(() => {
                    this.loading = false;
                });
        },
        save() {
            if (this.form.quantity_total <= 0 || this.form.quantity_free <= 0) {
                this.$showSAlert(
                    "ALERTA IMPORTANTE",
                    "La CANTIDAD Total y Gratuita, deben ser MAYORES a 0",
                    "warning"
                );
                return;
            }

            this.loading = true;
            this.$http
                .post("/items/sale-offert/save", this.form)
                .then(response => {
                    this.$showSAlert(
                        "CORRECTO",
                        "Oferta de Venta Guardada Correctamente",
                        "success"
                    );
                    this.clearForm();
                    this.getData();
                })
                .catch(error => {

                    this.$showSAlert(
                        "ERROR",
                        "Error al GUARDAR la Oferta de Venta",
                        "Warning"
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
