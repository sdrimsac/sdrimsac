<template>
    <el-dialog
        title="Configuración de Hotel"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        :visible="showDialog"
        append-to-body
        @close="close"
        @open="open"
        width="70%"
        class="rounded-dialog"
    >
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Template Hotel -->
                    <template v-if="form.hotels">
                        <div class="col-md-4 mt-4">
                            <div class="form-group">
                                <label class="control-label w-100">
                                    Tiempo de alarma de alquileres por vencer
                                </label>

                                <el-input-number
                                    @change="submit"
                                    v-model="form.alarm_to_end"
                                ></el-input-number>
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div class="form-group">
                                <label class="control-label w-100">
                                    Tiempo para el calculo del inicio del dia
                                </label>

                                <el-time-picker
                                    style="width: 100%;"
                                    value-format="HH:mm:ss"
                                    :format="'hh:mm A'"
                                    :picker-options="{
                                        format: 'hh:mm A' // Utiliza 'hh' para las horas en formato de 12 horas y 'A' para AM/PM
                                    }"
                                    timezone="America/Lima"
                                    v-model="form.time_to_enter"
                                ></el-time-picker>
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div class="form-group">
                                <label class="control-label w-100">
                                    Tiempo para el calculo del final del dia
                                </label>

                                <el-time-picker
                                    style="width: 100%;"
                                    value-format="HH:mm:ss"
                                    :format="'hh:mm A'"
                                    :picker-options="{
                                        format: 'hh:mm A' // Utiliza 'hh' para las horas en formato de 12 horas y 'A' para AM/PM
                                    }"
                                    timezone="America/Lima"
                                    v-model="form.time_to_leave"
                                ></el-time-picker>
                            </div>
                        </div>

                        <div class="col-md-4 mt-4">
                            <div class="form-group">
                                <label class="control-label w-100"
                                    >Tiempo de mantenimiento</label
                                >

                                <el-input-number
                                    @change="submit"
                                    v-model="form.time_manteniment"
                                ></el-input-number>
                            </div>
                        </div>

                        <div class="col-md-4 mt-4">
                            <div class="form-group">
                                <label class="control-label w-100">
                                    Limite de la garantía - frigobar
                                </label>
                                <el-input-number
                                    @change="submit"
                                    v-model="form.credit_line_hotel_limit"
                                ></el-input-number>
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div class="form-group">
                                <label class="control-label w-100">
                                    Descuento aplicado por día a cambio del
                                    servicio x habitación
                                </label>
                                <el-input-number
                                    @change="submit"
                                    v-model="
                                        form.discount_amount_instead_service
                                    "
                                ></el-input-number>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog"],
    components: {},
    data() {
        return {
            resource: "configurations",
            form: {
                alarm_to_end: 0,
                time_to_enter: null,
                time_to_leave: null,
                time_manteniment: 0,
                credit_line_hotel_limit: 0,
                discount_amount_instead_service: 0
            },
            loading_submit: false
        };
    },
    methods: {
        promotionsSetUp(optionName) {
            if (
                optionName === "Habilitar Promociones Documento" &&
                this.form.is_promotion_document
            ) {
                this.form.promotions_by_points = false;
            } else if (
                optionName === "Habilitar Promociones por puntos" &&
                this.form.promotions_by_points
            ) {
                this.form.is_promotion_document = false;
            }
        },
        async submit(
            optionName,
            isActive,
            iconOrImgSrc,
            iconRef,
            isImage = false
        ) {
            this.promotionsSetUp(optionName);
            const action = isActive ? "ACTIVADO" : "DESACTIVADO";
            const backgroundColor = "#f8f9fa";
            const actionColor = isActive ? "#28a745" : "#dc3545";

            let iconHtml = "";

            if (isImage && iconOrImgSrc) {
                iconHtml = `<img src="${iconOrImgSrc}" alt="${optionName} Logo" class="payment-logo" style="width: 80px; height: auto; vertical-align: middle; margin-right: 10px; border-radius: 0;" />`;
            }

            this.loading_submit = true;

            try {
                const response = await this.$http.post(
                    `/${this.resource}`,
                    this.form
                );

                if (response.data.success) {
                    Swal.fire({
                        position: "center",
                        icon: isActive ? "success" : "error",
                        title: optionName
                            ? optionName.toUpperCase()
                            : "ACTUALIZADO",
                        html: `<strong style="color: ${actionColor};">${action}</strong>${
                            iconHtml ? `<br>${iconHtml}` : ""
                        }`,
                        background: backgroundColor,
                        showConfirmButton: false,
                        timer: 2000 // Duración de 2 segundos
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "ERROR",
                        text: `Hubo un problema al actualizar la opción "${optionName}". Inténtalo de nuevo.`,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "ERROR EN EL FORMULARIO",
                        text:
                            "Hay errores en el formulario. Revísalos e intenta nuevamente.",
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else if (!navigator.onLine) {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "SIN CONEXIÓN A INTERNET",
                        html: `<i class="fas fa-wifi-slash" style="color: #dc3545; font-size: 2rem;"></i><br>Parece que no tienes conexión a Internet. Verifica tu conexión y vuelve a intentarlo.`,
                        background: backgroundColor,
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    console.log("Error de conexión:", error);
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "ERROR DE CONEXIÓN",
                        text:
                            "Error de conexión. Verifica tu red y vuelve a intentarlo.",
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            } finally {
                this.loading_submit = false;
            }

            this.animateIcon(iconRef); // Animar el ícono correspondiente
        },
        animateIcon(iconRef) {
            const icon = this.$refs[iconRef];
            if (icon) {
                icon.classList.add("animate-icon");
                setTimeout(() => {
                    icon.classList.remove("animate-icon");
                }, 1000);
            }
        },

        async open() {
            console.log(this.isArca);
            await this.$http.get(`/${this.resource}/record`).then(response => {
                if (response.data !== "") {
                    this.form = response.data.data;
                }
            });

            if (this.isArca) {
                this.activeTab = "hotel";
            }
        },
        close() {
            this.$emit('update:showDialog', false)
        }
    }
};
</script>
