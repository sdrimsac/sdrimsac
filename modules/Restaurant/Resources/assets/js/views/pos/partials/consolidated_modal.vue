<template>
    <el-dialog
        :visible="showDialog"
        title="Consolidado"
        @open="open"
        @close="close"
        append-to-body
        v-loading="loading"
    >
        <div class="row m-2">
            <div class="col-md-12 text-end">
                <el-button
                    type="primary"
                    @click="consolidate"
                    :disabled="!hasSelected"
                >
                    Consolidar
                </el-button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <el-checkbox
                                v-model="checkAll"
                                @change="handleCheckAll"
                            ></el-checkbox>
                        </th>
                        <th>
                            Cotización
                        </th>
                        <th>
                            Preventa
                        </th>
                        <th>
                            Fecha
                        </th>
                        <th>
                            Cliente
                        </th>
                        <th>
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="record in records" :key="record.id">
                        <td>
                            <el-checkbox v-model="record.checked"
                            @change="handleCheck(record)"
                            ></el-checkbox>
                        </td>
                        <td>{{ record.identifier }}</td>
                        <td>{{ record.user_name }}</td>
                        <td>{{ record.date_of_issue }}</td>
                        <td>
                            {{ record.customer_name }}
                            <br />
                            <small>
                                {{ record.customer_number }}
                            </small>
                        </td>
                        <td>{{ record.total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog"],
    data() {
        return {
            resource: "quotations",
            records: [],
            excludes: [],
            loading: false,
            checkAll: false,
            pagination: {},
            loading: false
        };
    },
    computed: {
        hasSelected() {
            return this.records.some(record => record.checked);
        }
    },
    methods: {
        handleCheck(record) {
            if (!record.checked) {
                this.excludes.push(record.id);
            } else {
                this.excludes = this.excludes.filter(id => id !== record.id);
            }
        },
        async consolidate() {
            let excludes = this.excludes;
            try {
                this.loading = true;
                const response = await this.$http.post(
                    `/${this.resource}/consolidated`,
                    { excludes }
                );
                if (response.data.success) {
                    this.$message.success(response.data.message);
                    this.close();
                } else {
                    this.$message.error(response.data.message);
                }
            } catch (e) {
                this.$message.error("Ocurrió un error al consolidar");
                console.error(e);
            }finally {
                this.loading = false;
            }
        },
        handleCheckAll() {
            this.records.forEach(record => {
                record.checked = this.checkAll;
            });
            if (!this.checkAll) {
                this.excludes = this.records.map(record => record.id);
            } else {
                this.excludes = [];
            }
        },
        open() {
            this.checkAll = false;
            this.excludes = [];

            this.getRecords();
        },
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/${this.resource}/to-consolidated`
                );
                this.pagination = response.data.meta;
                this.pagination.current_page = Number(
                    this.pagination.current_page
                );
                this.records = response.data.data.map(record => {
                    return {
                        ...record,
                        checked: true
                    };
                });
                // this.checkAll = true;
                // this.handleCheckAll();
            } catch (e) {
                console.error(e);
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

<style></style>
