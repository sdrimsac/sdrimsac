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
                    <el-input placeholder="especiaidad"></el-input>
                </div>
                <div class="col-md-4">
                    <label>Medico</label>
                    <el-input placeholder="medico"></el-input>
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
                                <!-- <el-input
                                v-model="form.client"
                                placeholder="Seleccione Cliente"
                            ></el-input> -->
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </el-dialog>
</template>
<script>
import Calendar from "@components/calendar/Calendar.vue";
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
                date: null
            },
            selectedDate: null
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
        open() {},
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
