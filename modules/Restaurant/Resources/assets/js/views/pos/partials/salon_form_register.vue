<template>
    <el-dialog
        :visible="showDialog"
        :close-on-click-modal="false"
        :show-close="true"
        width="90%"
        @close="close"
        @open="open"
        class="salon-register-dialog"
        append-to-body
    >
        <template #title>
            <div
                class="d-flex justify-content-between align-items-center bg-primary p-3 text-white w-100"
            >
                <h4 class="m-0 text-white">{{ isEditing ? 'Editar Cita' : 'Registro de Citas' }}</h4>
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
                        v-model="form.category_id"
                        placeholder="Seleccione Categoría"
                        class="w-100"
                        filterable
                        @change="getServices"
                    >
                        <el-option
                            v-for="category in categories"
                            :key="category.id"
                            :label="category.name"
                            :value="category.id"
                        ></el-option>
                    </el-select>
                </div>
                <div class="col-3">
                    <label class="form-label">Servicio</label>
                    <el-select
                        v-model="form.item_id"
                        placeholder="Seleccione Servicio"
                        class="w-100"
                        :disabled="loading"
                        @change="setService"
                    >
                        <el-option
                            v-for="service in services"
                            :key="service.id"
                            :label="service.name"
                            :value="service.id"
                        ></el-option>
                    </el-select>
                </div>
                <div class="col-3">
                    <label class="form-label">Estilista</label>
                    <el-select
                        v-model="form.user_id"
                        placeholder="Seleccione Estilista"
                        class="w-100"
                        @change="getStylistSchedule"
                    >
                        <el-option
                            v-for="user in users_has_services"
                            :key="user.id"
                            :label="user.name"
                            :value="user.id"
                        ></el-option>
                    </el-select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-lg-3 col-12 border-end">
                    <Calendar 
                        v-model="selectedDate" 
                        @input="getStylistSchedule" 
                        :key="calendarKey"
                    />
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
                    
                        <el-select
                            class="col-md-6"
                            ref="select_person"
                            v-model="form.client"
                            filterable
                            clearable
                            size="small"
                            placeholder="Cliente"
                            :disabled="loading"
                            @change="changeCustomer"
                            @keyup.native="keyupCustomer"
                        >
                            <el-option
                                v-for="(option, idx) in customers"
                                :key="idx"
                                :label="option.description"
                                :value="option.id"
                            ></el-option>
                        </el-select>
                    </div>

                    <div class="col-md-6 col-lg-6 col-12">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-user"></i>
                            <label class="mb-0">Nro de WhatsApp:</label>
                            <el-button
                                type="success"
                                size="mini"
                                icon="el-icon-phone"
                            ></el-button>
                        </div>
                        <el-input
                            v-model="form.whatsapp"
                            placeholder="Nro de WhatsApp"
                        ></el-input>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Observaciones:</label>
                        <el-input
                            type="textarea"
                            v-model="form.observations"
                            rows="2"
                        ></el-input>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">Horarios Disponibles</h5>
                            <div v-if="selectedDate" class="text-primary">
                                {{ formattedSelectedDate }}
                            </div>
                        </div>

                        <div v-if="loading" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Cargando...</span>
                            </div>
                            <p class="mt-2">Cargando horarios disponibles...</p>
                        </div>

                        <div v-else-if="!form.user_id || !selectedDate" class="alert alert-info">
                            Seleccione un estilista y una fecha para ver los horarios disponibles.
                        </div>

                        <div v-else-if="availableTimeSlots.length === 0" class="alert alert-warning">
                            No hay horarios disponibles para la fecha seleccionada.
                        </div>

                        <div v-else class="time-slots-grid">
                            <div 
                                v-for="(slot, index) in availableTimeSlots" 
                                :key="index"
                                class="time-slot-card"
                                :class="{
                                    'available': slot.available,
                                    'reserved': slot.reserved,
                                    'unavailable': !slot.available && !slot.reserved,
                                    'selected': selectedTimeSlot === index
                                }"
                                @click="selectTimeSlot(slot, index)"
                            >
                                <div class="time">{{ slot.start }} - {{ slot.end }}</div>
                                <div class="status">
                                    <span v-if="slot.available" class="badge badge-success">Disponible</span>
                                    <span v-else-if="slot.reserved" class="badge badge-warning">Reservado</span>
                                    <span v-else class="badge badge-danger">No Disponible</span>
                                </div>
                            </div>
                        </div>

                        <!-- Leyenda de colores -->
                        <div class="time-slots-legend mt-3">
                            <div class="legend-item">
                                <div class="legend-color available"></div>
                                <div class="legend-text">Disponible</div>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color reserved"></div>
                                <div class="legend-text">Reservado</div>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color unavailable"></div>
                                <div class="legend-text">No Disponible</div>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color selected"></div>
                                <div class="legend-text">Seleccionado</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-3" v-if="selectedTimeSlot !== null">
                        <div class="alert alert-info">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>Horario seleccionado:</strong> 
                                    {{ selectedTimeSlotData ? `${selectedTimeSlotData.start} - ${selectedTimeSlotData.end}` : '' }}
                                </div>
                                <div>
                                    <strong>Duración estimada:</strong> {{ estimatedEndTime }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <template #footer>
            <div class="text-end">
                <el-button type="primary" @click="saveAppointment" :disabled="!canSave">
                    Registrar
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script>
import Calendar from "@components/calendar/Calendar.vue";
import moment from "moment";

export default {
    props: {
        categories: {
            type: Array,
            default: []
        },
        showDialog: {
            type: Boolean,
            required: true
        },
        preselectedClient: {
            type: [Number, String],
            default: null
        },
        appointmentId: {
            type: [Number, String],
            default: null
        }
    },
    components: {
        Calendar
    },
    data() {
        return {
            input_person: {
                number: null
            },
            loading: false,
            saving: false,
            services: [],
            users_has_services: [],
            selectedDate: new Date(),
            selectedTimeSlot: null,
            selectedTimeSlotData: null,
            availableTimeSlots: [],
            users: [],
            clients: [],
            customers: [],
            all_customers: [],
            form: {
                local: null,
                category: null,
                service: null,
                stylist: null,
                client: null,
                whatsapp: null,
                observations: null,
                user_id: null,
                item_id: null,
                category_id: null,
            },
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
            },
            isEditing: false,
            calendarKey: 0
        };
    },
    created() {
        this.getUsers();
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
            let monthsSpanish = {
                "January": "Enero",
                "February": "Febrero", 
                "March": "Marzo",
                "April": "Abril",
                "May": "Mayo",
                "June": "Junio",
                "July": "Julio",
                "August": "Agosto",
                "September": "Septiembre",
                "October": "Octubre",
                "November": "Noviembre",
                "December": "Diciembre"
            };

            let dateString = this.selectedDate
                ? moment(this.selectedDate).format("D [de] ") + monthsSpanish[moment(this.selectedDate).format("MMMM")]
                : "";
                
            return dateString;
        },
        estimatedEndTime() {
            return "45 min";
        },
        canSave() {
            return (
                this.form.user_id &&
                this.form.client &&
                this.selectedTimeSlotData &&
                this.selectedTimeSlotData.available
            );
        }
    },
    watch: {
        showDialog(val) {
            if (val && this.appointmentId) {
                this.loadAppointmentData(this.appointmentId);
            } else if (val && !this.appointmentId) {
                this.isEditing = false;
                this.resetForm();
            }
        }
    },
    methods: {
        setService() {
            if(!this.form.item_id) return;
            let item = this.services.find(service => service.id === this.form.item_id);
            if(item){
                let users_id = item.users_id;
                this.users_has_services = this.users.filter(user => users_id.includes(user.id));    
                if(this.users_has_services.length > 0){
                    this.form.user_id = this.users_has_services[0].id;
                    this.getStylistSchedule();
                }
            }
        },
        initService() {
            this.form.item_id = null;
            this.form.start_time = null;
            this.form.end_time = null;
            this.form.duration = null;
            this.form.notes = null;
            this.form.user_id = null;
            
        },
        async getServices() {
            this.initService();
            if(!this.form.category_id) return;  
            this.loading = true;
            const response = await this.$http.get(`/caja/estilista/get-services/${this.form.category_id}`);
            this.services = response.data;
            if(this.services.length > 0){
                this.form.item_id = this.services[0].id;
                let users_id = this.services[0].users_id;
                this.users_has_services = this.users.filter(user => users_id.includes(user.id));
                if(this.users_has_services.length > 0){
                    this.form.user_id = this.users_has_services[0].id;
                    this.getStylistSchedule();
                }
            }
            this.loading = false;
        },
    
        async keyupCustomer(e) {
            //buscar
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                this.input_person.number = this.$refs.select_person.$el.getElementsByTagName(
                    "input"
                )[0].value;

                if (!this.input_person.number) {
                    return;
                }

                let url = `/caja/search_customers?value=${this.input_person.number}`;
            
                const response = await this.$http(url);
                const { persons } = response.data;

                this.customers = persons.filter(n => n.number != "88888888");
            }, 1000);
        },
        async getCustomerById(id) {
            const response = await this.$http.get(`/caja/search_customer_by_id/${id}`);
            const { person } = response.data;
            this.customers = person;
            console.log(this.customers);
            this.form.client = id;
            this.changeCustomer();
        },
        changeCustomer() {
            // this.form.client = this.value;
        },
    
        async getStylistSchedule() {
            if (!this.form.user_id || !this.selectedDate) {
                this.availableTimeSlots = [];
                return;
            }
            
            this.loading = true;
            this.selectedTimeSlot = null;
            this.selectedTimeSlotData = null;
            
            try {
                const formattedDate = moment(this.selectedDate).format("YYYY-MM-DD");
                const response = await this.$http.get(
                    `/caja/estilista/time-slots/available/${this.form.user_id}/${formattedDate}`
                );
                
                if (response.data.success) {
                    // Procesamos los slots para añadir el estado "reservado"
                    this.availableTimeSlots = response.data.data.map(slot => {
                        // Simulamos algunos slots como reservados (esto debería venir del backend)
                        // En un caso real, el backend debería indicar si un slot está reservado o no disponible
                        const random = Math.random();
                        if (!slot.available && random > 0.5) {
                            return { ...slot, reserved: true };
                        }
                        return { ...slot, reserved: false };
                    });
                    
                    // Ordenamos los slots por hora de inicio
                    this.availableTimeSlots.sort((a, b) => {
                        return a.start.localeCompare(b.start);
                    });
                    
                    // Si no hay slots disponibles, mostramos un mensaje
                    if (this.availableTimeSlots.length === 0) {
                        this.$message.warning("No hay horarios disponibles para la fecha seleccionada");
                    }
                } else {
                    this.$message.error(response.data.message || "Error al cargar horarios");
                    this.availableTimeSlots = [];
                }
            } catch (error) {
                console.error("Error al obtener horario del estilista:", error);
                this.$message.error("Error al cargar horarios disponibles");
                this.availableTimeSlots = [];
            } finally {
                this.loading = false;
            }
        },
        async getUsers() {
            try {
                const response = await this.$http.get("/caja/estilista/workers");
                this.users = response.data;
            } catch (error) {
                console.error("Error al obtener estilistas:", error);
                this.$message.error("Error al cargar estilistas");
            }
        },
    
        selectTimeSlot(slot, index) {
            if (!slot.available) return;
            
            this.selectedTimeSlot = index;
            this.selectedTimeSlotData = slot;
        },
        close() {
            this.$emit("update:showDialog", false);
            this.isEditing = false;
            this.$emit('update:appointmentId', null);
        },
        open() {
            if (this.appointmentId) {
                this.loadAppointmentData(this.appointmentId);
        
            } else {
                this.resetForm();
            
            }
        },
        async saveAppointment() {
            // Validaciones
            if (!this.form.user_id) {
                this.$message.warning("Por favor seleccione un estilista");
                return;
            }
            if (!this.form.client && !this.selectedClient) {
                this.$message.warning("Por favor seleccione un cliente");
                return;
            }
            if (!this.selectedTimeSlot && this.selectedTimeSlot !== 0) {
                this.$message.warning("Por favor seleccione un horario");
                return;
            }
            
            this.saving = true;
            
            try {
                const formattedDate = moment(this.selectedDate).format("YYYY-MM-DD");
                
                const appointmentData = {
                    user_id: this.form.user_id,
                    client_id: this.form.client || this.selectedClient.id,
                    appointment_date: formattedDate,
                    start_time: this.selectedTimeSlotData.start,
                    end_time: this.selectedTimeSlotData.end,
                    duration: this.form.duration || 60, // Duración en minutos
                    notes: this.form.observations,
                    service_id: this.form.service || 1,
                    whatsapp: this.form.whatsapp
                };
                
                let response;
                
                if (this.isEditing) {
                    // Actualizar cita existente
                    response = await this.$http.put(`/caja/estilista/appointments/${this.appointmentId}`, appointmentData);
                } else {
                    // Crear nueva cita
                    response = await this.$http.post('/caja/estilista/appointments', appointmentData);
                }
                
                if (response.data.success) {
                    this.$message.success(this.isEditing ? "Cita actualizada con éxito" : "Cita registrada con éxito");
                    this.close();
                    
                    // Emitir evento para actualizar otras vistas
                    this.$emit("appointment-saved", response.data.data);
                } else {
                    this.$message.error(response.data.message || "Error al procesar cita");
                }
            } catch (error) {
                console.error('Error al guardar cita:', error);
                this.$message.error("Error al procesar cita");
            } finally {
                this.saving = false;
            }
        },
    
        // Método para manejar el cambio de cliente seleccionado
        onClientChange() {
            if (this.form.client) {
                this.getCustomerById(this.form.client);
            } else {
                this.form.whatsapp = '';
            }
        },
        async loadAppointmentData(appointmentId) {
            try {
                this.loading = true;
                const response = await this.$http.get(`/caja/estilista/appointments/${appointmentId}`);
                const appointment = response.data.data;
                
                if (appointment) {
                    this.isEditing = true;
                    
                    // Cargar los datos de la cita en el formulario
                    this.form.client = appointment.client_id;
                    this.form.user_id = appointment.user_id;
                    this.form.service = appointment.service_id;
                    
                    // Establecer la fecha y forzar la re-renderización del calendario
                    this.selectedDate = new Date(appointment.appointment_date);
                    this.calendarKey++; // Incrementar la key para forzar la re-renderización
                    
                    // Formatear las horas correctamente
                    this.form.start_time = this.formatTime(appointment.start_time);
                    this.form.end_time = this.formatTime(appointment.end_time);
                    this.form.duration = appointment.duration;
                    this.form.notes = appointment.notes;
                    
                    // Cargar datos del cliente
                    if (appointment.client) {
                        this.form.client = appointment.client.id;
                        await this.getCustomerById(appointment.client.id);
                        this.form.whatsapp = appointment.client.telephone;
                    }
                    
                    // Cargar horarios disponibles después de establecer la fecha
                    await this.getStylistSchedule();
                    
                    // Marcar el horario seleccionado
                    if(this.availableTimeSlots && this.availableTimeSlots.length > 0){
                        this.availableTimeSlots.forEach((slot, index) => {
                            if (slot.start === this.form.start_time && slot.end === this.form.end_time) {
                                this.selectedTimeSlot = index;
                                this.selectedTimeSlotData = slot;
                            }
                        });
                    }
                }
            } catch (error) {
                console.error('Error al cargar datos de la cita:', error);
                this.$message.error('Error al cargar datos de la cita');
            } finally {
                this.loading = false;
            }
        },
        formatTime(time) {
            if (!time) return '';
            // Convertir formato "2023-01-01T09:00:00.000000Z" a "09:00"
            const match = time.match(/T(\d{2}:\d{2})/);
            return match ? match[1] : time;
        },
        resetForm() {
            this.form = {
                local: 'micaela',
                category: 'cabello',
                service: '',
                stylist: '',
                client: '',
                start_time: '',
                end_time: '',
                duration: 60,
                notes: ''
            };
            this.selectedClient = null;
            this.selectedDate = new Date();
            console.log("reiniciando");
            this.selectedTimeSlot = null;
            this.timeSlots = [];
        },
        formatDate(date) {
            return moment(date).format("YYYY-MM-DD");
        }
    },
    
};
</script>

