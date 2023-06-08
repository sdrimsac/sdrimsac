<template>
    <el-dialog
        @open="open"
        @close="close"
        :visible="showDialog"
        append-to-body
        title="Zonas de cliente"
        v-loading="loading"
    >
        <div style="margin-top:5px" class=" d-flex justify-content-end">
            <button
                type="button"
                class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                @click.prevent="clickCreate()"
            >
                <i class="icofont-plus-circle"></i>
                <span>Nuevo</span>
            </button>
        </div>
        <div class="row" v-if="zones.length != 0">
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(zone, idx) in zones" :key="idx">
                        <td>{{ idx + 1 }}</td>
                        <td>{{ zone.description }}</td>
                        <td>
                            <button
                                type="button"
                                :class="
                                    `btn ${
                                        zone.active
                                            ? 'btn-danger'
                                            : 'btn-success'
                                    }`
                                "
                                @click.prevent="clickActive(zone)"
                            >
                                {{ zone.active ? "Desactivar" : "Activar" }}
                            </button>
                            <button
                                type="button"
                                class="btn btn-primary "
                                @click.prevent="clickEdit(zone)"
                            >
                                Editar
                            </button>
                            <button
                                type="button"
                                class="btn btn-danger"
                                @click.prevent="clickDelete(zone)"
                            >
                                Eliminar
                            </button>
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
        <el-dialog
            width="550px"
            :visible.sync="showCreateForm"
            append-to-body
            @close="showCreateForm = false"
            :title="form.id ? 'Editar Zona' : 'Crear Zona'"
        >
            <div class="row m-2">
                <div class="col-12">
                    <label>Descripción</label>
                    <el-input v-model="form.description"></el-input>
                </div>
                <div
                    style="margin-top:5px"
                    class="d-flex justify-content-center "
                >
                    <button
                        type="button"
                        class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                        @click.prevent="submit"
                    >
                        <span> {{ form.id ? "Actualizar" : "Crear" }} </span>
                    </button>
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
            showCreateForm: false
        };
    },
    methods: {
        async clickActive(zone) {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/${this.resource}/active/${zone.id}`
                );
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
                //create a $confirm with async/await
                const confirm = await this.$confirm(
                    "¿Está seguro de eliminar este registro?",
                    "Confirmación",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );
                if (confirm == "confirm") {
                    this.loading = true;
                    const response = await this.$http.delete(
                        `/${this.resource}/delete/${zone.id}`
                    );
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
                const response = await this.$http.post(
                    `/${this.resource}`,
                    this.form
                );
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
                const response = await this.$http(
                    `/${this.resource}/records?${this.getQueryParameters()}`
                );
                if (response.status == 200) {
                    this.zones = response.data;
                    // this.pagination = response.data;
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
