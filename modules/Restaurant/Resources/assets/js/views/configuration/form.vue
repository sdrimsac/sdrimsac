<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
        append-to-body
        :close-on-click-modal="false"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <!-- <div v-if="type == 'caja/rooms' && recordId" class="row mt-2">
                    <div class="col-md-3">
                        <button
                            class="btn btn-primary"
                            @click="minibar"
                            type="button"
                        >
                            Frigobar
                        </button>
                    </div>
                </div> -->
                <div class="row">
                    <div
                        v-if="type !== 'caja/tables' && type !== 'caja/rooms'"
                        class="col-md-12"
                    >
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.description }"
                        >
                            <label class="control-label">Descripción</label>
                            <el-input v-model="form.description"></el-input>
                            <small
                                class="text-danger"
                                v-if="errors.description"
                                v-text="errors.description[0]"
                            ></small>
                        </div>
                    </div>
                    <div
                        v-if="
                            type == 'caja/areas' &&
                                configurations.multiple_boxes === 1
                        "
                        class="col-md-6"
                    >
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.printer }"
                        >
                            <label class="control-label">Impresora</label>
                            <el-input v-model="form.printer"> </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.printer"
                                v-text="errors.printer[0]"
                            ></small>
                        </div>
                    </div>
                    <div
                        v-if="
                            type == 'caja/areas' &&
                                configurations.multiple_boxes === 1
                        "
                        class="col-md-6"
                    >
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.printer }"
                        >
                            <label class="control-label">Nº COPIAS</label>
                            <el-input v-model="form.copies"> </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.copies"
                                v-text="errors.copies[0]"
                            ></small>
                        </div>
                    </div>
                    <template
                        v-if="type == 'caja/tables' || type == 'caja/rooms'"
                    >
                        <div class="col-md-4">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.number }"
                            >
                                <label class="control-label"
                                    >Número de
                                    {{
                                        type == "caja/tables"
                                            ? "mesa"
                                            : "habitación"
                                    }}</label
                                >
                                <el-input v-model="form.number"></el-input>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.number"
                                    v-text="errors.number[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="type == 'caja/rooms'">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.tower_id }"
                            >
                                <label class="control-label">Torre</label>
                                <el-select
                                    v-model="form.tower_id"
                                    @change="filterFloorsByTower(form.tower_id)"
                                >
                                    <el-option
                                        v-for="(data, index) in towers"
                                        :key="index"
                                        :label="data.name"
                                        :value="data.id"
                                    ></el-option>
                                </el-select>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.floor_id"
                                    v-text="errors.floor_id[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="type == 'caja/rooms'">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.floor_id }"
                            >
                                <label class="control-label">Piso</label>
                                <el-select v-model="form.floor_id">
                                    <el-option
                                        v-for="(data, index) in floors"
                                        :key="index"
                                        :label="data.name"
                                        :value="data.id"
                                    ></el-option>
                                </el-select>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.floor_id"
                                    v-text="errors.floor_id[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="type == 'caja/rooms'">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.type_id }"
                            >
                                <label class="control-label">Tipo</label>
                                <el-select v-model="form.table_type_id">
                                    <el-option
                                        v-for="(data, index) in types"
                                        :key="index"
                                        :label="data.name"
                                        :value="data.id"
                                    ></el-option>
                                </el-select>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.type_id"
                                    v-text="errors.type_id[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="type == 'caja/rooms'">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.price }"
                            >
                                <label class="control-label">Precio</label>
                                <el-input
                                    v-model="form.price"
                                    type="number"
                                ></el-input>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.price"
                                    v-text="errors.price[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="type == 'caja/rooms'">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.month_price }"
                            >
                                <label class="control-label"
                                    >Precio mensual</label
                                >
                                <el-input
                                    v-model="form.month_price"
                                    type="number"
                                ></el-input>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.month_price"
                                    v-text="errors.month_price[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div
                                class="form-group"
                                :class="{
                                    'has-danger': errors.status_table_id
                                }"
                            >
                                <label class="control-label"
                                    >Estado de
                                    {{
                                        type == "caja/tables"
                                            ? "mesa"
                                            : "habitación"
                                    }}</label
                                >
                                <el-select
                                    :disabled="recordId != null"
                                    v-model="form.status_table_id"
                                >
                                    <el-option
                                        v-for="(data, index) in statusTable"
                                        :key="index"
                                        :label="data.description"
                                        :value="data.id"
                                    ></el-option>
                                </el-select>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.status_table_id"
                                    v-text="errors.status_table_id[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.area_id }"
                            >
                                <label class="control-label"
                                    >Área de
                                    {{
                                        type == "caja/tables"
                                            ? "mesa"
                                            : "habitación"
                                    }}</label
                                >
                                <el-select
                                    v-model="form.area_id"
                                    :disabled="type == 'caja/rooms'"
                                >
                                    <el-option
                                        v-for="(data, index) in areas"
                                        :key="index"
                                        :label="data.description"
                                        :value="data.id"
                                    ></el-option>
                                </el-select>
                                <small
                                    class="text-danger"
                                    v-if="errors.area_id"
                                    v-text="errors.area_id[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div
                                class="form-group"
                                :class="{
                                    'has-danger': errors.establishment_id
                                }"
                            >
                                <label class="control-label"
                                    >Establecimiento</label
                                >
                                <el-select v-model="form.establishment_id">
                                    <el-option
                                        v-for="(data, index) in establishments"
                                        :key="index"
                                        :label="data.description"
                                        :value="data.id"
                                    ></el-option>
                                </el-select>
                                <small
                                    class="text-danger"
                                    v-if="errors.establishment_id"
                                    v-text="errors.establishment_id[0]"
                                ></small>
                            </div>
                        </div>
                        <template
                            v-if="
                                type == 'caja/rooms' && all_services.length > 0
                            "
                        >
                            <div class="col-12 my-2">
                                <el-checkbox
                                    v-model="form.has_frigobar"
                                    label="Frigobar"
                                >
                                    ¿Tiene frigobar?
                                </el-checkbox>
                            </div>
                            <div class="col-12">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.all_services
                                    }"
                                >
                                    <label class="control-label"
                                        >Servicios</label
                                    >
                                </div>
                            </div>
                            <div
                                class="d-flex flex-wrap justify-content-center p-2"
                            >
                                <el-tag
                                    role="button"
                                    :type="
                                        data.selected ? 'success' : 'primary'
                                    "
                                    style="margin-right:5px;margin-top:5px"
                                    v-for="(data, idx) in all_services"
                                    :key="idx"
                                    :disable-transitions="true"
                                    @click="selectService(idx)"
                                >
                                    {{ data.name.toUpperCase() }}
                                </el-tag>
                            </div>
                        </template>
                        <template v-if="type == 'caja/rooms'">
                            <div class="col-12">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.description
                                    }"
                                >
                                    <label class="control-label"
                                        >Contiene</label
                                    >
                                    <el-input
                                        v-model="detail"
                                        type="textarea"
                                        readonly
                                        :rows="3"
                                    ></el-input>

                                    <small
                                        class="text-danger"
                                        v-if="errors.description"
                                        v-text="errors.description[0]"
                                    ></small>
                                </div>
                            </div>
                            <div
                                class="d-flex flex-wrap justify-content-center p-2"
                            >
                                <el-tag
                                    role="button"
                                    :type="
                                        data.selected ? 'success' : 'primary'
                                    "
                                    style="margin-right:5px;margin-top:5px"
                                    v-for="(data, idx) in tags"
                                    :key="idx"
                                    :disable-transitions="true"
                                    @click="select(idx)"
                                >
                                    {{ data.description }}
                                </el-tag>
                                <template v-if="tags.length == 0">
                                    <el-tag
                                        type="danger"
                                        :disable-transitions="true"
                                    >
                                        <span>
                                            PRESIONE <b>+ AGREGAR</b> PARA
                                            GUARDARLA
                                        </span>
                                    </el-tag>
                                </template>
                            </div>
                            <div
                                class="d-flex justify-content-end align-items-center"
                            >
                                <div class="col-md-3 col-lg-3 col-6">
                                    <el-input
                                        class="input-new-tag"
                                        @input="search"
                                        v-model="newTag"
                                        placeholder="Nueva obs.."
                                        size="medium"
                                    >
                                    </el-input>
                                </div>
                                <div>
                                    <el-button
                                        class="button-new-tag"
                                        size="small"
                                        style="margin-left: 10px;"
                                        type="primary"
                                        @click="handleInputConfirm"
                                        >+ Agregar</el-button
                                    >
                                </div>
                            </div>
                        </template>
                    </template>
                </div>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button
                    type="primary"
                    native-type="submit"
                    :loading="loading_submit"
                    >Guardar</el-button
                >
            </div>
        </form>
        <mini-bar :showDialog.sync="showMinibar" :table_id="recordId">
        </mini-bar>
    </el-dialog>
