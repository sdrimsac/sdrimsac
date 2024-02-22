<template>
    <div>
        <el-dialog
            :title="titleDialog"
            :visible="showDialog"
            @open="create"
            :close-on-click-modal="false"
            :close-on-press-escape="false"
            :show-close="false"
        >
            <template v-if="configuration.print_direct == false">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12  ">
                        <el-tabs v-model="activeName">
                            <el-tab-pane label="Imprimir A4" name="first">
                                <embed
                                    :src="form.print_a4"
                                    type="application/pdf"
                                    width="100%"
                                    height="400px"
                                />
                            </el-tab-pane>
                            <el-tab-pane label="Imprimir A5" name="second">
                                <embed
                                    :src="form.print_a5"
                                    type="application/pdf"
                                    width="100%"
                                    height="400px"
                                />
                            </el-tab-pane>
                            <el-tab-pane label="Imprimir Ticket" name="third">
                                <embed
                                    :src="form.print_ticket"
                                    type="application/pdf"
                                    width="100%"
                                    height="400px"
                                />
                            </el-tab-pane>
                            <el-tab-pane
                                label="Imprimir Cronograma"
                                name="schedule"
                                v-if="showSchedule"
                            >
                                <embed
                                    :src="form.schedule"
                                    type="application/pdf"
                                    width="100%"
                                    height="400px"
                                />
                            </el-tab-pane>
                        </el-tabs>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="row justify-content-center">
                    <div
                        class="col-lg-3 col-md-3 col-sm-12 text-center font-weight-bold mt-3"
                    >
                        <button
                            type="button"
                            class="btn btn-lg btn-info waves-effect waves-light"
                            @click="clickPrint('a4')"
                        >
                            <i class="fa fa-file-alt"></i>
                        </button>
                        <p>Imprimir A4</p>
                    </div>
                    <div
                        class="col-lg-3 col-md-3 col-sm-12 text-center font-weight-bold mt-3"
                    >
                        <button
                            type="button"
                            class="btn btn-lg btn-info waves-effect waves-light"
                            @click="clickPrint('a5')"
                        >
                            <i class="fa fa-receipt"></i>
                        </button>
                        <p>Imprimir A5</p>
                    </div>
                    <div
                        class="col-lg-3 col-md-3 col-sm-12 text-center font-weight-bold mt-3"
                    >
                        <button
                            type="button"
                            class="btn btn-lg btn-info waves-effect waves-light"
                            @click="clickPrint('ticket')"
                        >
                            <i class="fa fa-receipt"></i>
                        </button>
                        <p>Imprimir Ticket</p>
                    </div>
                    <div
                        class="col-lg-3 col-md-3 col-sm-12 text-center font-weight-bold mt-3"
                        v-if="form.view_schedule"
                    >
                        <button
                            type="button"
                            class="btn btn-lg btn-info waves-effect waves-light"
                            @click="clickPrint('cronograma')"
                        >
                            <i class="fa fa-receipt"></i>
                        </button>
                        <p>Imprimir Cronograma</p>
                    </div>
                </div>
            </template>
            <span slot="footer" class="dialog-footer row">
                <div class="col-md-12">
                    <el-input v-model="form.customer_email">
                        <el-button
                            slot="append"
                            icon="el-icon-message"
                            @click="clickSendEmail"
                            :loading="loading"
                            >Enviar</el-button
                        >
                        <i slot="prefix" class="el-icon-edit-outline"></i
                    ></el-input>
                </div>
                <div class="col-md-12" style="margin-top:5px;">
                    <el-input v-model="form.customer_telephone">
                        <el-button
                            slot="append"
                            icon="fab fa-whatsapp"
                            @click="clickSendWhatsapp"
                            :loading="loading"
                            >Enviar</el-button
                        >
                        <i slot="prefix" class="fab fa-whatsapp"></i>
                    </el-input>
                </div>
                <div class="col-md-12 m-t-10">
                    <template v-if="showClose == true">
                        <el-button @click="clickClose" v-if="editSale == false"
                            >Cerrar</el-button
                        >
                        <el-button
                            @click="clickFinalize"
                            v-if="editSale == true"
                            >Ir al listado</el-button
                        >
                    </template>
                    <template v-else>
                        <el-button @click="clickFinalize"
                            >Ir al listado</el-button
                        >

                        <el-button type="primary" @click="clickNewSaleNote"
                            >Nuevo Nota de venta</el-button
                        >
                    </template>
                </div>
            </span>
        </el-dialog>
    </div>
</template>

