<template>
    <el-dialog
        :visible="showDialog"
        append-to-body
        @close="close"
        @open="open"
        :title="title"
    >
        <div class="form-body" v-loading="loading">
            <el-tabs tab-position="top" v-model="tab">
                <el-tab-pane name="parent" label="Datos del Cliente">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label for="number" class="control-label"
                                    >Tipo de documento</label
                                >
                                <el-select
                                    @change="closeProperty"
                                    style="width:100%;"
                                    v-model="form.identity_document_type_id"
                                >
                                    <el-option
                                        v-for="option in identityDocuments"
                                        :key="option.id"
                                        :value="option.id"
                                        :label="option.description"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="col-md-3 col-12">
                                <label for="number" class="control-label"
                                    >Documento</label
                                >
                                <el-input
                                    class="to_left"
                                    style="width:100%;"
                                    v-model="documentNumber"
                                    @input="closeProperty"
                                    :controls="false"
                                >
                                    <el-button
                                        v-if="
                                            form.identity_document_type_id ==
                                                1 ||
                                                form.identity_document_type_id ==
                                                    6
                                        "
                                        slot="append"
                                        :loading="loading_search"
                                        icon="el-icon-search"
                                        @click.prevent="searchCustomer"
                                    ></el-button>
                                </el-input>
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="number" class="control-label"
                                    >Nombres</label
                                >
                                <el-input v-model="form.name"> </el-input>
                            </div>
                        </div>
                        <div
                            class="row mt-2"
                            v-if="form.state && form.condition"
                        >
                            <div class="col-md-6 col-12"></div>
                            <div class="col-md-3 col-12">
                                <el-alert
                                    :title="form.state"
                                    :type="
                                        `${
                                            form.state == 'ACTIVO'
                                                ? 'success'
                                                : 'error'
                                        }`
                                    "
                                >
                                </el-alert>
                            </div>
                            <div class="col-md-3">
                                <el-alert
                                    :title="form.condition"
                                    :type="
                                        `${
                                            form.condition == 'HABIDO'
                                                ? 'success'
                                                : 'error'
                                        }`
                                    "
                                >
                                </el-alert>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div
                                    class="form-group"
                                    :class="{ 'has-danger': errors.country_id }"
                                >
                                    <label class="control-label">País</label>
                                    <el-select
                                        v-model="form.country_id"
                                        filterable
                                        dusk="country_id"
                                        disabled
                                    >
                                        <el-option
                                            v-for="option in countries"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.description"
                                        ></el-option>
                                    </el-select>
                                    <small
                                        class="text-danger"
                                        v-if="errors.country_id"
                                        v-text="errors.country_id[0]"
                                    ></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.department_id
                                    }"
                                >
                                    <label class="control-label"
                                        >Departamento</label
                                    >
                                    <el-select
                                        v-model="form.department_id"
                                        filterable
                                        @change="filterProvince"
                                        popper-class="el-select-departments"
                                        dusk="department_id"
                                    >
                                        <el-option
                                            v-for="option in departments"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.description"
                                        ></el-option>
                                    </el-select>
                                    <small
                                        class="text-danger"
                                        v-if="errors.department_id"
                                        v-text="errors.department_id[0]"
                                    ></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.province_id
                                    }"
                                >
                                    <label class="control-label"
                                        >Provincia</label
                                    >
                                    <el-select
                                        v-model="form.province_id"
                                        filterable
                                        @change="filterDistrict"
                                        popper-class="el-select-provinces"
                                        dusk="province_id"
                                    >
                                        <el-option
                                            v-for="option in provinces"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.description"
                                        ></el-option>
                                    </el-select>
                                    <small
                                        class="text-danger"
                                        v-if="errors.province_id"
                                        v-text="errors.province_id[0]"
                                    ></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.district_id
                                    }"
                                >
                                    <label class="control-label"
                                        >Distrito</label
                                    >
                                    <el-select
                                        @change="updateAll"
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
                            <div class="col-md-8">
                                <div
                                    class="form-group"
                                    :class="{ 'has-danger': errors.address }"
                                >
                                    <label class="control-label"
                                        >Dirección</label
                                    >
                                    <el-input
                                        v-model="form.address"
                                        dusk="address"
                                    >
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i
                                    ></el-input>
                                    <small
                                        class="text-danger"
                                        v-if="errors.address"
                                        v-text="errors.address[0]"
                                    ></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <label for="number" class="control-label"
                                    >Teléfono</label
                                >
                                <el-input v-model="form.phone"> </el-input>
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="number" class="control-label"
                                    >Correo</label
                                >
                                <el-input v-model="form.email"> </el-input>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6 col-12">
                                <label for="number" class="control-label"
                                    >Teléfono secundario</label
                                >
                                <el-input v-model="form.extra_phone">
                                </el-input>
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="number" class="control-label"
                                    >Relacion</label
                                >
                                <el-select v-model="form.type">
                                    <el-option
                                        value="mother"
                                        label="Madre"
                                    ></el-option>
                                    <el-option
                                        value="father"
                                        label="Padre"
                                    ></el-option>
                                    <el-option
                                        value="attorney"
                                        label="Apoderado"
                                    ></el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div
                                v-if="form.type == 'attorney'"
                                class="col-md-6 col-12"
                            >
                                <label for="number" class="control-label"
                                    >Tipo de apoderado</label
                                >

                                <a
                                    href="#"
                                    v-if="form_attorney.add == false"
                                    class="control-label font-weight-bold text-info"
                                    @click="form_attorney.add = true"
                                >
                                    [ + Nuevo]</a
                                >
                                <a
                                    href="#"
                                    v-if="form_attorney.add == true"
                                    class="control-label font-weight-bold text-info"
                                    @click="saveType()"
                                >
                                    [ + Guardar]</a
                                >
                                <a
                                    href="#"
                                    v-if="form_attorney.add == true"
                                    class="control-label font-weight-bold text-danger"
                                    @click="form_attorney.add = false"
                                >
                                    [ Cancelar]</a
                                >
                                <el-input
                                    v-if="form_attorney.add == true"
                                    v-model="form_attorney.name"
                                    dusk="item_code"
                                    @input="searchType"
                                    style="margin-bottom:1.5%;"
                                >
                                    <i
                                        slot="prefix"
                                        class="el-icon-edit-outline"
                                    ></i
                                ></el-input>

                                <el-select
                                    v-if="form_attorney.add == false"
                                    v-model="form.attorney_id"
                                    filterable
                                    clearable
                                >
                                    <el-option
                                        v-for="option in types"
                                        :key="option.id"
                                        :value="option.id"
                                        :label="option.description"
                                    ></el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                </el-tab-pane>
                <el-tab-pane name="children" label="Datos de los estudiantes">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label for="number" class="control-label"
                                    >Tipo de documento</label
                                >
                                <el-select
                                    style="
                    width:100%;"
                                    v-model="documentTypeChildren"
                                >
                                    <el-option
                                        v-for="option in identityDocuments"
                                        :key="option.id"
                                        :value="option.id"
                                        :label="option.description"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="col-md-3 col-12">
                                <label for="number" class="control-label"
                                    >Documento</label
                                >
                                <el-input
                                    class="to_left"
                                    style="
                    width:100%;"
                                    v-model="documentNumberChildren"
                                    :controls="false"
                                >
                                    <el-button
                                        v-if="documentTypeChildren == '1'"
                                        slot="append"
                                        :loading="loading_search"
                                        icon="el-icon-search"
                                        @click.prevent="searchCustomer"
                                    ></el-button>
                                </el-input>
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="number" class="control-label"
                                    >Nombres</label
                                >
                                <el-input v-model="form_children.name">
                                </el-input>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div
                                class="col-md-3 col-12 align-self-end d-flex justify-content-end"
                            >
                                <el-button
                                    class=" mt-2"
                                    type="primary"
                                    @click="addChildren"
                                >
                                    Agregar
                                </el-button>
                            </div>
                        </div>
                        <div class="row mt-2 p-2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Documento</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(child, idx) in children"
                                        :key="idx"
                                    >
                                        <td>{{ idx + 1 }}</td>
                                        <td>{{ child.name }}</td>
                                        <td>
                                            {{ child.number }}

                                            <br />
                                            <small>
                                                {{
                                                    getDocumentType(
                                                        child.identity_document_type_id
                                                    )
                                                }}
                                            </small>
                                        </td>
                                        <td>
                                              <el-button
                                                v-if="child.edit"
                                                type="success"
                                                size="mini"
                                                icon="el-icon-edit"
                                                circle
                                                @click="editPerson(child)"
                                            ></el-button>
                                            <el-button
                                                v-if="!child.id"
                                                type="danger"
                                                size="mini"
                                                icon="el-icon-delete"
                                                circle
                                                @click="deleteChild(child)"
                                            ></el-button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </el-tab-pane>
            </el-tabs>
        </div>
        <div slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="sendData">Guardar</el-button>
        </div>
             <person-form
                :external="false"
                :recordId="currentPersonId"
                :showDialog.sync="showDialogNewPerson"
            ></person-form>
    </el-dialog>
