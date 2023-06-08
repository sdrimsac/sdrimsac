<template>
    <el-dialog
        append-to-body
        @open="open"
        @close="close"
        :visible="showDialog"
        class="p-2"
        v-loading="loading"
    >
        <div class="p-3">
            <div>
                <label class="control-label">Buscar producto</label>
                <el-select
                    @change="changeItem"
                    v-model="form.item_id"
                    :remote-method="searchItem"
                    filterable
                    remote
                    :loading="loading_item"
                    popper-class="el-select-document_type"
                >
                    <el-option
                        v-for="option in items"
                        :key="option.id"
                        :value="option.id"
                        :label="option.description"
                    ></el-option>
                </el-select>
            </div>

            <div
                class="d-flex flex-wrap justify-content-center"
                v-if="selected.length != 0"
                style="margin-top:15px"
            >
                <el-tag
                    style="margin:0 5px;"
                    v-for="(item, idx) in selected"
                    :key="idx"
                    closable
                    @close="removeSelected(item.id)"
                >
                    {{ item.description }}
                </el-tag>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <el-button @click="close">
                    Cerrar
                </el-button>
                <el-button @click="addItems" type="primary">
                    Agregar
                </el-button>
            </div>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "elements"],
    data() {
        return {
            loading: false,
            resource: "toll",
            loading_item: false,
            loading_search: false,
            items: [],
            selected: [],
            form: {
                item_id: null,
                warehouse_id: 1
            }
        };
    },
    methods: {
        async addItems() {
            let ids = this.selected.map(s => s.id);
            try {
                this.loading = true;
                const response = await this.$http.post(`${this.resource}`, {
                    ids
                });
                const { message } = response.data;
                this.$toast.success(message);

                this.$emit("reloadData");
                this.close();
            } catch (e) {
                this.$toast.error("Ocurrió un problema");
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        async saveItems() {},
        removeSelected(id) {
            this.selected = this.selected.filter(i => i.id != id);
        },
        searchItem(input) {
            if (input.length > 2) {
                if (this.time) {
                    clearTimeout(this.time);
                }
                this.time = setTimeout(async () => {
                    let query = `?description=${input}`;

                    await this.searchItems(query);
                }, 500);
            }
        },
        async searchItems(query) {
            try {
                this.loading_item = true;
                const response = await this.$http.get(
                    `/${this.resource}/items/${this.form.warehouse_id}${query}`
                );
                if (response.status == 200) {
                    this.items = response.data.items;
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loading_item = false;
            }
        },
        async changeItem() {
            let { item_id } = this.form;
            let added = this.selected.some(i => i.id == item_id);
            if (added) {
                return this.$toast.error("Ya fue agregado.");
            }
            added = this.elements.some(i => i.id == item_id);
            if (added) {
                return this.$toast.error("Ya fue agregado.");
            }
            let item = this.items.find(i => i.id == item_id);
            this.selected = [...this.selected, item];
        },

        close() {
            this.$emit("update:showDialog", false);
        },
        async open() {
            await this.searchItems();
        }
        // async records(input = null) {
        //     try {
        //         this.loading = true;
        //         const response = await this.$http(
        //             `/${this.resource}/items/1?${
        //                 input ? `description=${input}` : ""
        //             }`
        //         );
        //         console.log(response);
        //     } catch (e) {
        //         console.log(e);
        //     } finally {
        //         this.loading = false;
        //     }
        // }
    }
};
</script>
