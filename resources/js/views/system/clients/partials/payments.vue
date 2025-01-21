<template>
    <el-dialog width="90%" :title="title" :visible="showDialog" @close="close" @open="getData"
    :close-on-click-modal="false"
    >
        <div class="form-body">
            <div class="row">
                <div class="col-md-12" v-if="records.length > 0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Fecha de pago</th>
                                <th>Fecha de vencimiento</th>
                                <!-- <th>Método de pago</th>
                                <th>Tarjeta</th>
                                <th>Referencia</th> -->
                                <th>Monto</th>
                                <th>Pagar</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(row, index) in records" :key="index">
                                <template v-if="row.id">
                                    <td>{{ row.date_of_payment }}</td>
                                    <td>{{ row.end_payment }}</td>
                                    <!-- <td>{{ row.payment_method_type_description }}</td>
                                    <td v-if="row.card_brand">{{ row.card_brand.description }}</td>
                                    <td v-else>-</td>
                                    <td>{{ row.reference }}</td> -->
                                    <td  >S/ {{ row.payment }}</td>
                                    <td>
                                        <template v-if="!row.state">
                                            <button type="button" class="btn waves-effect waves-light btn-xs btn-primary" @click.prevent="clickCancelPayment(row.id)">
                                                Pagar
                                            </button>
                                        </template>
                                        <template v-else>
                                            Pagado
                                        </template>

                                        
                                    </td>
                                    <td class="series-table-actions text-right">
                                        <button type="button" class="btn waves-effect waves-light btn-xs btn-success" @click.prevent="clickMessages(row.id)">Mensajes</button>
                                        <button type="button" class="btn waves-effect waves-light btn-xs btn-danger" @click.prevent="clickDelete(row.id)">Eliminar</button>
                                        <!--<el-button type="danger" icon="el-icon-delete" plain @click.prevent="clickDelete(row.id)"></el-button>-->
                                    </td>
                                </template>
                                <template v-else>
                                    <td>
                                        <div class="form-group mb-0" :class="{'has-danger': row.errors.date_of_payment}">
                                            <el-date-picker v-model="row.date_of_payment"
                                                            type="date"
                                                            :clearable="false"
                                                            format="dd/MM/yyyy"
                                                            value-format="yyyy-MM-dd"></el-date-picker>
                                            <small class="form-control-feedback" v-if="row.errors.date_of_payment" v-text="row.errors.date_of_payment[0]"></small>
                                        </div>
                                    </td> 
                                    <td>
                                        <el-date-picker v-model="row.end_payment"
                                                            type="date"
                                                            :clearable="false"
                                                            format="dd/MM/yyyy"
                                                            value-format="yyyy-MM-dd"></el-date-picker>
                                    </td>
                                    
                                    
                                    <td>
                                        <div class="form-group mb-0" :class="{'has-danger': row.errors.payment}">
                                            <!-- <el-input v-model="row.payment"></el-input> -->
                                            <el-input  v-model="row.payment" >
                                                <template slot="prepend">S/ </template>
                                            </el-input>
                                            <small class="form-control-feedback" v-if="row.errors.payment" v-text="row.errors.payment[0]"></small>
                                        </div>
                                    </td>
                                    <td>
                                        -
                                    </td>
                                    <td class="series-table-actions text-right">
                                        <button type="button" class="btn waves-effect waves-light btn-xs btn-info" @click.prevent="clickSubmit(index)">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button type="button" class="btn waves-effect waves-light btn-xs btn-danger" @click.prevent="clickCancel(index)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </template>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3" class="text-right">TOTAL PAGADO</td>
                                <td class="text-right">S/ {{ client.total_paid }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">TOTAL A PAGAR</td>
                                <td class="text-right">S/ {{ client.total }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">PENDIENTE DE PAGO</td>
                                <td class="text-right">S/ {{ client.total_difference }}</td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 text-center pt-2" >
                    <el-button type="primary" icon="el-icon-plus" @click="clickAddRow">Programar pago</el-button>
                </div>
            </div>
            <client-messages :showDialog.sync="showDialogMessages" :client_payment_id="recordId"></client-messages>
            <payment-form :showDialog.sync="showDialogPayment"></payment-form>
        </div>
    </el-dialog>

</template>

<script>

    import {deletable} from '../../../../mixins/deletable'
    import ClientMessages from './client_messages.vue';
    import PaymentForm from './payment.vue';

    export default {
        props: ['showDialog', 'clientId'],
        mixins: [deletable],
        components: {
            ClientMessages,
            PaymentForm
        },
        data() {
            return {
                title: null,
                recordId: null,
                resource: 'client_payments',
                records: [],
                payment_method_types: [],
                card_brands: [],
                showAddButton: true,
                has_card: false,
                client: {},
                showDialogMessages: false,
                showDialogPayment: false
            }
        },
        async created() {
            await this.initForm();
            await this.$http.get(`/${this.resource}/tables`)
                .then(response => {
                    this.payment_method_types = response.data.payment_method_types;
                    this.card_brands = response.data.card_brands;
                    //this.initDocumentTypes()
                })
        },
        methods: {
            clickMessages(client_payment_id){
                this.showDialogMessages = true;
                this.recordId = client_payment_id;
            },
            changePaymentMethodType(row){
                let payment_method_type = _.find(this.payment_method_types,{'id':row.payment_method_type_id})
                this.has_card = (payment_method_type.has_card)? true:false
            },
            initForm() {
                this.records = [];
                this.showAddButton = true;
            },
            async getData() {
                this.initForm();
                await this.$http.get(`/${this.resource}/client/${this.clientId}`)
                    .then(response => {
                        this.client = response.data;
                        this.title = 'Programación de pagos del cliente: '+this.client.name;
                    });
                await this.$http.get(`/${this.resource}/records/${this.clientId}`)
                    .then(response => {
                        this.records = response.data.data
                    });
            },
            async clickCancelPayment(client_payment_id){

                this.showDialogPayment = true;
                // await this.$http.get(`/${this.resource}/cancel_payment/${client_payment_id}`)
                //     .then(response => { 
                //         if (response.data.success) {
                //             this.$message.success(response.data.message);
                //             this.getData(); 
                //         } else {
                //             this.$message.error(response.data.message);
                //         }
                //     });
            },
            clickAddRow() {
                this.records.push({
                    id: null,
                    date_of_payment: moment().format('YYYY-MM-DD'),
                    end_payment:moment().add(1,'month').format('YYYY-MM-DD'),
                    payment_method_type_id: null,
                    card_brand_id: null,
                    reference: null,
                    reference: null,
                    payment: this.client.pricing,
                    errors: {},
                    loading: false
                });
                this.showAddButton = false;
            },
            clickCancel(index) {
                this.records.splice(index, 1);
                this.showAddButton = true;
            },
            clickSubmit(index) {
                if(this.has_card && this.records[index].card_brand_id == null) {
                    this.$message.error('Elija una tarjeta.');
                    return;
                }
                let payment_method_type_id = this.payment_method_types.find(payment_method_type => payment_method_type.description === 'Efectivo').id;
                let form = {
                    id: this.records[index].id,
                    client_id: this.clientId,
                    date_of_payment: this.records[index].date_of_payment,
                    end_payment: this.records[index].end_payment,
                    payment_method_type_id: payment_method_type_id,
                    card_brand_id: this.records[index].card_brand_id,
                    reference: this.records[index].reference,
                    payment: this.records[index].payment,
                };
                this.$http.post(`/${this.resource}`, form)
                    .then(response => {
                        if (response.data.success) {
                            this.$message.success(response.data.message);
                            this.getData();
                            // this.initDocumentTypes()
                            this.showAddButton = true;
                        } else {
                            this.$message.error(response.data.message);
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.records[index].errors = error.response.data;
                        } else {
                            console.log(error);
                        }
                    })
            }, 
            close() {
                this.$emit('update:showDialog', false);
                // this.initDocumentTypes()
                // this.initForm()
            },
            clickDelete(id) {
                this.destroy(`/${this.resource}/${id}`).then(() =>
                    this.getData()
                    // this.initDocumentTypes()
                )
            }
        }
    }
</script>