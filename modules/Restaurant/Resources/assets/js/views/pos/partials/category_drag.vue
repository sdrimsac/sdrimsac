<template>
    <el-dialog
        @open="open"
        :visible="showDialog"
        @close="close"
        width="80%"
        title="Categorias"
    >
        <div class="container" v-loading="loading">
            <div
                v-if="categories.length > 1"
                class="d-flex flex-wrap justify-content-center "
                
            >
                <div
                    v-for="(cat, idxCat) in categories"
                    :key="idxCat"
                    class="d-flex flex-column m-4 flex-grow-1"
                    :id="cat.id"
                    @drop="drop"
                    @dragover="allowDrop"
                >
                    <h3>
                        {{ cat.name }}
                    </h3>
                    <div class="row">
                        <div class="col-12">
                            <el-input
                                v-model="cat.search"
                                placeholder="Buscar"
                                clearable
                                size="small"
                                :id="cat.id"
                                @input="searchItems(cat.id)"
                            >
                            </el-input>
                        </div>
                    </div>
                    <div
                        class="border border-primary p-2 m-1 "
                        draggable="true"
                        @dragstart="drag"
                        v-for="(item, idx) in cat.items"
                        :key="idx"
                        :id="`${cat.id}-${item.id}`"
                    >
                        {{ item.name }}
                    </div>
                </div>
            </div>
            <div
                v-else
                class="d-flex justify-content-center align-items-center"
            >
                <h4 class="m-2 text-center">
                    No tiene las categorías necesarias activadas para poder
                    utilizar esta funcionalidad.
                </h4>
            </div>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog"],
    data() {
        return {
            categories: [],
            loading: false,
            timer: null
        };
    },
    methods: {
        async searchItems(categoryId) {
            if (this.timer) {
                clearTimeout(this.timer);
            }
            this.timer = setTimeout(async () => {
                try {
                    this.loading = true;
                    let category = this.categories.find(
                        category => category.id == categoryId
                    );

                    const response = await this.$http.post(
                        `/items/categories/search/${categoryId}`,
                        {
                            value: category.search
                        }
                    );
                    if (response.status == 200) {
                        const { items } = response.data;
                        this.categories = this.categories.map(category => {
                            if (category.id == categoryId) {
                                category.items = items;
                            }
                            return {
                                ...category
                            };
                        });
                    }
                } catch (e) {
                    this.$toast.error("Ha ocurrido un error");
                    console.log(e);
                } finally {
                    this.loading = false;
                }
            }, 350);
        },
        async getCategories() {
            try {
                this.loading = true;
                const response = await this.$http.get("/items/categories/drag");
                if (response.status == 200) {
                    const { categories } = response.data;
                    this.categories = categories;
                }
            } catch (e) {
                this.$toast.error("Ha ocurrido un error");
            } finally {
                this.loading = false;
            }
        },
        async open() {
            this.getCategories();
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        },

        allowDrop(ev) {
            ev.preventDefault();
        },
        async updateCategory(itemId, categoryId) {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/items/categories/update_category/${categoryId}/${itemId}`
                );
                if (response.status != 200) {
                    this.$toast.error("Ha ocurrido un error");
                }
            } catch (e) {
                this.$toast.error("Ha ocurrido un error");
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        drop(ev) {
            ev.preventDefault();
            let id = ev.target.id.split("-");
            let categoryDropId = id[0];
            let data = ev.dataTransfer.getData("text");
            let [categoryId, itemid] = data.split("-");
            let item = this.categories
                .find(category => category.id == categoryId)
                .items.find(item => item.id == itemid);
            this.updateCategory(itemid, categoryDropId);
            this.categories = this.categories.map(category => {
                if (category.id == categoryId) {
                    category.items = category.items.filter(
                        item => item.id != itemid
                    );
                }
                if (category.id == categoryDropId) {
                    category.items.push(item);
                }

                return {
                    ...category
                };
            });
        }
    }
};
</script>

<style>

.scroll-drag{
    overflow-y: scroll;
    height: 350px;
}

</style>
