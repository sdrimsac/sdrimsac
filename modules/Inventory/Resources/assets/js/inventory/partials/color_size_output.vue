<template>
    <el-dialog
        @open="open"
        @close="close"
        :visible="showDialog"
        title="Listado de colores y tallas"
        append-to-body
    >
        <div class="p-1">
            <div class="row">
                <div class="col-md-4">
                    <el-input
                        v-model="inputSearch"
                        placeholder="Buscar por color"
                        @input="search"
                    >
                    </el-input>
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
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th class="text-end">Stock</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(colorsize, idx) in color_size" :key="idx">
                        <td>{{ customIndex(idx) }}</td>
                        <td>{{ colorsize.color }}</td>
                        <td>{{ colorsize.size }}</td>
                        <td class="text-end">{{ colorsize.stock }}</td>
                        <td>
                          <el-input
                          type="number"
                            v-model="colorsize.quantity"
                            @input="saveColorSize(colorsize)"
                          >

                          </el-input>
                        </td>
                    </tr>
                </tbody>
            </table>
            <el-pagination
                @current-change="getColorSize"
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
        "item",
        "idx",
        "colorSizeSelected",
        "establishments",
        "warehouse_id",
    ],
    data() {
        return {
            loading: false,
            color_size: [],
            pagination: {},
            inputSearch: null,
            timer: null,
            showSelecteds: false
        };
    },
    methods: {
        checkColorSize() {
            for (let i = 0; i < this.color_size.length; i++) {
                let color_size = this.colorSizeSelected.find(
                    s => s.id == this.color_size[i].id
                );
                if (color_size) {
                    this.color_size[i].quantity = color_size.quantity;
                    this.color_size[i].disabled = color_size.disabled;
                }

                // if (this.colorSizeSelected.some(s => s.id == this.series[i].id)) {
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
        saveColorSize(colorSize) {
            let color_size = [
                ...this.colorSizeSelected.filter(
                    s => s.quantity && s.quantity != 0
                )
            ];
             color_size = color_size.filter(s => s.id != colorSize.id);
            if (colorSize.quantity !== 0) {
                //if(colorSize.quantity > colorSize.stock){
                    //colorSize.quantity = colorSize.stock;
                   // return this.$toast.error(
                  //      "La cantidad no puede ser mayor al stock"
                //    );
              //  }
                colorSize.disabled = false;
                color_size = [...color_size, colorSize];
            } else {
                color_size = color_size.filter(s => s.id != colorSize.id);
            }
            this.$forceUpdate();
            this.$emit("update:colorSizeSelected", color_size);
        },
        save() {
            if (this.limitQty != 0) {
                if (this.colorSizeSelected.length % this.limitQty != 0) {
                    return this.$toast.error(
                        "La cantidad de series no coninciden con la cantidad de venta por politica de precio"
                    );
                }
            }
            this.$emit("updateColorSize", this.idx, this.colorSizeSelected);
            this.close();
        },
        getQueryParameters() {
            return queryString.stringify({
                warehouse_id: this.warehouse_id,

                page: this.pagination.current_page,
                item_id: this.item.id,
                color: this.inputSearch
            });
        },
        open() {
            
            console.log("🚀 ~ file: color_size_output.vue:163 ~ open ~ this.item:", this.item)
            if (this.item) {
                this.getColorSize();
            }
        },
        search() {
            if (this.timer) {
                clearTimeout(this.timer);
            }
            this.timer = setTimeout(async () => {
                await this.getColorSize();
            }, 350);
        },
        close() {
            this.inputSearch = null;
            this.pagination = {};
            this.color_size = [];
            this.$emit("update:showDialog", false);
        },
        async getColorSize() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/item-color-size/records?${this.getQueryParameters()}`
                );
                let { data, meta } = response.data;
                this.color_size = data;
                // this.checkColorSize();
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