</template>
<style>
.to_left .el-input .el-input__inner {
    text-align: left !important;
}
</style>
<script>
const PersonForm = () =>
    import("../../../../../../../resources/js/views/persons/form.vue");
export default {
    props: ["showDialog", "recordId", "extern", "fromPerson"],
    components: {
        PersonForm
    },
    data() {
        return {
            identityDocuments: [],
            tab: "parent",
            title: "Nuevo registro",
            loading: false,
showDialogNewPerson:false,
            loading_search: false,
            children: [],
            form: {},
            resource: "college/persons",
            documentNumber: null,
            documentNumberChildren: null,
            documentTypeChildren: null,
            departments: [],
            provinces: [],
            currentPersonId:null,
            form_attorney: {
                add: false
            },
            countries: [],
            districts: [],
            all_departments: [],
            all_provinces: [],
            all_countries: [],
            all_districts: [],
            errors: {},
            types: [],
            form_children: {
                name: ""
            },
            timer: null
        };
    },
    async created() {
        await this.getTables();
        await this.getAttorneyTypes();
        this.initForm();
        this.$eventHub.$on("reloadData", () => {
            this.open();
        });
    },
    methods: {
        editPerson(child){
            this.currentPersonId = child.id;
            this.showDialogNewPerson = true;
        },
        updateAll() {
            this.$forceUpdate();
        },
        async sendData() {
            if (this.validForm()) {
                return;
            }
            this.form.children = this.children;
            this.form.number = this.documentNumber;

            try {
                this.loading = true;
                const response = await this.$http.post(
                    `/${this.resource}${this.recordId ? "/update" : ""}`,
                    this.form
                );
                if (response.status == 200) {
                    let { success, message } = response.data;
                    if (success) {
                        this.$toast.success(message);
                        this.$emit("memberCreated", this.form.number);
                        this.close();
                    } else {
                        this.$toast.error(message);
                    }
                }
            } catch (e) {
                this.$toast.error("Ocurrió un error");
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        getDocumentType(id) {
            return this.identityDocuments.find(i => i.id == id).description;
        },
        initForm() {
            this.form = {
                country_id: "PE",
                identity_document_type_id: "1",
                type: "mother"
            };
            this.children = [];
            this.documentTypeChildren = "1";
            this.documentNumber = null;
            this.documentNumber = null;
            this.documentNumberChildren = null;
            this.form_children.name = null;
        },
        validForm() {
            let error = false;
            let {
                name,
                department_id,
                province_id,
                district_id,
                address,
                phone,

                attorney_id,
                type
            } = this.form;
            if (!name) {
                error = true;
                this.$toast.error("El nombre es obligatorio");
            }
            if (!this.documentNumber) {
                error = true;
                this.$toast.error("El documento es obligatorio");
            }

            if (!department_id) {
                error = true;
                this.$toast.error("El departamento es obligatorio");
            }
            if (!province_id) {
                error = true;
                this.$toast.error("La provincia es obligatorio");
            }
            if (!district_id) {
                error = true;
                this.$toast.error("El distrito es obligatorio");
            }
            if (!address) {
                error = true;
                this.$toast.error("La dirección es obligatorio");
            }
            if (!phone) {
                error = true;
                this.$toast.error("El teléfono es obligatorio");
            }

            if (type == "attorney") {
                if (!attorney_id) {
                    error = true;
                    this.$toast.error("Elija un parentezco");
                }
            }

            if (this.children.length == 0) {
                error = true;
                this.$toast.error("Debe registrar al menos un estudiante");
            }

            return error;
        },
        addChildren() {
            if (!this.documentNumberChildren) {
                return this.$toast.error("Documento obligatorio");
            }

            if (!this.form_children.name) {
                return this.$toast.error("Nombre obligatorio");
            }
            this.children = [
                ...this.children.filter(
                    c => c.number != this.documentNumberChildren
                ),
                {
                    ...this.form_children,
                    identity_document_type_id: this.documentTypeChildren,
                    number: this.documentNumberChildren,
                    id: null
                }
            ];

            this.form_children.name = "";
            this.documentNumberChildren = null;
        },
        deleteChild(child) {
            let { number, id } = child;
            if (id) {
                console.log("No se puede borrar");
            } else {
                this.children = [
                    ...this.children.filter(c => c.number != number)
                ];
            }
        },
        async searchType() {
            if (this.timer) {
                clearTimeout(this.timer);
            }

            this.timer = setTimeout(async () => {
                await this.getAttorneyTypes();
            }, 250);
        },

        async getAttorneyTypes() {
            //persons/attorney/record
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/${this.resource}/attorney/records?description=${
                        this.form_attorney.name ? this.form_attorney.name : ""
                    }`
                );

                if (response.status == 200) {
                    let { records } = response.data;
                    this.types = records;
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        async saveType() {
            try {
                this.loading = true;
                const response = await this.$http.post(
                    `/${this.resource}/attorney`,
                    { description: this.form_attorney.name }
                );

                if (response.status == 200) {
                    let { id, message, success } = response.data;
                    if (success) {
                        this.form.attorney_id = id;
                        this.$toast.success(message);
                        this.getAttorneyTypes();
                        this.form_attorney.add = false;
                        this.form_attorney.name = null;
                    } else {
                        this.$toast.error(message);
                    }
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        async getTables() {
            try {
                this.loading = true;
                const response = await this.$http(`/${this.resource}/tables`);
                if (response.status == 200) {
                    let {
                        departments,
                        provinces,
                        countries,
                        districts,
                        identity_documents
                    } = response.data;

                    this.all_departments = departments;
                    this.all_provinces = provinces;
                    this.all_countries = countries;
                    this.all_districts = districts;
                    this.identityDocuments = identity_documents;
                    this.departments = departments;
                    this.provinces = provinces;
                    this.countries = countries;
                    this.districts = districts;
                }

                this.form.identity_document_type_id = "1";
                // this.form_children.identity_document_type_id = "1";
                this.documentTypeChildren = "1";
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        async open() {
            this.initForm();
            this.recordId && (this.title = "Editar registro");

            if (this.recordId) {
                try {
                    this.loading = true;
                    const response = await this.$http(
                        `/${this.resource}/update/${
                            this.recordId
                        }?from_person=${this.fromPerson ? 1 : ""}`
                    );
                    const { data } = response.data;
                    this.form = data;
                    this.documentNumber = this.form.number;
                    this.children = this.form.children;
                } catch (e) {
                    console.log(e);
                    this.$toast.error(
                        "Ocurrió un error al obtener el registro"
                    );
                } finally {
                    this.loading = false;
                }
            }
        },
        async searchCustomer() {
            let documentNumber =
                this.tab == "parent"
                    ? this.documentNumber
                    : this.documentNumberChildren;
            if (documentNumber == null || documentNumber == "") return;
            if (documentNumber.length != 8 && documentNumber.length != 11) {
                this.$toast.error("Ingrese un documento válido");
                return;
            }
            if (this.timer) {
                clearTimeout(this.timer);
            }
            this.timer = setTimeout(async () => {
                try {
                    this.currentCustomer = null;
                    this.loading_search = true;
                    const response = await this.$http(
                        `/${this.resource}/${documentNumber}?type=${
                            this.tab == "parent" ? "parent" : "student"
                        }`
                    );
                    if (response.status == 200) {
                        const { data } = response;
                        if (data.numero || data.ruc) {
                            if (this.tab == "parent") {
                                if (documentNumber.length == 8) {
                                    this.form.name = data.nombre_completo;
                                } else {
                                    this.form.name = data.nombre_o_razon_social;
                                    this.form.state = data.estado;
                                    this.form.condition = data.condicion;
                                }

                                this.form.address = data.direccion_completa;
                                if (data.ubigeo.length == 3) {
                                    let [
                                        department,
                                        province,
                                        district
                                    ] = data.ubigeo;
                                    this.form.department_id = department;
                                    this.form.province_id = province;
                                    this.form.district_id = district;
                                }
                            } else {
                                this.form_children.name = data.nombre_completo;
                            }
                        } else {
                            this.$toast.error(
                                data.message || "No se encontró el documento"
                            );
                        }
                    } else {
                        this.$toast.error("No se pudo obtener los datos");
                    }
                } catch (e) {
                    this.$toast.error("No se pudo obtener los datos");
                } finally {
                    this.loading_search = false;
                }
            }, 250);
        },
        filterProvince() {
            this.form.province_id = null;
            this.form.district_id = null;
            this.filterProvinces();
        },
        filterProvinces() {
            this.provinces = this.all_provinces.filter(f => {
                return f.department_id === this.form.department_id;
            });
        },
        filterDistrict() {
            this.form.district_id = null;
            this.filterDistricts();
        },
        filterDistricts() {
            this.districts = this.all_districts.filter(f => {
                return f.province_id === this.form.province_id;
            });
        },
        closeProperty() {
            this.form.state = null;
            this.form.condition = null;
        }
    }
};
</script>
