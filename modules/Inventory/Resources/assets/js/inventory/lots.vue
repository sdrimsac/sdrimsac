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
                                <!-- <th >Cod. Lote</th> -->
                                <th>Serie</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(row, index) in lots_"
                                :key="index"
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
    props: ["showDialog", "lots", "stock", "recordId"],
    data() {
        return {
            titleDialog: "Series",
            loading: false,
            errors: {},
            form: {},
            search: "",
            lots_: []
        };
    },
    async created() {},
    watch: {
        lots(val) {
            // Clonar para no mutar la prop original desde la vista
            this.lots_ = val ? JSON.parse(JSON.stringify(val)) : [];
        }
    },
    methods: {
        filter() {
            if (this.search) {
                const base = this.lots || [];
                this.lots_ = base.filter(x =>
                    (x.series || "").toString().toUpperCase().includes(this.search.toUpperCase())
                );
            } else {
                // Restaurar lista completa (clonada)
                this.lots_ = this.lots ? JSON.parse(JSON.stringify(this.lots)) : [];
            }
        },
        create() {
            // Al abrir el diálogo, reiniciamos búsqueda y restauramos la lista de series
            this.search = "";
            this.lots_ = this.lots ? JSON.parse(JSON.stringify(this.lots)) : [];
        },
        async submit() {
            // Filtrar solo los seleccionados
            const selectedLots = this.lots_.filter(lot => lot.has_sale);
            // Si no hay seleccionados, no emitimos un arreglo vacío para no borrar las series
            if (selectedLots && selectedLots.length > 0) {
                await this.$emit("addRowSelectLot", selectedLots);
            }
            // Siempre cerramos el diálogo
            await this.$emit("update:showDialog", false);
        },
        close() {
            // Filtrar solo los seleccionados
            const selectedLots = this.lots_.filter(lot => lot.has_sale);
            // Solo emitimos si hay seleccionados
            if (selectedLots && selectedLots.length > 0) {
                this.$emit("addRowSelectLot", selectedLots);
            }
            this.$emit("update:showDialog", false);
        },
        async clickCancelSubmit() {
            // this.$emit('addRowLot', []);
            // await this.$emit('update:showDialog', false)
        }
    }
};
</script>
