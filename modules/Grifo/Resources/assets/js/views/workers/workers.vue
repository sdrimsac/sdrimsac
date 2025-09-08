<!-- Módulo de Usuarios Principal -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card">
                <div class="card-header bg-primary d-flex align-items-center" style="padding: 15px;">
                    <h4 class="my-0 text-white d-flex align-items-center" style="font-size: 1.5rem; font-weight: bold;">
                        <i class="far fa-address-book" style="font-size: 2rem; margin-right: 0.5rem;"></i>
                        Módulo de Usuarios
                    </h4>
                </div>

                <div class="data-table-visible-columns">
                    <el-button class="btn_titulos_modal" href="javascript:void(0)" @click.prevent="clickCreate()">
                        <i class="fa fa-user-plus"></i>
                        <span style="color: #000; font-size: 1.25rem; font-weight: bold;">Nuevo</span>
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
                                    <label class="control-label fw-bold" for="filter-state">Filtro por Estado</label>
                                    <el-select id="filter-state" v-model="form.qty_type" clearable filterable
                                        placeholder="Seleccione un estado" class="input-custom">
                                        <el-option v-for="option in qty_types" :key="option.id" :value="option.value"
                                            :label="option.name">
                                            {{ option.name }}
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>

                            <!-- Buscar por Nombre de Usuario -->
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label fw-bold" for="user-name">Buscar por Nombre de
                                        Usuario</label> <el-input id="user-name" v-model="form.name"
                                        placeholder="Ingrese el nombre de usuario" clearable @input="getData"
                                        class="input-custom"></el-input>
                                </div>
                            </div>

                            <!-- Botón Buscar -->
                            <!-- <div
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
                            </div> -->
                        </div>
                    </template>

                    <div class="users-card-grid">
                        <div v-if="records.length === 0" class="text-center text-muted p-5">
                            No hay usuarios para mostrar.
                        </div>
                        <div v-for="(row, index) in records" :key="index" class="user-card-horizontal shadow-sm">
                            <div class="user-card-h-main d-flex align-items-stretch position-relative">
                                <!-- Avatar/Icono -->
                                <div class="user-card-h-avatar d-flex flex-column align-items-center justify-content-center">
                                    <img
                                        v-if="getUserImage(row)"
                                        :src="getUserImage(row)"
                                        alt="Avatar"
                                        class="user-avatar-img"
                                    />
                                    <div v-else class="user-avatar-placeholder">
                                        <i class="fa fa-user-circle"></i>
                                        <span>Sin imagen</span>
                                    </div>
                                </div>
                                <!-- Datos -->
                                <div class="user-card-h-data flex-grow-1 px-3 py-2">
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="fw-bold fs-5 me-2">{{ row.name }}</span>
                                        <span class="text-muted small">#{{ index + 1 }}</span>
                                    </div>
                                    <div class="row g-1 mb-1">
                                        <div class="col-6">
                                            <span class="label">Tipo:</span>
                                            <span class="value">{{ row.type }}</span>
                                        </div>
                                        <div class="col-6">
                                            <span class="label">Área:</span>
                                            <span class="value">{{ row.area }}</span>
                                        </div>
                                        <div class="col-6">
                                            <span class="label">Establecimiento:</span>
                                            <span class="value">{{ row.establishment_description }}</span>
                                        </div>
                                        <div class="col-6">
                                            <span class="label">Series:</span>
                                            <span class="value">{{ row.series }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="label me-1">PIN:</span>
                                        <span class="me-2">{{ row.visible ? row.pin : '****' }}</span>
                                        <button class="btn btn-outline-success btn-sm mx-1" @click="visiblePin(index)"
                                            title="Mostrar PIN">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-primary btn-sm mx-1" @click="editPin(row)"
                                            title="Editar PIN">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <el-button v-if="authenticatedUser && authenticatedUser.type === 'superadmin'"
                                            class="btn btn-outline-success btn-sm mx-1" icon="el-icon-phone-outline"
                                            @click="whatsapp(row.id)">
                                        </el-button>
                                    </div>
                                    <div v-if="authenticatedUser && authenticatedUser.type === 'superadmin'"
                                        class="mb-1">
                                        <span class="label">Token:</span>
                                        <span class="value">{{ row.api_token }}</span>
                                    </div>
                                    <div class="mb-1">
                                        <span class="label">Actividad:</span>
                                        <span v-if="row.last_register && row.last_register.user">
                                            <strong>{{ row.last_register.user }}</strong>:
                                            <span class="text-primary">{{ row.last_register.description }}</span>
                                            <span :class="{ 'text-danger': row.last_register.date_time.is24Hours }">
                                                ({{ formatDateTime(row.last_register.date_time) }})
                                            </span>
                                        </span>
                                        <span v-else class="text-muted small">Sin actividad reciente</span>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown">
                                                Acciones
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item text-info"
                                                        @click.prevent="clickCreate(row.id)">
                                                        <i class="fas fa-edit"></i>
                                                        Editar
                                                    </a>
                                                </li>
                                                <li v-if="row.active">
                                                    <a class="dropdown-item text-danger"
                                                        @click.prevent="clickDelete(row.id)">
                                                        <i class="fas fa-toggle-off"></i>
                                                        Desactivar
                                                    </a>
                                                </li>
                                                <li v-if="!row.active">
                                                    <a class="dropdown-item text-success"
                                                        @click.prevent="clickActivate(row.id)">
                                                        <i class="fas fa-toggle-on"></i>
                                                        Activar
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <span class="text-muted small ms-3">ID: {{ row.id }}</span>
                                    </div>
                                </div>
                                <!-- Sello de estado -->
                                <div class="user-card-h-stamp"
                                    :class="row.active ? 'stamp-activo' : 'stamp-suspendido'">
                                    {{ row.active ? 'ACTIVO' : 'SUSPENDIDO' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <create-form :configuration="configuration" :showDialog.sync="showDialog" :areas="areas"
                :recordId="recordId" :workersType="workersType" :series="series" :establishments="establishments"
                :allEstablishments="allEstablishments" :allWarehouses="allWarehouses"
                :commercial_treatment="commercial_treatment"></create-form>
        </div>
        <el-dialog :visible.sync="showEditPin" title="Editar PIN" v-if="currentUser" width="450px" v-loading="loading">
            <div class="row m-2">
                <!-- Campo para ingresar el nuevo PIN de usuario -->
                <div class="col-12">
                    <label for="newPin">Ingrese Nuevo PIN de Usuario</label>
                    <input type="password" id="newPin" maxlength="6" @input="validatePin" class="form-control"
                        v-model="newPin" placeholder="Nuevo PIN" />
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
    // ...existing code...
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
        getUserImage(row) {
            // Prioridad: image_url > avatar > photo > image
            let img = row.image_url || row.avatar || row.photo || row.image;
            if (!img) return '';
            // Si la ruta es relativa, prepende la URL base
            if (!/^https?:\/\//.test(img)) {
                return `${window.location.origin}/${img.replace(/^\/+/, '')}`;
            }
            return img;
        },
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


.user-avatar-img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #e0e0e0;
    background: #fff;
    box-shadow: 0 2px 8px 0 rgba(0, 0, 0, 0.07);
}

/* Card horizontal estilo tipo "sello" y avatar */
.user-card-horizontal {
    background: #f5ede3;
    border-radius: 0.8rem;
    border: 1.5px solid #e0d6c3;
    padding: 0.7rem 1.2rem 0.7rem 0.7rem;
    min-height: 170px;
    display: flex;
    align-items: stretch;
    position: relative;
    overflow: hidden;
    box-shadow: 0 2px 10px 0 rgba(180, 150, 100, 0.10);
    transition: box-shadow 0.2s;
}

.user-card-horizontal:hover {
    box-shadow: 0 6px 24px 0 rgba(180, 150, 100, 0.18);
}

.user-card-h-main {
    width: 100%;
    display: flex;
    align-items: stretch;
    position: relative;
}

.user-card-h-avatar {
    min-width: 110px;
    max-width: 110px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #f7f3ee;
    border-radius: 0.7rem;
    margin-right: 1.2rem;
    border: 1px solid #e0d6c3;
    padding: 0.5rem 0.2rem;
    height: 120px;
}

.user-avatar-img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 0.5rem;
    border: 1.5px solid #e0d6c3;
    background: #fff;
    box-shadow: 0 2px 8px 0 rgba(180, 150, 100, 0.07);
    margin-bottom: 0.3rem;
}

.user-avatar-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #b8b8b8;
    font-size: 0.95rem;
    text-align: center;
    margin-top: 0.2rem;
}

