<template>
    <el-dialog
        @open="open"
        @close="close"
        :visible="showDialog"
        :close-on-click-modal="false"
        title="Listado de series"
    >
        <div class="p-1">
            <div class="row align-items-center mb-2">
                <label class="col-auto mb-0">Buscar Serie a Vender</label>
                <div class="col">
                    <el-input
                        v-model="inputSearch"
                        placeholder="Buscar por serie"
                        @input="search"
                    >
                    </el-input>
                </div>
            </div>
            <table v-loading="loading" class="table">
               <thead style="background-color:#073f68; color:#ffffff;">
                    <tr>
                        <th style="color:#fff; width:60px; min-width:60px;">#</th>
                        <th style="color:#fff; width:160px; min-width:140px;">Serie</th>
                        <th style="color:#fff; width:120px; min-width:110px;">Fecha de Ingreso</th>
                        <!-- <th style="color:#fff; width:120px; min-width:110px;">Lote</th> -->
                        <th class="text-center" style="color:#fff; width:130px; min-width:120px;">Seleccionar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(serie, idx) in series" :key="serie.id">
                        <td>{{ customIndex(idx) }}</td>
                        <td>{{ serie.series }}</td>
                        <td>{{ serie.date }}</td>
                        <!-- <td>{{ serie.lote }}</td> -->
                        <td class="text-center">
                            <el-checkbox
                                :disabled="serie.disabled"
                                v-model="serie.selected"
                                @change="saveSerie(serie)"
                            >
                            </el-checkbox>
                        </td>
                    </tr>
                </tbody>
            </table>
            <el-pagination
                @current-change="getSeries"
                layout="total, prev, pager, next"
                :total="pagination.total"
                :current-page.sync="pagination.current_page"
                :page-size="pagination.per_page"
            >
            </el-pagination>
            <span slot="footer" class="dialog-footer" style="display: flex; justify-content: flex-end;">
                <el-button class="btn_cancelarsmall" type="primary" @click="close">
                    <i class="el-icon-arrow-left"></i>
                    Cerrar
                </el-button>
                <el-button class="btn_guardarsmall" type="primary" @click="save">
                    <i class="el-icon-plus"></i>
                    Agregar
                </el-button>
            </span>

         
            
        </div>
    </el-dialog>
</template>

<script>
import queryString from "query-string";
export default {
    props: [
        "showDialog",
        "limitQty",
        "item",
        "idx",
        "seriesSelected",
        "establishments"
    ],
    data() {
        return {
            loading: false,
            series: [],
            pagination: {},
            inputSearch: null,
            timer: null,
            showSelecteds: false
        };
    },
    methods: {
        checkSeries() {
            for (let i = 0; i < this.series.length; i++) {
                let serie = this.seriesSelected.find(
                    s => s.id == this.series[i].id
                );
                if (serie) {
                    this.series[i].selected = true;
                    this.series[i].disabled = serie.disabled;
                }

                // if (this.seriesSelected.some(s => s.id == this.series[i].id)) {
                // }
            }
        },
        showSelected() {
            this.showSelecteds = !this.showSelecteds;
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        saveSerie(serie) {
            let series = [
                ...this.seriesSelected.filter(
                    s => s.disabled != null && s.disabled == false
                )
            ];
            if (serie.selected) {
                serie.disabled = false;
                series = [...series, serie];
            } else {
                series = series.filter(s => s.id != serie.id);
            }
            this.$forceUpdate();
            this.$emit("update:seriesSelected", series);
        },
        save() {
            if (this.limitQty != 0) {
                if (this.seriesSelected.length % this.limitQty != 0) {
                    return this.$toast.error(
                        "La cantidad de series no coninciden con la cantidad de venta por politica de precio"
                    );
                }
            }
            this.$emit("updateSeries", this.idx, this.seriesSelected);
            this.close();
        },
        getQueryParameters() {
            return queryString.stringify({
                warehouse_id: this.establishments.id,

                page: this.pagination.current_page,
                item_id: this.item.id,
                description: this.inputSearch
            });
        },
        open() {
            console.log(this.limitQty);

            if (this.item) {
                this.getSeries();
            }
        },
        search() {
            if (this.timer) {
                clearTimeout(this.timer);
            }
            this.timer = setTimeout(async () => {
                await this.getSeries();
            }, 350);
        },
        close() {
            this.inputSearch = null;
            this.pagination = {};
            this.series = [];
            this.$emit("update:showDialog", false);
        },
        async getSeries() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/lotitem/series-by-item?${this.getQueryParameters()}`
                );
                let { data, meta } = response.data;
                this.series = data;
                this.checkSeries();
                this.pagination = meta;
                this.pagination.per_page = parseInt(meta.per_page);

                if (this.inputSearch) {
                    const foundSerie = this.series.find(
                        serie =>
                            serie.series.toLowerCase() ===
                            this.inputSearch.toLowerCase()
                    );
                    if (foundSerie) {
                        foundSerie.selected = true;
                        this.saveSerie(foundSerie);
                        setTimeout(() => {
                            this.inputSearch = null;
                            this.search();
                        }, 500);
                    } else {
                        this.$toast.warning(
                            "No se encontró la serie especificada."
                        );
                    }
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
