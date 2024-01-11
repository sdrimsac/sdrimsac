<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>
                            <span>Lista de salones</span>
                        </h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Lista de salones</span>
                            </li>
                        </ol>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <button
                            type="button"
                            class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                            @click.prevent="clickCreate()"
                        >
                            <i class="icofont-plus-circle"></i>
                            <span>Nuevo</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card" v-loading="loading">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">
                        {{ `Lista de salones` }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="col-md-12 col-lg-12 col-xl-12 mb-2">
                        <div class="d-flex justify-content-end">
                            <div class="col-3 text-end">
                                <el-button
                                    type="primary"
                                    @click="clickMultiRegister"
                                    >Multi matricula</el-button
                                >
                            </div>
                        </div>
                        <div class="row">
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
                        <div class="row mt-2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nivel</th>
                                        <th>Grado</th>
                                        <th>Sección</th>
                                        <th>Turno</th>
                                        <th>Alumnos</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(record, idx) in records"
                                        :key="idx"
                                    >
                                        <td>{{ customIndex(idx) }}</td>
                                        <td>{{ record.level }}</td>
                                        <td>{{ record.degree }}</td>
                                        <td>
                                            {{ record.section }}
                                        </td>
                                        <td>
                                            {{ record.turn }}
                                        </td>
                                        <td>
                                            <el-button
                                                @click="viewStudents(record.id)"
                                                icon="el-icon-search"
                                            >
                                                {{ record.students.length }}/
                                                {{ record.places }}
                                            </el-button>
                                        </td>
                                        <td>
                                            <div
                                                class="d-flex justify-content-end"
                                            >
                                                <el-button
                                                    v-if="
                                                        record.students
                                                            .length !=
                                                            record.places
                                                    "
                                                    size="mini"
                                                    type="primary"
                                                    @click="
                                                        clickRegister(record)
                                                    "
                                                    >Matricular</el-button
                                                >
                                                <el-button
                                                    size="mini"
                                                    type="primary"
                                                    @click="clickCreate(record)"
                                                    >Editar</el-button
                                                >
                                                <el-button
                                                    @click="desactive(record)"
                                                    size="mini"
                                                    :type="
                                                        record.active
                                                            ? 'danger'
                                                            : 'success'
                                                    "
                                                    >{{
                                                        record.active
                                                            ? "Desactivar"
                                                            : "Activar"
                                                    }}</el-button
                                                >
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
                    </div>
                </div>
            </div>
        </div>
        <create-form
            :showDialog.sync="showCreateForm"
            :record.sync="recordCreateForm"
            @getRecords="getRecords"
            :sections="sections"
            :levels="levels"
            :turns="turns"
            :degrees="degrees"
        >
        </create-form>

        <!-- <create-register-form
            :showDialog.sync="showCreateRegisterForm"
            :record.sync="recordCreateRegisterForm"
            @getRecords="getRecords"
        >
        </create-register-form> -->

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
            :multiRegister.sync="multiRegister"
            :sections.sync="sections"
            :levels.sync="levels"
            :turns.sync="turns"
            :degrees.sync="degrees"
        >
        </payment-form>
    </div>
</template>

<script>
const CreateForm = () => import("./form.vue");
const CreateRegisterForm = () => import("./register_form.vue");
const PaymentForm = () => import("../../components/payment_college.vue");
const StudentView = () => import("./student_view.vue");
export default {
    props: ["configuration"],
    components: { CreateForm, CreateRegisterForm, PaymentForm, StudentView },
    data() {
        return {
            loading: false,
            resource: "college/classrooms",
            search: {},
            multiRegister: false,
            recordCreateForm: null,
            recordCreateRegisterForm: null,
            pagination: {},
            showCreateForm: false,
            showCreateRegisterForm: false,
            records: [],
            showPayment: false,
            paymentTitle: null,
            sections: [],
            levels: [],
            turns: [],
            degrees: [],
            showStudentsView: false,
            recordViewStudent: null
        };
    },
    async created() {
        // this.getColumns();
        await this.getRecords();
        await this.getTables();

        qz.security.setCertificatePromise((resolve, reject) => {
            this.$http
                .get("/api/qz/crt/override", {
                    responseType: "text"
                })
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.data);
                });
        });
        qz.security.setSignaturePromise(toSign => {
            return (resolve, reject) => {
                this.$http
                    .post("/api/qz/signing", {
                        request: toSign
                    })
                    .then(response => {
                        resolve(response.data);
                    })
                    .catch(error => {
                        reject(error.data);
                    });
            };
        });
    },
    mounted() {
        Echo.channel("print_orden").listen(
            `.print-order-${this.configuration.socket_channel}`,
            e => {
                console.log("imprimiendo", e);
                if (e.data.direct_printing == true) {
                    if (e.data.printing == true) {
                        this.Printer(
                            e.data.printer,
                            e.data.print,
                            e.data.copies,
                            e.data.user_id,
                            e.data.multiple_boxes,
                            e.data.typeuser,
                            e.data.printing
                        );
                    }
                }
            }
        );
    },
    methods: {
        clickMultiRegister() {
            this.showPayment = true;
            this.multiRegister = true;
        },
        async Printer(Printer, linkpdf, copies) {
            let paperConfig = {
                scaleContent: false
            };
            let partsUrl = linkpdf.split("/");
            let document = partsUrl[partsUrl.length - 1];
            let isTicket = document.toLowerCase().includes("ticket");

            let tipoBandejaImpresora = this.configuration.new_old_printer;

            if (!isTicket && tipoBandejaImpresora == 1) {
                paperConfig.density = 600;
                paperConfig.orientation = "portrait";
                paperConfig.margins = { left: 2 };
            } else if (!isTicket && tipoBandejaImpresora == 0) {
                paperConfig.density = 350;
                paperConfig.orientation = "portrait";
            }
            let config = qz.configs.create(Printer, paperConfig);

            if (!qz.websocket.isActive()) {
                await qz.websocket.connect(config);
            }
            let data = [
                {
                    type: "pdf",
                    format: "file",
                    data: linkpdf
                }
            ];

            qz.print(config, data).catch(e => {
                this.$toast.error(e.message);
            });
            for (let index = 0; index < copies; index++) {
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });
            }
        },
        viewStudents(record) {
            this.showStudentsView = true;
            this.recordViewStudent = record;
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        async getTables() {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/${this.resource}/tables`
                );
                const { sections, turns, levels, degrees } = response.data;
                this.sections = sections;
                this.levels = levels;
                this.turns = turns;
                this.degrees = degrees;
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un problema");
            } finally {
                this.loading = false;
            }
        },
        searchItem() {},
        clickRegister(record) {
            this.recordCreateRegisterForm = record;
            this.showPayment = true;
            this.paymentTitle = `Matricula ${record.level} | ${record.degree}-${record.section} | ${record.turn}`;
            // this.showCreateRegisterForm = true;
        },
        clickCreate(record = null) {
            this.search = {};
            this.recordCreateForm = record;

            this.showCreateForm = true;
        },
        async desactive(record) {
            try {
                this.loading = true;
                const response = await this.$http.post(`classrooms/active`, {
                    id: record.id
                });
                const { message, success } = response.data;
                if (success) {
                    this.$toast.success(message);
                    this.getRecords();
                } else {
                    this.$toast.error(message);
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un problema");
            } finally {
                this.loading = false;
            }
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
        },
        query() {
            let q = "?";

            Object.keys(this.search).forEach(s => {
                q += `${s}=${this.search[s]}&`;
            });

            return q;
        }
    }
};
</script>
