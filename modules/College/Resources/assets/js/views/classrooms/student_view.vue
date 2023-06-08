<template>
    <el-dialog
        @open="open"
        @close="close"
        :visible="showDialog"
        v-loading="loading"
        width="650px"
        append-to-body
        title="Lista de estudiantes"
    >
        <div class="row mt-4">
            <div class="col-12">
                <el-input
                    placeholder="Nombre/documento"
                    v-model="description"
                    @input="searchStudent"
                >
                    <i slot="prefix" class="el-input__icon el-icon-search"></i>
                </el-input>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(student, idx) in students" :key="idx">
                    <td>{{ idx + 1 }}</td>
                    <td>
                        {{ student.name }}
                        <br />
                        <small>{{ student.number }}</small>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <el-button
                                v-if="!student.incomplete"
                                @click="openPayment(student)"
                                type="success"
                            >
                                Mensualidad
                            </el-button>
                            <!-- <el-button
                                v-if="!student.incomplete"
                                type="success"
                                @click="openPayment(student)"
                            >
                                Mensualidad
                            </el-button> -->

                            <el-button
                                v-if="!student.incomplete"
                                @click="openFormPayments(student)"
                                type="primary"
                            >
                                Ver tramites
                            </el-button>
                            <el-button
                                v-else
                                @click="openFormPayments(student)"
                                type="danger"
                            >
                                Cancelar pagos
                            </el-button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <payment-college
            title="Servicio"
            :is_payment.sync="showPayment"
            @getRecords="open"
            type="service"
            :member.sync="member"
            :classroomId="classroomId"
        ></payment-college>
        <payments-form
            title="Tramites"
            :showDialog.sync="showPaymentsForm"
            :member="member"
            @getRecords="getRecords"
        ></payments-form>
    </el-dialog>
</template>

<script>
const PaymentCollege = () => import("../../components/payment_college.vue");
const PaymentsForm = () => import("../../components/payment_form.vue");
export default {
    props: ["showDialog", "classroomId"],
    components: { PaymentCollege, PaymentsForm },
    data() {
        return {
            loading: false,
            students: [],
            allStudents: [],
            description: null,
            showPayment: false,
            member: null,
            showPaymentsForm: false
        };
    },
    methods: {
        getRecords() {
            
        },
        openFormPayments(record) {
            this.showPaymentsForm = true;
            this.member = record.member;
        },
        openPayment(record) {
            this.showPayment = true;
            this.member = record.member;
        },
        searchStudent() {
            let desc = this.description.toLowerCase();
            this.students = this.allStudents.filter(s => {
                if (
                    s.name.toLowerCase().includes(desc) ||
                    s.number.toLowerCase().includes(desc)
                ) {
                    return s;
                }
            });
        },
        async open() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/college/classrooms/${this.classroomId}`
                );

                this.allStudents = response.data;
                this.students = this.allStudents;
                console.log(this.students);
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
