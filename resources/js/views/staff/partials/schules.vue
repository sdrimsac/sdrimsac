<template>
    <el-dialog
        :visible.sync="dialogVisible"
        width="80%"
        :before-close="handleClose"
        :close-on-click-modal="false"
        top="3vh"
    >
        <div slot="title" class="">
            <i class="el-icon-time"></i>
            <span>Gestión de Horarios Laborales</span>
        </div>

        <!-- Formulario de Creación -->
        <div class="card mb-2">
            <div class="card-body">
            <div class="row">
                <div class="col-2">
                <el-input
                    v-model="form.name"
                    placeholder="Ej: Turno Mañana"
                    prefix-icon="el-icon-edit"
                    size="small"
                >
                </el-input>
                </div>
                <div class="col-2">
                <el-select
                    v-model="form.person_id"
                    placeholder="Seleccionar personal"
                    filterable
                    size="small"
                    style="width: 100%"
                >
                    <el-option
                    v-for="person in persons"
                    :key="person.id"
                    :label="person.name"
                    :value="person.id"
                    >
                    </el-option>
                </el-select>
                Personal Asignado
                </div>
                <div class="col-2">
                <el-time-picker
                    v-model="form.entrada"
                    placeholder="00:00"
                    format="HH:mm"
                    value-format="HH:mm"
                    size="small"
                    style="width: 100%"
                >
                </el-time-picker>
                Entrada
                </div>
                <div class="col-2">
                <el-time-picker
                    v-model="form.salida"
                    placeholder="00:00"
                    format="HH:mm"
                    value-format="HH:mm"
                    size="small"
                    style="width: 100%"
                >
                </el-time-picker>
                Salida
                </div>
                <div class="col-1">
                <el-input-number
                    v-model="form.tolerancia_min"
                    :min="0"
                    :max="60"
                    size="small"
                    controls-position="right"
                    style="width: 100%"
                >
                </el-input-number>
                Tolerancia
                </div>
                <div class="col-3">
                <div style="display: flex; justify-content: flex-center; align-items: center;">
                    <el-tooltip
                    content="Limpia datos a registrar"
                    placement="top"
                    >
                    <el-button
                        class="btn_limpiarsmall"
                        @click="resetForm"
                        icon="el-icon-brush"
                        size="small"
                        circle
                        style="margin-right: 10px;"
                    >
                    </el-button>
                    </el-tooltip>
                    <el-button
                    class="btn_guardarsmall"
                    type="primary"
                    @click="handleSubmit"
                    icon="el-icon-check"
                    size="small"
                    >
                    Registrar
                    </el-button>
                </div>
                </div>
            </div>
            </div>
        </div>

        <!-- Tabla de Horarios -->
        <div class="schedule-table-card">
            <div class="table-header">
                <h4><i class="el-icon-document"></i> Horarios Registrados</h4>
                <el-tag type="info">{{ records.length }} registros</el-tag>
            </div>

            <el-table
                :data="records"
                v-loading="loading"
                element-loading-text="Cargando horarios..."
                stripe
                border
                style="width: 100%"
                :empty-text="'No hay horarios registrados'"
                class="schedule-table"
            >
                <el-table-column
                    prop="name"
                    label="Nombre del Horario"
                    min-width="110"
                >
                    <template slot-scope="scope">
                        <i class="el-icon-price-tag"></i>
                        <strong>{{ scope.row.name }}</strong>
                    </template>
                </el-table-column>

                <el-table-column
                    prop="person_name"
                    label="Personal Asignado"
                    min-width="110"
                >
                    <template slot-scope="scope">
                        <i class="el-icon-user"></i>
                        {{ scope.row.person_name }}
                    </template>
                </el-table-column>

                <el-table-column
                    prop="entrada"
                    label="Hora Entrada"
                    width="120"
                    align="center"
                >
                    <template slot-scope="scope">
                        <el-tag type="success" size="small">
                            <i class="el-icon-sunrise"></i>
                            {{ scope.row.entrada }}
                        </el-tag>
                    </template>
                </el-table-column>

                <el-table-column
                    prop="salida"
                    label="Hora Salida"
                    width="120"
                    align="center"
                >
                    <template slot-scope="scope">
                        <el-tag type="warning" size="small">
                            <i class="el-icon-sunset"></i>
                            {{ scope.row.salida }}
                        </el-tag>
                    </template>
                </el-table-column>

                <el-table-column
                    prop="tolerancia_min"
                    label="Tolerancia"
                    width="110"
                    align="center"
                >
                    <template slot-scope="scope">
                        <el-tag type="info" size="small">
                            {{ scope.row.tolerancia_min }} min
                        </el-tag>
                    </template>
                </el-table-column>

                <el-table-column
                    label="Acciones"
                    width="160"
                    align="center"
                    fixed="right"
                >
                    <template slot-scope="scope">
                        <el-tooltip content="Editar" placement="top">
                            <el-button
                                type="primary"
                                icon="el-icon-edit"
                                size="mini"
                                circle
                                @click="editRecord(scope.row)"
                            >
                            </el-button>
                        </el-tooltip>
                        <el-tooltip content="Eliminar" placement="top">
                            <el-button
                                type="danger"
                                icon="el-icon-delete"
                                size="mini"
                                circle
                                @click="deleteRecord(scope.row)"
                            >
                            </el-button>
                        </el-tooltip>
                    </template>
                </el-table-column>
            </el-table>
        </div>

        <el-row type="flex" justify="end" style="margin-top: 20px;">
            <el-button
                class="btn_cancelarsmall"
                type="danger"
                @click="handleClose"
                size="medium"
            >
                <i class="el-icon-close"></i> Cerrar
            </el-button>
        </el-row>
    </el-dialog>
