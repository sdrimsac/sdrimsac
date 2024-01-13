<template>
    <el-dialog
        :title="title"
        :visible="showDialog"
        width="80%"
        append-to-body
        @close="close"
        @open="open"
        v-loading="loading"
    >
        <div class="row mt-2">
            <label class="label-control w-100">
                Elige un salón para el estudiante
            </label>
        </div>
        <div class="row mt-2">
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
        <div class="row mt-2" v-if="records.length != 0">
            <table class="table">
                <thead>
                    <tr>
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
                            <div
                                class="d-flex justify-content-end"
                                v-if="record.students.length < record.places"
                            >
                                <el-button
                                    @click="register(record)"
                                    size="mini"
                                    type="success"
                                >
                                    Elegir
                                </el-button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div>
                <el-pagination
                    @current-change="getRecords"
                    layout="total, prev, pager, next"
                    :total="pagination.total"
                    :current-page.sync="pagination.current_page"
                    :page-size="pagination.per_page"
                >
                </el-pagination>
            </div>
        </div>
        <div class="row mt-2"></div>
    </el-dialog>
</template>

<script>
export default {
    props: [
        "showDialog",
        "student",
        "classroomId",
        "levels",
        "turns",
        "degrees",
        "sections"
    ],
    data() {
        return {
            loading: false,
            resource: "college/classrooms",
            title: "Cambiar de salón",
            search: {},
            pagination: {},
            records: []
        };
    },
    methods: {
        async register(classroom) {
            try {
                this.loading = true;
                let { id } = classroom;
                if (id == this.classroomId) {
                    this.$toast.error("No puedes cambiar al mismo salón");
                    return;
                }
                let {
                    member: { children_id }
                } = this.student;
                const response = await this.$http.post(
                    "/college/classrooms/change",
                    {
                        classroom_id_new: id,
                        classroom_id_old: this.classroomId,
                        student_id: children_id
                    }
                );
                if (response.status == 200) {
                    this.$toast.success(
                        "Se ha cambiado de salón correctamente"
                    );
                    this.$emit("getRecordsClose");
                    this.close();
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("Ha ocurrido un error");
            } finally {
                this.loading = false;
            }
        },
        query() {
            let q = "?";

            Object.keys(this.search).forEach(s => {
                q += `${s}=${this.search[s]}&`;
            });

            return q;
        },
        open() {
            console.log(this.student);
            let { name } = this.student;
            this.title = `Cambiar de salón a ${name}`;
        },
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/${this.resource}/records${this.query()}`
                );
                const { data, meta } = response.data;
                this.pagination = meta;
                // this.records = data
                this.records = data.filter(r => {
                    return r.students.length < r.places;
                });
                console.log(
                    "🚀 ~ file: modal_change_class_room.vue:201 ~ getRecords ~ this.records:",
                    this.records
                );
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
