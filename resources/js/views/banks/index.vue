<!-- Módulo de Bancos -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card">
                <div class="card-header bg-primary d-flex align-items-center" style="padding: 8px;">
                    <h4 class="my-0 text-white d-flex align-items-center" style="font-size: 1rem; font-weight: bold;">
                        <i class="fas fa-university" style="font-size: 1rem; margin-right: 0.5rem;"></i>
                        Módulo de Bancos
                    </h4>
                </div>
                <!-- <div class="data-table-visible-columns">
                    <el-button class="btn_titulos_modal" href="javascript:void(0)" @click.prevent="clickCreate()">
                        <i class="fas fa-university fa-lg"></i>
                        <i class="fa fa-plus"></i>
                        <span style="color: #000; font-size: 1.25rem; font-weight: bold;">Nuevo Banco</span>
                    </el-button>
                </div> -->
                <div class="data-table-visible-columns">
                    <el-button class="btn_guardarsmall" type="primary" href="javascript:void(0)" @click.prevent="clickCreate()">
                        <i class="fa fa-plus"></i>
                        <span >Nuevo</span>
                    </el-button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover custom-table">
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th class="text-center">#</th>
                                    <th class="text-center">Descripción</th>
                                    <th class="text-center">Imagen</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in records" :key="index"
                                    :class="index % 2 === 0 ? 'table-row-even' : 'table-row-odd'">
                                    <td class="text-center">{{ index + 1 }}</td>
                                    <td class="text-center">{{ row.description }}</td>
                                    <td class="text-center">
                                        <template v-if="row.image">
                                            <img :src="row.image" alt="image" class="img-thumbnail"
                                                style="width: 100px; height: 100px; object-fit: cover; cursor: pointer;"
                                                @click="clickUploadImage(row.id)" />
                                            <button class="btn btn-danger btn-sm" @click="clickDeleteImage(row.id)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button class="btn btn-primary" @click="clickUploadImage(row.id)">
                                                <i class="fa fa-upload"></i> Subir Imagen
                                            </button>
                                        </template>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown">
                                                Acciones
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item text-info"
                                                        @click.prevent="clickCreate(row.id)">
                                                        <i class="fa fa-edit"></i> Editar
                                                    </a>
                                                </li>
                                                <li v-if="typeUser === 'admin' || typeUser === 'superadmin'">
                                                    <a class="dropdown-item text-danger"
                                                        @click.prevent="clickDelete(row.id)">
                                                        <i class="fa fa-trash"></i> Eliminar
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <input type="file" id="file" ref="file" style="display: none" @change="uploadImage"
                        accept="image/*" />
                </div>
                <banks-form :showDialog.sync="showDialog" :recordId="recordId"></banks-form>
            </div>
        </div>
    </div>
</template>

<script>
import BanksForm from "./form.vue";
import { deletable } from "../../mixins/deletable";

export default {
    mixins: [deletable],
    props: ["typeUser"],
    components: {
        BanksForm
    },
    data() {
        return {
            title: "Bancos",
            showDialog: false,
            resource: "banks",
            recordId: null,
            records: []
        };
    },
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getData();
        });
        this.getData();
    },
    methods: {
        clickDeleteImage(id) {
            this.$http
                .delete(`/${this.resource}/${id}/delete-image`)
                .then(() => {
                    this.getData();
                })
                .catch(() => {
                    this.$toast.error("Error al eliminar la imagen");
                });
        },
        uploadImage(event) {
            const formData = new FormData();
            let file = event.target.files[0];
            if (!file.type.includes("image")) {
                this.$toast.error("Solo se permiten imagenes");
                return;
            }
            formData.append("image", file);
            formData.append("bank_id", this.recordId);
            this.$http
                .post(
                    `/${this.resource}/${this.recordId}/upload-image`,
                    formData
                )
                .then(() => {
                    this.getData();
                })
                .catch(() => {
                    this.$toast.error("Error al subir la imagen");
                })
                .finally(() => {
                    this.$refs.file.value = "";
                });
        },
        clickUploadImage(id) {
            this.recordId = id;
            if (this.$refs.file && id) {
                this.$refs.file.click();
            }
        },
        getData() {
            this.$http.get(`/${this.resource}/records`).then(response => {
                this.records = response.data.data;
            });
        },
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