</template>
<script>
export default {
    name: "Schules",
    props: {
        clickCreatehorarios: {
            type: Boolean,
            default: false
        },
        staffList: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            dialogVisible: false,
            persons: [],
            records: [],
            loading: false,
            form: {
                name: "",
                person_id: "",
                entrada: "",
                salida: "",
                tolerancia_min: 5
            }
        };
    },
    watch: {
        clickCreatehorarios(val) {
            this.dialogVisible = val;
        },
        dialogVisible(val) {
            if (!val) {
                this.$emit("update:clickCreatehorarios", false);
            }
        }
    },
    async mounted() {
        console.log(
            "adelanto mounted, person_id prop:",
            this.person_id,
            "selectedPerson:",
            this.selectedPerson,
            "showDialog:",
            this.showDialog
        );
        // Fetch persons list from server and store locally as a fallback
        try {
            const response = await this.$http.get("/staff/tables");
            if (response && response.data && response.data.persons) {
                this.persons = response.data.persons;
            }
        } catch (error) {
            console.error("Failed to load persons:", error);
        }

        // Cargar los registros de horarios
        this.getData();
    },
    methods: {
        handleClose() {
            this.dialogVisible = false;
            this.resetForm();
        },
        resetForm() {
            this.form = {
                name: "",
                person_id: "",
                entrada: "",
                salida: "",
                tolerancia_min: 5
            };
        },

        getData() {
            this.loading = true;
            // Usamos el cliente HTTP global ($http) consistente con el resto del proyecto
            this.$http
                .get("schedules/records")
                .then(response => {
                    // Almacenar registros recibidos
                    this.records = response.data.data || response.data || [];

                    console.log("schedules records", this.records);
                })
                .catch(error => {
                    console.error("Error obteniendo schedules records", error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        async handleSubmit() {
            // Validación básica
            if (
                !this.form.name ||
                !this.form.person_id ||
                !this.form.entrada ||
                !this.form.salida
            ) {
                this.$message.error(
                    "Por favor complete todos los campos requeridos"
                );
                return;
            }

            try {
                const response = await this.$http.post("/schedules", this.form);

                if (response.data.success) {
                    this.$message.success("Horario creado exitosamente");
                    this.$emit("save", response.data);
                    // Recargar los datos después de guardar
                    this.getData();
                    this.handleClose();
                } else {
                    this.$message.error(
                        response.data.message || "Error al crear el horario"
                    );
                }
            } catch (error) {
                console.error("Error al guardar horario:", error);
                this.$message.error(
                    error.response?.data?.message ||
                        "Error al guardar el horario"
                );
            }
        },
        editRecord(record) {
            // Cargar datos del registro en el formulario para editar
            this.form = {
                id: record.id,
                name: record.name,
                person_id: record.person_id,
                entrada: record.entrada,
                salida: record.salida,
                tolerancia_min: record.tolerancia_min
            };
            this.$message.info("Editando horario: " + record.name);
        },
        deleteRecord(record) {
            this.$confirm(
                "¿Está seguro de eliminar este horario?",
                "Confirmar eliminación",
                {
                    confirmButtonText: "Eliminar",
                    cancelButtonText: "Cancelar",
                    type: "warning"
                }
            )
                .then(() => {
                    this.$http
                        .delete(`/schedules/${record.id}`)
                        .then(response => {
                            this.$message.success(
                                "Horario eliminado exitosamente"
                            );
                            this.getData();
                        })
                        .catch(error => {
                            console.error("Error al eliminar:", error);
                            this.$message.error("Error al eliminar el horario");
                        });
                })
                .catch(() => {
                    this.$message.info("Eliminación cancelada");
                });
        }
    }
};
</script>

<style scoped>
/* Dialog principal */
.schedule-dialog {
    border-radius: 8px;
}

.dialog-header {
    font-size: 20px;
    font-weight: 600;
    color: #303133;
    display: flex;
    align-items: center;
    gap: 10px;
}

.dialog-header i {
    font-size: 24px;
    color: #409eff;
}

/* Tarjeta del formulario */
.schedule-form-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
}

.form-header {
    margin-bottom: 20px;
}

.form-header h4 {
    color: #ffffff;
    font-size: 18px;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-header i {
    font-size: 20px;
}

.schedule-form :deep(.el-form-item__label) {
    color: #ffffff !important;
    font-weight: 500;
    padding-bottom: 8px;
}

.schedule-form :deep(.el-input__inner),
.schedule-form :deep(.el-input-number),
.schedule-form :deep(.el-select) {
    border-radius: 6px;
}

.form-hint {
    color: rgba(255, 255, 255, 0.8);
    font-size: 12px;
    display: block;
    margin-top: 5px;
}

.form-actions-col {
    display: flex;
    align-items: flex-end;
}

.form-actions {
    width: 100%;
}

.form-actions :deep(.el-form-item__content) {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

/* Tarjeta de la tabla */
.schedule-table-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.table-header h4 {
    color: #303133;
    font-size: 16px;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.table-header i {
    color: #409eff;
}

/* Estilos de la tabla */
.schedule-table :deep(.el-table__header) {
    background: #f5f7fa;
}

.schedule-table :deep(.el-table__header th) {
    background: #f5f7fa !important;
    color: #606266;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}

.schedule-table :deep(.el-table__row) {
    transition: all 0.3s;
}

.schedule-table :deep(.el-table__row:hover) {
    background: #f0f9ff !important;
}

.schedule-table :deep(.el-table td) {
    padding: 12px 0;
}

/* Footer del diálogo */
.dialog-footer {
    display: flex;
    justify-content: flex-end;
    padding-top: 20px;
    border-top: 1px solid #f0f0f0;
}

/* Responsive */
@media (max-width: 768px) {
    .schedule-form-card {
        padding: 15px;
    }

    .form-actions :deep(.el-form-item__content) {
        flex-direction: column;
        width: 100%;
    }

    .form-actions :deep(.el-button) {
        width: 100%;
    }

    .table-header {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }
}

/* Animaciones */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.schedule-form-card,
.schedule-table-card {
    animation: fadeIn 0.3s ease-out;
}
</style>
