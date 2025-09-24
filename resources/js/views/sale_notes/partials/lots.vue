<template>
    <el-dialog :title="titleDialog" width="40%"  :visible="showDialog"  @open="create"  :close-on-click-modal="false" :close-on-press-escape="false" append-to-body :show-close="false">

        <div class="form-body">
            <div class="row" >
                <div class="col-lg-12 col-md-12 table-responsive">
                    <div class="col-lg-5 col-md-5 col-sm-12 pb-2">
                        <el-input
                            v-model="search"
                            placeholder="Buscar por serie..."
                            clearable
                            prefix-icon="el-icon-search"
                            @input="filter"
                            style="width: 100%; border-radius: 20px; background: #f5f7fa;"
                        >
                        </el-input>
                    </div>
                    <table width="100%" class="table">
                        <thead>
                            <tr width="100%" style="background-color: #073f68; color: #fff;">
                                <th class="text-center" style="color: #fff;">Seleccionar</th>
                                <th style="color: #fff;">Cod. Lote</th>
                                <th style="color: #fff;">Serie</th>
                                <th style="color: #fff;">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in lots_" :key="index" width="100%">
                                <!-- <td>{{index}}</td> -->
                                <td class="text-center">
                                    <el-checkbox v-model="row.has_sale"></el-checkbox>
                                </td>
                                <td>
                                    {{row.lot_code}}
                                </td>
                                <td>
                                    {{row.series}}
                                </td>
                                <td>
                                    {{row.date}}
                                </td>
                                <br>
                            </tr>
                        </tbody>
                    </table>


                </div>

            </div>
        </div>

    <div class="form-actions pt-2 pb-2" style="display: flex; justify-content: flex-end;">
        <el-button class="btn_cancelarsmall" type="primary" @click.prevent="close()">Cerrar</el-button>
        <!-- <el-button type="primary" @click="submit" >Guardar</el-button> -->
    </div>
    </el-dialog>
</template>

<script>
    export default {
        props: ['showDialog', 'lots', 'stock','recordId'],
        data() {
            return {
                titleDialog: 'Series',
                loading: false,
                errors: {},
                form: {},
                search: '',
                lots_: []
            }
        },
        async created() {

        },
        watch:{
            lots(val)
            {
                this.lots_ = val
            }
        },
        methods: {
            filter()
            {

                if(this.search)
                {
                    // this.lots_ = this.lots.filter( x => x.series.toUpperCase().includes(this.search.toUpperCase()))
                    this.lots_ = _.filter(this.lots, x => x.series.toUpperCase().includes(this.search.toUpperCase()))
                }
                else{
                    this.lots_ = this.lots
                }
            },
            create(){

            },
            async submit(){

                // let val_lots = await this.validateLots()
                // if(!val_lots.success)
                //     return this.$toast.error(val_lots.message);

                // await this.$emit('addRowLot', this.lots);
                // await this.$emit('update:showDialog', false)

            },
            close() {
                this.$emit('update:showDialog', false)
   
                
                this.$emit('addRowSelectLot', this.lots_);
            },
            async clickCancelSubmit() {

                // this.$emit('addRowLot', []);
                // await this.$emit('update:showDialog', false)

            },
        }
    }
</script>
