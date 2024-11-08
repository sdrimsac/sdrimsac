<template>
    <el-dialog
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
        width="80%"
        title="Promoción"
        v-loading="loading"
    >
        <div class="row m-1">
            <div class="col-md-6">
                <label for="description">
                    <strong>Descripción</strong>
                </label>
                <el-input
                    v-model="form.description"
                    placeholder="Descripción"
                    clearable
                ></el-input>
            </div>
            <div class="col-md-2">
                <label for="total">
                    <strong>
                        <template v-if="promotionByPoints">
                            Monto x Punto
                        </template>
                        <template v-else>
                            Total
                        </template>
                    </strong>
                </label>
                <el-input
                    v-model="form.total"
                    placeholder="Total a consumir"
                    clearable
                ></el-input>
            </div>
            <div class="col-md-2">
                <label for="date_start">
                    <strong>Fecha Inicio</strong>
                </label>
                <el-date-picker
                    v-model="form.date_start"
                    type="date"
                    placeholder="Fecha Inicio"
                    format="yyyy-MM-dd"
                    value-format="yyyy-MM-dd"
                    clearable
                    class="w-100"
                ></el-date-picker>
            </div>
            <div class="col-md-2">
                <label for="date_end">
                    <strong>Fecha Fin</strong>
                </label>
                <el-date-picker
                    v-model="form.date_end"
                    type="date"
                    placeholder="Fecha Fin"
                    clearable
                    format="yyyy-MM-dd"
                    value-format="yyyy-MM-dd"
                    class="w-100"
                ></el-date-picker>
            </div>
        </div>
        <template v-if="!promotionByPoints">
            <div class="row m-1">
                <div class="col-md-6">
                    <label for="item">Producto</label>
                    <el-select
                        v-model="form.item_id"
                        :loading="loading_search"
                        :remote-method="searchRemoteItems"
                        filterable
                        placeholder="Buscar"
                        remote
                        @change="changeItem"
                    >
                        <el-option
                            v-for="option in items"
                            :key="option.id"
                            :value="option.id"
                            :label="option.full_description"
                        ></el-option>
                    </el-select>
                </div>
                <div class="col-md-4">
                    <label for="quantity">
                        <strong>Cantidad</strong>
                    </label>
                    <el-input
                        v-model="form.quantity"
                        placeholder="Cantidad"
                        clearable
                    ></el-input>
                </div>
                <div class="col-md-2">
                    <br />
                    <el-button type="primary" @click="addItem">
                        Agregar
                    </el-button>
                </div>
            </div>
            <div class="row m-1">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in form.items"
                                :key="index"
                            >
                                <td>{{ item.full_description }}</td>
                                <td>{{ item.quantity }}</td>
                                <td>
                                    <el-button
                                        type="danger"
                                        @click="deleteItem(index)"
                                    >
                                        Eliminar
                                    </el-button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>
        <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="save">Guardar</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "recordId", "promotionByPoints"],
    data() {
        return {
            form: {
                description: null,
                date_start: null,
                date_end: null,
                items: [],
                quantity: 1,
                total: 0
            },
            items: [],
            loading_search: false,
            timer: null,
            loading: false
        };
    },
    methods: {
        changeItem() {
            this.form.quantity = 1;
        },
        getRecord() {
            this.$http
                .get(`/promotions-document/record/${this.recordId}`)
                .then(response => {
                    this.form = response.data;
                });
        },
        validForm() {
            if (this.form.description.length < 3) {
                this.$toast.error(
                    "La descripción debe tener al menos 3 caracteres"
                );
                return false;
            }
            if (this.form.date_start == null || this.form.date_end == null) {
                this.$toast.error("Las fechas no pueden estar vacías");
                return false;
            }

            if (this.form.date_start > this.form.date_end) {
                this.$toast.error(
                    "La fecha de inicio no puede ser mayor a la fecha de fin"
                );
                return false;
            }

            if (this.form.items.length == 0) {
                this.$toast.error("Debe agregar al menos un item");
                return false;
            }

            for (let i = 0; i < this.form.items.length; i++) {
                if (this.form.items[i].quantity <= 0) {
                    this.$toast.error(
                        "La cantidad de los items debe ser mayor a 0"
                    );
                    return false;
                }
            }
            if (this.form.total <= 0) {
                this.$toast.error("El total debe ser mayor a 0");
                return false;
            }
            return true;
        },
        deleteItem(index) {
            this.form.items.splice(index, 1);
        },
        async save() {
            if (!this.validForm()) {
                return;
            }

            let parameters = {
                id: this.recordId,
                description: this.form.description,
                date_start: this.form.date_start,
                date_end: this.form.date_end,
                items: this.form.items,
                total: this.form.total
            };

            try {
                this.loading = true;
                const response = await this.$http.post(
                    "/promotions-document",
                    parameters
                );
                if (response.status == 200) {
                    this.$toast.success("Promoción creada correctamente");
                    this.$emit("reload");
                    this.close();
                }
            } catch (error) {
                this.$toast.error("Error al crear la promoción");
            } finally {
                this.loading = false;
            }
        },
        async searchRemoteItems(input) {
            if (input.length > 2) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                if (this.timer) {
                    clearTimeout(this.timer);
                }
                this.timer = setTimeout(async () => {
                    await this.$http
                        .get(`/documents/search-items/?${parameters}`)
                        .then(response => {
                            this.items = response.data;

                            this.loading_search = false;
                        });
                }, 500);
            }
        },
        addItem() {
            let item = this.items.find(item => item.id === this.form.item_id);

            if (item) {
                this.form.items.push({
                    id: item.id,
                    full_description: item.full_description,
                    quantity: this.form.quantity
                });
            }
        },
        open() {
            console.log("open " + this.promotionByPoints);
            if (this.recordId) {
                this.getRecord();
            }
        },
        initForm() {
            this.form = {
                description: null,
                date_start: null,
                date_end: null,
                items: []
            };
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>

<style></style>
