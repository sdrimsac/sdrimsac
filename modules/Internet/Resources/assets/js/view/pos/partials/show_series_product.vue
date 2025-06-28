<template>
    <el-dialog @open="open" @close="close" :visible="showDialog" title="Listado de series">
        <div class="p-1">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <div class="row">
                        <div class="col-md-6">
                            <el-input v-model="inputSearch" placeholder="Buscar Serie" @input="search">
                            </el-input>
                        </div>
                        <div class="col-md-6">
                            <el-button @click="close">Cerrar</el-button>
                            <el-button type="primary" @click="save">Guardar</el-button>
                        </div>
                    </div>

                </div>
                <!-- <div class="col-md-4">
                    <el-button
                        :type="showSelecteds ? 'primary' : 'danger'"
                        @click="showSelected"
                    >
                        {{ showSelecteds ? "Ocultar" : "Ver seleccionados" }}
                    </el-button>
                </div> -->
            </div>
            <table v-loading="loading" class="table">
                <thead style="background-color: #1e5a85; color: #fff;">
                    <tr>
                        <th style="color: #fff;">#</th>
                        <th style="color: #fff;">Serie</th>
                        <th style="color: #fff;">Fecha</th>
                        <th style="color: #fff;">Lote</th>
                        <th style="color: #fff;">Seleccionar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(serie, idx) in series" :key="serie.id">
                        <td>{{ customIndex(idx) }}</td>
                        <td>{{ serie.series }}</td>
                        <td>{{ serie.date }}</td>
                        <td>{{ serie.lote }}</td>
                        <td>
                            <el-checkbox :disabled="serie.disabled" v-model="serie.selected" @change="saveSerie(serie)">
                            </el-checkbox>
                        </td>
                    </tr>
                </tbody>
            </table>
            <el-pagination background @current-change="handlePageChange" @size-change="handleSizeChange"
                layout="total, sizes, prev, pager, next, jumper" :total="pagination.total"
                :current-page="pagination.current_page" :page-size="pagination.per_page"
                :page-sizes="[10, 20, 50, 100]">
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
    props: ["showDialog", "limitQty", "item", "idx", "seriesSelected"],
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
        handlePageChange(page) {
            this.pagination.current_page = page;
            this.getSeries();
        },
        handleSizeChange(size) {
            this.pagination.per_page = size;
            this.pagination.current_page = 1;
            this.getSeries();
        },

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
            this.$emit("updateSeries", this.idx, this.seriesSelected);
            this.close();
        },
        getQueryParameters() {
            return queryString.stringify({
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
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
