<!-- Listado de Zona de Clientes  -->
<template>
    <el-dialog @open="open" @close="close" :visible="showDialog" append-to-body title="Zonas de cliente"
        v-loading="loading" width="40%" :close-on-click-modal="false" :show-close="false">
        <template #title>
            <div class="d-flex justify-content-between align-items-center">
                <span>Zonas (Ubicación)</span>

            </div>
            <div class="d-flex justify-content-end">
                <el-button class="btn_buscarsmall me-2" href="javascript:void(0)" @click.prevent="clickCreate()">
                    <i class="fas fa-plus"></i>
                    <span style="color: #fff; font-size: 1.25rem; font-weight: bold;">Nuevo</span>
                </el-button>
            </div>


        </template>
        <br />
        <div class="row" v-if="zones.length != 0">
            <div>
                <table class="table table-responsive table-striped">
                    <thead>
                        <tr slot="heading" style="background-color: #1e5a85;">
                            <th class="text-white" style="width: 50px;">#</th>
                            <th class="text-white" style="width: 60%;">Descripción</th>
                            <th class="text-white text-center" style="width: 120px;">Estado</th>
                            <th class="text-white text-center" style="width: 140px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(zone, idx) in zones" :key="idx">
                            <td>{{ idx + 1 }}</td>
                            <td>{{ zone.description }}</td>
                            <td class="text-center">
                                <span
                                    :style="{ color: zone.active ? 'green' : 'red', fontWeight: 'bold', textTransform: 'uppercase' }">
                                    {{ zone.active ? 'ACTIVO' : 'SUSPENDIDO' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <el-button type="primary" size="mini" icon="el-icon-edit"
                                    @click.prevent="clickEdit(zone)" class="btn_guardarsmall">
                                    Editar
                                </el-button>
                                <!-- <button 
                                class="btn p-0" 
                                type="button" 
                                data-bs-toggle="dropdown" 
                                aria-haspopup="true" 
                                aria-expanded="false"
                            >
                                <span 
                                    class="btn btn-primary dropdown-toggle" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    data-bs-delay="0" 
                                    title="" 
                                    data-bs-original-title="Item Count" 
                                    aria-label="Item Count"
                                >
                                    Acciones
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a 
                                    type="button" 
                                    class="dropdown-item text-secondary" 
                                    @click.prevent="clickEdit(zone)"
                                >
                                    <i class="fa fa-edit"></i> Editar
                                </a>
                                <a 
                                    type="button" 
                                    class="dropdown-item text-danger" 
                                    @click.prevent="clickDelete(zone)"
                                >
                                    <i class="fa fa-trash"></i> Eliminar
                                </a>
                            </div> -->
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>

        <div v-else>
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info">
                        No hay registros
                    </div>
                </div>
            </div>
        </div>
        <div slot="footer" class="dialog-footer">
            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                <el-button class="btn_cancelarsmall" @click="close">
                    <i class="fas fa-times fa-lg" style="margin-right: 4px;"></i>
                    Cancelar
                </el-button>
               
            </div>
        </div>
        <!-- <template #footer>
            <div class="d-flex justify-content-end">
                <el-button @click="close" class=".btn_cancelarsmall" icon="fas fa-times fa-lg">
                    Cerrar
                </el-button>
            </div>
        </template> -->

        <el-dialog width="600px" :visible.sync="showCreateForm" append-to-body @close="showCreateForm = false"
            :title="form.id ? 'Editar Zona (Ubicación)' : 'Crear Zona (Ubicación)'">
            <div class="row m-2">
                <div class="col-12">
                    <label class="control-label">
                        <i class="fas fa-align-left"></i> Ingrese la Zona
                    </label>
                    <el-input v-model="form.description"></el-input>
                </div>
                <div style="margin-top:5px" class="d-flex justify-content-center">
                    <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
                        <el-button class="btn_buscarsmall" icon="fas fa-save fa-lg" type="primary"
                            @click.prevent="submit" native-type="submit" :loading="loading_submit">
                            <span> {{ form.id ? "Actualizar" : "Crear" }} </span>
                        </el-button>
                    </div>
                </div>
            </div>
        </el-dialog>
    </el-dialog>
</template>

<script>
import queryString from "query-string";

export default {
    props: ["showDialog"],
    data() {
        return {
            form: {},
            loading: false,
            zones: [],
            resource: "client_zones",
            search: {
                column: null,
                value: null
            },
            pagination: {
                current_page: 1,
                per_page: 20,
                total: 0
            },
            showCreateForm: false,
            loading_submit: false // Add this line
        };
    },
    methods: {
        async clickActive(zone) {
            try {
                this.loading = true;
                const response = await this.$http(`/${this.resource}/active/${zone.id}`);
                this.$message.success(response.data.message);
                this.showCreateForm = false;
                await this.getRecords();
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        clickEdit(zone) {
            this.form = zone;
            this.showCreateForm = true;
        },
        async clickDelete(zone) {
            try {
                const confirm = await this.$confirm("¿Está seguro de eliminar este registro?", "Confirmación", {
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar",
                    type: "warning"
                });
                if (confirm == "confirm") {
                    this.loading = true;
                    const response = await this.$http.delete(`/${this.resource}/delete/${zone.id}`);
                    this.$message.success(response.data.message);
                    this.showCreateForm = false;
                    await this.getRecords();
                }
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        async submit() {
            try {
                this.loading = true;
                const response = await this.$http.post(`/${this.resource}`, this.form);
                this.$message.success(response.data.message);
                this.showCreateForm = false;
                await this.getRecords();
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        clickCreate() {
            this.form = {};
            this.showCreateForm = true;
        },
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                ...this.search
            });
        },
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http(`/${this.resource}/records?${this.getQueryParameters()}`);
                if (response.status == 200) {
                    this.zones = response.data;
                }
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        async open() {
            await this.getRecords();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
