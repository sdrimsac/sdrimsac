<template>
    <el-dialog
        :title="title"
        :visible="showDialog"
        append-to-body
        @open="open"
        @close="close"
        width="30%"
    >
        <div class="row-m-2">
            <div class="col-12">
                <label for="name">Número/Descripción</label>
                <el-input
                    v-model="form.name"
                    placeholder="Número/Descripción"
                ></el-input>
            </div>
            <div class="col-12" v-if="type == 'table_types'">
                <label for="price">Precio</label>
                <el-input
                    type="number"
                    v-model="form.price"
                    placeholder="precio"
                ></el-input>
            </div>
            <div class="col-12" v-if="type == 'floors'">
                <label for="name">Torre</label>
                <el-select
                    v-model="form.tower_id"
                    placeholder="Torre"
                    @change="filterFloors"
                >
                    <el-option
                        v-for="tower in all_towers"
                        :key="tower.id"
                        :label="tower.description"
                        :value="tower.id"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-12 mt-1">
                <el-button type="primary" @click="submit">Guardar</el-button>
                <el-button v-if="form.id" type="danger" @click="cancel"
                    >Cancelar</el-button
                >
            </div>
        </div>
        <div class="row m-2">
            <table class="table">
                <thead>
                    <tr>
                        <th>Descripción|Número</th>
                        <th v-if="type == 'floors'">Torre</th>
                        <th v-if="type == 'table_types'">Precio</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody v-if="type == 'floors'">
                    <tr v-for="(floor, idx) in floors" :key="idx">
                        <td>{{ floor.name }}</td>
                        <td>{{ floor.tower.name }}</td>
                        <td>
                            <button
                                @click="editFloor(floor.id)"
                                class="btn btn-primary btn-sm"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button
                                @click="removeItem(floor.id)"
                                class="btn btn-danger btn-sm"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else-if="type == 'towers'">
                    <tr v-for="(tower, idx) in all_towers" :key="idx">
                        <td>{{ tower.name }}</td>
                        <td>
                            <button
                                @click="editTower(tower.id)"
                                class="btn btn-primary btn-sm"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button
                                @click="removeItem(tower.id)"
                                class="btn btn-danger btn-sm"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr v-for="(type, idx) in all_table_types" :key="idx">
                        <td>{{ type.name }}</td>
                        <td>{{ type.price.toFixed(2) }}</td>
                        <td>
                            <button
                                @click="editType(type.id)"
                                class="btn btn-primary btn-sm"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button
                                @click="removeItem(type.id)"
                                class="btn btn-danger btn-sm"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "type"],
    data() {
        return {
            title: "",
            all_towers: [],
            all_floors: [],
            all_table_types: [],
            floors: [],
            form: {
                id: null,
                name: null,
                tower_id: null
            }
        };
    },
    methods: {
        initForm() {
            this.form = {
                id: null,
                name: null,
                tower_id: null
            };
        },
        setTitle() {
            this.title =
                this.type == "floors"
                    ? "Pisos"
                    : this.type == "towers"
                    ? "Torres"
                    : "Tipo de habitación";
        },
        cancel() {
            this.setTitle();
            this.initForm();
        },
        async removeItem(id) {
            try {
                await this.$confirm(
                    "¿Está seguro de eliminar este registro?",
                    "Advertencia",
                    {
                        confirmButtonText: "Eliminar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );
                try {
                    const response = await this.$http.delete(
                        `/caja/rooms/delete/${this.type}/${id}`
                    );
                    let { message } = response.data;
                    this.$toast.success(message);
                    this.initForm();
                    this.getTables();
                } catch (e) {
                    console.log(e);
                    this.$toast.error("Error al eliminar");
                }
            } catch (e) {}
        },

        editType(id) {
            this.form = { ...this.all_table_types.find(type => type.id == id) };

            this.title = "Editando tipo de habitación";
        },
        editTower(id) {
            this.form = { ...this.all_towers.find(tower => tower.id == id) };

            this.title = "Editando torre";
        },
        editFloor(id) {
            this.form = { ...this.all_floors.find(floor => floor.id == id) };

            this.title = "Editando piso";
        },
        filterFloors(tower_id) {
            this.floors = this.all_floors.filter(
                floor => floor.tower_id == tower_id
            );
        },
        async submit() {
            const response = await this.$http.post(
                `/caja/rooms/store/${this.type}`,
                this.form
            );
            if (response.status) {
                let { message } = response.data;
                this.$toast.success(message);
                this.setTitle();
                this.initForm();
                this.getTables();
            } else {
                let { message } = response.data;
                this.$toast.error(message);
            }
        },
        close() {
            this.initForm();
            this.$emit("update:showDialog", false);
        },
        async getTables() {
            try {
                const response = await this.$http.get(`/caja/rooms/tablas`);
                let { towers, floors, table_types } = response.data;
                this.all_towers = towers;
                this.all_floors = floors;
                this.all_table_types = table_types;
                let [tower] = towers;
                this.floors = this.all_floors.filter(
                    floor => floor.tower_id == tower.id
                );
            } catch (e) {
                console.log(e);
                this.$toast.error("Error al obtener las mesas");
            }
        },
        open() {
            this.setTitle();
            this.getTables();
        }
    }
};
</script>
