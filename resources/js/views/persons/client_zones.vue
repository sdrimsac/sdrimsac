<!-- Listado de Zona de Clientes  -->
<template>
    <el-dialog @open="open" @close="close" :visible="showDialog" append-to-body title="Zonas de cliente" v-loading="loading" width="50%">
        <div class="d-flex justify-content-end mb-3" style="margin-top: 20px;">
            <el-button class="btn_titulos_modal" href="javascript:void(0)" @click.prevent="clickCreate()">
                <i class="icofont-plus-circle"></i>
                <span style="color: #000; font-size: 1.25rem; font-weight: bold;">Nuevo</span>
            </el-button>
        </div>
        <div class="row" v-if="zones.length != 0">
            <table class="table table-responsive table-striped">
                <thead>
                    <tr slot="heading" class="bg-primary">
                        <th class="text-white">#</th>
                        <th class="text-white">Descripción</th>
                        <th class="text-white text-center">Estado</th>
                        <th class="text-white text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(zone, idx) in zones" :key="idx">
                        <td>{{ idx + 1 }}</td>
                        <td>{{ zone.description }}</td>
                        <td class="text-center">
                            <button class="btn" :style="{ color: 'white', backgroundColor: zone.active ? 'green' : 'red', fontWeight: 'bold', width: '110px' }">
                                {{ zone.active ? 'Activo' : 'Suspendido' }}
                            </button>
                        </td>
                        <td class="text-end">
                            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="btn btn-primary dropdown-toggle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay="0" title="" data-bs-original-title="Item Count" aria-label="Item Count">Acciones</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a type="button" class="dropdown-item text-secondary" @click.prevent="clickEdit(zone)">
                                    <i class="fa fa-edit"></i> Editar
                                </a>
                                <a type="button" class="dropdown-item text-danger" @click.prevent="clickDelete(zone)">
                                    <i class="fa fa-trash"></i> Eliminar
                                </a>
                                <a type="button" :class="`text-secondary dropdown-item ${ zone.active ? 'btn-danger' : 'btn-success'}`" @click.prevent="clickActive(zone)">
                                    <i class="fas fa-toggle-off"></i>
                                    {{ zone.active ? "Desactivar" : "Activar" }}
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
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
        <el-dialog width="600px" :visible.sync="showCreateForm" append-to-body @close="showCreateForm = false" :title="form.id ? 'Editar Zona' : 'Crear Zona'">
            <div class="row m-2">
                <div class="col-12">
                    <label class="control-label">
                        <i class="fas fa-align-left"></i> Ingrese la Zona
                    </label>
                    <el-input v-model="form.description"></el-input>
                </div>
                <div style="margin-top:5px" class="d-flex justify-content-center">
                    <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
                        <!-- Botón Guardar -->
                        <el-button class="btn-save btn-save:hover" icon="fas fa-save fa-lg" type="primary" @click.prevent="submit" native-type="submit" :loading="loading_submit">
                            <i class="fas fa-plus-circle"></i>
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
