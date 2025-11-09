<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <div class="d-flex align-items-center flex-column flex-sm-row">
                <span class="d-inline-flex align-items-center mb-2 mb-sm-0 mr-sm-2">
                    <svg class="text-white" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                        <rect x="2" y="5" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.5" />
                        <rect x="3.5" y="9" width="6" height="2" rx="0.5" fill="currentColor" />
                        <rect x="11" y="9" width="9" height="2" rx="0.5" fill="currentColor" />
                    </svg>
                </span>
                <h5 class="mb-0 text-white"> Consulta de métodos de pago</h5>
            </div>
        </div>
        <div class="card mb-0">
            <div class="card-body">
                <data-table :resource="resource">
                    <tr slot="heading" style="background-color: #073f68; color: #ffffff;">
                        <th class="text-white">#</th>
                        <th class="text-white">Usuario</th>
                        <!-- <th class="text-white">Fecha</th>
                        <th class="text-white">Hora</th> -->
                        <th class="text-white">Cliente</th>
                        <!-- <th class="text-white">Documento</th> -->
                        <th class="text-white">Método de pago</th>
                         <th class="text-white">N° Operación</th>
                        <th class="text-white">Producto vendido</th>
                       
                        <th class="text-white">Monto</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }" :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                        <td>{{ index }}</td>
                        <td>
                            {{ row.user }} <br>
                            {{ row.date }} - {{ row.time }}

                        </td>
                        <!-- <td>
                            
                        </td>
                        <td>
                           
                        </td> -->
                        <td>
                            {{ row.customer_document }}
                            <br>
                            {{ row.customer_name }}
                        </td>
                        <!-- <td>
                           
                        </td> -->
                         <td>{{ row.method }}</td>
                         <td>
                            {{ row.operation_number }}
                        </td>
                       
                        <!-- <td>
                            <el-button  @click=" 
                            previsualitation( 
                            data.external_id, 
                            data.document_type_id)"
                            >Ver Documento</el-button>
                        </td> -->
                        <el-button 
                            class="btn_guardarsmall" type="primary" 
                        @click="previsualitation(row.external_id, row.document_type_id)">Ver Documento</el-button>
                       
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
