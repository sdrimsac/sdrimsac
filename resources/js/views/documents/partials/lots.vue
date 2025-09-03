<template>
    <el-dialog
        :title="titleDialog"
        width="40%"
        :visible="showDialog"
        @open="create"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        append-to-body
        :show-close="false"
    >
        <div class="form-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 table-responsive">
                    <div class="col-lg-5 col-md-5 col-sm-12 pb-2">
                        <el-input
                            placeholder="Buscar serie ..."
                            v-model="search"
                            style="width: 100%;"
                            prefix-icon="el-icon-search"
                            @input="filter"
                        >
                            <i slot="prefix" class="el-icon-edit-outline"></i
                        ></el-input>
                    </div>
                    <table width="100%" class="table">
                        <thead>
                            <tr width="100%">
                                <th class="text-center">Seleccionar</th>
                                <th>Cod. Lote</th>
                                <th>Serie</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(row, index) in lots_"
                                :key="row.id ? 'lot-'+row.id : 'lot-'+(row.lot_code||'')+'-'+(row.series||index)"
                                width="100%"
                            >
                                <!-- <td>{{index}}</td> -->
                                <td class="text-center">
                                    <el-checkbox
                                        v-model="row.has_sale"
                                    ></el-checkbox>
                                </td>
                                <td>
                                    {{ row.lot_code }}
                                </td>
                                <td>
                                    {{ row.series }}
                                </td>
                                <td>
                                    {{ row.date }}
                                </td>
                                <br />
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="form-actions text-end pt-2 pb-2">
            <el-button @click.prevent="close()">Cerrar</el-button>
            <el-button type="primary" @click="submit">Guardar</el-button>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "lots", "stock", "recordId", "itemWarehouseId"],
    data() {
        return {
            titleDialog: "Series",
            loading: false,
            errors: {},
            form: {},
            search: "",
            lots_: [],
            lotsLocal: []
        };
    },
    async created() {},
    watch: {
        lots: {
            handler(newVal) {
                this.lots_ = Array.isArray(newVal)
                    ? JSON.parse(JSON.stringify(newVal))
                    : [];
                this.lotsLocal = Array.isArray(newVal)
                    ? JSON.parse(JSON.stringify(newVal))
                    : [];
            },
            immediate: true
        }
    },
    methods: {
        create() {
            this.lots_ = Array.isArray(this.lots)
                ? JSON.parse(JSON.stringify(this.lots))
                : [];
            console.log("ver que datos llega aqui lots_", this.lots_);
        },
        filter() {
            if (this.search) {
                // this.lots_ = this.lots.filter( x => x.series.toUpperCase().includes(this.search.toUpperCase()))
                this.lots_ = _.filter(this.lots, x =>
                    x.series.toUpperCase().includes(this.search.toUpperCase())
                );
            } else {
                this.lots_ = this.lots;
            }
        },
        async submit() {
            const selectedSeries = this.lots_.filter(lot => lot.has_sale);
            this.$emit("addRowSelectLot", selectedSeries);
            await this.$emit("update:showDialog", false);
        },
        //async submit() {
            //let val_lots = await this.validateLots()
            //if(!val_lots.success)
            //     return this.$toast.error(val_lots.message);
            //await this.$emit('addRowLot', this.lots);
            //this.$emit("addRowSelectLot", this.lots);
            //await this.$emit('update:showDialog', false)
           // const selectedSeries = this.lots.filter(lot => lot.has_sale);
           // this.$emit("addRowSelectLot", selectedSeries);
           // await this.$emit("update:showDialog", false);
        //},
        close() {
            this.$emit("update:showDialog", false);

            //this.$emit("addRowSelectLot", this.lots_);
        },
        async clickCancelSubmit() {
            // this.$emit('addRowLot', []);
            // await this.$emit('update:showDialog', false)
        }
    }
};
</script>
