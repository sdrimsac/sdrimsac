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
                                <!-- <div class="text-end mb-3"> -->
                                <!-- <el-button type="primary" @click="list_product">
                                    <i class="fas fa-print"></i> todo los
                                    productos
                                </el-button> -->
                                <el-button
                                    @click="toggleCatalog"
                                    :type="
                                        isCatalogEnabled ? 'danger' : 'success'
                                    "
                                    >{{
                                        isCatalogEnabled
                                            ? "Desactivar Catálogo completo"
                                            : "Activar Catálogo completo"
                                    }}</el-button
                                >
                                <el-button @click="sendToCatalog">
                                    armar catalogo
                                </el-button>
                                <!-- </div> -->
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 pb-2">
                                <!-- <div class="text-end mb-3"> -->
                                <div class="text-end mb-3">
                                    <el-button type="primary" @click="printPDF">
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
                                    style="height: 1200px; overflow-y: auto;"
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
                                                    src="logo/logo.png"
                                                    alt="Logo"
                                                    class="my-4"
                                                    style="max-width: 200px;"
                                                />
                                                <h3>demo</h3>
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
                                                <p>Teléfono: (01) 123-4567</p>
                                                <p>Email: info@empresa.com</p>
                                                <p>
                                                    Dirección: Av. Principal 123
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Página de productos -->
                                        <template v-if="enableCatalog">
                                            <div>
                                                <div
                                                    v-for="(chunk,
                                                    chunkIndex) in Math.ceil(
                                                        records.length / 9
                                                    )"
                                                    :key="chunkIndex"
                                                    class="pdf-page products-page"
                                                    :style="{
                                                        minHeight: '1000px',
                                                        padding: '20px',
                                                        backgroundImage: `url(${images[1].url})`,
                                                        backgroundSize: 'cover',
                                                        backgroundPosition:
                                                            'center',
                                                        backgroundRepeat:
                                                            'no-repeat',
                                                        position: 'relative'
                                                    }"
                                                >
                                                    <div class="row g-3">
                                                        <div
                                                            v-for="(product,
                                                            index) in records.slice(
                                                                chunkIndex * 9,
                                                                (chunkIndex +
                                                                    1) *
                                                                    9
                                                            )"
                                                            :key="index"
                                                            class="col-4"
                                                            style="height: 300px; margin-bottom: 15px;"
                                                        >
                                                            <div
                                                                class="card"
                                                                style="width: 180px; height: 280px;"
                                                            >
                                                                <img
                                                                    :src="
                                                                        product.image_url
                                                                    "
                                                                    class="card-img-top"
                                                                    alt="Producto"
                                                                    style="height: 150px; object-fit: contain; padding: 5px;"
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
                                                                        style="font-size: 11px; height: 45px; overflow: hidden;"
                                                                    >
                                                                        {{
                                                                            product.description
                                                                        }}
                                                                    </p>
                                                                    <p
                                                                        class="card-text mb-0"
                                                                        style="font-size: 16px; margin-top: 8px;"
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
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div
                                                v-for="(chunk,
                                                chunkIndex) in Math.ceil(
                                                    records.length / 9
                                                )"
                                                :key="chunkIndex"
                                                class="pdf-page products-page"
                                                :style="{
                                                    minHeight: '1000px',
                                                    padding: '20px',
                                                    backgroundImage: `url(${images[1].url})`,
                                                    backgroundSize: 'cover',
                                                    backgroundPosition:
                                                        'center',
                                                    backgroundRepeat:
                                                        'no-repeat',
                                                    position: 'relative'
                                                }"
                                            >
                                                <div class="row g-3">
                                                    <div
                                                        v-for="(product,
                                                        index) in records.slice(
                                                            chunkIndex * 9,
                                                            (chunkIndex + 1) * 9
                                                        )"
                                                        :key="index"
                                                        class="col-4"
                                                        style="height: 300px; margin-bottom: 15px;"
                                                    >
                                                        <div
                                                            class="card"
                                                            style="width: 180px; height: 280px;"
                                                        >
                                                            <img
                                                                :src="
                                                                    product.image_url
                                                                "
                                                                class="card-img-top"
                                                                alt="Producto"
                                                                style="height: 150px; object-fit: contain; padding: 5px;"
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
                                                                    style="font-size: 11px; height: 45px; overflow: hidden;"
                                                                >
                                                                    {{
                                                                        product.description
                                                                    }}
                                                                </p>
                                                                <p
                                                                    class="card-text mb-0"
                                                                    style="font-size: 16px; margin-top: 8px;"
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
                                                        src="logo/logo.png"
                                                        alt="Logo"
                                                        class="my-4 mx-auto"
                                                        style="max-width: 200px;"
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
                                                    <p>
                                                        Teléfono: (01) 123-4567
                                                    </p>
                                                    <p>
                                                        Email: info@empresa.com
                                                    </p>
                                                    <p>
                                                        Dirección: Av. Principal
                                                        123
                                                    </p>
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
/* import DataTable from "../../../components/DataTableCatalogos.vue"; */
import queryString from "query-string";
export default {
    props: [
        "just_sale_notes",
        "soapCompany",
        "company",
        "configuration",
        "user_type"
    ],
    /* components: {
        DataTable
    }, */
    data() {
        return {
            selectedProducts: [],
            headers: headers_token,
            images: [
                { column: "image_past", url: null },
                { column: "image_fond", url: null },
                { column: "image_footer", url: null }
            ],
            isCatalogEnabled: false,
            enableCatalog: false,
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
            time: null
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
        await this.$http.get(`/${this.resource}/tables`).then(response => {
            this.categories = response.data.categories;
        });
        this.getRecords();
        this.fetchImages();
    },
    methods: {
        async sendToCatalog() {
            if (this.selectedProducts.length === 0) {
                this.$showSAlert("ALERTA", "Debes seleccionar al menos un producto.", "error");
                return;
            }
            console.log("Productos seleccionados:", this.selectedProducts);
            
            try {

                const response = await this.$http.post("catalog/storeCatalog", {
                    products: this.selectedProducts // Cambiado de 'records' a 'products' para mayor claridad
                }, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                
                console.log("Respuesta del servidor:", response.data);

                if (response.data) {
                    this.$message.success("Catálogo armado con éxito");
                    this.enableCatalog = true;
                    this.selectedProducts = [];
                }
            } catch (error) {
                console.error("Error completo:", error);
                this.$message.error("Error al armar el catálogo");
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
                console.error("Error al obtener imágenes:", error);
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
        async toggleCatalog() {
            this.isCatalogEnabled = !this.isCatalogEnabled;

            try {
                const response = await this.$http.get("catalog/records", {
                    params: { enable_catalog: this.isCatalogEnabled ? 1 : 0 }
                });

                if (this.isCatalogEnabled) {
                    // Handle multiple data entries
                    let allItems = [];
                    if (Array.isArray(response.data.data)) {
                        response.data.data.forEach(entry => {
                            if (entry.items && Array.isArray(entry.items)) {
                                allItems = [...allItems, ...entry.items];
                            }
                        });
                    }
                    this.records = allItems;
                } else {
                    this.records = response.data.data;
                }

                console.log("Respuesta del servidor:", response.data);
            } catch (error) {
                console.error("Error al enviar la solicitud:", error);
                this.$message.error("Error al cargar los datos del catálogo");
            }
        },
        /* printPDF() {
            let printContents = this.$refs.printSection.innerHTML;
            let originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }, */
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
        /* printPDF() {
            // Guardamos el contenido original antes de modificarlo
            this.originalContents = this.$refs.printSection.innerHTML;

            // Preparamos el contenido para la impresión
            let printContents = this.$refs.printSection.innerHTML;
            document.body.innerHTML = printContents;

            // Cambiamos el estado a 'imprimiendo'
            this.printState = true;

            // Imprimimos y restauramos el contenido
            setTimeout(() => {
                window.print();
                document.body.innerHTML = this.originalContents;
                this.printState = false; // Cambiamos el estado a 'no imprimiendo'
            }, 300);
        }, */
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
