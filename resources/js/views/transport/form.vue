<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
        class="rounded-dialog"
        :close-on-click-modal="false"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.plate_number }"
                        >
                            <label class="control-label">
                                Número de Placa
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Este campo es obligatorio...!!!"
                                    placement="top"
                                >
                                    <i
                                        class="fas fa-info-circle text-danger"
                                    ></i>
                                </el-tooltip>
                            </label>
                            <div>
                                <el-input
                                    ref="number"
                                    v-model="form.plate_number"
                                    :maxlength="6"
                                    dusk="number"
                                    show-word-limit
                                >
                                    <template v-slot:append>
                                        <el-button
                                            :loading="loading_search"
                                            type="primary"
                                            icon="el-icon-search text-white"
                                            @click.prevent="searchPlaca"
                                        ></el-button>
                                    </template>
                                    <template v-slot:prefix>
                                        <i class="el-icon-edit-outline"></i>
                                    </template>
                                </el-input>
                            </div>
                            <small
                                class="form-control-feedback"
                                v-if="errors.plate_number"
                                v-text="errors.plate_number[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.model }"
                        >
                            <label class="control-label">Modelo</label>
                            <el-input v-model="form.model">
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i
                            ></el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.model"
                                v-text="errors.model[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.brand }"
                        >
                            <label class="control-label">Marca</label>
                            <el-input v-model="form.brand">
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i
                            ></el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.symbol"
                                v-text="errors.brand[0]"
                            ></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <el-button icon="fas fa-times fa-lg" @click.prevent="close()">
                    Cancelar</el-button
                >
                <el-button
                    icon="fas fa-save fa-lg"
                    type="primary"
                    native-type="submit"
                    :loading="loading_submit"
                >
                    Guardar</el-button
                >
            </div>
        </form>
    </el-dialog>
</template>
<style>
.el-dialog {
    border-radius: 10px;
    overflow: hidden;
}
</style>

<script>
export default {
    props: ["showDialog", "recordId"],
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            resource: "transport",
            errors: {},
            form: {},
            options: [],
            loading_search: false
        };
    },
    created() {
        this.initForm();
    },
    methods: {
        searchPlaca() {
            this.loading_search = true;
            this.$http(`/${this.resource}/vehicles/${this.form.plate_number}`)
                .then(response => {
                    const data = response.data.data;

                    this.form.serie = data.serie || "";
                    this.form.model = data.modelo || "";
                    this.form.brand = data.marca || "";
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.data;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {
                    this.loading_search = false;
                });
        },
        initForm() {
            this.errors = {};
            this.form = {
                plate_number: null,
                model: null,
                brand: null,
                active: true
            };
        },
        create() {
            this.titleDialog = this.recordId
                ? "Editar Vehiculo de Transporte"
                : "Nueva Vehiculo de transporte";
            if (this.recordId) {
                this.$http
                    .get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data;
                    });
            }
        },
        submit() {
            this.loading_submit = true;
            this.$http
                .post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                        this.close();
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    } else {
                        console.log(error);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        }
    }
};
</script>
