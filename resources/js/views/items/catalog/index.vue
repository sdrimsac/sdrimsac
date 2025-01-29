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
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading" class="bg-primary">
                            <th class="text-white">#</th>
                            <th class="text-white text-center">cod. interno</th>
                            <th class="text-white text-center">Unidad</th>
                            <th class="text-center text-white">Nombre</th>
                            <th class="text-center text-white">P. Venta</th>
                        </tr>

                        <tr></tr>

                        <tr slot-scope="{ index_, row }">
                            <td>{{ index }}</td>
                            <td class="text-center">{{ row.internal_id }}</td>
                            <td class="text-center">{{ row.unit_type_id }}</td>
                            <td class="text-center">{{ row.description }}</td>
                            <td class="textcenter">
                                {{ parseFloat(row.sale_unit_price).toFixed(2) }}
                            </td>
                        </tr>
                    </data-table>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
td {
    color: #000;
}
</style>
<script>
import DataTable from "../../../components/DataTableCatalogos.vue";
export default {
    props: [
        "just_sale_notes",
        "soapCompany",
        "company",
        "configuration",
        "user_type"
    ],
    components: {
        DataTable
    },
    data() {
        return {
            cashId: null,

            resource: "catalog",
            saleNotesNewId: null,
            recordId: null,
            currentNumber: null,
            boxes: [],
            editSale: false,
            showDialogOptions: false
        };
    },
    created() {},
    mounted() {
        /* this.$getCashId().then(() => {
      this.cashId = this.$cashId;
    }); */
    },
    methods: {
        clickDownload(external_id) {
            window.open(
                `/sale-notes/downloadExternal/${external_id}`,
                "_blank"
            );
        },
        clickSchedule(recordId) {
            window.open(`/sale-notes/schedule/${recordId}`, "_blank");
        },
        clickContract(recordId) {
            window.open(`/sale-notes/contract/${recordId}`, "_blank");
        },
        changeConcurrency(row) {
            // console.log(row)
            this.$http
                .post(`/${this.resource}/enabled-concurrency`, row)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .then(() => {});
        }
    }
};
</script>
