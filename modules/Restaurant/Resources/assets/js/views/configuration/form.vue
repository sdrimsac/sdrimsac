<!-- Nueva mesa -->
<!-- Nueva Habitacion -->
<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
        append-to-body
        :close-on-click-modal="false"
        class="rounded-dialog"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <br />
                <div class="row">
                    <div
                        v-if="type !== 'caja/tables' && type !== 'caja/rooms'"
                        class="col-md-12"
                    >
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.description }"
                        >
                            <label class="control-label">
                                <i class="fas fa-info-circle mr-2"></i>
                                Producto
                            </label>
                            <el-select v-model="form.item_id" 
                            clearable
                            filterable
                            placeholder="Seleccione un producto"
                            >
                                <el-option
                                    v-for="(data, index) in items"
                                    :key="index"
                                    :label="data.description"
                                    :value="data.id"
                                ></el-option>
                            </el-select>
                            <!-- <el-input v-model="form.description"></el-input> -->
                            <small
                                class="text-danger"
                                v-if="errors.description"
                                v-text="errors.description[0]"
                            ></small>
                        </div>
                    </div>
                    <div
                        v-if="type !== 'caja/tables' && type !== 'caja/rooms'"
                        class="col-md-12"
                    >
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.description }"
                        >
                            <label class="control-label">
                                <i class="fas fa-info-circle mr-2"></i>
                                Descripción
                            </label>
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
                            <label class="control-label">
                                <i class="fas fa-print mr-2"></i> Impresora
                            </label>
                            <el-input v-model="form.printer"></el-input>
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
                            <label class="control-label">
                                <i class="fas fa-copy mr-2"></i> Nº COPIAS
                            </label>
                            <el-input v-model="form.copies"></el-input>
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
                                <label class="control-label">
                                    <i class="fas fa-hashtag mr-2"></i>
                                    Número de
                                    {{
                                        // type == "caja/tables" ? "mesa" : type === 'billar' ? 'mesa billar' : "habitación"
                                        //type === 'caja/tables' ? 'mesa' : 'habitacion' : 'Mesa Billar'
                                        getLabelText(type)
                                    }}
                                </label>
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
                                <label class="control-label">
                                    <i class="fas fa-building mr-2"></i> Torre
                                </label>
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
                                <label class="control-label">
                                    <i class="fas fa-layer-group mr-2"></i> Piso
                                </label>
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
                                <label class="control-label">
                                    <i class="fas fa-bed mr-2"></i> Tipo
                                </label>
                                <el-select
                                    v-model="form.table_type_id"
                                    @change="updatePrice"
                                >
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
                                <label class="control-label">
                                    <i class="fas fa-dollar-sign mr-2"></i>
                                    Precio
                                </label>
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
                                <label class="control-label">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    Precio mensual
                                </label>
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
                                <label class="control-label">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Estado de
                                    {{
                                        //type == "caja/tables" ? "mesa" : "habitación"
                                        getLabelText(type)
                                    }}
                                </label>
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
                                <label class="control-label">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    Área de
                                    {{
                                        //type == "caja/tables" ? "mesa" : "habitación"
                                        getLabelText(type)
                                    }}
                                </label>
                                <el-select v-model="form.area_id">
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
                                :class="{ 'has-danger': errors.zone_id }"
                            >
                                <label class="control-label">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    Ubicación de
                                    {{
                                        //type == "caja/tables" ? "mesa" : "habitación"
                                        getLabelText(type)
                                    }}
                                </label>
                                <el-select v-model="form.zone_id">
                                    <el-option
                                        v-for="(data, index) in zones"
                                        :key="index"
                                        :label="data.name"
                                        :value="data.id"
                                    ></el-option>
                                </el-select>
                                <small
                                    class="text-danger"
                                    v-if="errors.zone_id"
                                    v-text="errors.zone_id[0]"
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
                                <label class="control-label">
                                    <i class="fas fa-store mr-2"></i>
                                    Establecimiento
                                </label>
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
                                    <i class="fas fa-snowflake mr-2"></i> ¿Tiene
                                    frigobar?
                                </el-checkbox>
                            </div>
                            <div class="col-12">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.all_services
                                    }"
                                >
                                    <label class="control-label">
                                        <i
                                            class="fas fa-concierge-bell mr-2"
                                        ></i>
                                        Servicios
                                    </label>
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
                                    >{{ data.name.toUpperCase() }}</el-tag
                                >
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
                                    <label class="control-label">
                                        <i class="fas fa-list mr-2"></i>
                                        Contiene
                                    </label>
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
                                    @click.prevent="select(idx)"
                                    >{{ data.description }}</el-tag
                                >
                                <template v-if="tags.length == 0">
                                    <el-tag
                                        type="danger"
                                        :disable-transitions="true"
                                    >
                                        <span>
                                            PRESIONE
                                            <b>+ AGREGAR</b> PARA GUARDARLA
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
                                    ></el-input>
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
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label class="control-label">
                                        <i class="fas fa-images mr-2"></i>
                                        Imágenes de la habitación (Máximo 5)
                                    </label>
                                    <div
                                            class="d-block"
                                            v-if="
                                                form.images &&
                                                    getTotalImagesCount < 5
                                            "
                                        >
                                            <input
                                                type="file"
                                                ref="fileInput"
                                                accept="image/*"
                                                class="d-none"
                                                @change="handleImageUpload"
                                            />
                                            <button
                                                @click.prevent="
                                                    $refs.fileInput.click()
                                                "
                                                class="btn btn-primary"
                                            >
                                                <i class="fas fa-plus mr-2"></i>
                                                Agregar imagen ({{
                                                    5 - getTotalImagesCount
                                                }}
                                                restantes)
                                            </button>
                                        </div>
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        <div
                                            v-for="(image,
                                            index) in form.images"
                                            :key="index"
                                        >
                                            <div
                                                class="position-relative me-2 mb-2"
                                            >
                                                <img
                                                    :src="
                                                        image.preview ||
                                                            image.url
                                                    "
                                                    class="img-thumbnail"
                                                    style="width: 100px; height: 100px; object-fit: cover;"
                                                />
                                                <button
                                                    @click.prevent="
                                                        removeImageLocal(index)
                                                    "
                                                    class="btn btn-danger btn-sm position-absolute"
                                                    style="top: -10px; right: -10px;"

                                                >
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    
                                    </div>

                                    <small class="text-muted">
                                        Formatos permitidos: JPG, PNG. Tamaño
                                        máximo: 10MB
                                    </small>
                                    <small
                                        class="text-danger"
                                        v-if="errors.images"
                                        v-text="errors.images[0]"
                                    ></small>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div
                                    class="form-group"
                                    v-if="
                                        form.images_uploaded &&
                                            form.images_uploaded.length > 0
                                    "
                                >
                                    <label class="control-label">
                                        <i class="fas fa-images mr-2"></i>
                                        Imágenes subidas
                                    </label>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <div
                                        v-for="(image,
                                        index) in form.images_uploaded"
                                        :key="index"
                                        class="position-relative me-2 mb-2"
                                    >
                                        <img
                                            :src="image.image_path"
                                            class="img-thumbnail"
                                            style="width: 100px; height: 100px; object-fit: cover;"
                                        />
                                        <button
                                            @click.prevent="removeImage(index)"
                                            class="btn btn-danger btn-sm position-absolute"
                                            style="top: -10px; right: -10px;"
                                        >
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </template>
                </div>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <el-button icon="fas fa-times fa-lg" @click.prevent="close()"
                    >Cancelar</el-button
                >
                <el-button
                    type="primary"
                    icon="fas fa-save fa-lg"
                    native-type="submit"
                    :loading="loading_submit"
                    >Guardar</el-button
                >
            </div>
        </form>

        <mini-bar
            :showDialog.sync="showMinibar"
            :table_id="recordId"
        ></mini-bar>
    </el-dialog>