<style scoped>
/* Estilos para los slots de tiempo */
.time-slots-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 10px;
    margin-top: 10px;
}

.time-slot-card {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    color: white;
}

.time-slot-card.available {
    background-color: #22bb33;
    border-color: #c3e6cb;
}

.time-slot-card.reserved {
    background-color: #f0ad4e;
    border-color: #ffeeba;
}

.time-slot-card.unavailable {
    background-color: #bb2124;
    border-color: #f5c6cb;
    opacity: 0.7;
    cursor: not-allowed;
}

.time-slot-card.selected {
    border: 2px solid #007bff;
    background-color: #cce5ff;
}

.time-slot-card .time {
    font-weight: bold;
    margin-bottom: 5px;
}

.time-slot-card .status {
    font-size: 0.8rem;
}

/* Estilos para la leyenda */
.time-slots-legend {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 15px;
    padding: 10px;
    border-top: 1px solid #eee;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 5px;
}

.legend-color {
    width: 20px;
    height: 20px;
    border-radius: 4px;
    border: 1px solid #ddd;
}

.legend-color.available {
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.legend-color.reserved {
    background-color: #fff3cd;
    border-color: #ffeeba;
}

.legend-color.unavailable {
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.legend-color.selected {
    background-color: #cce5ff;
    border: 2px solid #007bff;
}

.legend-text {
    font-size: 0.9rem;
}

:deep(.el-dialog) {
    max-width: 1200px;
}
</style>
