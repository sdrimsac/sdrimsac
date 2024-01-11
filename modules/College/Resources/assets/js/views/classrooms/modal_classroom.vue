<template>
    <el-dialog 
    title="Seleccionar salón"
    :visible="showDialog" @open="open" @close="close" append-to-body>
        <div class="row mt-2"></div>
        <div class="row m-2">
            <div class="col-12 col-md-3">
                <label class="label-control w-100">
                    Nivel
                </label>
                <el-select
                    v-model="search.level_id"
                    @change="getRecords"
                    clearable
                >
                    <el-option
                        v-for="level in levels"
                        :key="level.id"
                        :value="level.id"
                        :label="level.description"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-12 col-md-3">
                <label class="label-control w-100">
                    Turno
                </label>
                <el-select
                    v-model="search.turn_id"
                    @change="getRecords"
                    clearable
                >
                    <el-option
                        v-for="turn in turns"
                        :key="turn.id"
                        :value="turn.id"
                        :label="turn.description"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-12 col-md-3">
                <label class="label-control w-100">
                    Grado
                </label>
                <el-select
                    v-model="search.degree_id"
                    @change="getRecords"
                    clearable
                >
                    <el-option
                        v-for="degree in degrees"
                        :key="degree.id"
                        :value="degree.id"
                        :label="degree.description"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-12 col-md-3">
                <label class="label-control w-100">
                    Sección
                </label>
                <el-select
                    v-model="search.section_id"
                    @change="getRecords"
                    clearable
                >
                    <el-option
                        v-for="section in sections"
                        :key="section.id"
                        :value="section.id"
                        :label="section.description"
                    ></el-option>
                </el-select>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <!-- <th>#</th> -->
                        <th>Nivel</th>
                        <th>Grado</th>
                        <th>Sección</th>
                        <th>Turno</th>
                        <th>Alumnos</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(record, idx) in records" :key="idx">
                        <!-- <td>{{ customIndex(idx) }}</td> -->
                        <td>{{ record.level }}</td>
                        <td>{{ record.degree }}</td>
                        <td>
                            {{ record.section }}
                        </td>
                        <td>
                            {{ record.turn }}
                        </td>
                        <td>
                                {{ record.students.length }}/
                                {{ record.places }}
                        </td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <el-button
                                    v-if="
                                        record.students.length != record.places
                                    "
                                    @click="choose(record)"
                                    size="mini"
                                    type="primary"
                                    >Elegir</el-button
                                >
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: [
        "showDialog",
        "studentId",
        "sections",
        "levels",
        "turns",
        "degrees"
    ],
    data() {
        return {
            search: {
              
            },
            records: [],
            pagination: {},
            loading: false,
            resource: "college/classrooms"
        };
    },
    methods: {
        choose(record) {
            // console.log("🚀 ~ file: modal_classroom.vue:147 ~ choose ~ record:", record)
            this.$emit("update:showDialog", false);
            this.$emit("choose", record);
        },
        open() {
            console.log("open");
        },
        close() {
            this.$emit("update:showDialog", false);
        },
          query() {
            let q = "?";

            Object.keys(this.search).forEach(s => {
                q += `${s}=${this.search[s]}&`;
            });

            return q;
        },
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/${this.resource}/records${this.query()}`
                );
                const { data, meta } = response.data;
                this.pagination = meta;
                this.records = data;
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
