<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Productos</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Verificar stock de Productos</span
                                >
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <el-button @click="printTest">
                        <i class="el-icon-printer"></i>
                        Test
                    </el-button>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <table class="table table-responsive"></table>
        </div>
    </div>
</template>

<script>
export default {
    props: ["user"],

    data() {
        return {
            resource: "/items/check_stock",
            records: [],
            loading: false,
            pagination: {}
        };
    },

    created() {
        this.getRecords();
    },
    methods: {
        async printTest() {
            try {
                const pdfUrl =
                    "https://tunegocio.villacorpfact.net/print/document/75877986-94b5-4c83-bb1d-382edf33ec71/ticket";
                const pdfFile = new File([pdfUrl], "archivo.pdf", {
                    type: "application/pdf"
                });

                if (navigator.share) {
                    await navigator.share({
                        title: "Compartir archivo PDF",
                        text: "Aquí tienes un archivo PDF para compartir",
                        files: [pdfFile]
                    });
                    this.$toast.success("Archivo PDF compartido con éxito");
                } else {
                    this.$toast.error(
                        "Tu navegador no soporta la API Web Share"
                    );
                }
            } catch (error) {
                this.$toast.error("Error al compartir el archivo PDF");
            }
        },
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http.get(this.resource);
                this.records = response.data.data;
                this.pagination = response.data.meta;
                this.loading = false;
            } catch (e) {
                this.loading = false;
                console.log(e);
            }
        }
    }
};
</script>
