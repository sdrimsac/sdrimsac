<template>
    <div
        v-loading="loading"
        class="d-flex align-items-center justify-content-center flex-column"
        style="min-height: 350px;"
    >
        <div v-if="!isActive" class="d-flex justify-content-center">
            <div class="card p-3">
                <el-empty v-if="qr == null" :image-size="276"></el-empty>
                <div v-else style="width:276px;height: 276px;">
                    <img class="img" :src="qr" alt="código qr" />
                </div>
                <el-button :disabled="!whatsapp" @click="connect">
                    {{ message }}
                </el-button>
            </div>
        </div>
        <div v-else class="d-flex justify-content-center">
            <div class="card d-flex flex-column align-items-center">
                <el-alert
                    :closable="false"
                    title="Sesión activa"
                    type="success"
                    description="La sesión esta activada, puede enviar mensajes."
                    show-icon
                >
                </el-alert>
                <!-- <el-button type="danger" class="m-3" @click="destroySesion">
                    Eliminar sesión
                </el-button> -->
                <div class="p-3">
                    <label>Número</label>
                    <el-input v-model="number" style="width:100px;"></el-input>
                    <label>Mensaje</label>
                    <el-input
                        v-model="messageToSend"
                        style="width:100px;"
                    ></el-input>
                    <el-button type="success" class="m-3" @click="sendMessage">
                        Enviar
                    </el-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import image from "../worker/image.vue";
// import io from "";
export default {
    components: { image },
    props: ["configuration"],
    data() {
        return {
            number: null,
            messageToSend: null,
            isActive: false,
            loading: false,
            url: null,
            sender: null,
            qr: null,
            message: "CONECTAR A WHATSAPP",
            //
            whatsapp: true,
            socket: null
        };
    },
    beforeDestroy() {},
    mounted() {
        try {
            this.socket = io.connect(this.$socketUrl);
        } catch (e) {
            console.log(e);
        }
        let hostName = window.location.hostname;
        this.url = `https://${hostName}`;
        // this.sender = hostName
        //     .replace(/https?\:\/\//, "")
        //     .replace("/", "")
        //     .split(".")
        //     .join("");
        // console.log(this.sender);
        this.socket.on("connected", ({ message }) => {
            this.$message.success(message);
            this.socket.emit("getStatus", this.url);
            // this.socket.emit("tets", this.sender);
        });
        this.socket.on("setStatus", async ({ status, sender }) => {
            this.isActive = status;
            this.sender = sender;
            if (!status) {
                this.showMessage("Presione el botón para conectarse!");
            } else {
                this.whatsapp = !status;
                //
            }
        });
        this.socket.on("clientDestroy", message => {
            this.$message.warning(message);
            this.whatsapp = true;
            this.isActive = false;
            this.qr = null;
            this.message = "CONECTAR A WHATSAPP";
        });
        this.socket.on("message", message => {
            this.showMessage(message);
        });
        this.socket.on("registering", () => {
            this.whatsapp = false;
            this.message = "SOLICITANDO QR..";
        });
        this.socket.on("qr", ({ id, src }) => {
            this.qr = src;
            this.message = "ESCANEE EL QR";
        });
        this.socket.on("ready", message => {
            this.isActive = true;
            this.whatsapp = true;
            this.showMessage(message);
        });
        this.socket.on("authenticated", ({ message }) => {
            this.showMessage(message);
        });

        this.socket.on("MessageResponse", ({ success, message }) => {
            if (success) {
                this.$message.success(message);
            } else {
                this.$message.error(message);
            }
        });
        //authenticated
        // this.getStatus();
    },
    methods: {
        sendMessage() {
            if (this.number == undefined || this.messageToSend == undefined) {
                return this.$message.error("Número o mensaje no válido");
            }
            if (this.number.length != 9 || this.messageToSend.length < 3) {
                return this.$message.error("Número o mensaje no válido");
            }
            if (this.socket.connected) {
                this.socket.emit("basicMessage", {
                    message: this.messageToSend,
                    sender: this.sender,
                    number: "51" + this.number
                });
            }
        },
        destroySesion() {
            if (this.socket.connected) {
                this.socket.emit("clientDestroy", this.sender);
            } else {
                this.$message.warning("No se puede conectar con el servidor");
            }
        },
        showMessage(text, duration = 6000) {
            this.$message({
                message: text,
                duration,
                type: "success"
            });
        },
        createDateFormat() {
            let date = new Date();
            let dateString = date
                .toLocaleString()
                .replace(",", "")
                .split(" ");
            let [dateS, timeS] = dateString;
            dateS = dateS.split("/").join("_");
            timeS = timeS.split(":").join("_");
            return dateS + "-" + timeS;
        },
        connect() {
            let hostName = window.location.hostname;
            let name = hostName
                .replace(/https?\:\/\//, "")
                .replace("/", "")
                .split(".")
                .join("");
            let newDate = this.createDateFormat();
            this.sender = `${name}-${newDate}`;
            let body = {
                url: this.url,
                sender: this.sender,
                description: `Sesión de ${this.url}`
            };
            console.log(body);
            if (this.socket.connected) {
                this.socket.emit("initSesion", body);
            } else {
                this.$message.warning("No se puede conectar con el servidor");
            }
        }
    }
};
</script>
