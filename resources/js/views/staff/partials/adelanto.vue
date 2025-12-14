<template>
    <el-dialog :visible.sync="showDialog" :before-close="handleBeforeClose" :close-on-click-modal="false"
        :close-on-press-escape="false" :width="dialogWidth" title="Adelanto de sueldo">
        <div class="card">
            <div class="card-body">
                <el-form ref="adelantoForm" :model="form" :rules="rules" label-position="top" class="adelanto-form">
                    <div class="">
                        <div class="col-12">
                            Personal/Empleado
                            <el-select v-model="form.selectedPerson" placeholder="Buscar personal" clearable filterable>
                                <el-option v-for="person in staffList" :key="person.id" :label="person.name"
                                    :value="person.id" />
                            </el-select>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                Monto a adelantar
                                <el-input-number v-model="form.amount" controls-position="right" :min="1" :max="999999"
                                    :step="1" style="width:100%" />

                            </div>
                            <div class="col-6">
                                Metodo de pago
                                <el-select v-model="form.method" placeholder="Seleccione un método">
                                    <el-option label="Efectivo" value="Efectivo" />
                                    <el-option label="YAPE" value="YAPE" />
                                    <el-option label="PLIN" value="PLIN" />
                                </el-select>

                            </div>
                        </div>
                        Motivo / Observación
                        <el-input type="textarea" rows="3" placeholder="Ingrese una observación"
                            v-model="form.observacion" />


                        <div class="row">
                            <div class="actions" style="width:100%;">
                                <el-button @click="cancel" :disabled="loading" class="btn_cancelarsmall">
                                    Cancelar
                                </el-button>
                                <el-button type="primary" @click="submitAdelanto" :loading="loading" :disabled="loading"
                                    class="btn_guardarsmall ml-2">
                                    Enviar
                                </el-button>
                            </div>
                        </div>
                    </div>
                </el-form>
            </div>
        </div>
        <div>
            <br>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Personal</label>
                            <el-select v-model="filterPerson" placeholder="Buscar personal" clearable filterable
                                @change="getDataRecords">
                                <el-option v-for="person in staffList" :key="person.id" :label="person.name"
                                    :value="person.id" />
                            </el-select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Fecha</label>
                            <el-date-picker v-model="date" type="date" placeholder="Seleccione fecha"
                                style="width: 100%;" @change="getDataRecords" />
                        </div>
                    </div>
                </div>
                <br>
                <table class="table table-striped">
                    <thead>
                        <tr class="bg-primary">
                            <th class="text-white">Personal</th>
                            <th class="text-white">Monto</th>
                            <th class="text-white">Método</th>
                            <th class="text-white">Fecha y Hora</th>
                            <th class="text-white">Observación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="adelanto in adelantos" :key="adelanto.id" class="">
                            <td>{{ adelanto.person_name }}</td>
                            <td>{{ adelanto.amount }}</td>
                            <td>{{ adelanto.method }}</td>
                            <td>{{ adelanto.date_time_advance }}</td>
                            <td>{{ adelanto.observacion }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </el-dialog>
</template>
<script>
export default {
    props: {
        showDialog: { type: Boolean, default: false },
        person_id: { type: [Number, String], default: null }
    },
    data() {
        return {
            showFormSelect: true,
            loading: false,
            persons: [],
            adelantos: [],
            dialogWidth: "800px",
            form: {
                selectedPerson: this.person_id || null,
                amount: null,
                method: null,
                observacion: ""
            },
            filterPerson: null,
            date: null,
            rules: {
                selectedPerson: [
                    {
                        required: true,
                        message: "Seleccione personal",
                        trigger: "change"
                    }
                ],
                amount: [
                    {
                        required: true,
                        type: "number",
                        min: 1,
                        message: "Ingrese un monto válido",
                        trigger: "change"
                    }
                ],
                method: [
                    {
                        required: true,
                        message: "Seleccione un método de pago",
                        trigger: "change"
                    }
                ]
            }
        };
    },
    async mounted() {
        this.getDataRecords();
        // Fetch persons list from server and store locally as a fallback
        try {
            const response = await this.$http.get("/staff/tables");
            if (response && response.data && response.data.persons) {
                this.persons = response.data.persons;
            }
        } catch (error) {
            console.error("Failed to load persons:", error);
        }

        /* try {
            const response = await this.$http.get("adelantos/records");
            if (response && response.data) {

                this.adelantos = response.data.data;
                console.log("adelantos fsdfsdgdgdgdfdfgdf", this.adelantos);
            }
        } catch (error) {
            console.error("Failed to load persons:", error);
        } */
    },
    computed: {
        // safely read staff list from the store; if the module/state isn't registered, return empty array
        staffList() {
            return this.$store &&
                this.$store.state &&
                this.$store.state.staff &&
                this.$store.state.staff.staff
                ? this.$store.state.staff.staff
                : this.persons || [];
        }
    },
    watch: {
        person_id(newVal) {
            // sync when parent updates
            this.form.selectedPerson = newVal;
        },
        // sync local model with parent via v-model pattern
        "form.selectedPerson"(newVal) {
            this.$emit("update:person_id", newVal);
        }
    },
    methods: {

        async getDataRecords() {
            try {
                const params = {};
                if (this.filterPerson) params.person_id = this.filterPerson;
                if (this.date) {
                    let dateValue = this.date;
                    // Si es un objeto Date, formatear a YYYY-MM-DD
                    if (Object.prototype.toString.call(dateValue) === '[object Date]') {
                        dateValue = dateValue.toISOString().slice(0, 10);
                    }
                    // Si es string tipo ISO, tomar solo la parte de la fecha
                    if (typeof dateValue === 'string' && dateValue.length >= 10) {
                        dateValue = dateValue.slice(0, 10);
                    }
                    params.date = dateValue;
                }
                const response = await this.$http.get("adelantos/records", { params });
                if (response && response.data) {
                    this.adelantos = response.data.data;
                }
            } catch (error) {
                console.error("Failed to load adelantos:", error);
            }
        },

        // NOTE: mounted() logic moved to the component-level mounted() hook above.
        handleBeforeClose(done) {
            // emit update for .sync binding so parent updates its boolean
            this.$emit("update:showDialog", false);
            if (typeof done === "function") done();
        },
        submitAdelanto() {
            this.$refs.adelantoForm.validate(valid => {
                if (!valid) return;
                this.loading = true;
                const payload = {
                    person_id: this.form.selectedPerson,
                    amount: this.form.amount,
                    method: this.form.method,
                    observacion: this.form.observacion,
                    date_time_advances: new Date()
                        .toISOString()
                        .slice(0, 19)
                        .replace("T", " ")
                };
                this.$http
                    .post(`/staff/adelanto`, payload)
                    .then(response => {
                        this.$emit("success", response.data);
                        this.$message({
                            message: "Adelanto registrado con éxito",
                            type: "success"
                        });
                        this.resetForm();
                        this.$emit("update:showDialog", false);
                    })
                    .catch(error => {
                        console.error("adelanto error", error);
                        this.$message({
                            message: "Error al registrar el adelanto",
                            type: "error"
                        });
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            });
        },
        cancel() {
            this.$emit("update:showDialog", false);
        },
        resetForm() {
            this.$nextTick(() => {
                if (this.$refs.adelantoForm)
                    this.$refs.adelantoForm.resetFields();
                // keep selected person in sync if parent provided one
                this.form.selectedPerson = this.person_id || null;
            });
        }
    }
};
</script>

<style scoped>
.adelanto-form .el-form-item {
    margin-bottom: 12px;
}

.actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    margin-top: 8px;
}

.ml-2 {
    margin-left: 8px;
}

@media (max-width: 520px) {
    .el-dialog {
        width: 96% !important;
    }
}
</style>
