<template>
    <el-dialog
    title="FrigoBar"
     :visible="showDialog" @open="open" @close="close" append-to-body>
        <div class="row m-2">
            <div class="col-md-6">
                <label for="item">Producto</label>
                <el-select
                    v-model="form.item_id"
                    placeholder="Producto"
                    remote
                    filterable
                    :remote-method="search_items"
                    @change="filterItems"
                    :loading="loading"
                >
                    <el-option
                        v-for="item in listFoods"
                        :key="item.id"
                        :label="item.description"
                        :value="item.id"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-md-3">
                <label for="quantity">Cantidad</label>
                <el-input
                    type="number"
                    v-model="form.quantity"
                    placeholder="Cantidad"
                ></el-input>
            </div>
            <div class="col-md-3">
                <label for="unit_price">Precio Unitario</label>
                <el-input
                    type="number"
                    v-model="form.price"
                    placeholder="Precio Unitario"
                ></el-input>
            </div>
        </div>
        <div class="row m-2 d-flex justify-content-end">
            <div class="col-md-3 text-end">
                <button
                    class="btn btn-primary"
                    @click="addFood"
                    :disabled="!form.item_id"
                >
                    Agregar
                </button>
            </div>
        </div>
        <div class="row m-2">

        </div>
    </el-dialog>
</template>

<script>
import queryString from "query-string";
export default {
    props: ["showDialog", "table_id"],
    data() {
        return {
            foods: [],
            loading: false,
            form: {},
            allFoods: [],
            listFoods: []
        };
    },
    methods: {
        addFood() {},
        filterItems() {},
        open() {},
        close() {
            this.$emit("update:showDialog", false);
        },
        async search_items(inputitem) {
            inputitem = inputitem.toLowerCase();
            let form = { value: inputitem };
            await this.getFoods(this.getQueryParameters(form));
        },
        async getFoods(query = "") {
            try {
                const response = await this.$http.get(
                    `/caja/pos/foods?${query}`
                );
                this.loading = true;
                if (response.status == 200) {
                    const {
                        data: { data }
                    } = response;

                    this.allFoods = data.map(d => {
                        if (d.item.lots_group.length > 0) {
                            d.item.lots_group = d.item.lots_group.filter(
                                lt =>
                                    lt.warehouse_id ==
                                    this.worker.establishment_id
                            );
                        }
                        return d;
                    });
                    this.listFoods = this.allFoods;

                    this.loading = false;
                }
            } catch (e) {
                console.log(e);
                this.loading = false;
            }
        },
        getQueryParameters(form = {}) {
            return queryString.stringify({
                ...form
            });
        }
    }
};
</script>
