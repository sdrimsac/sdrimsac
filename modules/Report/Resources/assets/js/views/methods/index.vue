<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Consulta de métodos de pago</h6>
        </div>
        <div class="card mb-0">
            <div class="card-body">
                <data-table :resource="resource">
                    <tr slot="heading">
                        <th class="">#</th>
                        <th class="">Usuario</th>
                        <th class="">Fecha</th>
                        <th class="">Hora</th>
                        <th class="">Cliente</th>
                        <th class="">Documento</th>
                        <th class="">Método de pago</th>
                        <th class="">Producto vendido</th>
                        <th class="">N° Operación</th>
                        <th class="">Monto</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>
                            {{ row.user }}
                        </td>
                        <td>
                            {{ row.date }}
                        </td>
                        <td>
                            {{ row.time }}
                        </td>
                        <td>
                            {{ row.customer_name }}
                        </td>
                        <td>
                            {{ row.customer_document }}
                        </td>
                        <td>{{ row.method }}</td>
                        <!-- <td>
                            <el-button  @click=" 
                            previsualitation( 
                            data.external_id, 
                            data.document_type_id)"
                            >Ver Documento</el-button>
                        </td> -->
                        <el-button @click="previsualitation(row.external_id, row.document_type_id)">Ver Documento</el-button>
                        <td>
                            {{ row.operation_number }}
                        </td>
                        <td>
                            {{ row.amount }}
                        </td>
                    </tr>
                </data-table>
            </div>
        </div>
        <document-print-previsualitation
            :resource="resourcePdf"
            :showDialog.sync="showPrevisualitation"
        >
        </document-print-previsualitation>
    </div>
</template>

<script>
import DataTable from "../../components/DataTableMethods.vue";
const DocumentPrintPrevisualitation = () =>
    import("../../../../../../Restaurant/Resources/assets/js/views/pos/partials/document_print_previsualitation.vue");

export default {
    components: { DataTable, DocumentPrintPrevisualitation  },

    data() {
        return {
            resource: "reports/methods",
            form: {},
            showPrevisualitation: false,
            resourcePdf: null,
        };
    },
    async created() {},
    methods: {
        previsualitation(external_id, type) {
            let url = null;
            if (type == "80") {
                url = `/sale-notes/print/${external_id}/ticket`;
            } else if (
                type == "03" ||
                type == "01" ||
                type == "07" ||
                type == "08"
            ) {
                url = `/print/document/${external_id}/ticket`;
            } else {
                url = `/quotations/print/${external_id}/ticket`;
            }
            console.log('URL:', url);
            console.log(type);
            this.resourcePdf = url;
            this.showPrevisualitation = true;
        },
        
    }
};
</script>
