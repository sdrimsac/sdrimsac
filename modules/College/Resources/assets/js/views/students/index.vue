<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Lista de estudiantes</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Lista de estudiantes</span
                                >
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card" v-loading="loading">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">Lista de estudiantes</h6>
                </div>
                <div class="card-body">
                    <div class="col-md-12 col-lg-12 col-xl-12 mb-2">
                        <div class="row ">
                            <div class="col-md-12 col-lg-12 col-xl-12 ">
                                <div class="row" v-if="applyFilter">
                                    <div
                                        class="col-lg-4 col-md-4 col-sm-12 pb-2"
                                    >
                                        <div class="d-flex">
                                            <div style="width:100px">
                                                Filtrar por:
                                            </div>
                                            <el-select
                                                v-model="search.column"
                                                placeholder="Select"
                                            >
                                                <el-option
                                                    v-for="(label,
                                                    key) in columns"
                                                    :key="key"
                                                    :value="key"
                                                    :label="label"
                                                ></el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                    <div
                                        class="col-lg-3 col-md-4 col-sm-12 pb-2"
                                    >
                                        <el-input
                                            placeholder="Buscar"
                                            v-model="search.value"
                                            style="width: 100%;"
                                            prefix-icon="el-icon-search"
                                            @input="filterRecords"
                                        >
                                        </el-input>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Clase</th>
                                                <th>Nivel</th>
                                                <th>Turno</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(row, index) in records"
                                                :key="index"
                                            >
                                                <td>
                                                    {{ customIndex(index) }}
                                                </td>
                                                <td>
                                                    {{ row.student.name }}
                                                    <br /><small>
                                                        {{ row.student.number }}
                                                    </small>
                                                </td>
                                                <td>
                                                    {{ row.classroom }}
                                                </td>
                                                <td>{{ row.level }}</td>
                                                <td>{{ row.turn }}</td>
                                                <td>
                                                    <el-button
                                                        v-if="row.payCompleted"
                                                        @click="
                                                            openFormPayment(row)
                                                        "
                                                        type="success"
                                                    >
                                                        Mensualidad
                                                    </el-button>

                                                    <el-button
                                                        v-if="row.payCompleted"
                                                        @click="
                                                            openFormPayments(
                                                                row
                                                            )
                                                        "
                                                        type="primary"
                                                    >
                                                        Ver tramites
                                                    </el-button>
                                                    <el-button
                                                        v-else
                                                        @click="
                                                            openFormPayments(
                                                                row
                                                            )
                                                        "
                                                        type="danger"
                                                    >
                                                        Cancelar pagos
                                                    </el-button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div>
                                        <el-pagination
                                            @current-change="getRecords(true)"
                                            layout="total, prev, pager, next"
                                            :total="pagination.total"
                                            :current-page.sync="
                                                pagination.current_page
                                            "
                                            :page-size="pagination.per_page"
                                        >
                                        </el-pagination>
                                    </div>
                                </div>
                            </div>
                            <payment-college
                                title="Servicio"
                                :is_payment.sync="showPayment"
                                @getRecords="getRecords"
                                type="service"
                                :member="member"
                                :classroomId="classroomId"
                            ></payment-college>
                            <payments-form
                                title="Tramites"
                                :showDialog.sync="showPaymentsForm"
                                :member="member"
                                @getRecords="getRecords"
                            ></payments-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const PaymentCollege = () => import("../../components/payment_college.vue");
const PaymentsForm = () => import("../../components/payment_form.vue");
import queryString from "query-string";
export default {
    components: { PaymentCollege, PaymentsForm },
    data() {
        return {
            resource: "college/students",
            pagination: {},
            records: [],
            applyFilter: true,

            search: {
                column: "description"
            },
            columns: [],
            loading: false,
            showCreateForm: false,
            showViewChildren: false,
            parentIdChildrenView: null,
            timer: null,
            showPayment: false,
            showPaymentsForm: false,
            member: null,
            classroomId: null,
            title: null
        };
    },
    async created() {
        this.getColumns();
        this.getRecords();
    },
    methods: {
        openFormPayments(record) {
            this.showPaymentsForm = true;
            this.member = record.member;
        },
        openFormPayment(record) {
            this.showPayment = true;
            this.member = record.member;
            this.classroomId = record.classroom_id;
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        async getColumns() {
            try {
                this.loading = true;
                const response = await this.$http(`/${this.resource}/columns`);
                this.columns = response.data;
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
             getQueryParameters() {
        
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                value: this.search.value,
                column: this.search.column
            });
        },
        async filterRecords(){
                this.getRecords();
        },
        async getRecords(pagination = false) {
            if (this.timer) {
                clearTimeout(this.timer);
            }
            let ms = pagination ? 0 : 450;
            this.timer = setTimeout(async () => {
                try {
                    this.loading = true;
                    // const response = await this.$http(
                    //     `/${this.resource}/records?${
                    //         this.search.column && this.search.value
                    //             ? `${this.search.column}=${this.search.value}`
                    //             : ""
                    //     }`
                    // );

                      const response = await this.$http(
                        `/${this.resource}/records?${this.getQueryParameters()
                        }`
                    );
                    let { data, meta } = response.data;
                    this.records = data;
                    this.pagination = meta;
                } catch (e) {
                    console.log(e);
                } finally {
                    this.loading = false;
                }
            }, ms);
        }
    }
};
</script>
