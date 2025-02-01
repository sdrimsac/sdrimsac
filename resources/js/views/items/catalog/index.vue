<!-- Modulo de Notas de Venta -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>
                            <span>Crear Catalogos de Productos</span>
                        </h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashbodard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Catalogos Productos
                                </span>
                            </li>
                        </ol>
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
                                    clearable
                                ></el-input>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 pb-2">
                                <!-- <el-button
                                    class="submit"
                                    type="danger"
                                    icon="el-icon-tickets"
                                    @click.prevent="exportRecords"
                                    >Exportar PDF</el-button
                                > -->
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
                                <div class="image-container">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <img
                                                src="path/to/image1"
                                                class="img-fluid"
                                                alt="Image 1"
                                            />
                                            <el-button>
                                                subir imagen
                                            </el-button>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <img
                                                src="path/to/image2"
                                                class="img-fluid"
                                                alt="Image 2"
                                            />
                                        </div>
                                        <el-button>
                                            subir imagen
                                        </el-button>
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
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(row, index) in records" :row="row" :index="customIndex(index)" :key="index">
                                                <td>
                                                    {{ row.internal_id }}
                                                </td>
                                                <td>
                                                    {{ row.description }}
                                                </td>
                                                <td>
                                                    S/.
                                                    {{
                                                        row.sale_unit_price
                                                    }}
                                                </td>
                                                <td>
                                                    <el-checkbox
                                                       
                                                    >
                                                        <template slot="label">
                                                            <span
                                                                >Seleccionar</span
                                                            >
                                                        </template>
                                                    </el-checkbox>
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
                                            style="min-height: 1000px; padding: 20px;"
                                        >
                                            <div class="text-center py-3">
                                                <h1>Catálogo de Productos</h1>
                                                <img
                                                    src="status_images/logo.png"
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
                                        <div
                                            v-for="(chunk,
                                            chunkIndex) in Math.ceil(
                                                records.length / 9
                                            )"
                                            :key="chunkIndex"
                                            class="pdf-page products-page"
                                            style="min-height: 1000px; padding: 20px;"
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

                                        <!-- Página final (contraportada) -->
                                        <div
                                            class="pdf-page back-cover"
                                            style="min-height: 1000px; padding: 20px; page-break-before: always;"
                                        >
                                            <div
                                                class="text-center d-flex flex-column justify-content-center"
                                                style="height: 100%;"
                                            >
                                                <img
                                                    src="status_images/logo.png"
                                                    alt="Logo"
                                                    class="my-4 mx-auto"
                                                    style="max-width: 200px;"
                                                />
                                                <h3>
                                                    TODO LOS DERECHOS RESERVADOS
                                                </h3>
                                                <p class="mt-3">
                                                    {{
                                                        new Date().toLocaleDateString()
                                                    }}
                                                </p>
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
                per_page: 20, // Asegúrate que sea número, no string
                from: 1
            },
            records: [],
            loading: false,
            time: null,
        };
    },
    /* watch: {
        "form.category_id"(newVal, oldVal) {
            this.getRecords();
        }
    }, */
    created() {},
    async mounted() {
        await this.$http.get(`/${this.resource}/tables`).then(response => {
            this.categories = response.data.categories;
        });
        this.getRecords();
    },
    methods: {
        printPDF() {
            let printContents = this.$refs.printSection.innerHTML;
            let originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        },
        getRecords() {
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                this.loading = true;
                let url = `/${this.resource}/records?${this.getQueryParameters()}`;
                
                return this.$http
                    .get(url)
                    .then(response => {
                        if (response.data) {
                            this.records = response.data.data;
                            // Actualizar correctamente la paginación
                            this.pagination = {
                                current_page: parseInt(response.data.meta.current_page),
                                total: parseInt(response.data.meta.total),
                                per_page: parseInt(response.data.meta.per_page), // Convertir a número
                                from: parseInt(response.data.meta.from)
                            };
                            this.loading = false;
                        }
                    })
                    .catch(error => {
                        console.error(error);
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
            if (
                this.search.value &&
                typeof this.search.value == "object"
            ) {
                this.search.value = this.search.value.join(",");
            }
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                value: this.search.value,
                active: this.search.active,
                category_id: this.search.category_id,
                warehouse_id: this.search.warehouse_id,
                
            });
        },
        changeClearInput() {
            this.search.value = "";
            this.getRecords();
        }
    }
};
</script>
