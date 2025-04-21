<template>
    <div>
        <el-dialog
            append-to-body
            title="Generar CPE desde Múltiples Notas de Venta"
            :visible="show"
            @open="onOpened"
            :close-on-click-modal="false"
            :close-on-press-escape="false"
            @close="onClose"
            width="80%"
        >
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="form-group mr-3" style="flex: 3; margin-right: 15px;">
                        Cliente/Empresa
                        <el-select
                            v-model="form.client_id"
                            filterable
                            remote
                            reserve-keyword
                            placeholder="Ingreser el nombre del cliente"
                            @focus="onFetchClients"
                            @clear="onFetchClients"
                            :remote-method="onFindClients"
                            :loading="loading"
                        >
                            <el-option
                            v-for="item in clients"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="form-group mr-3" style="flex: 2; margin-right: 15px;">
                        # Nota de Venta
                        <el-input
                            
                            v-model="form.number"
                            :disabled="loading"
                        ></el-input>
                    </div>
                    <div class="form-group mr-3" style="flex: 2; margin-right: 15px;">
                        Fecha Inicio
                        <el-date-picker
                            v-model="form.date_of_issue"
                            type="date"
                            style="width: 100%"
                            
                            value-format="yyyy-MM-dd"
                        ></el-date-picker>
                    </div>
                    <div class="form-group mr-3" style="flex: 2; margin-right: 15px;">
                        Fecha Final
                        <el-date-picker
                            v-model="form.date_of_due"
                            type="date"
                            style="width: 100%"
                            
                            value-format="yyyy-MM-dd"
                        ></el-date-picker>
                    </div>
                    <div class="form-group">
                        <el-button
                            @click="onFindNotes"
                            class="btn btn-buscar"
                            type="primary"
                        >
                            <i class="fa fa-search"></i>
                        </el-button>
                    </div>
                </div>
            </div>
        </div>
        <br />
            
        <div class="card">
            <div v-if="!notes.length" class="card-header">
                <div
                    style="text-align: center; font-size: 18px; font-weight: bold; color: #ffbf00; animation: blink 1s step-start infinite;"
                >
                    Seleccione una o más notas de venta para poder continuar
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" v-if="notes">
                    <div
                        v-if="errors.notes_id"
                        class="alert alert-warning"
                        role="alert"
                        style="margin-top: 10px; margin-bottom: 10px;"
                    >
                        {{ errors.notes_id[0] }}
                    </div>

                    <table
                        class="table table-hover table-striped table-bordered table-responsive"
                        style="width: 100%; white-space: nowrap; font-size: 14px;"
                    >
                        <thead>
                            <tr class="bg-primary text-center">
                                <th class="text-white"></th>
                                <th class="text-white">Nota</th>
                                <th class="text-white">Fecha de emisión</th>
                                <th class="text-white">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="dis in notes" :key="dis.id">
                                <td>
                                    <el-switch
                                        v-model="dis.selected"
                                        @change="onFillSelectedNotes"
                                    ></el-switch>
                                </td>
                                <td>
                                    <span>{{ dis.series }}</span>-
                                    <span>{{ dis.number }}</span>
                                </td>
                                <td>{{ dis.date_of_issue }}</td>
                                <td>{{ dis.total }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td>{{ this.sum_total }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center">
                        <el-button
                            v-if="form.selecteds.length > 0"
                            type="primary"
                            :disabled="loading"
                            @click="onFetchNoteItems"
                        >
                            Generar CPE
                        </el-button>
                        <el-button :disabled="loading" @click="onClose">
                            Cerrar
                        </el-button>
                    </div>
                </div>
            </div>
        </div>
            
            
        </el-dialog>
    </div>
</template>

<style>
@keyframes blink {
50% {
    opacity: 0;
}
}
</style>

<script>
import moment from "moment";
export default {
    props: {
        show: {
            required: true,
            type: Boolean
        }
    },
    data() {
        return {
            title: "",
            loading: false,
            clients: [],
            filter: {
                type: "name",
                name: null
            },
            form: {
                client_id: null,
                selecteds: [],
                number:null,
            },
            notes: [],
            errors: {},
            group_items_generate_document: false,
            sum_total: null
        };
    },
    methods: {
        getObjectForNote(data) {
            return {
                number_full: `${data.series}-${data.number}`,
                id: data.id,
                items: data.items
            };
        },
        onFetchNoteItems() {
            if (this.form.selecteds.length === 0) {
                this.$message({
                    message: "Seleccione una o más notas de venta por favor",
                    type: "warning"
                });
                return;
            }
            this.loading = true;

            //   if(this.group_items_generate_document){
            if (true) {
                const data = {
                    notes_id: this.form.selecteds,
                };
                
                this.$http
                    .post("/sale-notes/items_caja", data)
                    .then(response => {
                        const {data,dscto_global} = response.data;
                      
                        const {client_id} = this.form;
                        let client = this.clients.find(
                            c => c.id === client_id
                        );
                        let clientNumber = client.number;
                        this.$emit("sendItems", data, clientNumber,this.form.selecteds,dscto_global);

                        // localStorage.setItem("client", JSON.stringify(client));
                        localStorage.setItem(
                            "itemsForNotes",
                            JSON.stringify(data)
                        );
                        this.$emit("close");
                        // localStorage.setItem("notes", JSON.stringify(notes));
                        // this.onClose();
                    })
                    .catch(error => console.log(error))
                    .finally(() => (this.loading = false));
            } 
        },
        processNotGroupItems() {
            const data = {
                notes_id: this.form.selecteds,
                select_all: true
            };

            this.$http
                .post("/sale-notes/items", data)
                .then(response => {
                    const notes = [];
                    this.notes.map(d => {
                        if (d.selected) {
                            // notes.push(`${d.series}-${d.number}`);
                            notes.push(this.getObjectForNote(d));
                        }
                    });

                    const items = response.data.data;

                    const client = this.clients.find(
                        c => c.id === this.form.client_id
                    );
                    localStorage.setItem("client", JSON.stringify(client));
                    localStorage.setItem(
                        "itemsNotGroupForNotes",
                        JSON.stringify(items)
                    );
                    localStorage.setItem("notes", JSON.stringify(notes));
                    this.onClose();
                    window.location.href = "/documents/create";
                })
                .catch(error => this.axiosError(error))
                .finally(() => (this.loading = false));
        },
        onFillSelectedNotes() {
            this.form.selecteds = [];
            this.sum_total = 0;
            let total = 0;
            this.notes.map(d => {
                if (d.selected) {
                    total += Number(d.total);
                    this.form.selecteds.push(d.id);
                }
            });
            this.sum_total += total;
        },
        onFindNotes() {
            this.form.selecteds = [];
            this.loading = true;
            const params = this.form;
            this.$http
            .get(`/sale-notes/list-by-client`, { params })
            .then(response => {
                if (response.data.data.length === 0) {
                this.$swal.fire({
                    icon: "warning",
                    title: "Sin coincidencias",
                    text: "No se encontraron coincidencias para los criterios de búsqueda.",
                });
                } else {
                this.notes = response.data.data.map(d => {
                    d.selected = false;
                    d.date_of_issue = moment(d.date_of_issue).format(
                    "YYYY-MM-DD"
                    );
                    d.items = d.items.map(item => {
                    return {
                        id: item.id,
                        item_id: item.item_id
                    };
                    });

                    return d;
                });
                }
            })
            .finally(() => (this.loading = false));
        },
        onFindClients(query) {
            this.filter.name = query;
            this.onFetchClients();
        },
        onFetchClients() {
            this.loading = true;
            this.notes = [];
            this.form.selecteds = [];
            const params = this.filter;
            this.$http
                .get("/customers/list", { params })
                .then(response => {
                    this.clients = response.data.data;
                })
                .finally(() => (this.loading = false));
        },
        onOpened() {
            this.filter.type = "name";
            this.filter.name = null;
            this.form.client_id = null;
            this.form.number = null;
            this.sum_total = 0;
            this.onFetchClients();
            //   this.getConfigGroupItems();
        },
        getConfigGroupItems() {
            this.$http.get("/sale-notes/config-group-items").then(response => {
                // console.log(response)
                this.group_items_generate_document =
                    response.data.group_items_generate_document;
            });
        },
        onClose() {
            this.notes = [];
            this.$emit("update:show", false);
        }
    }
};
</script>
