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
                            <div class="col-lg-3 col-md-3 col-sm-4 pb-2">
                                <label>Establecimientos</label>
                                <el-select v-model="search.warehouse_id">
                                    <el-option
                                        v-for="warehouse in warehouses"
                                        :key="warehouse.id"
                                        :value="warehouse.id"
                                        :label="warehouse.description"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 pb-2 d-flex justify-content-center align-items-end">
                                <el-button
                                    type="success"
                                    @click="sendToCatalog"
                                    class="me-2"
                                >
                                    Armar catálogo
                                </el-button>

                                <el-button 
                                    type="danger" 
                                    @click="printPDF"
                                >
                                    <i class="fas fa-print"></i> Generar Catalogo PDF
                                </el-button>
                            </div>
                            <!-- <div class="col-lg-1 col-md-1 col-sm-12 pb-2">
                                <div class="text-end mb-3">
                                    <el-button type="danger" @click="printPDF">
                                        <i class="fas fa-print"></i> Generar Catalogo PDF
                                    </el-button>
                                </div>
                            </div> -->
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
                                            <div class="overlay"></div> <!-- Nuevo overlay -->
                                            <div
                                                class="text-center py-3 content-wrapper"
                                                style="position: relative;"
                                            >
                                                <div>
                                                    <h1 class="catalog-title">
                                                        CATALOGOS DE PRODUCTOS
                                                    </h1>
                                                    <img
                                                        :src="'/storage/uploads/logos/' + company.logo"
                                                        alt="Logo"
                                                        class="my-4 company-logo"
                                                        v-if="company.logo"
                                                    />
                                                    <h3 class="company-name">
                                                        {{ company.trade_name }}
                                                    </h3>
                                                </div>
                                                
                                                <div class="spacer"></div>
                                                
                                                <div class="contact-info mt-4"> <!-- Cambiado de mt-auto a mt-4 -->
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
                                        </div>

                                        <!-- Página de productos -->
                                        <div>
                                            <template
                                                v-for="(category,
                                                catIndex) in categories"
                                            >
                                                <template
                                                    v-if="
                                                        filteredItems.filter(
                                                            item =>
                                                                item.category_id ===
                                                                category.id
                                                        ).length > 0
                                                    "
                                                >
                                                    <div
                                                        v-for="(chunk,
                                                        chunkIndex) in Math.ceil(
                                                            filteredItems.filter(
                                                                item =>
                                                                    item.category_id ===
                                                                    category.id
                                                            ).length / 9
                                                        )"
                                                        :key="
                                                            `${catIndex}-${chunkIndex}`
                                                        "
                                                        class="pdf-page products-page"
                                                        :style="{
                                                            minHeight: '1000px',
                                                            padding: '20px',
                                                            backgroundImage: `url(${images[1].url})`,
                                                            backgroundSize:
                                                                'cover',
                                                            backgroundPosition:
                                                                'center',
                                                            backgroundRepeat:
                                                                'no-repeat',
                                                            position: 'relative'
                                                        }"
                                                    >
                                                        <h6
                                                            class="category-title mb-3 text-center"
                                                        >
                                                            {{ category.name }}
                                                        </h6>
                                                        <div class="row g-2">
                                                            <div
                                                                v-for="(product,
                                                                index) in filteredItems
                                                                    .filter(
                                                                        item =>
                                                                            item.category_id ===
                                                                            category.id
                                                                    )
                                                                    .slice(
                                                                        chunkIndex *
                                                                            9,
                                                                        (chunkIndex +
                                                                            1) *
                                                                            9
                                                                    )"
                                                                :key="index"
                                                                class="col-4"
                                                                style="height: 280px; margin-bottom: 10px; padding: 0 5px;"
                                                            >
                                                                <div
                                                                    class="card mx-auto"
                                                                    style="width: 170px; height: 270px;"
                                                                >
                                                                    <img
                                                                        :src="
                                                                            product.image_url
                                                                        "
                                                                        class="card-img-top"
                                                                        alt="Producto"
                                                                        style="height: 140px; object-fit: contain; padding: 5px;"
                                                                    />
                                                                    <div
                                                                        class="card-body p-2"
                                                                    >
                                                                        <h6
                                                                            class="card-title mb-1 fw-bold"
                                                                            style="font-size: 12px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                                                        >
                                                                            {{
                                                                                product.internal_id
                                                                            }}
                                                                        </h6>
                                                                        <p
                                                                            class="card-text mb-1 fw-bold"
                                                                            style="font-size: 11px; height: 40px; overflow: hidden;"
                                                                        >
                                                                            {{
                                                                                product.description
                                                                            }}
                                                                        </p>
                                                                        <p
                                                                            class="card-text mb-0"
                                                                            style="font-size: 16px; margin-top: 5px;"
                                                                        >
                                                                            <strong
                                                                                style="color: #000000;"
                                                                            >
                                                                                S/.
                                                                                {{
                                                                                    product.sale_unit_price
                                                                                }}
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
                                            <div class="overlay"></div>
                                            <div
                                                class="text-center d-flex flex-column align-items-center justify-content-center content-wrapper"
                                                style="height: 100%; position: relative; padding-top: 100px;"
                                            >
                                                <div class="back-cover-content text-center">
                                                    <img
                                                        :src="'/storage/uploads/logos/' + company.logo"
                                                        alt="Logo"
                                                        class="my-4 company-logo"
                                                        v-if="company.logo"
                                                        style="display: block; margin: 0 auto;"
                                                    />
                                                    <div style="margin-top: 30px;">
                                                        <h3 class="rights-reserved">
                                                            TODO LOS DERECHOS RESERVADOS
                                                        </h3>
                                                        <p class="catalog-date" style="margin-top: 20px;">
                                                            {{ new Date().toLocaleDateString() }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="contact-info" style="margin-top: 100px;">
                                                    <h4>Contacto:</h4>
                                                    <template v-if="establishment">
                                                        <p>
                                                            Teléfono: {{ establishment.telephone || "No disponible" }}
                                                        </p>
                                                        <p>
                                                            Email: {{ establishment.email || "No disponible" }}
                                                        </p>
                                                        <p>
                                                            Dirección: {{ establishment.address || "No disponible" }}
                                                        </p>
                                                    </template>
                                                    <template v-else>
                                                        <p>Información de contacto no disponible</p>
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
.overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.4); /* Overlay semi-transparente */
    z-index: 1;
}

