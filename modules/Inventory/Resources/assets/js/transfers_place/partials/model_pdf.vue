<!-- Imprimir Acciones  CPE  -->
<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @open="create"
        @close="close()"
        append-to-body
    >
        <div class="row mb-4">
            <div class="col-md-12"></div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                <el-card class="box-card">
                    <div slot="header" class="clearfix">
                        <span>Seleccione Formato a Imprimir</span>
                    </div>
                    <div class="row justify-content-center">
                        <!-- Boton Imprimir A4 -->
                        <div
                            class="col-lg-3 col-md-3 col-sm-12 text-center font-weight-bold mt-3"
                        >
                            <button
                                type="button"
                                class="btn_imprimir"
                                @click="clickPrint('a4')"
                            >
                                <i class="fa fa-file-alt fa-2x"></i> A4
                            </button>
                        </div>

                        <!-- Boton Imprimir A5 -->
                        <!-- <div class="col-lg-3 col-md-3 col-sm-12 text-center font-weight-bold mt-3">
                            <button
                                type="button"
                                class="btn_imprimir"
                                @click="clickPrint('a5')"
                            >
                                <i class="fa fa-file fa-2x"></i> A5
                            </button>
                        </div> -->

                        <!-- Boton Imprimir Ticket 80mm -->
                        <div
                            class="col-lg-3 col-md-3 col-sm-12 text-center font-weight-bold mt-3"
                        >
                            <button
                                type="button"
                                class="btn_imprimir"
                                @click="clickPrint('ticket')"
                            >
                                <i class="fa fa-receipt fa-2x"></i> 80mm
                            </button>
                        </div>
                    </div>
                </el-card>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <el-input
                    v-model="form.customer_email"
                    placeholder="Ingrese Correo Electrónico - tucorreo@gmail.com"
                >
                    <el-button
                        slot="append"
                        @click="clickSendEmail"
                        :loading="loading"
                        style="color: navy; font-size: 18px;"
                    >
                        <i
                            class="el-icon-message"
                            style="font-size: 24px; color: navy;"
                        ></i>
                        Enviar
                    </el-button>
                    <i slot="prefix" class="el-icon-edit-outline"></i>
                </el-input>
                <small
                    class="form-control-feedback"
                    v-if="errors.customer_email"
                    v-text="errors.customer_email[0]"
                ></small>
            </div>
        </div>
        <br />
        <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
            <template v-if="showClose">
                <el-button
                    class="btn-cancel btn-cancel:hover"
                    icon="fas fa-times fa-lg"
                    @click="clickClose"
                    style="float: right;"
                >
                    <span>Salir</span>
                </el-button>
            </template>
        </div>

        <span slot="footer" class="dialog-footer"> </span>
    </el-dialog>
</template>

