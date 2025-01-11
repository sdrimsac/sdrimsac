<!-- Módulo de Usuarios Principal -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card">
                <div
                    class="card-header bg-primary d-flex align-items-center"
                    style="padding: 15px;"
                >
                    <h4
                        class="my-0 text-white d-flex align-items-center"
                        style="font-size: 1.5rem; font-weight: bold;"
                    >
                        <i
                            class="far fa-address-book"
                            style="font-size: 2rem; margin-right: 0.5rem;"
                        ></i>
                        Módulo de Usuarios
                    </h4>
                </div>

                <div class="data-table-visible-columns">
                    <el-button
                        class="btn_titulos_modal"
                        href="javascript:void(0)"
                        @click.prevent="clickCreate()"
                    >
                        <i class="fa fa-user-plus"></i>
                        <span
                            style="color: #000; font-size: 1.25rem; font-weight: bold;"
                            >Nuevo</span
                        >
                    </el-button>
                </div>

                <!-- <div class="data-table-visible-columns">
                    <el-button type="primary" class="btn-large" href="javascript:void(0)" @click.prevent="clickCreate()">
                        <i class="fa fa-user-plus" style="font-size: 1.5rem; margin-right: 0.5rem;"></i>
                        <span style="font-size: 1.25rem; font-weight: bold;">Nuevo Usuario</span>
                    </el-button>
                </div> -->
                <div class="card-body">
                    <template>
                        <div class="row m-3 align-items-center">
                            <!-- Filtro por Estado -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label
                                        class="control-label fw-bold"
                                        for="filter-state"
                                        >Filtro por Estado</label
                                    >
                                    <el-select
                                        id="filter-state"
                                        v-model="form.qty_type"
                                        clearable
                                        filterable
                                        placeholder="Seleccione un estado"
                                        class="input-custom"
                                    >
                                        <el-option
                                            v-for="option in qty_types"
                                            :key="option.id"
                                            :value="option.value"
                                            :label="option.name"
                                        >
                                            {{ option.name }}
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>

                            <!-- Buscar por Nombre de Usuario -->
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label
                                        class="control-label fw-bold"
                                        for="user-name"
                                        >Buscar por Nombre de Usuario</label
                                    >
                                    <el-input
                                        id="user-name"
                                        v-model="form.name"
                                        placeholder="Ingrese el nombre de usuario"
                                        clearable
                                        @change="getData"
                                        class="input-custom"
                                    ></el-input>
                                </div>
                            </div>

                            <!-- Botón Buscar -->
                            <div
                                class="col-md-3 d-flex align-items-center justify-content-center"
                            >
                                <el-button
                                    class="btn_buscar"
                                    type="primary"
                                    @click.prevent="getRecordsByFilter"
                                    :loading="loading_submit"
                                >
                                    <i class="fas fa-search icon-style"></i>
                                    <span class="label-style">Buscar</span>
                                </el-button>
                            </div>
                        </div>
                    </template>

                    <div class="table-responsive">
                        <table
                            class="table table-striped table-hover custom-table"
                        >
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th class="text-center">ITEM</th>
                                    <th class="text-center">NOMBRE</th>
                                    <th class="text-center">TIPO USUARIO</th>
                                    <th class="text-center">ÁREA</th>
                                    <th class="text-center">PIN</th>
                                    <th class="text-center">ACTIVIDAD</th>
                                    <th class="text-center">ESTABLECIMIENTO</th>
                                    <th class="text-center">SERIES</th>
                                    <th class="text-center">ACCIONES</th>
                                    <th class="text-center">ESTADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(row, index) in records"
                                    :key="index"
                                    :class="
                                        index % 2 === 0
                                            ? 'table-row-even'
                                            : 'table-row-odd'
                                    "
                                >
                                    <!-- ITEM -->
                                    <td class="text-center">{{ index + 1 }}</td>

                                    <!-- NOMBRE -->
                                    <td class="text-center">{{ row.name }}</td>

                                    <!-- TIPO USUARIO -->
                                    <td class="text-center">{{ row.type }}</td>

                                    <!-- ÁREA -->
                                    <td class="text-center">{{ row.area }}</td>

                                    <!-- PIN -->
                                    <td
                                        class="text-center d-flex align-items-center justify-content-center"
                                    >
                                        <span>{{
                                            row.visible ? row.pin : "****"
                                        }}</span>
                                        <button
                                            class="btn btn-outline-success btn-sm mx-1"
                                            @click="visiblePin(index)"
                                            title="Mostrar PIN"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button
                                            class="btn btn-outline-primary btn-sm mx-1"
                                            @click="editPin(row)"
                                            title="Editar PIN"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <el-button
                                            v-if="authenticatedUser.type === 'superadmin'"
                                            class="btn btn-outline-success btn-sm mx-1"
                                            icon="el-icon-phone-outline"
                                            @click="whatsapp(row.id)"
                                        >
                                        </el-button>
                                    </td>

                                    <!-- ACTIVIDAD -->
                                    <td class="text-center">
                                        <div
                                            v-if="
                                                row.last_register &&
                                                    row.last_register.user
                                            "
                                        >
                                            <strong>{{
                                                row.last_register.user
                                            }}</strong
                                            >:
                                            <span class="text-primary">{{
                                                row.last_register.description
                                            }}</span>
                                            <br />
                                            <span
                                                :class="{
                                                    'text-danger':
                                                        row.last_register
                                                            .date_time.is24Hours
                                                }"
                                            >
                                                {{
                                                    formatDateTime(
                                                        row.last_register
                                                            .date_time
                                                    )
                                                }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- ESTABLECIMIENTO -->
                                    <td class="text-center">
                                        {{ row.establishment_description }}
                                    </td>

                                    <!-- SERIES -->
                                    <td class="text-center">
                                        {{ row.series }}
                                    </td>

                                    <!-- ACCIONES -->
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-primary dropdown-toggle"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                            >
                                                Acciones
                                            </button>
                                            <ul
                                                class="dropdown-menu dropdown-menu-end"
                                            >
                                                <li>
                                                    <a
                                                        class="dropdown-item text-info"
                                                        @click.prevent="
                                                            clickCreate(row.id)
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-edit"
                                                        ></i>
                                                        Editar
                                                    </a>
                                                </li>
                                                <li v-if="row.active">
                                                    <a
                                                        class="dropdown-item text-danger"
                                                        @click.prevent="
                                                            clickDelete(row.id)
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-toggle-off"
                                                        ></i>
                                                        Desactivar
                                                    </a>
                                                </li>
                                                <li v-if="!row.active">
                                                    <a
                                                        class="dropdown-item text-success"
                                                        @click.prevent="
                                                            clickActivate(
                                                                row.id
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-toggle-on"
                                                        ></i>
                                                        Activar
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>

                                    <!-- ESTADO -->
                                    <td class="text-center">
                                        <strong
                                            :class="{
                                                'text-success': row.active,
                                                'text-danger': !row.active
                                            }"
                                        >
                                            {{
                                                row.active
                                                    ? "ACTIVO"
                                                    : "SUSPENDIDO"
                                            }}
                                        </strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <create-form
                :configuration="configuration"
                :showDialog.sync="showDialog"
                :areas="areas"
                :recordId="recordId"
                :workersType="workersType"
                :series="series"
                :establishments="establishments"
                :allEstablishments="allEstablishments"
                :allWarehouses="allWarehouses"
                :commercial_treatment="commercial_treatment"
            ></create-form>
        </div>
        <el-dialog
            :visible.sync="showEditPin"
            title="Editar PIN"
            v-if="currentUser"
            width="450px"
            v-loading="loading"
        >
            <div class="row m-2">
                <!-- Campo para ingresar el nuevo PIN de usuario -->
                <div class="col-12">
                    <label for="newPin">Ingrese Nuevo PIN de Usuario</label>
                    <input
                        type="password"
                        id="newPin"
                        maxlength="6"
                        @input="validatePin"
                        class="form-control"
                        v-model="newPin"
                        placeholder="Nuevo PIN"
                    />
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="d-flex justify-content-end m-2" style="gap: 10px;">
                <button class="btn btn-primary" @click="updatePin">
                    Guardar
                </button>
                <button class="btn btn-danger" @click="showEditPin = false">
                    Cerrar
                </button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
/* import DataTableUser from "../../../../../../../resources/js/components/DataTableUser.vue"; */
import CreateForm from "./form.vue";
import { deletable } from "../../../../../../../resources/js/mixins/deletable";
import queryString from "query-string";
export default {
    props: ["establishments", "configuration"],
    mixins: [deletable],
    components: {
        CreateForm
    },
    data() {
        return {
            authenticatedUser: null,
            typeUser: null,
            qty_types: [
                {
                    id: 1,
                    name: "Activo",
                    value: "1"
                },
                {
                    id: 2,
                    name: "Suspendido",
                    value: "0"
                }
            ],
            active: false,
            showEditPin: false,
            showDialog: false,
            resource: "workers",
            recordId: null,
            areas: [],
            workersType: [],
            series: [],
            records: [],
            currentUser: null,
            newPin: null,
            loading: false,
            allWarehouses: [],
            allEstablishments: [],
            form: {},
            loading_submit: false,
            commercial_treatment: []
        };
    },
    created() {
        this.fetchAuthenticatedUser();
        this.initForm();
        console.log(this.configuration);
        this.$eventHub.$on("reloadData", () => {
            this.getData();
        });
        console.log(this.typeUser);
        this.getTables();

        this.getData();
    },
    methods: {
        async fetchAuthenticatedUser() {
            try {
                const response = await this.$http.get("workers/authenticated-user");
                this.authenticatedUser = response.data.user;
            } catch (error) {
                console.error(
                    "Error al obtener el usuario autenticado:",
                    error
                );
            }
        },
        async whatsapp(id) {
            const response = await this.$http.post(`whatsapp/user/${id}`);
            if (response.status == 200) {
                const { phone } = response.data;
            }
        },
        /* async whatsapp(id) {
            const response = await this.$http.post(`whatsapp/user/${id}`);
            if (response.status == 200) {
                const { phone } = response.data;
            }
        }, */
        formatDateTime(date) {
            let days = date.days;
            let hours = date.hours;
            let minutes = date.minutes;
            let text = "Hace: ";
            if (days > 0) {
                text += `${days} días`;
            } else if (hours > 0) {
                text += `${hours} horas`;
            }
            if (days == 0 && hours == 0) {
                if (minutes == 0) {
                    text += `Recientemente`;
                } else {
                    text += `${minutes} minutos`;
                }
            }

            return text;
        },
        validatePin() {
            // Permitir solo números
            this.newPin = this.newPin.replace(/[^0-9]/g, "");

            if (this.newPin.length > 6) {
                this.newPin = this.newPin.substring(0, 6);
            }
        },
        async updatePin() {
            try {
                let maxDigits = 6;
                if (this.currentUser.type === "vendedor") {
                    maxDigits = 4;
                }
                const pinRegex = new RegExp(`^\\d{1,${maxDigits}}$`);
                if (!pinRegex.test(this.newPin)) {
                    this.$toast.error(
                        `El PIN debe ser un número de hasta ${maxDigits} dígitos.`
                    );
                    return;
                }
                this.loading = true;
                const response = await this.$http.post("/users/update_pin", {
                    id: this.currentUser.id,
                    pin: this.newPin
                });
                if (response.status == 200) {
                    this.$toast.success(response.data.message);
                    this.getData();
                    this.newPin = null;
                    this.showEditPin = false;
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        editPin(user) {
            this.showEditPin = true;
            this.currentUser = user;
        },
        visiblePin(idx) {
            this.records[idx].visible = !this.records[idx].visible;
        },
        async getTables() {
            let response = await this.$http.get(`areas/actives`);
            this.areas = response.data.data;
            response = await this.$http.get(`workers-type/actives`);
            this.workersType = response.data.workers_type;
            this.series = response.data.series;
            console.log(this.series);
            this.allWarehouses = response.data.warehouses;
            this.allEstablishments = response.data.establishments;
            this.commercial_treatment = response.data.commercial_treatment;
            console.log(
                "🚀 ~ getTables ~ this.commercial_treatment:",
                this.commercial_treatment
            );
            /* console.log(series); */
        },
        initForm() {
            this.form = {
                qty_type: null,
                name: null
            };
        },

        async getRecordsByFilter() {
            this.loading_submit = await true;
            await this.getData();
            this.loading_submit = await false;
        },
        getData() {
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                const response = await this.$http
                    .get(
                        `${this.resource}/records?${this.getQueryParameters()}`
                    )
                    .then(response => {
                        this.records = response.data.data.map(d => {
                            d.visible = false;
                            return d;
                        });
                    });
                this.loading_submit = false;
            }, 350);
        },
        getQueryParameters() {
            return queryString.stringify(this.form);
        },
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },
        async clickDelete(id) {
            const response = await this.$http.get(`${this.resource}/${id}`);
            if (response.status == 200) {
                const { message } = response.data;
                this.$toast.success(message);
                this.getData();
            }
        },
        async clickActivate(id) {
            const response = await this.$http.get(`${this.resource}/${id}`);
            if (response.status == 200) {
                const { message } = response.data;
                this.$toast.success(message);
                this.getData();
            }
        }
    }
};
</script>

<style>
.table-striped tr:nth-child(even) {
    background-color: #f2f2f2;
}
.custom-table th {
    background-color: #007bff;
    color: white;
}
.custom-table td {
    vertical-align: middle;
}
.icon-style {
    font-size: 1.25rem;
    margin-right: 0.5rem;
}
.label-style {
    font-size: 1.25rem;
    font-weight: bold;
}
</style>
