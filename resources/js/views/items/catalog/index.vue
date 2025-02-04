<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>
                            <span>Crear Catalogos de Productos</span>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h4 class="my-0 text-white">
                        <i class="fas fa-file-alt"></i>
                        Crear Catalogos Productos
                    </h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-4 pb-2">
                                <label>Categoria</label>
                                <el-select
                                    v-model="search.category_id"
                                    placeholder="Seleccione un tipo de producto"
                                    clearable
                                >
                                    <el-option
                                        v-for="option in categories"
                                        :key="option.id"
                                        :value="option.id"
                                        :label="option.name"
                                    ></el-option>
                                </el-select>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 pb-2">
                                <label>Buscar</label>
                                <el-input
                                    v-model="search.description"
                                    placeholder="Buscar producto"
                                    @input="getRecords"
                                    clearable
                                ></el-input>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 pb-2">
                                <!-- <el-button
                                    @click="toggleCatalog"
                                    :type="
                                        isCatalogEnabled ? 'danger' : 'success'
                                    "
                                    >{{
                                        isCatalogEnabled
                                            ? "Desactivar Catálogo completo"
                                            : "Activar Catálogo completo"
                                    }}</el-button
                                > -->
                                <el-button
                                    type="succces"
                                    @click="sendToCatalog"
                                >
                                    armar catalogo
                                </el-button>
                                <!-- </div> -->
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 pb-2">
                                <!-- <div class="text-end mb-3"> -->
                                <div class="text-end mb-3">
                                    <el-button type="danger" @click="printPDF">
                                        <i class="fas fa-print"></i> Generar PDF
                                    </el-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="container">
                                    <div
                                        v-for="(image, index) in images"
                                        :key="index"
                                        class="image-view"
                                    >
                                        <h5>
                                            {{
                                                index === 0
                                                    ? "Aqui va la imagen de la caratula de fondo a4"
                                                    : index === 1
                                                    ? "Aqui va la iamgen de fondo para los productos a4"
                                                    : "Aqui va la imagen de fondo para el la pasta trasera a4"
                                            }}
                                        </h5>
                                        <el-upload
                                            class="avatar-uploader text-center bg-light"
                                            action="catalog/upload"
                                            :headers="headers"
                                            :show-file-list="false"
                                            :on-success="
                                                response =>
                                                    handleAvatarSuccess(
                                                        response,
                                                        index
                                                    )
                                            "
                                            :before-upload="beforeAvatarUpload"
                                            :data="{ column: image.column }"
                                        >
                                            <img
                                                v-if="image.url"
                                                :src="image.url"
                                                class="avatar"
                                            />
                                            <i
                                                v-else
                                                class="el-icon-plus avatar-uploader-icon"
                                            ></i>
                                        </el-upload>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="text-white">
                                                    codigo
                                                </th>
                                                <th class="text-white">
                                                    Descripción
                                                </th>
                                                <th class="text-white">
                                                    Precio
                                                </th>
                                                <th class="text-white">
                                                    Seleccionar
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(row, index) in records"
                                                :row="row"
                                                :index="customIndex(index)"
                                                :key="index"
                                            >
                                                <td>
                                                    {{ row.internal_id }}
                                                </td>
                                                <td>
                                                    {{ row.description }}
                                                </td>
                                                <td>
                                                    S/.
                                                    {{ row.sale_unit_price }}
                                                </td>
                                                <td>
                                                    <!-- <el-checkbox>
                                                        {{ row.id }}
                                                    </el-checkbox> -->
                                                    <input
                                                        type="checkbox"
                                                        v-model="
                                                            selectedProducts
                                                        "
                                                        :value="row.id"
                                                    />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div>
                                        <el-pagination
                                            @current-change="getRecords"
                                            layout="total, prev, pager, next"
                                            :total="pagination.total"
                                            :current-page.sync="
                                                pagination.current_page
                                            "
                                            :page-size="pagination.per_page"
                                        >
                                        </el-pagination>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div
                                    class="scrollable-content"
                                    style="height: 1000px; overflow-y: auto;"
                                    ref="printSection"
                                >
                                    <div class="pdf-preview">
                                        <!-- Página de caratula -->
                                        <div
                                            class="pdf-page cover-page mb-4"
                                            :style="{
                                                minHeight: '1000px',

                                                backgroundImage: `url(${images[0].url})`,
                                                backgroundSize: 'cover',
                                                backgroundPosition: 'center',
                                                backgroundRepeat: 'no-repeat',
                                                position: 'relative'
                                            }"
                                        >
                                            <!-- Add a semi-transparent overlay to ensure text remains readable -->
                                            <div
                                                class="text-center py-3"
                                                style="position: relative;"
                                            >
                                                <h1>Catálogo de Productos</h1>
                                                <img
                                                    :src="
                                                        '/storage/uploads/logos/' +
                                                            company.logo
                                                    "
                                                    alt="Logo"
                                                    class="my-4"
                                                    style="max-width: 200px;"
                                                    v-if="company.logo"
                                                />
                                                <h3>
                                                    {{ company.trade_name }}
                                                </h3>
                                                <p class="mt-3">
                                                    {{
                                                        new Date().toLocaleDateString()
                                                    }}
                                                </p>
                                                <div
                                                    class="spacer"
                                                    style="height: 400px;"
                                                ></div>
                                                <h4>Contacto:</h4>
                                                <p>
                                                    Teléfono:
                                                    {{
                                                        establishment.telephone
                                                    }}
                                                </p>
                                                <p>
                                                    Email:
                                                    {{ establishment.email }}
                                                </p>
                                                <p>
                                                    Dirección:
                                                    {{ establishment.address }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Página de productos -->
                                        <div>
                                            <template v-for="(category, catIndex) in categories">
                                                <template v-if="items.filter(item => item.category_id === category.id).length > 0">
                                                    <div
                                                        v-for="(chunk, chunkIndex) in Math.ceil(
                                                            items.filter(item => item.category_id === category.id).length / 9
                                                        )"
                                                        :key="`${catIndex}-${chunkIndex}`"
                                                        class="pdf-page products-page"
                                                        :style="{
                                                            minHeight: '1000px',
                                                            padding: '20px',
                                                            backgroundImage: `url(${images[1].url})`,
                                                            backgroundSize: 'cover',
                                                            backgroundPosition: 'center',
                                                            backgroundRepeat: 'no-repeat',
                                                            position: 'relative'
                                                        }"
                                                    >
                                                        <h6 class="category-title mb-3 text-center">{{ category.name }}</h6>
                                                        <div class="row g-2">
                                                            <div
                                                                v-for="(product, index) in items
                                                                    .filter(item => item.category_id === category.id)
                                                                    .slice(chunkIndex * 9, (chunkIndex + 1) * 9)"
                                                                :key="index"
                                                                class="col-4"
                                                                style="height: 280px; margin-bottom: 10px; padding: 0 5px;"
                                                            >
                                                                <div
                                                                    class="card mx-auto"
                                                                    style="width: 170px; height: 270px;"
                                                                >
                                                                    <img
                                                                        :src="product.image_url"
                                                                        class="card-img-top"
                                                                        alt="Producto"
                                                                        style="height: 140px; object-fit: contain; padding: 5px;"
                                                                    />
                                                                    <div class="card-body p-2">
                                                                        <h6
                                                                            class="card-title mb-1 fw-bold"
                                                                            style="font-size: 12px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                                                        >
                                                                            {{ product.internal_id }}
                                                                        </h6>
                                                                        <p
                                                                            class="card-text mb-1 fw-bold"
                                                                            style="font-size: 11px; height: 40px; overflow: hidden;"
                                                                        >
                                                                            {{ product.description }}
                                                                        </p>
                                                                        <p
                                                                            class="card-text mb-0"
                                                                            style="font-size: 16px; margin-top: 5px;"
                                                                        >
                                                                            <strong style="color: #000000;">
                                                                                S/. {{ product.sale_unit_price }}
                                                                            </strong>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </template>
                                        </div>

                                        <!-- Página final (contraportada) -->
                                        <div
                                            class="pdf-page back-cover"
                                            :style="{
                                                minHeight: '1000px',

                                                pageBreakBefore: 'always',
                                                backgroundImage: `url(${images[2].url})`,
                                                backgroundSize: 'cover',
                                                backgroundPosition: 'center',
                                                backgroundRepeat: 'no-repeat',
                                                position: 'relative'
                                            }"
                                        >
                                            <div
                                                class="text-center d-flex flex-column justify-content-center"
                                                style="height: 100%; position: relative; padding-top: 200px;"
                                            >
                                                <div style="margin-top: 100px;">
                                                    <img
                                                        :src="
                                                            '/storage/uploads/logos/' +
                                                                company.logo
                                                        "
                                                        alt="Logo"
                                                        class="my-4"
                                                        style="max-width: 200px;"
                                                        v-if="company.logo"
                                                    />
                                                    <h3>
                                                        TODO LOS DERECHOS
                                                        RESERVADOS
                                                    </h3>
                                                    <p class="mt-3">
                                                        {{
                                                            new Date().toLocaleDateString()
                                                        }}
                                                    </p>
                                                </div>
                                                <div
                                                    class="contact-info mt-auto"
                                                >
                                                    <h4>Contacto:</h4>
                                                    <template
                                                        v-if="establishment"
                                                    >
                                                        <p>
                                                            Teléfono:
                                                            {{
                                                                establishment.telephone ||
                                                                    "No disponible"
                                                            }}
                                                        </p>
                                                        <p>
                                                            Email:
                                                            {{
                                                                establishment.email ||
                                                                    "No disponible"
                                                            }}
                                                        </p>
                                                        <p>
                                                            Dirección:
                                                            {{
                                                                establishment.address ||
                                                                    "No disponible"
                                                            }}
                                                        </p>
                                                    </template>
                                                    <template v-else>
                                                        <p>
                                                            Información de
                                                            contacto no
                                                            disponible
                                                        </p>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.pdf-preview {
    background: white;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.pdf-page {
    border: 1px solid #ddd;
    padding: 40px;
    margin-bottom: 20px;
}
.cover-page {
    min-height: 800px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
<script>
import queryString from "query-string";
export default {
    props: ["just_sale_notes", "soapCompany", "configuration", "user_type"],
    /* components: {
        DataTable
    }, */
    data() {
        return {
            establishment: {
                telephone: "",
                email: "",
                address: ""
            }, // Inicialización con estructura
            selectedProducts: [],
            headers: headers_token,
            images: [
                { column: "image_past", url: null },
                { column: "image_fond", url: null },
                { column: "image_footer", url: null }
            ],
            isCatalogEnabled: false,
            /* enableCatalog: false, */
            originalContents: "",
            printState: false,
            cashId: null,
            resource: "catalog",
            saleNotesNewId: null,
            recordId: null,
            currentNumber: null,
            boxes: [],
            editSale: false,
            showDialogOptions: false,
            categories: [],
            company: {},
            search: {
                category_id: null,
                warehouse_id: 1,
                value: null,
                active: null,
                description: null
            },
            pagination: {
                current_page: 1,
                total: 0,
                per_page: 20,
                from: 1
            },
            records: [],
            loading: false,
            time: null,
            items: []
        };
    },
    watch: {
        "search.category_id": {
            handler(newVal) {
                this.pagination.current_page = 1; // Reset pagination cuando cambia la categoría
                this.getRecords();
            }
        },
        "search.description": {
            handler(newVal) {
                this.pagination.current_page = 1; // Reset pagination cuando cambia la búsqueda
                this.getRecords();
            }
        }
    },
    /* mounted() {
        this.fetchImages();
    }, */
    created() {},
    async mounted() {
        try {
            const response = await this.$http.get(`/${this.resource}/tables`);
            console.log("Respuesta completa:", response.data); // Debugging

            this.categories = response.data.categories;
            this.company = response.data.company;

            // Verificación y asignación segura
            if (response.data.establishment) {
                this.establishment = response.data.establishment;
            } else {
            }
        } catch (error) {
            this.$message.error("Error al cargar datos del establecimiento");
        }

        // ...resto del mounted
        this.catalog();
        this.getRecords();
        this.fetchImages();
        this.listCatalog();
    },
    methods: {
        async sendToCatalog() {
            /* if (this.selectedProducts.length === 0) {
                this.$showSAlert(
                    "ALERTA",
                    "Debes seleccionar al menos un producto.",
                    "error"
                );
                return;
            } */

            try {
                const response = await this.$http.post(
                    "catalog/storeCatalog",
                    {
                        products: this.selectedProducts
                    },
                    {
                        headers: {
                            "Content-Type": "application/json"
                        }
                    }
                );

                if (response.data) {
                    this.$message.success("Catálogo armado con éxito");
                    this.enableCatalog = true;
                    this.selectedProducts = [];
                }
            } catch (error) {
                this.$message.error("Error al armar el catálogo");
            }
        },
        async listCatalog() {
            try {
                const response = await this.$http.post("catalog/storeCatalog");
                if (response.data) {
                    this.items = response.data.data;
                }
            } catch (error) {
                console.error("Error al cargar los registros:", error);
            }
        },
        async fetchImages() {
            try {
                const response = await this.$http.get("catalog/images");
                if (response && response.data) {
                    // Update images only if we have valid data
                    this.images = [
                        {
                            column: "image_past",
                            url: response.data.image_past || null
                        },
                        {
                            column: "image_fond",
                            url: response.data.image_fond || null
                        },
                        {
                            column: "image_footer",
                            url: response.data.image_footer || null
                        }
                    ];
                }
            } catch (error) {
                // Optionally show an error message to the user
                this.$message.error("Error al cargar las imágenes");
            }
        },
        handleAvatarSuccess(response, index) {
            this.images[index].url =
                response.catalog[this.images[index].column];
        },
        beforeAvatarUpload(file) {
            const isImage = file.type.startsWith("image/");
            if (!isImage) {
                this.$message.error("Solo se permiten imágenes.");
                return false;
            }
            return true;
        },
        catalog() {
            this.$http
                .get("catalog/getRecordsInfo")
                .then(response => {
                    this.selectedProducts = response.data;
                })
                .catch(error => {});
        },
        printPDF() {
            let printContents = this.$refs.printSection.innerHTML;
            let originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            setTimeout(() => {
                window.print();
                document.body.innerHTML = originalContents;
                this.$nextTick(() => {
                    document.location.reload();
                });
            }, 300);
        },
        getRecords() {
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                this.loading = true;
                let url = `/${
                    this.resource
                }/records?${this.getQueryParameters()}`;

                return this.$http
                    .get(url)
                    .then(response => {
                        if (response.data) {
                            this.records = response.data.data;
                            this.pagination = {
                                current_page: parseInt(
                                    response.data.meta.current_page
                                ),
                                total: parseInt(response.data.meta.total),
                                per_page: parseInt(response.data.meta.per_page),
                                from: parseInt(response.data.meta.from)
                            };
                        }
                    })
                    .catch(error => {
                        console.error("Error al cargar los registros:", error);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            }, 350);
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                per_page: this.pagination.per_page,
                category_id: this.search.category_id || "",
                description: this.search.description || "",
                warehouse_id: this.search.warehouse_id
            });
        },
        changeClearInput() {
            this.search.value = "";
            this.getRecords();
        }
    }
};
</script>
