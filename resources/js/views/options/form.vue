<template>
<div>
    <div class="card">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Configuraciones creditos</h6>
        </div>
        <div class="card-body pt-0 pb-5">
            <form autocomplete="off">
                <div class="form-body">
                    <el-tabs type="border-card">
                        <div class="row">
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    <el-button type="primary" native-type="submit" @click="deleteDocuments" :loading="loading_submit">Eliminar documentos
                                        <span>de prueba</span>
                                    </el-button>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    <el-button type="primary" @click="deleteItems" native-type="submit" :loading="loading_submitI">Eliminar los productos</el-button>
                                </div>
                            </div>
                        </div>
                    </el-tabs>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            loading_submit: false,
            loading_submitI: false,
            resource: "options",
            errors: {},
            form: {},
            loading_submit_voided: false
        };
    },
    methods: {
        async sendItemWarehouse() {
            let confirm = await this.$confirm(
                `El stock de los productos en el almacén que no coincidan con el stock general del producto
                        se igualarán o se crearán en el almacén si no existiesen `,
                "Mensaje de Advertencia", {
                    confirmButtonText: "Continuar",
                    cancelButtonText: "Cancelar",
                    type: "warning"
                }
            );
            if (confirm) {
                const response = await this.$http.get(
                    "/caja/pos/update_items_warehouse"
                );
                if (response.status == 200) {
                    const {
                        updates,
                        createds
                    } = response.data;
                    this.$toast.success(`
                    Actualizados:${updates} Creados:${createds}
                    `);
                }
            }
        },
        initForm() {
            this.errors = {};
            this.form = {};
        },
        deleteItems() {
            this.loading_submitI = true;
            this.$http
                .post(`/${this.resource}/delete_items`)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {

                        this.$toast.error(`${error.response.data.message}`);
                    }
                })
                .then(() => {
                    this.loading_submitI = false;
                });
        },
        deleteDocuments() {
            this.loading_submit = true;
            this.$http
                .post(`/${this.resource}/delete_documents`)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        this.$toast.error(`${error.response.data.message}`);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        consultVoided() {
            this.loading_submit_voided = true;
            this.$http
                .get(`/voided/status_masive`)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                    } else {
                        this.$toast.error("Sucedio un error");
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        this.$toast.error(`${error.response.data.message}`);
                    }
                })
                .then(() => {
                    this.loading_submit_voided = false;
                });
        }
    }
};
</script>
