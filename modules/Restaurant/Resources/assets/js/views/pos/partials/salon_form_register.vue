<template>
    <el-dialog
        :visible="showDialog"
        :close-on-click-modal="false"
        :show-close="true"
        width="90%"
        @close="close"
        @open="open"
        class="salon-register-dialog"
    >
        <template #title>
            <div
                class="d-flex justify-content-between align-items-center bg-primary p-3 text-white w-100"
            >
                <h4 class="m-0 text-white">Registro de Citas</h4>
                <div>{{ formattedCurrentDate }}</div>
            </div>
        </template>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h5 class="text-black">
                        Datos del Principales del Servicio
                    </h5>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-3">
                    <label class="form-label">Local</label>
                    <el-select
                        v-model="form.local"
                        placeholder="Seleccione Local"
                        class="w-100"
                    >
                        <el-option
                            label="Micaela Bastidas"
                            value="micaela"
                        ></el-option>
                    </el-select>
                </div>
                <div class="col-3">
                    <label class="form-label">Categoría</label>
                    <el-select
                        v-model="form.category"
                        placeholder="Seleccione Categoría"
                        class="w-100"
                    >
                        <el-option label="Cabello" value="cabello"></el-option>
                    </el-select>
                </div>
                <div class="col-3">
                    <label class="form-label">Servicio</label>
                    <el-select
                        v-model="form.service"
                        placeholder="Seleccione Servicio"
                        class="w-100"
                    >
                        <el-option
                            label="Cambio de Look"
                            value="look"
                        ></el-option>
                    </el-select>
                </div>
                <div class="col-3">
                    <label class="form-label">Estilista</label>
                    <el-select
                        v-model="form.stylist"
                        placeholder="Seleccione Estilista"
                        class="w-100"
                    >
                        <el-option
                            label="Mariela Soca"
                            value="mariela"
                        ></el-option>
                    </el-select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-lg-3 col-12 border-end">
                    <Calendar v-model="selectedDate" />
                </div>

                <div class="col-md-9 col-lg-9 col-12 row">
                    <div class="col-md-6 col-lg-6 col-12">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-user"></i>
                            <label class="mb-0">Cliente:</label>
                            <el-button
                                type="primary"
                                size="mini"
                                icon="el-icon-plus"
                            ></el-button>
                            <el-button
                                type="primary"
                                size="mini"
                                icon="el-icon-edit"
                            ></el-button>
                        </div>
                        <el-input
                            v-model="form.client"
                            placeholder="Seleccione Cliente"
                        ></el-input>
                    </div>

                    <div class="col-md-6 col-lg-6 col-12">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-user"></i>
                            <label class="mb-0">Nro de WhatsApp:</label>
                            <el-button
                                type="success"
                                size="mini"
                                icon="fab fa-whatsapp"
                            ></el-button>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <el-input v-model="form.whatsapp"></el-input>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Observaciones:</label>
                        <el-input
                            type="textarea"
                            v-model="form.observations"
                        ></el-input>
                    </div>

                    <div class="row mb-4">
                        <div class="col-lg-8 col-md-8 col-12">
                            <h5 class="mb-3">Disponibilidad del Estilista</h5>
                        <div class="row g-2">
                            <div
                                class="col-3"
                                v-for="time in timeSlots"
                                :key="time.hour"
                            >
                                <el-button
                                    :type="time.status"
                                    size="small"
                                    class="w-100"
                                >
                                    {{ time.hour }}
                                </el-button>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-12">
                            <img src="/assets/images/estilista.png" alt="Estilista" class="img-fluid">
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <span class="badge bg-success">LIBRE</span>
                        <span class="badge bg-danger">OCUPADO</span>
                        <span class="badge bg-warning">RESERVADO</span>
                    </div>
                </div>
            </div>

            <div class="row mt-4" v-if="selectedTime">
                <div class="col-12">
                    <div class="alert alert-info">
                        <p class="mb-1">
                            Ud. seleccionó una Reserva
                            {{ formattedSelectedDate }}, Hora:
                            {{ selectedTime }}
                        </p>
                        <p class="mb-0">
                            Hora Aprox. de Finalización: {{ estimatedEndTime }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <template #footer>
            <div class="text-end">
                <el-button type="primary" @click="saveAppointment"
                    >Registrar</el-button
                >
            </div>
        </template>
    </el-dialog>
</template>

<script>
import Calendar from "@components/calendar/Calendar.vue";
import moment from "moment";

export default {
    props: ["showDialog"],
    components: {
        Calendar
    },
    data() {
        return {
            selectedDate: null,
            selectedTime: null,
            form: {
                local: null,
                category: null,
                service: null,
                stylist: null,
                client: null,
                whatsapp: null,
                observations: null
            },
            timeSlots: [
                { hour: "10:00 a.m", status: "success" },
                { hour: "11:00 a.m", status: "success" },
                { hour: "12:00 m", status: "success" },
                { hour: "1:00 p.m", status: "success" },
                { hour: "2:00 p.m", status: "success" },
                { hour: "3:00 p.m", status: "danger" },
                { hour: "4:00 p.m", status: "success" },
                { hour: "5:00 p.m", status: "success" },
                { hour: "6:00 p.m", status: "success" },
                { hour: "7:00 p.m", status: "success" },
                { hour: "8:00 p.m", status: "warning" },
                { hour: "9:00 p.m", status: "success" }
            ],
            monthsSpanish: {
                January: "Enero",
                February: "Febrero",
                March: "Marzo",
                April: "Abril",
                May: "Mayo",
                June: "Junio",
                July: "Julio",
                August: "Agosto",
                September: "Septiembre",
                October: "Octubre",
                November: "Noviembre",
                December: "Diciembre"
            },
            daysSpanish: {
                Monday: "Lunes",
                Tuesday: "Martes",
                Wednesday: "Miércoles",
                Thursday: "Jueves",
                Friday: "Viernes",
                Saturday: "Sábado",
                Sunday: "Domingo"
            }
        };
    },
    computed: {
        formattedCurrentDate() {
            const date = moment();
            const day = this.daysSpanish[date.format("dddd")];
            const month = this.monthsSpanish[date.format("MMMM")];
            return `${day}, ${date.format("D")} de ${month} de ${date.format(
                "YYYY"
            )}`;
        },
        formattedSelectedDate() {
            return this.selectedDate
                ? moment(this.selectedDate).format("D [de] MMMM")
                : "";
        },
        estimatedEndTime() {
            return "45 min";
        }
    },
    methods: {
        close() {
            this.$emit("update:showDialog", false);
        },
        open() {
            // Inicialización al abrir el diálogo
        },
        saveAppointment() {
            // Lógica para guardar la cita
        }
    }
};
</script>

<style scoped>
/* Eliminamos todos los estilos personalizados y solo mantenemos ajustes específicos de Element UI si son necesarios */
:deep(.el-dialog) {
    max-width: 1200px;
}
</style>