.content-wrapper {
    position: relative;
    z-index: 2;
    color: white;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    padding-top: 40px; /* Agregado padding-top para ajustar posición inicial */
}

.catalog-title {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 2rem;
    /* letter-spacing: 2px; */
    background: rgba(0, 0, 0, 0.6);
    padding: 1rem;
    border-radius: 5px;
    /* display: inline-block; */
}

.company-name {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 1.5rem 0;
    background: rgba(0, 0, 0, 0.6);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    /* display: inline-block; */
}

.company-logo {
    max-width: 200px;
    filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.5));
    background: rgba(255, 255, 255, 0.9);
    padding: 10px;
    border-radius: 10px;
}

.contact-info {
    background: rgba(0, 0, 0, 0.6);
    padding: 1.5rem;
    border-radius: 10px;
    margin-top: 1rem; /* Reducido de 2rem a 1rem */
    width: 80%; /* Agregado para centrar mejor el contenido */
    margin-left: auto;
    margin-right: auto;
    /* Agregado para asegurar que se mantiene en la primera página */
    position: relative;
    bottom: auto;
}

.contact-info h4 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    border-bottom: 2px solid white;
    padding-bottom: 0.5rem;
}

.contact-info p {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}

.rights-reserved {
    font-size: 2rem;
    font-weight: 700;
    margin: 1.5rem 0;
    background: rgba(0, 0, 0, 0.6);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    display: inline-block;
}

