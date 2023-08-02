<template>
    <el-dialog
        @close="close"
        @open="open"
        append-to-body
        width="40%"
        title="Enviar reporte por whatsapp"
        :visible="showWhatsappForm"
    >
        <div class="p-3" v-loading="loading" element-loading-text="Enviando..">
            <label for="">Número</label>
            <el-input v-model="number" style="width:100%"></el-input>
            <div class="d-flex justify-content-end p-1">
                <!-- <el-button @click="sendWhatsapp">Enviar</el-button> -->
                <el-button @click="send">Enviar</el-button>
            </div>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["resource", "message", "showWhatsappForm"],
    data() {
        return {
            loading: false,
            number: null,
            configuration: {}
        };
    },
    async created() {
        this.socketWhatsappConfig();
        await this.getConfiguration();
    },

    methods: {
        async send() {
            if (this.sender == "sdrimsac") {
                await this.sendWhatsapp();
            } else {
                await this.sendFile();
            }
        },
        async getConfiguration() {
            try {
                const response = await this.$http("/configurations/record");
                const {
                    data: { data }
                } = response;
                this.configuration = data;
            } catch (e) {
                this.$toast.error("No se pudo obtener la configuración");
            }
        },
        open() {},
        socketWhatsappConfig() {
            let hostName = window.location.hostname;
            let url = `https://${hostName}`;
            this.sender = hostName
                .replace(/https?\:\/\//, "")
                .replace("/", "")
                .split(".")
                .join("");
            try {
                this.socket = io.connect(this.$socketUrl);
            } catch (e) {
                console.log(e);
            }
            this.socket.on("ready", message => {
                this.showMessage(message);
            });
            this.socket.on("authenticated", ({ message, sender }) => {
                this.sender = sender;
                this.showMessage(message);
            });
            this.socket.on("connected", ({ message }) => {
                this.$message.success(message);

                this.socket.emit("getStatus", url);
            });
            this.socket.on("setStatus", ({ status, sender }) => {
                if (!status) {
                    this.sender = "sdrimsac";
                    this.$message.warning("Sesión iniciada con SDRIMSAC");
                } else {
                    this.sender = sender;
                    this.$message.success("Whatsapp Listo!");
                }
            });
            //MessageResponse
            this.socket.on("MessageResponse", ({ success, message }) => {
                if (success) {
                    this.$message.success(message);
                } else {
                    this.$message.error(message);
                }
            });
        },
        async getBase64FromUrl(url) {
            const data = await fetch(url);
            const blob = await data.blob();
            return new Promise(resolve => {
                const reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = () => {
                    const base64data = reader.result;
                    resolve(base64data);
                };
            });
        },
        async sendFile() {
            try {
                if (
                    !this.number ||
                    this.number.length != 9 ||
                    isNaN(this.number)
                ) {
                    return this.$toast.error("Ingrese un número válido");
                }
                this.loading = true;
                let b64 = await this.getBase64FromUrl(this.resource);
                let extension = ".pdf";
                if (this.resource.includes(".xlsx")) {
                    extension = ".xlsx";
                }
                b64 = b64.split(",")[1];
                this.socket.emit("sendFile", {
                    file: b64,
                    name: `${this.message.split(" ").join("-")}${extension}`,
                    number: `51${this.number}`,
                    sender: this.sender
                });
                this.$toast.success("Se envió el mensaje");
            } catch (e) {
                let msg = "Ocurrió un error";

                console.log(e);
                this.$toast.error(msg);
            } finally {
                this.loading = false;
            }
        },
        async sendWhatsapp() {
            if (!this.number || this.number.length != 9 || isNaN(this.number)) {
                return this.$toast.error("Ingrese un número válido");
            }
            this.loading = true;
            try {
                const response = await this.$http.post("/whatsapp/historial", {
                    number: this.number,
                    message: this.message,
                    resource: this.resource,
                    file_name: this.message.split(" ").join("-"),
                    sender: this.sender
                });

                if (response.status == 200) {
                    this.$toast.success("Mensaje enviado");
                }
            } catch (e) {
                this.$toast.error("Mensaje no enviado");
                console.log(e);
            } finally {
                this.loading = false;
                this.close();
            }
        },
        close() {
            this.number = null;

            this.$emit("update:showWhatsappForm", false);
        }
    }
};
</script>
