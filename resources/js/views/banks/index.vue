<!-- Listado de Bancos -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>
                            <span>{{ title }}</span>
                        </h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">{{ title }}</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white">
                    <i class="fas fa-university"></i> Listado de Bancos
                </h4>
                <div class="card-actions white-text">
                    <a
                        href="#"
                        class="card-action card-action-toggle text-white"
                        data-card-toggle=""
                    ></a>
                    <a
                        href="#"
                        class="card-action card-action-dismiss text-white"
                        data-card-dismiss=""
                    ></a>
                </div>
            </div>
            <div class="data-table-visible-columns">
                <el-button
                    type="primary"
                    class=""
                    href="javascript:void(0)"
                    @click.prevent="clickCreate()"
                >
                    <i class="fas fa-university fa-lg"></i>
                    <i class="fa fa-plus"></i>
                    Nuevo Banco
                </el-button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr slot="heading" class="bg-primary">
                                <th class="text-white">#</th>
                                <th class="text-white">Descripción</th>
                                <th class="text-white">Imagen</th>
                                <th class="text-white text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in records" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ row.description }}</td>
                                <td>
                                    <!-- si la imagen existe mostrarla y al darle click abrir el dialog de archivo para subir otra imagen y reemplazar la  anterior, si no existe mostrar un boton para subir la imagen             -->
                                    <template v-if="row.image">
                                        <img
                                            :src="row.image"
                                            alt="image"
                                            class="img-thumbnail"
                                            style="width: 100px; height: 100px; object-fit: cover; cursor: pointer;"
                                            @click="clickUploadImage(row.id)"
                                        />
                                        <button
                                            class="btn btn-danger btn-sm"
                                            @click="clickDeleteImage(row.id)"
                                        >
                                            <i class="fa fa-trash"></i> 
                                            
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button
                                            class="btn btn-primary"
                                            @click="clickUploadImage(row.id)"
                                        >
                                            <i class="fa fa-upload"></i> Subir
                                            Imagen
                                        </button>
                                    </template>
                                </td>
                                <td class="text-end">
                                    <button
                                        class="btn p-0"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        <span
                                            class="btn btn-primary dropdown-toggle"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-delay="0"
                                            title=""
                                            data-bs-original-title="Item Count"
                                            aria-label="Item Count"
                                            >Acciones</span
                                        >
                                    </button>
                                    <div
                                        class="dropdown-menu dropdown-menu-end"
                                        style=""
                                    >
                                        <a
                                            type="button"
                                            class="dropdown-item text-secondary"
                                            @click.prevent="clickCreate(row.id)"
                                        >
                                            <i class="fa fa-edit"></i> Editar
                                        </a>
                                        <template
                                            v-if="
                                                typeUser === 'admin' ||
                                                    typeUser === 'superadmin'
                                            "
                                        >
                                            <a
                                                type="button"
                                                class="dropdown-item text-danger"
                                                @click.prevent="
                                                    clickDelete(row.id)
                                                "
                                            >
                                                <i class="fa fa-trash"></i>
                                                Eliminar
                                            </a>
                                        </template>
                                        <!-- <a type="button" class="dropdown-item text-warning" @click.prevent="
                                    clickDisable(row.id)" v-if="row.active">Inhabilitar
                                </a>
                                <a type="button" class="dropdown-item text-success" @click.prevent="
                                    clickEnable(row.id)" v-else>Habilitar
                                </a> -->
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <input
                    type="file"
                    id="file"
                    ref="file"
                    style="display: none"
                    @change="uploadImage"
                    accept="image/*"
                />
            </div>
            <banks-form
                :showDialog.sync="showDialog"
                :recordId="recordId"
            ></banks-form>
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
