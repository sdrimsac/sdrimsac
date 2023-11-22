<template>
    <el-dialog
        @open="open"
        @close="close"
        :visible="showDialog"
        append-to-body
        :title="title"
        v-loading="loading"
    >
        <div class="row m-2 table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Promoción</th>
                        <th>Cantidad</th>
                        <th>Código</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(record, idx) in records" :key="idx">
                        <td>{{ record.name }}</td>
                        <td>{{ record.quantity }}</td>
                        <td>{{ record.code }}</td>
                        <td>
                            {{ record.active ? "Por entregar" : "Entregado" }}
                        </td>
                        <td>
                            <button
                                class="btn-sm btn-danger"
                                @click="desactiveService(record.id)"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                            <button
                                class="btn-sm btn-primary"
                                @click="printTicket(record.id)"
                            >
                                <i class="fas fa-print"></i>
                            </button>
                            <!-- <button
                                class="btn-sm btn-success"
                                @click="sendWhatsapp(record.id)"
                            >
                                <i class="fab fa-whatsapp"></i>
                            </button> -->
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "hotelRentItemId", "numberRoom"],
    data() {
        return {
            title: "Servicios",
            loading: false,
            form: {},
            records: []
        };
    },
    methods: {
        desactiveService() {},
        printTicket(id) {
            window.open(`/caja/rooms/print_service/${id}`, "_blank");
        },
        sendWhatsapp() {},
        async getServices() {
            try {
                this.loading = true;

                const response = await this.$http.get(
                    `/caja/rooms/services/${this.hotelRentItemId}`
                );

                if (response.status == 200) {
                    const {
                        data: { data }
                    } = response;
                    this.records = data;
                }
            } catch (e) {
                this.$toast.error("Error al obtener las promociones");
            } finally {
                this.loading = false;
            }
        },
        open() {
            this.title = "Promociones de la habitación " + this.numberRoom;
            this.getServices();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
