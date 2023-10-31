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
            <div class="col-12">
                <el-button type="primary" @click="submit">Guardar</el-button>
            </div>
        </div>
        <div class="row m-2">
            <table class="table">
                <thead>
                    <tr>
                        <th>Descripción|Número</th>
                        <th v-if="type == 'floors'">Torre</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody v-if="type == 'floors'">
                    <tr v-for="(floor, idx) in floors" :key="idx">
                        <td>{{ floor.name }}</td>
                        <td>{{ floor.tower.name }}</td>
                        <td></td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr v-for="(tower, idx) in all_towers" :key="idx">
                        <td>{{ tower.name }}</td>
                        <td></td>
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
            floors: [],
            form: {
                name: "",
                tower_id: ""
            }
        };
    },
    methods: {
        filterFloors(tower_id) {
            this.floors = this.all_floors.filter(
                floor => floor.tower_id == tower_id
            );
        },
        submit() {},
        close() {
            this.$emit("update:showDialog", false);
        },
        async getTables() {
            try {
                const response = await this.$http.get(`/caja/rooms/tablas`);
                let { towers, floors } = response.data;
                this.all_towers = towers;
                this.all_floors = floors;
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
            this.title = this.type == "floors" ? "Pisos" : "Torres";
            this.getTables();
        }
    }
};
</script>