.user-card-h-data {
    flex: 1 1 0%;
    min-width: 0;
}

.user-card-h-stamp {
    position: absolute;
    top: 18px;
    right: -45px;
    font-size: 2.1rem;
    font-weight: bold;
    color: #fff;
    background: #e74c3c;
    padding: 0.4em 2.7em;
    border-radius: 0.5em;
    transform: rotate(-18deg);
    opacity: 0.22;
    pointer-events: none;
    z-index: 2;
    text-shadow: 1px 1px 2px #b03a2e;
    letter-spacing: 2px;
    box-shadow: 0 2px 8px 0 rgba(0, 0, 0, 0.10);
    user-select: none;
}

.stamp-activo {
    background: #27ae60;
    text-shadow: 1px 1px 2px #196f3d;
}

.stamp-suspendido {
    background: #e74c3c;
    text-shadow: 1px 1px 2px #b03a2e;
}

.user-card-h-data .label {
    font-weight: 600;
    color: #007bff;
    font-size: 0.95rem;
}

.user-card-h-data .value {
    font-size: 1.05rem;
    color: #222;
    margin-right: 0.5rem;
}

.user-card-h-avatar .fa-user-circle {
    color: #007bff;
    font-size: 3.5rem;
}

/* Cards grid and card styles */
.users-card-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 1.5rem;
    margin-top: 2rem;
    margin-bottom: 2rem;
}

@media (min-width: 768px) {
    .users-card-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1200px) {
    .users-card-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

.user-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e0e0e0;
    padding: 1.5rem 1.2rem 1.2rem 1.2rem;
    transition: box-shadow 0.2s;
    min-height: 270px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.user-card:hover {
    box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.10);
}

.user-card-header {
    border-bottom: 1px solid #f0f0f0;
    padding-bottom: 0.5rem;
}

.user-card-body .label {
    font-weight: 600;
    color: #007bff;
    font-size: 0.95rem;
}

.user-card-body .value {
    font-size: 1.05rem;
    color: #222;
    margin-bottom: 0.2rem;
}

.user-card-footer {
    border-top: 1px solid #f0f0f0;
    padding-top: 0.7rem;
}

.user-card .badge {
    font-size: 0.95rem;
    padding: 0.4em 0.9em;
    border-radius: 0.7em;
}

.user-card .dropdown-toggle {
    font-size: 1rem;
}

.user-card .btn {
    font-size: 0.95rem;
}

.user-card .fa-user-circle {
    color: #007bff;
}

.user-card .fa-eye,
.user-card .fa-edit {
    font-size: 1.1rem;
}

.user-card .text-muted.small {
    font-size: 0.92rem;
}
</style>