<script>
export default {
    props: [
        "company",
        "showDialog",
        "currentCode",
        "configuration",
        "showClose",
        "print"
    ],
    data() {
        return {
            titleDialog: "Imprimir Documento",
            loading: false,
            /* resource: "productos", */
            errors: {},
            form: {},
            // company: {},
            loading_print: false,
            message: ""
        };
    },
    async created() {
        this.initForm();
        //this.socketWhatsappConfig();
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
        // await this.$http.get(`/companies/record`).then(response => {
        //     if (response.data !== "") {
        //         this.company = response.data.data;
        //     }
        // });
    },
    mounted() {},
    methods: {
        validatePdfUrl(url) {
            if (!url || typeof url !== "string" || !url.startsWith("http")) {
                this.$toast.error("La URL del PDF no es válida.");
                return false;
            }
            return true;
        },
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
                console.log(sender, " xddd");
                this.showMessage(message);
            });
            this.socket.on("connected", ({ message }) => {
                // this.$message.success(message);

                this.socket.emit("getStatus", url);
            });
            this.socket.on("setStatus", ({ status, sender }) => {
                this.sender = sender || "sdrimsac";
                // if (!status) {
                //     this.sender = "sdrimsac";
                //     this.$message.warning("Sesión iniciada con SDRIMSAC");
                // } else {
                //     this.sender = sender;
                //     this.$message.success("Whatsapp Listo!");
                // }
            });
            //MessageResponse
        },
        /* async clickSendWhatsapp() {
            if (this.form.customer_telephone != null) {
                let formWhatsapp = {
                    id: this.recordId,
                    sender: this.sender,
                    document_id: this.recordId,
                    document_type_id: this.form.document_type_id,
                    customer_telephone: this.form.customer_telephone,
                    mensaje:
                        "Su  " +
                        this.form.number +
                        " por S/" +
                        this.form.total +
                        " de *" +
                        this.form.establishment_description +
                        "*, ha sido generado correctamente a través del facturador electrónico de " +
                        "*" +
                        this.$desarrollador +
                        "*"
                };
                try {
                    this.loading = true;
                    let response = await this.$http.post(
                        `/whatsapp`,
                        formWhatsapp
                    );
                    if (response.status == 200) {
                        this.$toast.success("Mensaje enviado");
                        this.loading = false;
                    }
                    if (this.configuration.xml_whatsapp) {
                        formWhatsapp.xml = true;
                        response = await this.$http.post(
                            `/whatsapp`,
                            formWhatsapp
                        );
                        if (response.status == 200) {
                            this.$toast.success("Mensaje enviado");
                            this.loading = false;
                        }
                    }
                } catch (e) {
                    console.log(e, " error");
                } finally {
                    this.loading = false;
                }
            }
        }, */

        initForm() {
            this.errors = {};
            this.form = {
                customer_email: null,
                download_pdf: null,
                external_id: null,
                number: null,
                image_detraction: null,
                id: null,
                response_message: null,
                response_type: null,
                customer_telephone: null,
                message_text: null
            };
        },
        async print_pdf(PrinterName, FileLink) {
            try {
                let config = qz.configs.create(PrinterName, {
                    scaleContent: false
                });
                if (!qz.websocket.isActive()) {
                    await qz.websocket.connect(config);
                }
                let format = FileLink.split("/")[
                    FileLink.split("/").length - 1
                ];
                let isTicket = format == "ticket";
                let isPosd = PrinterName.split(" ")[
                    PrinterName.split(" ").length - 1
                ];
                if (isPosd == "POSD" && isTicket) {
                    config.density = 200;
                }
                let data = [
                    {
                        type: "pdf",
                        format: "file",
                        data: FileLink
                    }
                ];
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });
            } catch (e) {
                this.$toast.error(e.message);
            }
        },
        async create() {
            console.log("Código recibido en el modal:", this.currentCode);
            this.loading_print = true;
            this.message = "Cargando la información del Comprobante";
            try {
                const response = await this.$http.get(
                    `/transfer_place/print_transfer_place/${this.currentCode}`
                );
                this.data = response.data;

                this.form.print_a4 = this.data.url_a4 || null;
                this.form.ticket = this.data.url_thermal || null;
                this.form.printer = this.data.printer || null;

                if (!this.form.print_a4 && !this.form.ticket) {
                    this.$toast.error(
                        "No se encontraron formatos de impresión disponibles."
                    );
                }
            } catch (error) {
                this.$toast.error(
                    "Error al cargar los datos del comprobante: " +
                        error.message
                );
            } finally {
                this.loading_print = false;
            }
        },
        async clickPrintPos(printerName, formatoPdf) {
            this.$confirm("Elija una de las opciones", "Imprimir", {
                confirmButtonText: "Impresión directa",
                cancelButtonText: "Descargar PDF",
                type: "warning"
            })
                .then(async () => {
                    try {
                        let paperConfig = {
                            scaleContent: false
                        };

                        let partsUrl = formatoPdf.split("/");
                        let document = partsUrl[partsUrl.length - 1];
                        let isTicket = document
                            .toLowerCase()
                            .includes("ticket");
                        /* let is80mm  =
                            document.toLowerCase().includes("thermal") ||
                            document.toLowerCase().includes("80mm"); */
                        let is80 = document.toLowerCase().includes("80mm");
                        let isA4 = document.toLowerCase().includes("a4");
                        let isA5 = document.toLowerCase().includes("a5");
                        console.log(this.configuration, " configuration");
                        /* if (is80mm) {
                            paperConfig = {
                                size: { width: 80, height: 200 },
                                units: "mm",
                                margins: {
                                    top: 0,
                                    left: 0,
                                    right: 0,
                                    bottom: 0
                                },
                                orientation: "portrait",
                                scaleContent: true
                            };
                        } */
                        let tipoBandejaImpresora = this.configuration
                            .new_old_printer;
                        if (isA4) {
                            if (tipoBandejaImpresora == 1) {
                                paperConfig.density = 700;
                                paperConfig.orientation = "portrait";
                            } else {
                                paperConfig.density = 200;
                                paperConfig.orientation = "portrait";
                            }
                            console.log(
                                this.configuration.new_old_printer,
                                " tipo bandeja"
                            );
                        } else {
                            let orientation = "portrait";
                            if (isA5) {
                                let { a5_orientation } = this.configuration;
                                orientation = a5_orientation
                                    ? "landscape"
                                    : "portrait";
                                console.log(a5_orientation, " orientation a5");
                            }
                            if (!isTicket && tipoBandejaImpresora == 1) {
                                //opciones que permiten hacer una impresion correcta en impresoras nuevas
                                paperConfig.density = 600;
                                paperConfig.orientation = orientation;
                                paperConfig.margins = { left: 2 };
                                console.log(
                                    this.configuration.new_old_printer,
                                    " tipo bandeja"
                                );
                            } else if (!isTicket && tipoBandejaImpresora == 0) {
                                paperConfig.density = 200;
                                paperConfig.orientation = orientation;
                                console.log("ver si ingresa aqui");
                                let margins = {};
                                if (orientation == "landscape") {
                                    margins = {
                                        top: 0,
                                        left: 0,
                                        right: 0,
                                        bottom: 0
                                    };
                                } else {
                                    margins = {
                                        left: 1.5
                                    };
                                }
                                paperConfig.margins = margins;
                                console.log(paperConfig, " margenes");
                            }
                        }
                        this.message =
                            "Espere imprimiendo Documento " + this.form.number;
                        this.loading_print = true;
                        let isPosd = printerName.split(" ")[
                            printerName.split(" ").length - 1
                        ];
                        if (isPosd == "POSD" && isTicket) {
                            paperConfig.density = 200;
                        }
                        let config = qz.configs.create(
                            printerName,
                            paperConfig,
                            { jobName: this.form.number }
                        );
                        if (!qz.websocket.isActive()) {
                            await qz.websocket.connect(config);
                        }

                        let data = [
                            {
                                type: "pdf",
                                format: "file",
                                data: formatoPdf
                            }
                        ];
                        qz.print(config, data).catch(e => {
                            this.$toast.error(e.message);
                        });

                        this.loading_print = false;
                        this.clickClose();
                    } catch (e) {
                        this.$toast.error(e.message);
                    }
                })
                .catch(() => {
                    window.open(formatoPdf, "_blank");
                    this.clickClose();
                });
        },
        clickPrint(format) {
            if (!this.form.printer) {
                this.$toast.error("No hay impresora configurada");
                return;
            }

            let formatoPdf = null;
            if (format === "a4") {
                formatoPdf = this.form.print_a4;
            } else if (format === "ticket") {
                formatoPdf = this.form.ticket;
            }

            if (!formatoPdf) {
                this.$toast.error(
                    `No se encontró el formato ${format} para imprimir.`
                );
                return;
            }

            if (!this.validatePdfUrl(formatoPdf)) {
                this.$toast.error(
                    `La URL del PDF para el formato ${format} no es válida.`
                );
                return;
            }

            this.clickPrintPos(this.form.printer, formatoPdf);
        },
        clickDownload(format) {
            window.open(`${this.form.download_pdf}/${format}`, "_blank");
        },
        clickSendEmail() {
            this.loading = true;
            this.$http
                .post(`/${this.resource}/email`, {
                    customer_email: this.form.customer_email,
                    id: this.form.id
                })
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(
                            "El correo fue enviado satisfactoriamente"
                        );
                    } else {
                        this.$toast.error("Error al enviar el correo");
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        this.$toast.error(error.response.data.message);
                    }
                })
                .then(() => {
                    this.loading = false;
                });
        },
        clickNewDocument() {
            this.clickClose();
        },
        /* clickClose() {
            this.$emit("update:showDialog", false);
            
            this.initForm();
        } */
        close() {
            this.initForm();

            this.$emit("update:showDialog", false);
        }
    }
};
</script>
