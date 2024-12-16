<template>
    <el-dialog
        title="PAGOS DIGITAL"
        :visible="showDigitalPay"
        @open="openDigitalPay"
        @close="closeDigitalPay"
        append-to-body
    >   
    <div class="row m-3">
        <div class="col-md-4">
            <el-input
                v-model="filters.person_name"
                placeholder="Buscar por persona"
                clearable
                @input="searchWithDebounce"
            >
            </el-input>
        </div>
        <div class="col-md-4">
            <el-input
                v-model="filters.amount"
                placeholder="Buscar por monto"
                type="number"
                clearable
                @input="searchWithDebounce"
            >
            </el-input>
        </div>
        <div class="col-md-4">
            <el-date-picker
                v-model="filters.date"
                type="date"
                placeholder="Seleccionar fecha"
                format="yyyy-MM-dd"
                value-format="yyyy-MM-dd"
                @change="getDigitalPayments"
                clearable
            >
            </el-date-picker>
        </div>
    </div>
        <div class="row m-3" v-loading="loading">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Persona</th>
                        <th scope="col">Monto</th>
                        <th scope="col">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="payment in digitalPayments" :key="payment.id">
                        <td>{{ payment.person_name }}</td>
                        <td>{{ payment.amount }}</td>
                        <td>{{ payment.created_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <el-pagination
            @current-change="getDigitalPayments"
            layout="total, prev, pager, next"
            :total="pagination.total"
            :current-page.sync="pagination.current_page"
            :page-size="pagination.per_page"
        >
        </el-pagination>
    </el-dialog>
</template>

<script>
export default {
    name: "DigitalPayComponent",
    props: {
        showDigitalPay: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            digitalPayments: [],
            pagination: {
            
            },
            loading: false,
            filters: {
                person_name: '',
                amount: '',
                date: null
            },
            debounceTimer: null
        };
    },
    methods: {
        searchWithDebounce() {
            console.log("searchWithDebounce ejecutado", this.filters);
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.getDigitalPayments();
            }, 500);
        },
        getDigitalPayments() {
            this.loading = true;
            this.$http.get("/digital-payments", {
                params: this.filters
            }).then(response => {
                this.digitalPayments = response.data.data;
                this.pagination = response.data.meta;
                this.pagination.per_page = parseInt(
                    response.data.meta.per_page
                );
            })
            .catch(error => {
                this.$message.error("Error al obtener los pagos digitales");
            })
            .finally(() => {
                this.loading = false;
            });
        },
        openDigitalPay() {
            this.getDigitalPayments();
        },
        closeDigitalPay() {
            this.$emit("update:showDigitalPay", false);
        }
    }
};
</script>
