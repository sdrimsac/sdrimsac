<template>
    <el-dialog
        title="Matriculas/Mensualidades"
        :visible="showDialog"
        v-loading="loading"
        @open="open"
        @close="close"
        append-to-body
    >
        <div class="row mt-3">
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
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>
                        SALON
                    </th>
                    <th>ALUMNOS</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(classroom, idx) in classes" :key="idx">
                    <td>{{ idx + 1 }}</td>
                    <td>
                        <span class="d-block">
                            {{ classroom.degree }} {{ classroom.section }}</span
                        >
                        <span class="small">
                            {{ classroom.level }} {{ classroom.turn }}
                        </span>
                    </td>
                    <td>
                        <el-button
                            @click="viewStudents(classroom.id)"
                            icon="el-icon-search"
                        >
                            {{ classroom.students.length }}/
                            {{ classroom.places }}
                        </el-button>
                    </td>

                    <td>
                        <div class="d-flex justify-content-end">
                            <el-button
                                v-if="
                                    classroom.students.length !=
                                        classroom.places
                                "
                                size="mini"
                                type="primary"
                                @click="clickRegister(classroom)"
                                >Matricular</el-button
                            >
                            <el-button
                                size="mini"
                                type="primary"
                                @click="clickCreate(classroom)"
                                >Editar</el-button
                            >
                            <el-button
                                @click="desactive(classroom)"
                                size="mini"
                                :type="classroom.active ? 'danger' : 'success'"
                                >{{
                                    classroom.active ? "Desactivar" : "Activar"
                                }}</el-button
                            >
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <student-view
            :showDialog.sync="showStudentsView"
            :classroomId="recordViewStudent"
        >
        </student-view>
        <payment-form
            type="register"
            :title="paymentTitle"
            :record="recordCreateRegisterForm"
            :is_payment.sync="showPayment"
            @getRecords="getRecords"
        >
        </payment-form>
    </el-dialog>
</template>

<script>
const CreateForm = () =>
    import(
        "../../../../../../../College/Resources/assets/js/views/classrooms/form.vue"
    );
const CreateRegisterForm = () =>
    import(
        "../../../../../../../College/Resources/assets/js/views/classrooms/register_form.vue"
    );
const StudentView = () =>
    import(
        "../../../../../../../College/Resources/assets/js/views/classrooms/student_view.vue"
    );
const PaymentForm = () =>
    import(
        "../../../../../../../College/Resources/assets/js/components/payment_college.vue"
    );

export default {
    props: ["showDialog", "configuration"],
    components: { CreateForm, CreateRegisterForm, PaymentForm, StudentView },
    created() {
        this.getTables();
    },
    data() {
        return {
            loading: false,
            classes: [],
            pagination: {},
            levels: [],
            degrees: [],
            sections: [],
            turns: [],
            search: {},
            recordViewStudent: null,
            showStudentsView: false,
            recordCreateRegisterForm: null,
            showPayment: false,
            paymentTitle: null
        };
    },
    methods: {
        clickRegister(record) {
            this.recordCreateRegisterForm = record;
            this.showPayment = true;
            this.paymentTitle = `Matricula ${record.level} | ${record.degree}-${record.section} | ${record.turn}`;
        },
        clickCreate() {},
        desactive() {},
        viewStudents(record) {
            this.showStudentsView = true;
            this.recordViewStudent = record;
        },
        query() {
            let q = "?";

            Object.keys(this.search).forEach(s => {
                q += `${s}=${this.search[s]}&`;
            });

            return q;
        },
        async getRecords() {
            //${this.query()}`
            try {
                this.loading = true;
                const response = await this.$http(
                    `/college/classrooms/records${this.query()}`
                );

                const {
                    data: { data }
                } = response;
                this.classes = data;
            } catch {
            } finally {
                this.loading = false;
            }
        },
        async getTables() {
            try {
                this.loading = true;
                const response = await this.$http("/college/classrooms/tables");
                const { data } = response;
                this.levels = data.levels;
                this.degrees = data.degrees;
                this.sections = data.sections;
                this.turns = data.turns;
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        async open() {
            await this.getRecords();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
