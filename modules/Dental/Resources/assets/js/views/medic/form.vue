<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
        :close-on-click-modal="false"
        width="50%"
    >
        <br />
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.number }"
                        >
                            <label for="dni">
                                <i class="far fa-id-card"></i> DNI
                            </label>
                            <el-input
                                v-model="form.number"
                                placeholder="Documento"
                                :disabled="loading_submit || loading_search"
                                minlength="8"
                                maxlength="8"
                                show-word-limit
                            >
                                <el-button
                                    @click="searchDocument"
                                    slot="prepend"
                                    icon="el-icon-search"
                                    :loading="loading_search"
                                ></el-button>
                            </el-input>
                            <small
                                class="form-control-feedback text-danger"
                                v-if="errors.number"
                            >
                                Ingreso Obligatorio
                            </small>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.name }"
                        >
                            <label class="control-label">
                                <i class="fas fa-align-left"></i> NOMBRES
                                APELLIDOS
                            </label>
                            <el-input v-model="form.name">
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.name"
                                v-text="errors.name[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.name }"
                        >
                            <label class="control-label">
                                <i class="fas fa-align-left"></i> ESPECIALIDAD
                            </label>
                            <el-select v-model="form.specialty_id" filterable>
                                <el-option
                                    v-for="specialty in specialties"
                                    :key="specialty.id"
                                    :label="specialty.description"
                                    :value="specialty.id"
                                >
                                </el-option>
                            </el-select>
                            <small
                                class="form-control-feedback"
                                v-if="errors.name"
                                v-text="errors.name[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.country_id }"
                        >
                            <label class="control-label">
                                <i class="fas fa-align-left"></i> PAIS
                            </label>
                            <el-select v-model="form.country_id" filterable>
                                <el-option
                                    v-for="country in countries"
                                    :key="country.id"
                                    :label="country.description"
                                    :value="country.id"
                                >
                                </el-option>
                            </el-select>
                            <small
                                class="form-control-feedback"
                                v-if="errors.country_id"
                                v-text="errors.country_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.department_id }"
                        >
                            <label class="control-label">
                                <i class="fas fa-align-left"></i> DEPARTAMENTO
                            </label>
                            <el-select v-model="form.department_id" filterable>
                                <el-option
                                    v-for="department in departments"
                                    :key="department.id"
                                    :label="department.description"
                                    :value="department.id"
                                >
                                </el-option>
                            </el-select>
                            <small
                                class="form-control-feedback"
                                v-if="errors.department_id"
                                v-text="errors.department_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.province_id }"
                        >
                            <label class="control-label">
                                <i class="fas fa-align-left"></i> PROVINCIA
                            </label>
                            <el-select v-model="form.province_id" filterable>
                                <el-option
                                    v-for="province in provinces"
                                    :key="province.id"
                                    :label="province.description"
                                    :value="province.id"
                                >
                                </el-option>
                            </el-select>
                            <small
                                class="form-control-feedback"
                                v-if="errors.province_id"
                                v-text="errors.province_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-4 col-lg-4 col-xl-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.district_id }"
                        >
                            <label class="control-label">
                                <i class="fas fa-map-marker-alt"></i> Distrito
                            </label>
                            <el-select
                                v-model="form.district_id"
                                filterable
                                popper-class="el-select-districts"
                                dusk="district_id"
                            >
                                <el-option
                                    v-for="option in districts"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="text-danger"
                                v-if="errors.district_id"
                                v-text="errors.district_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.telephone }"
                        >
                            <label class="control-label">
                                <i class="fas fa-align-left"></i> TELEFONO
                            </label>
                            <el-input
                                v-model="form.telephone"
                                maxlength="9"
                                show-limit
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.telephone"
                                v-text="errors.telephone[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.address }"
                        >
                            <label class="control-label">
                                <i class="fas fa-align-left"></i> DIRECION
                            </label>
                            <el-input v-model="form.address">
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.address"
                                v-text="errors.address[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.email }"
                        >
                            <label class="control-label">
                                <i class="fas fa-align-left"></i> CORREO
                                ELECTRONICO
                            </label>
                            <el-input v-model="form.email">
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.email"
                                v-text="errors.email[0]"
                            ></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <el-button icon="fas fa-times" @click.prevent="close()"
                    >Cancelar</el-button
                >
                <el-button
                    icon="fas fa-save"
                    type="primary"
                    native-type="submit"
                    :loading="loading_submit"
                    >Guardar</el-button
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
    props: [
        "showDialog",
        "recordId",
        "specialties",
        "countries",
        "departments",
        "provinces",
        "districts"
    ],
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            loading_search: false,
            resource: "dental/medic",
            errors: {},
            form: {},
            identity_document_type_id: "1"
        };
    },
    created() {
        this.initForm();
    },
    methods: {
        validateNumbers(field) {
            const value = this.form[field];
            if (/[^0-9]/.test(value)) {
                Swal.fire({
                    icon: "warning",
                    title: "Solo se permiten números.",
                    timer: 2000,
                    showConfirmButton: false
                });
                this.form[field] = value.replace(/[^0-9]/g, ""); // Reemplazar caracteres no válidos
            }
        },
        initForm() {
            this.errors = {};
            this.form = {
                country_id: "PE",
                number: null,
                name: null,
                specialty_id: null,
                department_id: null,
                province_id: null,
                district_id: null,
                address: null,
                telephone: null,
                email: null
            };
        },
        create() {
            this.titleDialog = this.recordId ? "Editar Medico" : "Nuevo Medico";
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
        async searchDocument() {
            if (!this.form.number) {
                this.$message({
                    message: 'Ingrese el número de documento',
                    type: 'warning'
                });
                return;
            }

            this.loading_search = true;
            try {
                const response = await this.$http.get(
                    `/service/dni/${this.form.number}`
                );
                
                if (response.data.success) {
                    const data = response.data.data;
                    
                    // Asignar nombre completo
                    this.form.name = data.nombre_completo;

                    // Buscar y asignar departamento
                    const departmentMatch = this.departments.find(
                        dep => dep.description.toUpperCase() === data.departamento
                    );
                    if (departmentMatch) {
                        this.form.department_id = departmentMatch.id;
                    }

                    // Buscar y asignar provincia
                    const provinceMatch = this.provinces.find(
                        prov => prov.description.toUpperCase() === data.provincia
                    );
                    if (provinceMatch) {
                        this.form.province_id = provinceMatch.id;
                    }

                    // Buscar y asignar distrito
                    const districtMatch = this.districts.find(
                        dist => dist.description.toUpperCase() === data.distrito
                    );
                    if (districtMatch) {
                        this.form.district_id = districtMatch.id;
                    }

                    // Asignar dirección
                    this.form.address = data.direccion_completa;

                    this.$message({
                        message: 'Datos encontrados y completados',
                        type: 'success'
                    });
                } else {
                    this.$message({
                        message: response.data.message || 'No se encontraron datos',
                        type: 'warning'
                    });
                }
            } catch (error) {
                console.error(error);
                this.$message({
                    message: 'Ocurrió un error al consultar el DNI',
                    type: 'error'
                });
            } finally {
                this.loading_search = false;
            }
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        }
    }
};
</script>