.catalog-date {
    font-size: 1.2rem;
    font-weight: 600;
    background: rgba(0, 0, 0, 0.6);
    padding: 0.5rem 1rem;
    border-radius: 6px;
    display: inline-block;
}

.spacer {
    height: 100px; /* Reducido de 200px a 100px */
}

.pdf-page.cover-page {
    min-height: 800px;
    max-height: 1123px; /* Altura estándar A4 */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 40px 20px;
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
            warehouses: [],
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
                warehouse_id: null, // Será establecido en mounted
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
            items: [],
            filteredItems: [] // Add this new property
        };
    },
    watch: {
        // Eliminar los watchers duplicados y unificarlos en uno solo
        "search.category_id": {
            async handler(newVal) {
                this.pagination.current_page = 1;

                // Ejecutar ambas peticiones de forma independiente
                try {
                    await Promise.all([
                        this.getRecords(), // Actualiza la tabla de records
                        this.updateFilteredItems(newVal) // Actualiza los items del catálogo
                    ]);
                } catch (error) {
                    console.error("Error al aplicar filtros:", error);
                }
            },
            immediate: true
        },
        "search.description": {
            handler(newVal) {
                this.pagination.current_page = 1;
                this.getRecords();
            }
        },
        // Agregar watcher para warehouse_id
        'search.warehouse_id': {
            handler(newVal) {
                this.pagination.current_page = 1;
                this.getRecords();
                this.updateFilteredItems(this.search.category_id);
            }
        },
    },
    /* mounted() {
        this.fetchImages();
    }, */
    created() {},
    async mounted() {
        try {
            const response = await this.$http.get(`/${this.resource}/tables`);

            this.categories = response.data.categories;
            this.company = response.data.company;
            this.warehouses = response.data.warehouses;

            // Verificación y asignación segura
            if (response.data.establishment) {
                this.establishment = response.data.establishment;
            } else {
            }

            // Establecer el primer warehouse por defecto si existe
            if (this.warehouses && this.warehouses.length > 0) {
                this.search.warehouse_id = this.warehouses[0].id;
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
        // Nuevo método para actualizar items filtrados
        async updateFilteredItems(categoryId) {
            try {
                const params = {
                    category_id: categoryId || null,
                    warehouse_id: this.search.warehouse_id
                };
                
                const response = await this.$http.post("catalog/storeCatalog", params);
                
                if (response.data) {
                    this.items = response.data.data;
                    this.filteredItems = this.items;
                }
            } catch (error) {
                console.error("Error al actualizar items filtrados:", error);
                this.$message.error("Error al actualizar items del catálogo");
            }
        },

        async sendToCatalog() {
            try {
                const response = await this.$http.post("catalog/storeCatalog", {
                    products: this.selectedProducts,
                    category_id: this.search.category_id || null,
                    warehouse_id: this.search.warehouse_id
                });

                if (response.data) {
                    this.$message.success("Catálogo armado con éxito");
                    this.enableCatalog = true;
                    this.selectedProducts = [];

                    // Actualizar ambas listas
                    await Promise.all([
                        this.getRecords(),
                        this.updateFilteredItems()
                    ]);
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
        async getRecords() {
            if (this.time) {
                clearTimeout(this.time);
            }

            return new Promise(resolve => {
                this.time = setTimeout(async () => {
                    this.loading = true;
                    try {
                        // Asegurarse de que category_id se incluya en los parámetros
                        const url = `/${
                            this.resource
                        }/records?${this.getQueryParameters()}`;
                        const response = await this.$http.get(url);

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
                    } catch (error) {
                        console.error("Error al cargar los registros:", error);
                    } finally {
                        this.loading = false;
                        resolve();
                    }
                }, 350);
            });
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        getQueryParameters() {
            // Asegurarse de que category_id siempre se incluya en los parámetros
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