</template>

<script>
import MiniBar from "./minibar.vue";
export default {
    props: [
        "showDialog",
        "recordId",
        "types",
        "type",
        "areas",
        "statusTable",
        "configurations",
        "establishments"
    ],
    components: {
        MiniBar
    },
    data() {
        return {
            newTag: null,
            loading_submit: false,
            titleDialog: null,
            resource: this.type,
            errors: {},
            tags: [],
            form: {},
            options: [],
            all_floors: [],
            all_services: [],
            floors: [],
            all_towers: [],
            towers: [],
            tower_id: null,
            detailsArray: [],
            detail: null,
            details: [],
            showMinibar: false
        };
    },
    created() {
        this.initForm();
    },
    methods: {
        minibar() {
            this.showMinibar = true;
        },
        async getDetails() {
            const response = await this.$http.get("/caja/rooms/detail_table");
            if (response.status == 200) {
                this.details = response.data.data;
                this.tags = this.details.slice(0, 10);
            } else {
                this.$toast.warning("Ocurrió un error");
            }
        },
        search(input) {
            this.tags = this.details
                .filter(o => o.description.includes(input.toUpperCase()))
                .slice(0, 10);
        },
        async handleInputConfirm() {
            if (this.newTag) {
                if (this.newTag.trim().length > 1) {
                    let toAdd = this.newTag.toUpperCase();

                    try {
                        this.loading = true;
                        const response = await this.$http.post(
                            "/caja/rooms/detail_table",
                            {
                                description: toAdd,
                                active: 1
                            }
                        );
                        if (response.status == 200) {
                            this.tags.push({
                                description: toAdd,
                                selected: true,
                                active: 1
                            });
                            this.addWord(toAdd);
                            this.formatObs();

                            // this.$emit("update:details", [
                            //     ...this.details,
                            //     ...this.tags
                            // ]);
                            // this.tags = this.details.slice(0, 10);
                        } else {
                            if (response.status == 422) {
                                this.$toast.error("La obse ya existe.");
                            } else {
                                this.$toast.error("No se guardó la obs.");
                            }
                        }
                    } catch (e) {
                        console.log(e);
                        const { response } = e;
                        if (response.status == 422) {
                            this.$toast.error("La observación ya existe.");
                        } else {
                            this.$toast.error("No se guardó la obs.");
                        }
                    } finally {
                        this.loading = false;
                    }
                }
            }

            this.newTag = null;
        },
        removeWord(word) {
            this.detailsArray = this.detailsArray.filter(o => o != word);
        },
        addWord(word) {
            this.detailsArray.push(word);
        },
        formatObs() {
            this.detail = this.detailsArray.join(" / ");
        },
        initForm() {
            this.detailsArray = [];

            this.detail = null;
            this.errors = {};
            this.form = {
                has_frigobar: false,
                description: null,
                id: null,
                description: null,
                printer: null,
                copies: null,
                active: 1,
                tower_id: null,
                price: 0,
                month_price: 0,
                floor_id: null
            };
        },
        async getTables() {
            const response = await this.$http("/caja/rooms/tables");
            if (response.status == 200) {
                const { towers, floors, services } = response.data;
                this.all_services = services;
                this.all_services = this.all_services.map(s => ({
                    ...s,
                    selected: false
                }));
                this.all_floors = floors;
                this.all_towers = towers;
                this.towers = towers;
                let [tower] = towers;
                this.form.tower_id = tower.id;

                this.filterFloorsByTower(tower.id);
            } else {
                this.$toast.warning("Ocurrió un error");
            }
        },
        filterFloorsByTower(tower_id) {
            this.form.floor_id = null;
            this.form.tower_id = tower_id;
            this.floors = this.all_floors.filter(f => {
                return f.tower_id == tower_id;
            });
        },
        selectService(idx) {
            this.all_services[idx].selected = !this.all_services[idx].selected;
        },
        select(idx) {
            this.tags[idx].selected = !this.tags[idx].selected;
            if (this.tags[idx].selected) {
                this.addWord(this.tags[idx].description);
            } else {
                this.removeWord(this.tags[idx].description);
            }
            this.formatObs();
        },

        restoreDetail() {
            this.tags = this.details.slice(0, 10).map(o => ({
                ...o,
                description: o.description.toUpperCase(),
                selected: false
            }));
            this.detailsArray = [];
            this.newTag = null;

            if (this.detail && this.detail.length > 0) {
                this.restore();
            }
        },
        restore() {
            let obs = this.detail.split(" / ");
            this.detailsArray = obs;
            let tgs = this.tags.map(t => t.description);
            let idxs = [];
            for (let i = 0; i < tgs.length; i++) {
                let wd = tgs[i];

                if (obs.some(t => t == wd)) {
                    idxs.push(i);
                }
            }
            if (idxs.length != 0) {
                idxs.forEach(i => {
                    this.tags[i].selected = true;
                });
            }
        },
        async create() {
            await this.getTables();
            this.getDetails();
            this.titleDialog = this.recordId
                ? "Modificar Registro"
                : "Nuevo Registro";
            this.initForm();
            if (this.recordId) {
                const response = await this.$http.get(
                    `/${this.resource}/record/${this.recordId}`
                );

                this.form = response.data.data;
                let { floor, description } = this.form;
                this.detail = description;
                this.restoreDetail();
                this.form.tower_id = floor.tower_id;
                this.filterFloorsByTower(floor.tower_id);
                this.form.floor_id = floor.id;
                this.all_services = this.all_services.map(s => {
                    if (
                        this.form.services.some(
                            srv => srv.room_service_id == s.id
                        )
                    ) {
                        return {
                            ...s,
                            selected: true
                        };
                    }
                    return s;
                });
            }

            if (this.type == "caja/rooms") {
                let area = this.areas.find(
                    area => area.description.toUpperCase() == "HOTEL"
                );
                if (area) {
                    this.form.area_id = area.id;
                }

                if (!this.recordId) {
                    let status = this.statusTable.find(
                        status => status.description.toUpperCase() == "LIBRE"
                    );
                    if (status) {
                        this.form.status_table_id = status.id;
                    }
                }
                if (this.types.length > 0) {
                    this.form.table_type_id = this.types[0].id;
                }
            }
        },
        validRoom() {
            if (this.type == "caja/rooms") {
                this.form.description = this.detail;
                let pass = true;
                let {
                    number,
                    floor_id,
                    table_type_id,
                    price,
                    status_table_id,
                    establishment_id
                } = this.form;
                if (!number) {
                    this.$toast.error("El número de habitación es requerido");
                    pass = false;
                }
                if (!floor_id) {
                    this.$toast.error("El piso es requerido");
                    pass = false;
                }
                if (!table_type_id) {
                    this.$toast.error("El tipo de habitación es requerido");
                    pass = false;
                }
                if (!price) {
                    this.$toast.error("El precio es requerido");
                    pass = false;
                }
                if (!status_table_id) {
                    this.$toast.error("El estado es requerido");
                    pass = false;
                }
                if (!establishment_id) {
                    this.$toast.error("El establecimiento es requerido");
                    pass = false;
                }
                return pass;
            }
            return true;
        },
        submit() {
            if (!this.validRoom()) {
                return;
            }
            this.loading_submit = true;
            this.form.services = this.all_services
                .filter(s => s.selected)
                .map(s => s.id);
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
