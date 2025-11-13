<template>
    <el-dialog :visible.sync="showDialog" :before-close="handleBeforeClose" :close-on-click-modal="false"
        :close-on-press-escape="false" :width="dialogWidth" title="Adelanto de sueldo">
        <el-form ref="adelantoForm" :model="form" :rules="rules" label-position="top" class="adelanto-form">
            <el-row :gutter="16">
                <el-col :span="24">
                    <el-form-item label="Seleccione personal" prop="selectedPerson">
                        <el-select v-model="form.selectedPerson" placeholder="Buscar personal">
                            <el-option v-for="person in staffList" :key="person.id" :label="person.name"
                                :value="person.id" />
                        </el-select>
                    </el-form-item>
                </el-col>

                <el-col :span="24">
                    <el-form-item label="Monto de adelanto" prop="amount">
                        <el-input-number v-model="form.amount" controls-position="right" :min="1" :max="999999"
                            :step="1" style="width:100%" />
                    </el-form-item>
                </el-col>

                <el-col :span="24">
                    <el-form-item label="Método de pago" prop="method">
                        <el-select v-model="form.method" placeholder="Seleccione un método">
                            <el-option label="Efectivo" value="Efectivo" />
                            <el-option label="YAPE" value="YAPE" />
                            <el-option label="PLIN" value="PLIN" />
                        </el-select>
                    </el-form-item>
                </el-col>

                <el-col :span="24">
                    <el-form-item label="Observación" prop="observacion">
                        <el-input type="textarea" rows="3" placeholder="Ingrese una observación"
                            v-model="form.observacion" />
                    </el-form-item>
                </el-col>

                <el-col :span="24" class="actions">
                    <el-button @click="cancel" :disabled="loading">Cancelar</el-button>
                    <el-button type="primary" @click="submitAdelanto" :loading="loading" :disabled="loading"
                        class="ml-2">Enviar</el-button>
                </el-col>
            </el-row>
        </el-form>
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
            loading: false,
            persons: [],
            dialogWidth: '520px',
            form: {
                selectedPerson: this.person_id || null,
                amount: null,
                method: null,
                observacion: ''
            },
            rules: {
                selectedPerson: [{ required: true, message: 'Seleccione personal', trigger: 'change' }],
                amount: [{ required: true, type: 'number', min: 1, message: 'Ingrese un monto válido', trigger: 'change' }],
                method: [{ required: true, message: 'Seleccione un método de pago', trigger: 'change' }]
            }
        };
    },
    async mounted() {
        console.log('adelanto mounted, person_id prop:', this.person_id, 'selectedPerson:', this.selectedPerson, 'showDialog:', this.showDialog);
        // Fetch persons list from server and store locally as a fallback
        try {
            const response = await this.$http.get('/staff/tables');
            if (response && response.data && response.data.persons) {
                this.persons = response.data.persons;
            }
        } catch (error) {
            console.error('Failed to load persons:', error);
        }
    },
    computed: {
        // safely read staff list from the store; if the module/state isn't registered, return empty array
        staffList() {
            return (this.$store && this.$store.state && this.$store.state.staff && this.$store.state.staff.staff)
                ? this.$store.state.staff.staff
                : (this.persons || []);
        }
    },
    watch: {
        person_id(newVal) {
            // sync when parent updates
            this.form.selectedPerson = newVal;
        },
        // sync local model with parent via v-model pattern
        'form.selectedPerson'(newVal) {
            this.$emit('update:person_id', newVal);
        }
    },
    methods: {
        // NOTE: mounted() logic moved to the component-level mounted() hook above.
        handleBeforeClose(done) {
            // emit update for .sync binding so parent updates its boolean
            this.$emit('update:showDialog', false);
            if (typeof done === 'function') done();
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
                    date_time_advances: new Date().toISOString().slice(0, 19).replace('T', ' ')
                };
                this.$http.post(`/staff/adelanto`, payload).then(response => {
                    this.$emit('success', response.data);
                    this.$message({ message: 'Adelanto registrado con éxito', type: 'success' });
                    this.resetForm();
                    this.$emit('update:showDialog', false);
                }).catch(error => {
                    console.error('adelanto error', error);
                    this.$message({ message: 'Error al registrar el adelanto', type: 'error' });
                }).finally(() => {
                    this.loading = false;
                });
            });
        },
        cancel() {
            this.$emit('update:showDialog', false);
        },
        resetForm() {
            this.$nextTick(() => {
                if (this.$refs.adelantoForm) this.$refs.adelantoForm.resetFields();
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