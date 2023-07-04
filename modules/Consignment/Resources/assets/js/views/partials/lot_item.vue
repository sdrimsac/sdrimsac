<template>
    <el-dialog
        @open="open"
        @close="close"
        :visible="showDialog"
        title="Listado de series"
        append-to-body
    >
        <div class="p-1">
            <div class="row">
                <div class="col-md-4">
                    <el-input
                        v-model="inputSearch"
                        placeholder="Buscar por serie"
                        @input="search"
                    >
                    </el-input>
                </div>
            </div>
            <table v-loading="loading" class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Serie</th>
                        <th>Fecha</th>
                        <th>Lote</th>
                        <th>Seleccionar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(serie, idx) in series" :key="serie.id">
                        <td>{{ customIndex(idx) }}</td>
                        <td>{{ serie.series }}</td>
                        <td>{{ serie.date }}</td>
                        <td>{{ serie.lote }}</td>
                        <td>
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
            <span slot="footer" class="dialog-footer">
                <el-button @click="close">Cerrar</el-button>
                <el-button type="primary" @click="save">Guardar</el-button>
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
        "item_id",
        "idx",
        "seriesSelected",
        "establishment_id"
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

            console.log(series, " aki");
            this.$forceUpdate();
            this.$emit("update:seriesSelected", series);
        },
        save() {
            if (this.limitQty != 0) {
                if (this.seriesSelected.length > this.limitQty ) {
                    return this.$toast.error(
                        "La cantidad de series no coninciden con la cantidad de venta por politica de precio"
                    );
                }
            }
            console.log(this.seriesSelected, " las series");
            this.$emit("updateSeries", this.idx, this.seriesSelected);
            this.close();
        },
        getQueryParameters() {
            return queryString.stringify({
                warehouse_id: this.establishment_id,

                page: this.pagination.current_page,
                item_id: this.item_id,
                description: this.inputSearch
            });
        },
        open() {

            if (this.item_id) {
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
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
