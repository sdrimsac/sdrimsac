<template>
    <div>
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
                                {{ new Date().toLocaleDateString() }}
                            </p>
                            <div class="spacer" style="height: 400px;"></div>
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
                        v-for="(chunk, chunkIndex) in Math.ceil(
                            records.length / 9
                        )"
                        :key="chunkIndex"
                        class="pdf-page products-page"
                        style="min-height: 1000px; padding: 20px;"
                    >
                        <div class="row g-3">
                            <div
                                v-for="(product, index) in records.slice(
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
                                        :src="product.image_url"
                                        class="card-img-top"
                                        alt="Producto"
                                        style="height: 150px; object-fit: contain; padding: 5px;"
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
                                            style="font-size: 11px; height: 45px; overflow: hidden;"
                                        >
                                            {{ product.description }}
                                        </p>
                                        <p
                                            class="card-text mb-0"
                                            style="font-size: 16px; margin-top: 8px;"
                                        >
                                            <strong style="color: #000000;">
                                                S/.
                                                {{ product.sale_unit_price }}
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
                                {{ new Date().toLocaleDateString() }}
                            </p>
                            <div class="contact-info mt-auto">
                                <h4>Contacto:</h4>
                                <p>Teléfono: (01) 123-4567</p>
                                <p>Email: info@empresa.com</p>
                                <p>Dirección: Av. Principal 123</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            records: [],
        };
    },
    mounted() {
        this.fetchRecords();
    },
    methods: {
        fetchRecords() {
            axios
                .get("/api/items")
                .then((response) => {
                    this.records = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
}
</script>