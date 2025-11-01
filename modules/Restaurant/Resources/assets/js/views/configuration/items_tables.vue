<template>
    <el-dialog
        :title="title"
        :visible="showDialog"
        append-to-body
        @open="open"
        @close="close"
        width="30%"
        :close-on-click-modal="false"
        class="rounded-dialog"
    >
        <div class="row-m-2">
            <div class="col-12" v-if="type == 'zones'">
                <label for="name">Establecimiento</label>
                <el-select
                    v-model="form.establishment_id"
                    placeholder="Seleccione establecimiento"
                    style="width: 100%;"
                    clearable
                    filterable
                >
                    <el-option
                        v-for="establishment in establishments"
                        :key="establishment.id"
                        :label="establishment.description"
                        :value="establishment.id"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-12">
                <label for="name">Número/Descripción</label>
                <el-input
                    v-model="form.name"
                    placeholder="Número/Descripción"
                ></el-input>
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
                        <th>Establecimiento</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody v-if="type == 'zones'">
                    <tr v-for="(zone, idx) in all_zones" :key="idx">
                        <td>{{ zone.name }}</td>
                        <td>{{ zone.description_establishment }}</td>
                        <td>
                            <button
                                @click="editZone(zone.id)"
                                class="btn btn-primary btn-sm"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button
                                @click="removeItem(zone.id)"
                                class="btn btn-danger btn-sm"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <td>no hay zona</td>
                </tbody>
            </table>
        </div>
    </el-dialog>
</template>

<style>
.el-dialog {
    border-radius: 10px; 
    overflow: hidden; 
  }
</style>

<script>
export default {
    props: ["showDialog", "type"],
    data() {
        return {
            title: "",
            all_zones: [],
            establishments: [],
            form: {
                id: null,
                name: null,
                establishment_id: null
            }
        };
    },
    methods: {
        initForm() {
            this.form = {
                id: null,
                name: null,
            };
        },
        setTitle() {
            this.title = "Zonas";
                
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
                        `/caja/tables/delete/${this.type}/${id}`
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

        editZone(id) {
            this.form = { ...this.all_zones.find(zone => zone.id == id) };

            this.title = "Editando zona";
        },
        /* filterFloors(tower_id) {
            this.floors = this.all_floors.filter(
                floor => floor.tower_id == tower_id
            );
        }, */
        async submit() {
            const response = await this.$http.post(
                `tables/store/${this.type}`,
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
                const response = await this.$http.get(`/caja/tables/tables-zone`);
                let { zones } = response.data;
                this.all_zones = zones;
                this.establishments = response.data.establishments;
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
