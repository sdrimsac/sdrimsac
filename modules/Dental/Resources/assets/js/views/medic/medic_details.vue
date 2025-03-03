<template>
    <el-dialog
        :visible.sync="showDialogMedicDetails"
        title="Configurar Horario Médico"
        :open="open"
        :close-on-click-modal="false"
        width="70%"
    >
        <el-form @submit.prevent="saveSchedule">
            <!-- Sección de Horario por Defecto -->
            <el-card shadow="never" style="margin-bottom: 20px;">
                <h3>Horario General</h3>
                <div style="display: flex; gap: 20px; align-items: center;">
                    <el-form-item label="Hora Inicio">
                        <el-time-picker
                            v-model="defaultSchedule.start_time"
                            format="HH:mm"
                        ></el-time-picker>
                    </el-form-item>
                    <el-form-item label="Hora Fin">
                        <el-time-picker
                            v-model="defaultSchedule.end_time"
                            format="HH:mm"
                        ></el-time-picker>
                    </el-form-item>
                    <el-button type="primary" @click="applyDefaultSchedule">
                        Aplicar Horario General
                    </el-button>
                </div>
                <div>

                </div>
            </el-card>

            <!-- Tabs para cada día -->
            <el-tabs v-model="activeTab" type="border-card">
                <el-tab-pane
                    v-for="(day, index) in schedules"
                    :key="index"
                    :label="day.day_of_week"
                    :name="day.day_of_week"
                >
                    <div class="day-content">
                        <el-checkbox v-model="day.is_active">
                            {{ day.day_of_week }} Activo
                        </el-checkbox>

                        <template v-if="day.is_active">
                            <div
                                v-for="(timeSlot, i) in day.time_slots"
                                :key="i"
                                class="time-slot"
                            >
                                <el-form-item label="Hora Inicio">
                                    <el-time-picker
                                        v-model="timeSlot.start_time"
                                        format="HH:mm"
                                    ></el-time-picker>
                                </el-form-item>
                                <el-form-item label="Hora Fin">
                                    <el-time-picker
                                        v-model="timeSlot.end_time"
                                        format="HH:mm"
                                    ></el-time-picker>
                                </el-form-item>
                                <el-button
                                    type="danger"
                                    @click="removeTimeSlot(day, i)"
                                >
                                    Eliminar
                                </el-button>
                            </div>
                            <el-button type="success" @click="addTimeSlot(day)">
                                Agregar Horario
                            </el-button>
                        </template>
                    </div>
                </el-tab-pane>
            </el-tabs>

            <div
                style="display: flex; justify-content: flex-end; margin-top: 20px;"
            >
                <el-button
                    type="danger"
                    size="large"
                    @click="close"
                    style="margin-right: 10px;"
                >
                    Cancelar
                </el-button>
                <el-button type="success" size="large" @click="saveSchedule">
                    Guardar
                </el-button>
            </div>
        </el-form>
    </el-dialog>
</template>

<script>
import Clock from "@components/clock/Clock.vue";
export default {
    props: {
        showDialogMedicDetails: {
            type: Boolean,
            default: false
        },
        recordId: {
            type: [String, Number],
            default: null
        }
    },
    components: {
        Clock
    },
    data() {
        return {
            activeTab: 'Lunes',
            showModal: false,
            defaultSchedule: {
                start_time: "08:00",
                end_time: "18:00"
            },
            schedules: [
                {
                    day_of_week: "Lunes",
                    is_active: true,
                    time_slots: [{ start_time: "08:00", end_time: "18:00" }]
                },
                {
                    day_of_week: "Martes",
                    is_active: true,
                    time_slots: [{ start_time: "08:00", end_time: "18:00" }]
                },
                {
                    day_of_week: "Miercoles",
                    is_active: true,
                    time_slots: [{ start_time: "08:00", end_time: "18:00" }]
                },
                {
                    day_of_week: "Jueves",
                    is_active: true,
                    time_slots: [{ start_time: "08:00", end_time: "18:00" }]
                },
                {
                    day_of_week: "Viernes",
                    is_active: true,
                    time_slots: [{ start_time: "08:00", end_time: "18:00" }]
                },
                {
                    day_of_week: "Sabado",
                    is_active: true,
                    time_slots: [{ start_time: "08:00", end_time: "14:00" }]
                },
                { day_of_week: "Domingo", is_active: false, time_slots: [] }
            ]
        };
    },
    methods: {
        applyDefaultSchedule() {
            this.schedules.forEach(day => {
                if (day.is_active) {
                    day.time_slots = [
                        {
                            start_time: this.defaultSchedule.start_time,
                            end_time: this.defaultSchedule.end_time
                        }
                    ];
                }
            });
        },
        addTimeSlot(day) {
            day.time_slots.push({ start_time: "", end_time: "" });
        },
        removeTimeSlot(day, index) {
            day.time_slots.splice(index, 1);
        },
        async saveSchedule() {
            try {
                // Preparar los datos para enviar
                const schedulesData = {
                    medic_id: this.recordId,
                    schedules: this.schedules.map(day => ({
                        day_of_week: day.day_of_week,
                        start_time: day.time_slots[0]?.start_time || "",
                        end_time: day.time_slots[0]?.end_time || "",
                        is_active: day.is_active
                    }))
                };

                // Enviar los datos al backend
                const response = await this.$http.post(
                    "medic_details",
                    schedulesData
                );

                if (response.data.success) {
                    this.$message.success("Horarios guardados correctamente");
                    this.$emit("update:showDialogMedicDetails", false);
                }
            } catch (error) {
                console.error("Error al guardar:", error);
                this.$message.error("Ocurrió un error al guardar los horarios");
            }
        },
        open() {
            this.showModal = true;
        },
        close() {
            this.showModal = false;
            this.$emit("update:showDialogMedicDetails", false);
        }
    }
};
</script>

<style scoped>
.day-content {
    padding: 20px;
}
.time-slot {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}
.day-card {
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}
</style>