<script>
export default {
    props: [
        "showDialog",
        "configuration",
        "recordId",
        "showClose",
        "editSale",
        "showSchedule",
        "company"
    ],
    data() {
        return {
            titleDialog: null,
            loading: false,
            resource: "sale-notes",
            resource_documents: "documents",
            errors: {},
            form: {},
            document: {},
            document_types: [],
            all_series: [],
            series: [],
            loading_submit: false,
            showDialogOptions: false,
            documentNewId: null,
            activeName: "first",
            sender: null
        };
    },
    created() {
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
        this.initForm();
        this.socketWhatsappConfig();
    },

    methods: {
        socketWhatsappConfig() {
return;
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
        async clickSendWhatsapp() {
            if (this.form.customer_telephone != null) {
                let formWhatsapp = {
                    id: this.form.id,
                    sender: this.sender,
                    document_id: this.form.id,
                    document_type_id: "80",
                    customer_telephone: this.form.customer_telephone,
                    mensaje:
                        "Su comprobante de pago electrónico " +
                        this.form.identifier +
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
                } catch (e) {
                    console.log(e, " error");
                } finally {
                    this.loading = false;
                }
            }
        },
        initForm() {
            this.errors = {};
            this.form = {
                id: null,
                external_id: null,
                identifier: null,
                date_of_issue: null,
                print_ticket: null,
                schedule: null,
                print_a4: null,
                print_a5: null,
                series: null,
                number: null,
                view_schedule: null
            };
        },
        async clickPrintPos(printerName, formatoPdf) {
            this.$confirm("Elija una de las opciones", "Imprimir", {
                confirmButtonText: "Impresión directa",
                cancelButtonText: "Descargar PDF",
                type: "warning"
            })
                .then(async () => {
                    try {
                        this.message =
                            "Espere imprimiendo el Comprobante " +
                            this.form.number;
                        this.loading_print = true;
                        let paperConfig = {
                            scaleContent: false
                        };
                        let partsUrl = formatoPdf.split("/");
                        let document = partsUrl[partsUrl.length - 1];
                        let isTicket = document
                            .toLowerCase()
                            .includes("ticket");
                        let isA4 = document.toLowerCase().includes("a4");
                        let isA5 = document.toLowerCase().includes("a5");
                        let tipoBandejaImpresora = this.configuration
                            .new_old_printer;
                        if (isA4) {
                            if (tipoBandejaImpresora == 1) {
                                paperConfig.density = 700;
                                paperConfig.orientation = "portrait";
                            } else {
                                paperConfig.density = 350;
                                paperConfig.orientation = "portrait";
                            }
                        } else {
                            let orientation = "portrait";
                            if (isA5) {
                                let { a5_orientation } = this.configuration;
                                orientation = a5_orientation
                                    ? "landscape"
                                    : "portrait";
                            }
                            if (!isTicket && tipoBandejaImpresora == 1) {
                                //opciones que permiten hacer una impresion correcta en impresoras nuevas
                                paperConfig.density = 600;
                                paperConfig.orientation = orientation;
                                paperConfig.margins = { left: 2 };
                            } else if (!isTicket && tipoBandejaImpresora == 0) {
                                paperConfig.density = 350;
                                paperConfig.orientation = orientation;
                                let margins = {};
                                if (orientation == "landscape") {
                                    margins = {
                                        top: 1.1,
                                        left: 0.95,
                                        right: 0.3,
                                        bottom: 1.1
                                    };
                                } else {
                                    margins = {
                                        left: 1.5
                                    };
                                }
                                paperConfig.margins = margins;
                            }
                        }
                        this.message =
                            "Espere imprimiendo el Comprobante " +
                            this.form.number;
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
                        // let config = qz.configs.create(
                        //     printerName,
                        //     { scaleContent: false },
                        //     { jobName: this.form.number }
                        // );
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
            if (this.configuration.print_direct == 1) {
                if (format == "a4") {
                    this.clickPrintPos(this.form.printer, this.form.print_a4);
                }
                if (format == "a5") {
                    this.clickPrintPos(this.form.printer, this.form.print_a5);
                }
                if (format == "ticket") {
                    this.clickPrintPos(
                        this.form.printer,
                        this.form.print_ticket
                    );
                }
                if (format == "ticket_50") {
                    this.clickPrintPos(this.form.printer, this.form.ticket_50);
                }
                if (format == "cronograma") {
                    this.clickPrintPos(this.form.printer, this.form.schedule);
                }
            }
        },
        async create() {
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
                        .post("/api/qz/signing", {
                            request: toSign
                        })
                        .then(response => {
                            resolve(response.data);
                        })
                        .catch(error => {
                            reject(error.data);
                        });
                };
            });
            await this.$http
                .get(`/${this.resource}/record/${this.recordId}`)
                .then(response => {
                    console.log(response);
                    this.form = response.data.data;
                    this.titleDialog = `Nota de venta registrada:  ${this.form.serie}-${this.form.number}`;
                });

            // if(this.form.direct_printing=="1"){
            //     let formatoPdf=""
            //     if(this.form.format_printer=="1"){
            //          formatoPdf=this.form.print_a4
            //     }else if(this.form.format_printer=="2"){
            //            formatoPdf=this.form.print_a5
            //     }else if(this.form.format_printer=="3"){
            //            formatoPdf=this.form.print_ticket
            //     }else if(this.form.format_printer=="4"){
            //            formatoPdf=this.form.print_ticket
            //     }

            //     await this.clickPrintPos(this.form.printer,formatoPdf);
            // }
        },
        clickFinalize() {
            location.href = `/${this.resource}`;
        },
        clickNewSaleNote() {
            this.clickClose();
        },
        clickClose() {
            this.$emit("update:showDialog", false);
            this.$emit("update:showSchedule", false);
            this.initForm();
        },
        clickDownload() {
            window.open(
                `/downloads/saleNote/sale_note/${this.form.external_id}`,
                "_blank"
            );
        },
        clickToPrint(format) {
            window.open(
                `/${this.resource}/print/${this.form.id}/${format}`,
                "_blank"
            );
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
        }
    }
};
</script>
