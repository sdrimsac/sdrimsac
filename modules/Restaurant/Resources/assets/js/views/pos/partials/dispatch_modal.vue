<template>
    <el-dialog
        title="Lista de guias"
        :visible="showDialog"
        @open="open"
        @close="close"
        v-loading="loading"
    >
        <div class="d-flex justify-content-end mt-2">
            <el-button type="primary" @click="showCreate = true">
                <i class="fas fa-plus"></i>
                Nuevo
            </el-button>
            <el-button @click="close">
                <i class="fas fa-times"></i>
                Cerrar
            </el-button>
        </div>
        <div class="row mt-2">
            <table
                class="table
            table-responsive table-striped table-bordered table-hover
            "
            >
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Numero</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(record, idx) in records" :key="idx">
                        <td>
                            {{ record.date_of_issue }}
                        </td>
                        <td>
                            {{ record.number }}
                        </td>
                        <td>
                            {{ record.customer_name }}
                        </td>
                        <td>
                            {{ record.state_type_description }}
                        </td>
                        <td>
                            <el-button
                                type="primary"
                                size="mini"
                                @click="openPdf(record, 'a4')"
                            >
                                <i class="fas fa-file"></i>
                                A4
                            </el-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <el-dialog
            class="guide-dialog"
            width="90%"
            :visible.sync="showCreate"
            append-to-body
        >
            <dispatch-create
                @records="getRecords"
                @closeDispatch="closeDispatch"
                :configuration="configuration"
                :pos="true"
            ></dispatch-create>
        </el-dialog>
    </el-dialog>
</template>
<style>
.guide-dialog .el-dialog__header {
    display: none;
}
.guide-dialog .el-dialog__body {
    padding: 0px !important;
}
</style>
<script>
const DispatchCreate = () =>
    import("../../../../../../../../resources/js/views/dispatches/create.vue");

export default {
    props: ["showDialog", "configuration"],
    components: {
        DispatchCreate
    },
    data() {
        return {
            showCreate: false,
            loading: false,
            resource: "dispatches",
            records: []
        };
    },
    methods: {
        openPdf(record, format) {
            window.open(
                `/print/dispatch/${record.external_id}/${format}`,
                "_blank"
            );
        },
        closeDispatch() {
            this.showCreate = false;
        },
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http(`/dispatches/records`);
                if (response.status == 200) {
                    const { data } = response.data;
                    this.records = data;
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        async open() {
            await this.getRecords();
        }
    }
};
</script>
