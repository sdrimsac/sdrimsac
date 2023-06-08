<template>
    <div>
     <el-dialog title="Lista de Cotizaciones" :visible="showDialogQuotations"    width="80%" top="7vh" :close-on-click-modal="false">
        <div class="card mb-0">
           
            <div class="card-body">
                <data-table :resource="resource">
                    <tr slot="heading">
                        <th>#</th>
                        <th class="text-center">Fecha Emisión</th>
                        <th class="text-center" v-if="columns.delivery_date.visible">Fecha Entrega</th>
                        <th>Vendedor</th>
                        <th>Cliente</th>
                       
                        <th>Cotización</th>
                        <th>Comprobantes</th>
                        <th>Nota de venta</th>
                        <th>Oportunidad Venta</th>
                        <th v-if="columns.contract.visible">Contrato</th>
                        <!-- <th>Estado</th> -->
                        <th class="text-center">Moneda</th>
                        <th class="text-end" v-if="columns.total_exportation.visible">T.Exportación</th>
                        <th class="text-end" v-if="columns.total_free.visible">T.Gratuito</th>
                        <th class="text-end" v-if="columns.total_unaffected.visible">T.Inafecta</th>
                        <th class="text-end" v-if="columns.total_exonerated.visible">T.Exonerado</th>
                        <th class="text-end">T.Gravado</th>
                        <th class="text-end">T.Igv</th>
                        <th class="text-end">Total</th>
                        <th class="text-center">PDF</th>
                        <th class="text-end">Acciones</th>
                    <tr>
                    <tr slot-scope="{ index, row }" :class="{ anulate_color : row.state_type_id == '11' }">
                        <td>{{ index }}</td>
                        <td class="text-center">{{ row.date_of_issue }}</td>
                        <td class="text-center" v-if="columns.delivery_date.visible">{{ row.delivery_date }}</td>
                        <td>{{ row.user_name }}</td>
                        <td>{{ row.customer_name }}<br/><small v-text="row.customer_number"></small></td>
                        <td>
                            
                        </td>
                        <td>{{ row.identifier }}
                        </td>
                        <td>
                            <template v-for="(document,i) in row.documents">
                                <label :key="i" v-text="document.number_full" class="d-block"></label>
                            </template>
                        </td>
                        <td>
                            <template v-for="(sale_note,i) in row.sale_notes">
                                <label :key="i" v-text="sale_note.identifier" class="d-block"></label>
                            </template>
                        </td>
                        <td>
                            <!-- {{ row.sale_opportunity_number_full }} -->

                            <el-popover
                                placement="right"
                                v-if="row.sale_opportunity"
                                width="400"
                                trigger="click">

                                <div class="col-md-12 mt-4">
                                    <table>
                                        <tr>
                                            <td><strong>O. Venta: </strong></td>
                                            <td><strong>{{row.sale_opportunity_number_full}}</strong></td>
                                        </tr>
                                        <tr  class="mt-4 mb-4">
                                            <td><strong>F. Emisión:</strong></td>
                                            <td><strong>{{row.date_of_issue}}</strong></td>
                                        </tr>
                                    </table>
                                    <div class="table-responsive mt-4">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Descripción</th>
                                                    <th>Cantidad</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(row, index) in row.sale_opportunity.items" :key="index">
                                                    <td>{{index+1}}</td>
                                                    <td>{{row.item.description}}</td>
                                                    <td>{{row.quantity}}</td>
                                                    <td>{{row.total}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <el-button slot="reference"> <i class="fa fa-eye"></i></el-button>
                            </el-popover>
                        </td>
                        <!-- <td>{{ row.state_type_description }}</td> -->
                        <td v-if="columns.contract.visible">{{ row.contract_number_full }}</td>
                        <td class="text-center">{{ row.currency_type_id }}</td>
                        <td class="text-end"  v-if="columns.total_exportation.visible" >{{ row.total_exportation }}</td>
                        <td class="text-end" v-if="columns.total_free.visible">{{ row.total_free }}</td>
                        <td class="text-end" v-if="columns.total_unaffected.visible">{{ row.total_unaffected }}</td>
                        <td class="text-end" v-if="columns.total_exonerated.visible">{{ row.total_exonerated }}</td>
                        <td class="text-end">{{ row.total_taxed }}</td>
                        <td class="text-end">{{ row.total_igv }}</td>
                        <td class="text-end">{{ row.total }}</td>
                        <td class="text-end">

                            <button type="button" class="btn waves-effect waves-light btn-sm btn-info"
                                    @click.prevent="clickOptionsPdf(row.id)">PDF</button>
                        </td>

                        <td class="text-end">
                            <button  
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-info"
                                    @click.prevent="clickOptions(row.id)" >
                                Generar comprobante
                            </button>

                        </td>

                    </tr>
                </data-table>
            </div>

        </div>
    </el-dialog>
    </div>
</template>
<style scoped>
    .anulate_color{
        color:red;
    }
</style>
<script>

 
    import DataTable from "../../../components/DataTable.vue"
    //'../../components/DataTable.vue'
    import {deletable} from '../../../mixins/deletable'
    export default {
        props:['typeUser', 'soapCompany','showDialogQuotations'],
        mixins: [deletable],
        components: {DataTable},
        data() {
            return {
                resource: 'quotations',
                recordId: null,
                showDialogOptions: false,
                showDialogOptionsPdf: false,
                state_types: [],
                columns: {
                    total_exportation: {
                        title: 'T.Exportación',
                        visible: false
                    },
                    total_unaffected: {
                        title: 'T.Inafecto',
                        visible: false
                    },
                    total_exonerated: {
                        title: 'T.Exonerado',
                        visible: false
                    },
                    total_free: {
                        title: 'T.Gratuito',
                        visible: false
                    },
                    contract: {
                        title: 'Contrato',
                        visible: false
                    },
                    delivery_date: {
                        title: 'F.Entrega',
                        visible: false
                    }
                }
            }
        },
        async created() {
            await this.filter()
        },
        methods: {
            async changeStateType(row){

                await this.updateStateType(`/${this.resource}/state-type/${row.state_type_id}/${row.id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )

            },
            filter(){
                this.$http.get(`/${this.resource}/filter`)
                            .then(response => {
                                this.state_types = response.data.state_types
                            })
            },
            clickEdit(id)
            {
                this.recordId = id
                this.showDialogFormEdit = true
            },
            clickOptions(recordId = null) {
                this.recordId = recordId
                this.showDialogOptions = true
            },
            clickOptionsPdf(recordId = null) {
                this.recordId = recordId
                this.showDialogOptionsPdf = true
            },
            clickAnulate(id)
            {
                this.anular(`/${this.resource}/anular/${id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
            },
            duplicate(id)
            {
                this.$http.post(`${this.resource}/duplicate`, {id})
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success('Se guardaron los cambios correctamente.')
                        this.$eventHub.$emit('reloadData')
                    } else {
                        this.$toast.error('No se guardaron los cambios')
                    }
                })
                .catch(error => {

                })
                this.$eventHub.$emit('reloadData')
            }
        }
    }
</script>
