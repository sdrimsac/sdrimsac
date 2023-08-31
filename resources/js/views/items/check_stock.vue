<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Productos</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Verificar stock de Productos</span
                                >
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="link">Url</label>
                        <el-input v-model="linkpdf"></el-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4" col-12>
                        <label for="density">Densidad</label>
                        <el-input type="number" v-model="config.density">
                        </el-input>
                    </div>
                      <div class="col-md-4 col-12">
                        <label for="density">Impresora</label>
                        <el-input  v-model="printer">
                        </el-input>
                    </div>
                    <div class="col-md-4 col-12">
                        <label for="orientation">Orientación</label>
                        <el-select v-model="config.orientation">
                            <el-option
                                label="Vertical"
                                value="portrait"
                            ></el-option>
                            <el-option
                                label="Horizontal"
                                value="landscape"
                            ></el-option>
                        </el-select>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-12">
                        <label for="top">Arriba</label>
                        <el-input type="number" v-model="config.margins.top">
                        </el-input>
                    </div>
                    <div class="col-md-3 col-12">
                        <label for="left">Izquierda</label>
                        <el-input type="number" v-model="config.margins.left">
                        </el-input>
                    </div>
                    <div class="col-md-3 col-12">
                        <label for="right">Derecha</label>
                        <el-input type="number" v-model="config.margins.right">
                        </el-input>
                    </div>
                    <div class="col-md-3 col-12">
                        <label for="bottom">Abajo</label>
                        <el-input type="number" v-model="config.margins.bottom">
                        </el-input>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3 col-12">
                        <el-button type="primary" @click="Printer('zebra')">
                        Imprimir
                    </el-button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <table class="table table-responsive"></table>
        </div>
    </div>
</template>

<script>
export default {
    props: ["user"],

    data() {
        return {
            linkPdf:"https://tunegocio.sdrimsac.pro/sale-notes/print/6e977e52-38c8-4c4d-a897-3bbb1fd77ca8/a5",
            printer:null,
            resource: "/items/check_stock",
            records: [],
            loading: false,
            pagination: {},
            config: {
                scaleContent: false,
                density: 350,
                orientation: "landscape",
                margins: {
                    top: 0,
                    left: 0,
                    right: 0,
                    bottom: 0
                }
            }
        };
    },

    created() {
        // this.getRecords();
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
        async Printer() {
            if(!this.printer){
                this.$toast.error("Debe ingresar una impresora");
                return;
            }
            if(!this.linkpdf || this.linkpdf == "" || this.linkpdf == null){
                
                this.$toast.error("Debe ingresar una url");
                return;
            }
            // let linkpdf = "https://portal.sdrimsac.pro/sale-notes/print/c393face-938f-40d1-9c9d-6cd9e55fb791/a5";   
            let config = qz.configs.create(this.printer, this.config);
            localStorage.setItem("printer", this.config);
            if (!qz.websocket.isActive()) {
                await qz.websocket.connect(config);
            }
            let data = [
                {
                    type: "pdf",
                    format: "file",
                    data: this.linkpdf
                }
            ];

            qz.print(config, data).catch(e => {
                this.$toast.error(e.message);
            });
          
        },
    
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http.get(this.resource);
                this.records = response.data.data;
                this.pagination = response.data.meta;
                this.loading = false;
            } catch (e) {
                this.loading = false;
                console.log(e);
            }
        }
    }
};
</script>
