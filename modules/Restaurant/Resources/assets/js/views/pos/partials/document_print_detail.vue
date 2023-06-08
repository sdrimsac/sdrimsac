<template>
    <div v-loading="loading">
        <div class="container table-responsive col-md-12">
            <table
                class="table table-hover table-striped table-condensed  table-responsive"
                style="width:100%;     white-space: nowrap;"
            >
                <thead>
                    <tr>
                        <th v-if="type == 'documents'">SUNAT</th>
                        <th>
                            Acciones
                        </th>
                        <th>
                            Número
                        </th>
                        <th>Fecha</th>
                        <th>
                            Cliente
                        </th>
                        <th v-if="type == 'documents'">
                            Estado
                        </th>
                        <th>
                            Monto
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data, idx) in records" :key="idx">
                        <td v-if="type == 'documents'">
                            <div
                                class="dropdown-as-select d-inline-block"
                                data-childselector="span"
                            >
                                <button
                                    v-if="data.state_type_id != '11'"
                                    class="btn p-0"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    <span
                                        class="btn btn-primary dropdown-toggle"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        data-bs-delay="0"
                                        title=""
                                        data-bs-original-title="Item Count"
                                        aria-label="Item Count"
                                        ><i class="fas fa-list"></i
                                    ></span>
                                </button>

                                <div
                                    class="dropdown-menu dropdown-menu-end col-md-2 col-1"
                                >
                                    <el-button
                                        class="col-md-12 col-12"
                                        v-if="
                                            type == 'documents' &&
                                                data.state_type_id != '11' &&
                                                data.document_type_id == '01'
                                        "
                                        @click="clickReStore(data.id)"
                                    >
                                        Recrear
                                    </el-button>
                                    <br
                                        v-if="
                                            type == 'documents' &&
                                                data.state_type_id != '11' &&
                                                data.document_type_id == '01'
                                        "
                                    />
                                    <el-button
                                        class="col-md-12 col-12"
                                        v-if="
                                            type == 'documents' &&
                                                data.document_type_id == '01' &&
                                                data.state_type_id != '11'
                                        "
                                        plain
                                        @click="clickSendOnline(data.id)"
                                    >
                                        Reenviar
                                    </el-button>
                                    <br
                                        v-if="
                                            type == 'documents' &&
                                                data.document_type_id == '01'
                                        "
                                    />

                                    <el-button
                                        class="col-md-12 col-12"
                                        v-if="
                                            type == 'documents' &&
                                                data.state_type_id != '11'
                                        "
                                        @click="clickValidarCpe(data.id)"
                                    >
                                        Validar cpe
                                    </el-button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <el-button
                                size="mini"
                                type="success"
                                style="margin-bottom:3px;"
                                @click="clickOpenWhatsapp(data)"
                            >
                                <i
                                    class="fab fa-whatsapp"
                                    aria-hidden="true"
                                ></i>
                            </el-button>

                            <el-button
                                size="mini"
                                plain
                                @click="
                                    print(
                                        data.external_id,
                                        data.document_type_id
                                    )
                                "
                            >
                                <i class="fas fa-print"></i>
                            </el-button>
                        </td>
                        <td>
                            <template v-if="type == 'saleNotes'">
                                {{ data.full_number }}
                            </template>
                            <template v-if="type == 'documents'">
                                {{ data.number }}
                            </template>
                            <template v-if="type == 'quotations'">
                                {{ data.identifier }}
                            </template>
                        </td>
                        <td>{{ data.date_of_issue }}</td>
                        <td>
                            {{ data.customer_name }} <br />
                            <span class="text-muted">{{
                                data.customer_number
                            }}</span>
                            <template
                                v-if="type == 'saleNotes' && data.variation"
                            >
                                <br />
                                <small>
                                    <span
                                        >{{ data.variation.series }}-{{
                                            data.variation.number
                                        }}
                                        /
                                    </span>
                                    <span>
                                        {{ data.variation.customer.name }}
                                    </span>
                                    <span>
                                        {{
                                            data.variation.customer.number
                                        }}</span
                                    >
                                </small>
                            </template>
                        </td>
                        <td
                            v-if="type == 'documents'"
                            :class="
                                `${
                                    data.state_type_description == 'Aceptado'
                                        ? 'text-success'
                                        : data.state_type_description ==
                                          'Anulado'
                                        ? 'text-danger'
                                        : data.state_type_description ==
                                          'Enviado'
                                        ? 'text-primary'
                                        : 'text-black'
                                }`
                            "
                        >
                            <b> {{ data.state_type_description }}</b>
                        </td>
                        <td>
                            {{ data.total }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <el-pagination
            @current-change="getRecords"
            layout="total, prev, pager, next"
            :total="pagination.total"
            :current-page.sync="pagination.current_page"
            :page-size="pagination.per_page"
        ></el-pagination>
        <whatsapp-modal
            :documentNumber="currentNumber"
            :company="company"
            :documentId="currentId"
            :documentTypeId="currentType"
            :showDialog.sync="showWhatsappModal"
            :sender="sender"
        >
        </whatsapp-modal>
    </div>
</template>

<script>
import whatsappModal from "./whatsapp_modal.vue";
export default {
    components: { whatsappModal },
    props: ["records", "pagination", "type", "company", "sender"],
    data() {
        return {
            loading: false,
            showWhatsappModal: false,
            currentId: null,
            currentType: null,
            currentNumber: null
        };
    },

    methods: {
        clickOpenWhatsapp(record) {
            this.showWhatsappModal = true;
            this.currentId = record.id;
            this.currentType = record.document_type_id || "COT";
            if (this.type == "saleNotes") {
                this.currentNumber = record.full_number;
            } else if (this.type == "documents") {
                this.currentNumber = record.number;
            } else {
                this.currentNumber = record.identifier;
            }
        },
        async clickSendOnline(document_id) {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/documents/send/${document_id}`
                );

                if (response.data.success) {
                    this.$toast.success(
                        "Se envio satisfactoriamente el comprobante."
                    );
                    this.$eventHub.$emit("reloadData");

                    // this.clickCheckOnline(document_id);
                } else {
                    this.$toast.error(response.data.message);
                }
            } catch (error) {
                this.$toast.error(error.response.data.message);
            } finally {
                this.loading = false;
            }
        },
        async clickReStore(document_id) {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/documents/re_store/${document_id}`
                );
                console.log(response);
                if (response.data.success) {
                    this.$toast.success(response.data.message);
                } else {
                    this.$toast.error(response.data.message);
                }
            } catch (error) {
                this.$toast.error(error.response.data.message);
            } finally {
                this.loading = false;
            }
        },

        async clickValidarCpe(document_id) {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/documents/validate/${document_id}`
                );

                if (response.data.success) {
                    this.$toast.success(response.data.message);
                    this.$emit("getRecords", this.pagination.current_page);
                } else {
                    this.$toast.error(response.data.message);
                }
            } catch (error) {
                this.$toast.error(error.response.data.message);
            } finally {
                this.loading = false;
            }
        },
        getRecords() {
            this.$emit("getRecords", this.pagination.current_page);
        },
        print(external_id, type) {
            this.$emit("printData", external_id, type);
        }
    }
};
</script>
