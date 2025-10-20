<template>
    <el-dialog
        title="Configuración de Penalidades"
        :visible="showDialog"
        append-to-body
        @close="close"
        @open="open"
        class="rounded-dialog"
    >
        <div class="row m-2">
            <div class="col-md-6 col-lg-6 col-12">
                <label class="control-label w-100">Tipo de Habitación</label>
                <el-select
                    class="w-100"
                    v-model="form.table_type_id"
                    filterable
                    clearable
                    placeholder="Seleccione tipo de habitación"
                >
                    <el-option
                        v-for="option in tableTypes"
                        :key="option.id"
                        :value="option.id"
                        :label="option.name"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-md-6 col-lg-6 col-12">
                <label class="control-label">Monto por día {{ form.is_percentage ? '%' : '' }}</label>
                <el-input-number 
                    v-model="form.amount_per_day"
                    :precision="2"
                    :step="0.01"
                    :min="0"
                    class="w-100"
                ></el-input-number>
            </div>
        </div>
        <div class="row m-2">
            <div class="col-md-6 col-lg-6 col-12">
                <label class="control-label">Días de gracia</label>
                <el-input-number 
                    v-model="form.grace_period_days"
                    :min="0"
                    class="w-100"
                ></el-input-number>
            </div>
            <div class="col-md-6 col-lg-6 col-12">
                <label class="control-label">Es porcentaje</label>
                <el-switch
                    v-model="form.is_percentage"
                    class="d-block mt-2"
                ></el-switch>
            </div>
        </div>
        <div class="row m-2">
            <div class="col-12 text-right">
                <el-button
                    type="primary"
                    icon="el-icon-plus"
                    @click="add"
                >Agregar</el-button>
            </div>
        </div>

        <div class="row m-2" v-if="records.length > 0">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tipo de Habitación</th>
                            <th>Monto por día</th>
                            <th>Días de gracia</th>
                            <th>Es porcentaje</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="record in records" :key="record.id">
                            <td>{{ record.table_type ? record.table_type.name : '*' }}</td>
                            <td>{{ record.amount_per_day }}</td>
                            <td>{{ record.grace_period_days }}</td>
                            <td>
                                <el-tag :type="record.is_percentage ? 'success' : 'info'">
                                    {{ record.is_percentage ? 'Sí' : 'No' }}
                                </el-tag>
                            </td>
                            <td>
                                <el-switch
                                    v-model="record.active"
                                    @change="updateStatus(record)"
                                ></el-switch>
                            </td>
                            <td>
                                <el-button
                                    type="danger"
                                    icon="el-icon-delete"
                                    size="mini"
                                    @click="deleteRecord(record.id)"
                                ></el-button>
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
    props: ["showDialog"],
    data() {
        return {
            form: {
                table_type_id: null,
                amount_per_day: 0,
                grace_period_days: 0,
                is_percentage: true,
                active: true
            },
            records: [],
            tableTypes: [],
        };
    },
    methods: {
        async add() {
            try {
                console.log("Agregando configuración de penalidad: " + this.form);
                const response = await this.$http.post(
                    `/caja/rent/penalties-settings`,
                    this.form
                );

                if (response.status == 200) {
                    this.$message({
                        message: "Configuración agregada correctamente",
                        type: "success"
                    });
                    this.resetForm();
                    this.getRecords();
                }
            } catch (e) {
                this.$message({
                    message: "Ocurrió un error al guardar",
                    type: "error"
                });
            }
        },
        resetForm() {
            this.form = {
                table_type_id: null,
                amount_per_day: 0,
                grace_period_days: 0,
                is_percentage: true,
                active: true
            };
        },
        async updateStatus(record) {
            console.log("Actualizando estado de penalidad: " + record.id);
            try {
                await this.$http.post(`/caja/rent/penalties-settings/${record.id}/toggle`);
                this.$message({
                    message: "Estado actualizado correctamente",
                    type: "success"

                });
            } catch (e) {
                record.active = !record.active;
                this.$message({
                    message: "Ocurrió un error al actualizar",
                    type: "error"
                });
            }
        },
        async deleteRecord(id) {
            try {
                await this.$confirm(
                    "¿Está seguro que desea eliminar esta configuración?",
                    "Advertencia",
                    {
                        confirmButtonText: "Sí",
                        cancelButtonText: "No",
                        type: "warning"
                    }
                );
                console.log("Eliminando configuración de penalidad: " + id);
                const response = await this.$http.delete(
                    `/caja/rent/penalties-settings/${id}`
                );
                if (response.status == 200) {
                    this.$message({
                        message: "Configuración eliminada correctamente",
                        type: "success"
                    });
                    this.getRecords();
                }
            } catch (e) {
                if (e.toString() !== 'Error: Operation canceled by user') {
                    this.$message({
                        message: "Ocurrió un error al eliminar",
                        type: "error"
                    });
                }
            }
        },
        async getRecords() {
            console.log("Obteniendo configuraciones de penalidades");
            const response = await this.$http.get(`/caja/rent/penalties-settings`);
            if (response.status == 200) {
                this.records = response.data.penalties;
            }
        },
        async getTableTypes() {
            console.log("Obteniendo tipos de habitación");
            const response = await this.$http.get(`/caja/tables/table-types`);
            if (response.status == 200) {
                this.tableTypes = response.data.table_types;
            }
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        open() {
            this.getRecords();
            this.getTableTypes();
        }
    }
};
</script>

<style>
.el-dialog {
    border-radius: 10px;
    overflow: hidden;
}
</style>
