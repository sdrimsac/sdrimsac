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
          var printWindow = window.open(
                "https://tunegocio.sdrimsac.pro/print/document/5a0cb63a-a97c-4443-9672-5ec464978c18/ticket",
                "Print",
                "left=200",
                "top=200",
                "width=950",
                "height=500",
                "toolbar=0",
                "resizable=0"
            );
            printWindow.addEventListener(
                "load",
                function() {
                    printWindow.print();
                    printWindow.close();
                },
                true
            );

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