</template>

<style>
.el-dialog {
    border-radius: 10px;
    overflow: hidden;
}
.gap-2 {
    gap: 0.5rem;
}
</style>

<script>
import MiniBar from "./minibar.vue";
export default {
    props: [
        "showDialog",
        "recordId",
        "types",
        "type",
        "areas",
        "zones",
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
            form: {
                images: []
            },
            options: [],
            all_floors: [],
            all_services: [],
            floors: [],
            all_towers: [],
            all_zones: [],
            towers: [],
            tower_id: null,
            detailsArray: [],
            detail: null,
            details: [],
            items: [],
            showMinibar: false
        };
    },
    computed: {
        isRenta() {
            return this.configurations.mod_renta;
        },
        getTotalImagesCount() {
            const uploadedCount = this.form.images_uploaded
                ? this.form.images_uploaded.length
                : 0;
            const newImagesCount = this.form.images
                ? this.form.images.length
                : 0;
            return uploadedCount + newImagesCount;
        }
    },
    created() {
        this.initForm();
    },
    methods: {
        removeImageLocal(index) {
            this.form.images.splice(index, 1);
            this.$forceUpdate();
        },
        updatePrice() {
            if (this.isRenta) {
                let type = this.types.find(
                    t => t.id == this.form.table_type_id
                );
                if (type) {
                    this.form.price = type.price;
                    this.form.month_price = type.month_price;
                }
            }
        },
        getLabelText(type) {
            switch (type) {
                case "caja/tables":
                    return "mesa";
                case "caja/rooms":
                    return "habitación";
            }
        },
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
                table_type_id: null,
                establishment_id: null,
                area_id: null,
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
                floor_id: null,
                images: [],
                zone_id: null,
            };

            let [establishment] = this.establishments;
            if (establishment) {
                this.form.establishment_id = establishment.id;
            }
            let [area] = this.areas;
            if (area) {
                this.form.area_id = area.id;
            }
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
                let [floor] = floors;
                this.form.tower_id = tower.id;
                this.filterFloorsByTower(tower.id);
            } else {
                this.$toast.warning("Ocurrió un error");
            }
        },
        async getItems() {
            const response = await this.$http("/caja/observations/items");
            if (response.status == 200) {
                const { items } = response.data;
                this.items = items;
                
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
            let [floor] = this.floors;
            if (floor) {
                this.form.floor_id = floor.id;
            }
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
            /* if (configurations.mod_renta) { */
            this.getItems();
            /* } */
            if (this.type == "caja/rooms") {
                await this.getTables();
            }
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
                this.form.images = [];
                if (this.type === "caja/rooms") {
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
                let [tower] = this.towers;
                this.form.tower_id = tower.id;
                this.filterFloorsByTower(tower.id);
                if (this.isRenta) {
                    this.updatePrice();
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
        handleImageUpload(event) {
            event.preventDefault();
            const file = event.target.files[0];
            if (!file) return;

            // Validar tamaño (10MB máximo) 
            if (file.size > 10 * 1024 * 1024) {
                this.$toast.error("La imagen no debe superar los 10MB");
                return;
            }

            // Validar tipo de archivo
            if (!file.type.match("image.*")) {
                this.$toast.error("Por favor seleccione una imagen válida");
                return;
            }

            // Verificar límite total de imágenes
            if (this.getTotalImagesCount >= 5) {
                this.$toast.error("Máximo 5 imágenes permitidas");
                return;
            }

            // Crear preview y añadir a la lista
            const reader = new FileReader();
            reader.onload = e => {
                // Usar this.$set para asegurar reactividad al modificar el array
                const newImages = [...this.form.images];
                newImages.push({
                    file: file,
                    preview: e.target.result
                });
                this.$set(this.form, 'images', newImages);
                this.$forceUpdate();
            };
            reader.readAsDataURL(file);
            event.target.value = ""; // Resetear input
        },
        removeImage(index) {
            this.$confirm(
                "¿Estás seguro de querer eliminar esta imagen?",
                "Eliminar imagen",
                {
                    confirmButtonText: "Eliminar",
                    cancelButtonText: "Cancelar",
                    type: "warning"
                }
            ).then(() => {
                let image = this.form.images_uploaded[index];
                this.$http
                    .delete(`/${this.resource}/delete_image/${image.id}`)
                    .then(response => {
                        if (response.status == 200) {
                            this.form.images_uploaded.splice(index, 1);
                        }
                    });
            });
        },

        async submit() {
            if (!this.validRoom()) return;

            this.loading_submit = true;
            const formData = new FormData();

            // Obtener servicios seleccionados
            const selectedServices = this.all_services
                .filter(s => s.selected)
                .map(s => s.id);

            // Crear una copia del form sin los servicios para evitar duplicación
            const formCopy = { ...this.form };
            delete formCopy.services; // Eliminar servicios del objeto principal

            // Añadir el resto de propiedades del form
            Object.keys(formCopy).forEach(key => {
                if (key === "images") {
                    this.form.images.forEach((image, index) => {
                        if (image.file) {
                            formData.append(`images[${index}]`, image.file);
                        }
                    });
                } else {
                    if (formCopy[key] !== null && formCopy[key] !== undefined) {
                        formData.append(key, formCopy[key]);
                    }
                }
            });

            // Añadir servicios una sola vez
            formData.append("services", JSON.stringify(selectedServices));
            // Eliminar valores null o undefined de formData
            for (let [key, value] of formData.entries()) {
                if (value === 'null' || value === 'undefined') {
                    formData.delete(key);
                }
            }
            try {
                const response = await this.$http.post(
                    `/${this.resource}`,
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        }
                    }
                );

                if (response.data.success) {
                    this.$showSAlert(response.data.message, "success");
                    this.$eventHub.$emit("reloadData");
                    this.close();
                } else {
                    this.$toast.error(response.data.message);
                }
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors = error.response.data;
                    this.$toast.error("Ocurrió un error / Verifique los datos");
                } else {
                    console.log(error);
                }
            } finally {
                this.loading_submit = false;
            }
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        }
    }
};
</script>
