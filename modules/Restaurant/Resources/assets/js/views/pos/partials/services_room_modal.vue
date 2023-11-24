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
                           <template v-if="record.active">
                            <el-tooltip
                           :content="`Dar por entregado`"
                           >
                              <button
                                class="btn-sm btn-success"
                                @click="desactiveService(record.id)"
                            >
                                <i class="fas fa-check"></i>
                            </button>
                           </el-tooltip>
                           <el-tooltip
                           :content="`Eliminar servicio`"
                           >
                              <button
                                class="btn-sm btn-danger"
                                @click="deleteService(record.id)"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                           </el-tooltip>
                            <button
                                class="btn-sm btn-primary"
                                @click="printTicket(record.id)"
                            >
                                <i class="fas fa-print"></i>
                            </button>
                           </template>
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
    props: ["showDialog", "hotelRentItemId", "numberRoom","printer"],
    data() {
        return {
            title: "Servicios",
            loading: false,
            form: {},
            records: []
        };
    },
    created(){
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
                        .post("/api/qz/signing", { request: toSign })
                        .then(response => {
                            resolve(response.data);
                        })
                        .catch(error => {
                            reject(error.data);
                        });
                };
            });
    },
    methods: {
           async Printer(
            linkpdf,
          
        ) {
            let paperConfig = {
                scaleContent: false
            };
            let isTicket = linkpdf.toLowerCase().includes("ticket");

              if(!isTicket){
                let print_service = linkpdf.includes("print_service");
                isTicket = print_service;
            }

                // let orientation = "portrait";
               

               
            let config = qz.configs.create(this.printer, paperConfig);

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
          
       
        },
       async desactiveService(id) {
               try{
               await this.$confirm(
                    "¿Está seguro que desea dar por entregado este servicio?",
                    "Advertencia",
                    {
                        confirmButtonText: "Sí",
                        cancelButtonText: "No",
                        type: "warning"
                    }
                );
                this.loading = true;
                const response = await this.$http(
                    `/caja/rooms/success_service/${id}`
                );
                if (response.status == 200) {
                    this.$message({
                        message: "Servicio entregado correctamente",
                        type: "success"
                    });
                    this.getServices();
                }
            }catch(e){
                this.$toast.error(e.message);
            }finally{
                this.loading = false;
            }
        },
      async  deleteService(id) {
            try{
                await this.$confirm(
                    "¿Está seguro que desea eliminar este servicio?",
                    "Advertencia",
                    {
                        confirmButtonText: "Sí",
                        cancelButtonText: "No",
                        type: "warning"
                    }
                );
                this.loading = true;
                const response = await this.$http.delete(
                    `/caja/rooms/delete_service/${id}`
                );
                if (response.status == 200) {
                    this.$message({
                        message: "Servicio eliminado correctamente",
                        type: "success"
                    });
                    this.getServices();
                }
            }catch(e){
                this.$toast.error(e.message);
            }finally{
                this.loading = false;
            }
        },
        printTicket(id) {
            this.Printer(`/caja/rooms/print_service/${id}`);
            // window.open(`/caja/rooms/print_service/${id}`, "_blank");
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
