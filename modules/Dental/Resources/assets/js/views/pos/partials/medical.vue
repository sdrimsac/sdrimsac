<template>
    <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :visible.sync="showDialog"
        title="Citas Medicas"
        width="70%"
    >
        <div class="card-body">
            <div class="row">
                <!-- <div class="col-md-4">
                    <label>Fecha</label>
                    <el-input placeholder="fecha"></el-input>
                </div> -->
                <div class="col-md-4">
                    <label>Especialidad</label>
                    <el-select v-model="form.specialty_id">
                        <el-option
                             v-for="specialty in specialities" 
                             :key="specialty.id " 
                             :label="specialty.description" 
                             :value="specialty.id"
                        ></el-option> 
                    </el-select>
                    
                </div>
                <div class="col-md-4">
                    <label>Medico</label>
                    <el-select v-model="form.medic_id">
                        <el-option
                                v-for="medic in medics" 
                                :key="medic.id " 
                                :label="medic.name" 
                                :value="medic.id"
                        ></el-option>
                    </el-select>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Fecha</label>
                        <div class=" border-end">
                            <Calendar v-model="selectedDate" />
                        </div>
                        <!-- <el-input placeholder="fecha"></el-input> -->
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-12">
                                <div
                                    class="d-flex align-items-center gap-2 mb-2"
                                >
                                    <i class="fas fa-user"></i>
                                    <label class="mb-1 flex-shrink-0"
                                        >Cliente:
                                    </label>
                                    <el-button
                                        type="white"
                                        size="mini"
                                        style="border-radius: 10%;"
                                    >
                                        <i
                                            class="fas fa-plus fa-2x text-danger"
                                        ></i>
                                    </el-button>
                                    <el-button
                                        type="white"
                                        size="mini"
                                        style="border-radius: 10%;"
                                    >
                                        <i
                                            class="fas fa-edit fa-2x text-primary"
                                        ></i>
                                    </el-button>
                                    <el-input
                                        v-model="form.client"
                                        placeholder="Ingrese nombre completo del cliente"
                                        required
                                    ></el-input>
                                </div>
                            </div>
                            <div class="col-8">
                                <label class="form-label">Observaciones:</label>
                                <el-input
                                    type="textarea"
                                    v-model="form.observations"
                                ></el-input>
                            </div>
                            <div class="col-md-4 col-lg-4 col-12">
                                <div
                                    class="d-flex align-items-center gap-2 mb-2"
                                >
                                    <i class="fas fa-user"></i>
                                    <label class="mb-0">Nro de WhatsApp</label>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <el-button
                                        type="success"
                                        size="mini"
                                        icon="fab fa-whatsapp"
                                    ></el-button>
                                    <el-input
                                        v-model="form.whatsapp"
                                        maxlength="9"
                                        show-word-limit
                                    ></el-input>
                                </div>
                            </div>
                            <div class="col-8">
                                <br />
                                <label class="form-label"
                                    >Hora disponible :</label
                                >
                                <div
                                    style="border: 4px solid black; padding: 10px; border-radius: 10px;"
                                >
                                    <div class="row mb-2">
                                        <div class="col-md-3">
                                            <el-button
                                                type="success"
                                                size="default"
                                                icon="fas fa-clock"
                                                >8:00 AM</el-button
                                            >
                                        </div>
                                        <div class="col-md-3">
                                            <el-button
                                                type="success"
                                                size="default"
                                                icon="fas fa-clock"
                                                >9:00 AM</el-button
                                            >
                                        </div>
                                        <div class="col-md-3">
                                            <el-button
                                                type="success"
                                                size="default"
                                                icon="fas fa-clock"
                                                >10:00 AM</el-button
                                            >
                                        </div>
                                        <div class="col-md-3">
                                            <el-button
                                                type="success"
                                                size="default"
                                                icon="fas fa-clock"
                                                >11:00 AM</el-button
                                            >
                                        </div>
                                        <!-- Rest of the buttons remain the same -->
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-3">
                                            <el-button
                                                type="success"
                                                size="default"
                                                icon="fas fa-clock"
                                                >12:00 PM</el-button
                                            >
                                        </div>
                                        <div class="col-md-3">
                                            <el-button
                                                type="success"
                                                size="default"
                                                icon="fas fa-clock"
                                                >12:00 PM</el-button
                                            >
                                        </div>
                                        <div class="col-md-3">
                                            <el-button
                                                type="success"
                                                size="default"
                                                icon="fas fa-clock"
                                                >12:00 PM</el-button
                                            >
                                        </div>
                                        <div class="col-md-3">
                                            <el-button
                                                type="success"
                                                size="default"
                                                icon="fas fa-clock"
                                                >12:00 PM</el-button
                                            >
                                        </div>
                                        <!-- Rest of the buttons remain the same -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <el-button
                                                type="success"
                                                size="default"
                                                icon="fas fa-clock"
                                                >6:00 PM</el-button
                                            >
                                        </div>
                                        <div class="col-md-3">
                                            <el-button
                                                type="success"
                                                size="default"
                                                icon="fas fa-clock"
                                                >12:00 PM</el-button
                                            >
                                        </div>
                                        <div class="col-md-3">
                                            <el-button
                                                type="success"
                                                size="default"
                                                icon="fas fa-clock"
                                                >12:00 PM</el-button
                                            >
                                        </div>
                                        <div class="col-md-3">
                                            <el-button
                                                type="success"
                                                size="default"
                                                icon="fas fa-clock"
                                                >12:00 PM</el-button
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label></label>

                                <!-- <el-upload
                                    class="avatar-uploader"
                                    :data="{ type: 'items' }"
                                    :headers="headers"
                                    :action="`/${resource}/uploads`"
                                    :show-file-list="false"
                                    :on-success="onSuccess"
                                >
                                    <img
                                        v-if="form.image_url"
                                        :src="form.image_url"
                                        class="avatar"
                                    />
                                    <i
                                        v-else
                                        class="el-icon-plus avatar-uploader-icon"
                                    ></i>
                                </el-upload> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-end">
            <el-button
            type="danger"
            @click="close"
            round
            size="large"
            style="margin-top: 20px;"
            >
            Cancelar
            </el-button>
            <el-button
            type="success"
            @click="submit"
            Icons="fas fa-save"
            size="large"
            style="margin-top: 20px;"
            round
            >
            Guardar
            </el-button>
        </div>
        <br>
    </el-dialog>
</template>
<script>
import Calendar from "@components/calendar/CalendarMedic.vue";
export default {
    props: ["showDialog", "recordId"],
    components: {
        Calendar
    },
    data() {
        return {
            form: {
                local: null,
                category: null,
                service: null,
                stylist: null,
                client: null,
                whatsapp: null,
                observations: null,
                date: null,
                specialty_id: null,
                medic_id: null
            },
            selectedDate: null,
            specialities: [],
            medics: [],
        };
    },
    computed: {
        formattedSelectedDate() {
            return this.selectedDate
                ? moment(this.selectedDate).format("D [de] MMMM")
                : "";
        }
    },
    methods: {
        getTables()
        {
            axios.get('quotes/tables').then(response => {
                this.tables = response.data.data;
                this.medics = response.data.medics;
                this.specialities = response.data.specialities;
            });
        },
        submit() {
            this.$emit("update:showDialog", false);
        },
        open() {
            this.selectedDate = new Date();
            this.getTables();               
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
