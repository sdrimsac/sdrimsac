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
            </div>
            <table v-loading="loading" class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th class="text-end">Stock</th>
                        <th class="text-end">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(colorsize, idx) in color_size" :key="idx">
                        <td>{{ customIndex(idx) }}</td>
                        <td>{{ colorsize.code }}</td>
                        <td>{{ colorsize.color }}</td>
                        <td>{{ colorsize.size }}</td>
                        <td class="text-end">{{ colorsize.stock }}</td>
                        <td class="text-end">

                              <el-input-number 
                              v-model="colorsize.quantity" 
                              @input="saveColorSize(colorsize)"
                              controls-position="right"  
                              :min="0" 
                              :max="colorsize.stock"
                              :step="1"
                              :disabled="colorsize.stock === 0"
                              >
                            </el-input-number>
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
            <div slot="footer" class="dialog-footer d-flex justify-content-end">
                <el-button @click="close" size="large" type="danger" style="min-width:120px;">Cerrar</el-button>
                <el-button type="primary" @click="save" size="large" style="min-width:120px; margin-left: 10px;">Guardar</el-button>
            </div>
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
        "establishments",
        "warehouse_id"
    ],
    data() {
        return {
            loading: false,
            color_size: [],
            pagination: {},
            inputSearch: null,
            timer: null,
            showSelecteds: false,
            colorSizeSelected: []
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
            // Actualizar o agregar la cantidad de la combinación actual en colorSizeSelected
            const idx = this.colorSizeSelected.findIndex(s => s.id === colorSize.id);
            if (colorSize.quantity && colorSize.quantity > 0) {
                if (idx !== -1) {
                    // Actualizar existente
                    this.colorSizeSelected[idx] = { ...colorSize };
                } else {
                    // Agregar nuevo
                    this.colorSizeSelected.push({ ...colorSize });
                }
            } else if (idx !== -1) {
                // Eliminar si la cantidad es 0
                this.colorSizeSelected.splice(idx, 1);
            }
            this.$forceUpdate();
        },
        save() {
            // No limpiar colorSizeSelected ni color_size aquí, solo emitir y cerrar
            this.$emit("updateColorSize", this.colorSizeSelected);
            this.$emit("update:showDialog", false);
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
            this.$emit("update:showDialog", false);
            // Limpiar solo si se cierra el modal (Aceptar o Cancelar)
            this.inputSearch = null;
            this.pagination = {};
            this.color_size = [];
            this.colorSizeSelected = [];
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
