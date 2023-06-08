<template>
    <div class="card">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Otras Operaciones</h6>
        </div>
        <div class="card-body">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6 m-1">
                        <el-button
                            type="primary"
                            native-type="submit"
                            @click="deleteDocuments"
                            :loading="loading_submit"
                            >Eliminar documentos de prueba</el-button
                        >
                    </div>
                    <div class="col-md-5 m-1">
                        <el-button
                            type="primary"
                            @click="deleteItems"
                            native-type="submit"
                            :loading="loading_submitI"
                            >Eliminar los productos</el-button
                        >
                    </div>
                </div>
            </div>
            <br />
            <div class="col-md-12">
                <el-button
                    type="primary"
                    native-type="submit"
                    @click="sendItemWarehouse"
                    >Mandar stock a almacen 1</el-button
                >
            </div>
            <!--<form autocomplete="off" @submit.prevent="consultVoided">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">
                            <el-button type="primary" native-type="submit" :loading="loading_submit_voided">Consultar documentos anulados</el-button>
                        </div>
                    </div>
                </div>
            </form> -->
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading_submit: false,
            loading_submitI: false ,
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
                "Mensaje de Advertencia",
                {
                    confirmButtonText: "Continuar",
                    cancelButtonText: "Cancelar",
                    type: "warning"
                }
            );
            if (confirm) {
                const response = await this.$http.get(
                    "/restaurant/pos/update_items_warehouse"
                );
                if (response.status == 200) {
                    const { updates, createds } = response.data;
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
