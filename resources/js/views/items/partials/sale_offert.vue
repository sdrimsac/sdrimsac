<!-- Ofertas de Venta 3x2 etc -->
<template>
<el-dialog title="Módulo Ofertas de Venta" :visible.sync="showDialog" @close="close" @open="open" append-to-body v-loading="loading">
    <div class="row mt-2">
        <div class="col-md-4">
            <label>Se Entrega</label>
            <el-input
                v-model="form.quantity_free"
                placeholder="Cantidad gratis"
                maxlength="2"
                @input="val => { const v = String(val).replace(/\D/g,'').slice(0,2); this.form.quantity_free = v === '' ? 0 : Number(v); }"
            ></el-input>
        </div>
        <div class="col-md-5">
            <label>Se Paga:
            </label>
            <el-input
                v-model="form.quantity_total"
                placeholder="Cantidad total"
                maxlength="2"
                @input="val => { const v = String(val).replace(/\D/g,'').slice(0,2); this.form.quantity_total = v === '' ? 0 : Number(v); }"
            />
        </div>

        <div class="col-md-2 d-flex justify-content-center">
            <el-button  class="btn_guardarsmall " 
                        
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
                    <tr style="background-color: #073f68;  text-align: center;">
                        
                        <th style="color: #f1f1f1;">A Entregar</th>
                        <th style="color: #f1f1f1;">Por pagar</th>
                        <th style="color: #f1f1f1; text-align: center; vertical-align: middle;">Descripción</th>
                        <th style="color: #f1f1f1; text-align: center; vertical-align: middle;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="record in records" :key="record.id" :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                        
                        <td style="text-align:center; vertical-align:middle;">{{ record.quantity_free }}</td>
                        <td style="text-align:center; vertical-align:middle;">{{ record.quantity_total }}</td>
                        <td style="text-align:center; vertical-align:middle;">
                            <h3 style="margin:0;">
                                {{ record.quantity_free }} x {{ record.quantity_total }}
                            </h3>
                        </td>
                        <td style="text-align:center; vertical-align:middle;">
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
