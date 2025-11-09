<template>
    <el-dialog @close="close" @open="open" append-to-body width="40%" title="Enviar Reporte"
        :visible="showWhatsappForm">
        <div class="p-1" v-loading="loading" element-loading-text="Enviando..">
            <div class="d-flex">
                <div class="flex-grow-1 me-2" style="flex: 0 0 70%;">
                    <label for="" style="font-size: 1em;">Ingrese Número de WhatsApp Válido</label>
                    <el-input v-model="number" inputmode="numeric" type="text" placeholder="Ingrese 9 dígitos"
                        :maxlength="9" show-word-limit @input="number = String($event).replace(/\D/g, '').slice(0, 9)"
                        style="width:100%"></el-input>
                </div>
                <div class="d-flex align-items-center justify-content-center" style="flex: 0 0 30%;">
                    <el-button @click="send" style="width: 100%; max-width: 160px;" class="btn_whatsappsmall" type="success">
                        <i class="icofont-brand-whatsapp"></i>
                        Enviar
                    </el-button>
                </div>
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
            configuration: {},
            // Safe defaults to avoid undefined access
            sender: "sdrimsac",
            socket: null
        };
    },
    async created() {
        // Try to initialize Socket connection when available; fallback is HTTP
        try {
            this.socketWhatsappConfig();
        } catch (e) {
            // Ignore and keep HTTP fallback
            console.debug("Socket init skipped:", e);
        }
        await this.getConfiguration();
    },

    methods: {
        async send() {
            // If no socket or explicitly using SDRIMSAC, send via HTTP
            const canUseSocket = this.socket && this.sender && this.sender !== "sdrimsac";
            if (!canUseSocket) {
                await this.sendWhatsapp();
                return;
            }
            await this.sendFile();
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
        open() { },
        socketWhatsappConfig() {
            let hostName = window.location.hostname;
            let url = `https://${hostName}`;
            this.sender = hostName
                .replace(/https?\:\/\//, "")
                .replace("/", "")
                .split(".")
                .join("");
            // If Socket.IO isn't available, keep HTTP fallback
            try {
                if (typeof io !== "undefined" && this.$socketUrl) {
                    this.socket = io.connect(this.$socketUrl);
                } else {
                    this.socket = null;
                    this.sender = "sdrimsac";
                    return; // stop wiring listeners
                }
            } catch (e) {
                console.log(e);
                this.socket = null;
                this.sender = "sdrimsac";
                return;
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
                // Guard: if socket not available, fallback to HTTP
                if (!this.socket) {
                    return await this.sendWhatsapp();
                }
                this.loading = true;
                let b64 = await this.getBase64FromUrl(this.resource);
                let extension = ".pdf";

                b64 = b64.split(",")[1];
                this.socket.emit("sendFile", {
                    file: b64,
                    name: `${this.message.split(" ").join("-")}${this.message.includes(".xlsx") ? "" : extension}`,
                    number: `51${this.number}`,
                    sender: this.sender
                });
                this.$toast.success("Se envió el mensaje");
                this.close();
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
