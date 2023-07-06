<template>
    <el-dialog
        :visible="showDialog"
        append-to-body
        @open="open"
        @close="close"
        title="Lista de series"
        width="300px"
        v-loading="loading"
    >
        <table width="100%">
            <thead>
                <tr width="100%">
                    <th v-if="lots.length > 0">SERIE</th>
                    <th v-if="lots.length > 0">FECHA</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in lots" :key="index" width="100%">
                    <td>
                        <span>{{ row.series }}</span>
                    </td>

                    <td>
                        <span>{{ row.date }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "recordId"],
    data() {
        return {
            lots: [],
            resource: "/consignment",
            loading: false
        };
    },
    methods: {
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `${this.resource}/items_lot/${this.recordId}`
                );
                this.lots = response.data.lots;
                console.log(response);
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        open() {
            this.getRecords();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
