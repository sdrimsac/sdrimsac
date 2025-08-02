<template>
    <el-dialog
        :visible="visible"
        title="DATOS DE ENTREGA DE PEDIDO"
        width="50%"
        :close-on-click-modal="false"
        :before-close="handleClose"
        @close="handleDialogClose"
        @open="getTablesDelivery"
    >
        <div>
            <el-form>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <label>
                                    Cliente
                                    <a
                                        href="#"
                                        @click.prevent="
                                            showDialogNewPerson = true
                                        "
                                        >[+ Nuevo]</a
                                    >
                                </label>
                                <el-select
                                    v-model="form.customer_id"
                                    filterable
                                    remote
                                    class="border-left rounded-left border-info"
                                    popper-class="el-select-customers"
                                    dusk="customer_id"
                                    placeholder="Escriba el nombre o número de documento del cliente"
                                    :remote-method="searchRemoteCustomers"
                                    :loading="loading_search"
                                    @change="handleCustomerChange"
                                >
                                    <el-option
                                        v-for="option in customers"
                                        :key="option.id"
                                        :value="option.id"
                                        :label="option.description"
                                    ></el-option>
                                </el-select>
                            </div>
                            <div class="col-md-6">
                                <el-form-item label="Numero de Whatsapp">
                                    <!-- <el-select
                                        v-model="form.telephone"
                                        filterable
                                        allow-create
                                        default-first-option
                                        placeholder=""
                                        @change="
                                            onTelephoneInput(form.telephone)
                                        "
                                        @visible-change="
                                            onSelectDropdownVisible(
                                                'telephone',
                                                $event
                                            )
                                        "
                                        ref="selectTelephone"
                                    >
                                        <el-option
                                            v-for="item in addressesOptions"
                                            :key="item.id"
                                            :label="item.telephone"
                                            :value="item.telephone"
                                        />
                                    </el-select> -->
                                    <el-select
                                        v-model="form.telephone"
                                        filterable
                                        allow-create
                                        default-first-option
                                        placeholder=""
                                        @change="onTelephoneInput"
                                        @input.native="onTelephoneInput"
                                        @visible-change="
                                            onSelectDropdownVisible(
                                                'telephone',
                                                $event
                                            )
                                        "
                                        ref="selectTelephone"
                                    >
                                        <el-option
                                            v-for="item in addressesOptions"
                                            :key="item.id"
                                            :label="item.telephone"
                                            :value="item.telephone"
                                        />
                                    </el-select>
                                    <el-input
                                        v-if="false"
                                        v-model="form.telephone"
                                        style="display:none;"
                                        maxlength="9"
                                        show-word-limit
                                    />
                                </el-form-item>
                            </div>
                            <div class="col-md-12">
                                <el-form-item label="Alias cliente">
                                    <el-select
                                        v-model="form.ref"
                                        filterable
                                        allow-create
                                        default-first-option
                                        placeholder=""
                                        @input.native="onRefInput($event)"
                                        @change="onRefInput(form.ref)"
                                    >
                                        <el-option
                                            v-for="item in addressesOptions"
                                            :key="item.id"
                                            :label="item.alias"
                                            :value="item.alias"
                                        />
                                    </el-select>
                                    <el-input
                                        v-if="false"
                                        v-model="form.ref"
                                        style="display:none;"
                                        maxlength="20"
                                        @input="onRefInput($event)"
                                    />
                                </el-form-item>
                            </div>
                            <div class="col-md-12">
                                <el-form-item label="Direccion de Entrega">
                                    <el-select
                                        v-model="form.delivery_address"
                                        filterable
                                        allow-create
                                        default-first-option
                                        placeholder=""
                                        @change="onAddressSelect"
                                        @input.native="onAddressInput($event)"
                                    >
                                        <el-option
                                            v-for="item in addressesOptions"
                                            :key="item.id"
                                            :label="item.address"
                                            :value="item.address"
                                        />
                                    </el-select>
                                    <el-input
                                        v-if="false"
                                        v-model="form.delivery_address"
                                        style="display:none;"
                                        maxlength="200"
                                        @input="onAddressInput($event)"
                                    />
                                </el-form-item>
                            </div>
                            <div class="col-md-12">
                                <el-form-item label="Referencia  de Entrega">
                                    <el-select
                                        v-model="form.reference"
                                        filterable
                                        allow-create
                                        default-first-option
                                        placeholder=""
                                        @input.native="onReferenceInput($event)"
                                        @change="
                                            onReferenceInput(form.reference)
                                        "
                                    >
                                        <el-option
                                            v-for="item in addressesOptions"
                                            :key="item.id"
                                            :label="item.reference"
                                            :value="item.reference"
                                        />
                                    </el-select>
                                    <el-input
                                        v-if="false"
                                        v-model="form.reference"
                                        style="display:none;"
                                        maxlength="200"
                                        @input="onReferenceInput($event)"
                                    />
                                </el-form-item>
                            </div>
                        </div>
                        <div
                            class="d-flex justify-content-end align-items-center mt-3"
                            style="gap: 16px;"
                        >
                            <el-button
                                type="danger"
                                @click="handleDialogClose"
                                style="max-height: 60px; min-width: 140px; font-size: 1.2rem; border-radius: 30px; padding: 16px 32px;"
                            >
                                <i
                                    class="fas fa-times"
                                    style="color: white !important"
                                ></i>
                                Cancelar
                            </el-button>
                            <el-button
                                type="success"
                                @click="sendOrden"
                                style="max-height: 60px; min-width: 140px; font-size: 1.2rem; border-radius: 30px; padding: 16px 32px;"
                            >
                                <i
                                    class="fas fa-paper-plane"
                                    style="color: white !important"
                                ></i>
                                Enviar
                            </el-button>
                        </div>
                    </div>
                </div>
            </el-form>
        </div>
        <person-form
            :showDialog.sync="showDialogNewPerson"
            type="customers"
            :external="true"
        >
        </person-form>
    </el-dialog>
</template>
<script>
const PersonForm = () =>
    import("../../../../../../../../resources/js/views/persons/form.vue");
export default {
    props: [
        "isCreatingOrden",
        "localOrden",
        "ordenInBox",
        "variation",
        "to_carry",
        "configuration",
        "isSeller",
        "showDialog",
        "visible",
        "ordenLoading",
        "all_customers",
        "cash_id",
        "fromPos"
    ],
    components: {
        PersonForm
    },

    data() {
        return {
            deliveryAddress: "",
            deliveryTime: "",

            form: {
                customer_id: null,
                telephone: "",
                delivery_address: "",
                ref: "",
                reference: ""
            },
            clientTableData: null,
            localToCarry: false,
            showDialogNewPerson: false,
            loading_search: false,
            customers: [],
            resource: "quotations"
        };
    },
    created() {
        this.$eventHub.$on("reloadDataPersons", customer_id => {
            this.reloadDataCustomers(customer_id);
        });
    },
    computed: {
        addressesOptions() {
            const selected = this.customers.find(
                c => c.id === this.form.customer_id
            );
            return selected && Array.isArray(selected.addressesCustomer)
                ? selected.addressesCustomer
                : [];
        }
    },
    watch: {
        all_customers(newCustomer, _) {
            console.log("all_customers:", newCustomer);
            this.customers = newCustomer.filter(n => n.number != "88888888");
        }
    },
    methods: {
        onTelephoneInput(value) {
            if (typeof value !== "string") return;

            // Solo números y máximo 9 dígitos
            let filtered = value.replace(/\D/g, "").slice(0, 9);
            this.form.telephone = filtered;
        },

        onSelectDropdownVisible(field, visible) {
            // Cuando el select se abre, forzar el input a solo números si es el de teléfono
            if (field === "telephone" && visible) {
                this.$nextTick(() => {
                    const dropdown = document.querySelector(
                        ".el-select-dropdown__wrap input"
                    );
                    if (dropdown) {
                        dropdown.setAttribute("maxlength", "9");
                        dropdown.setAttribute("inputmode", "numeric");
                        dropdown.setAttribute("pattern", "[0-9]*");
                        // Limpia intervalos previos
                        if (window._whatsappInterval)
                            clearInterval(window._whatsappInterval);
                        window._whatsappInterval = setInterval(() => {
                            if (!dropdown.isConnected) {
                                clearInterval(window._whatsappInterval);
                                return;
                            }
                            let val = dropdown.value
                                .replace(/\D/g, "")
                                .slice(0, 9);
                            if (dropdown.value !== val) {
                                dropdown.value = val;
                                this.form.telephone = val;
                            }
                        }, 50);
                    }
                });
            } else if (field === "telephone" && !visible) {
                if (window._whatsappInterval)
                    clearInterval(window._whatsappInterval);
            }
        },
        onRefInput(e) {
            // Máximo 20 caracteres
            this.form.ref = e.slice(0, 20);
        },
        onAddressInput(e) {
            // Máximo 200 caracteres
            this.form.delivery_address = e.slice(0, 200);
        },
        onReferenceInput(e) {
            // Máximo 200 caracteres
            this.form.reference = e.slice(0, 200);
        },
        onAddressSelect(address) {
            // Cuando seleccionas una dirección, autocompleta los otros campos relacionados
            const selected = this.addressesOptions.find(
                a => a.address === address
            );
            if (selected) {
                this.form.reference = selected.reference || "";
                this.form.ref = selected.alias || "";
                this.form.telephone = selected.telephone || "";
            }
        },

        handleCustomerChange(customerId) {
            const selected = this.customers.find(c => c.id === customerId);
            if (selected) {
                if (
                    Array.isArray(selected.addressesCustomer) &&
                    selected.addressesCustomer.length > 0
                ) {
                    const addr = selected.addressesCustomer[0];
                    this.form.telephone =
                        addr.telephone || selected.telephone || "";
                    this.form.delivery_address = addr.address || "";
                    this.form.reference = addr.reference || "";
                    this.form.ref = addr.alias || "";
                } else {
                    this.form.telephone =
                        selected.telephone || selected.phone || "";
                    this.form.delivery_address = selected.address || "";
                    this.form.reference = "";
                    this.form.ref = "";
                }
            } else {
                // Si no se encuentra el cliente, limpiar los campos
                this.form.telephone = "";
                this.form.delivery_address = "";
                this.form.reference = "";
                this.form.ref = "";
            }
        },
        validateForm() {
            if (!this.form.customer_id) {
                this.$toast.warning("Debe seleccionar un cliente.");
                return false;
            }
            if (!this.form.telephone || this.form.telephone.trim() === "") {
                this.$toast.warning("Debe ingresar el número de WhatsApp.");
                return false;
            }
            if (!/^\d{9}$/.test(this.form.telephone)) {
                this.$toast.warning(
                    "El número de WhatsApp debe tener exactamente 9 dígitos numéricos."
                );
                return false;
            }
            if (!this.form.ref || this.form.ref.trim() === "") {
                this.$toast.warning("Debe ingresar el alias del cliente.");
                return false;
            }
            if (this.form.ref.length > 20) {
                this.$toast.warning(
                    "El alias del cliente no debe exceder 20 caracteres."
                );
                return false;
            }
            if (
                !this.form.delivery_address ||
                this.form.delivery_address.trim() === ""
            ) {
                this.$toast.warning("Debe ingresar la dirección de entrega.");
                return false;
            }
            if (this.form.delivery_address.length > 200) {
                this.$toast.warning(
                    "La dirección de entrega no debe exceder 200 caracteres."
                );
                return false;
            }
            if (this.form.reference && this.form.reference.length > 200) {
                this.$toast.warning(
                    "La referencia de entrega no debe exceder 200 caracteres."
                );
                return false;
            }
            return true;
        },

        reloadDataCustomers(customer_id) {
            this.$http
                .get(`/documents/search/customer/${customer_id}`)
                .then(response => {
                    this.customers = response.data.customers;
                    this.form.customer_id = customer_id;
                });
        },
        handleClose(done) {
            done();
        },
        handleDialogClose() {
            this.resetDeliveryForm();
            this.$emit("close");
        },
        resetDeliveryForm() {
            this.form.customer_id = null;
            this.form.telephone = "";
            this.form.delivery_address = "";
            this.form.ref = "";
            this.form.reference = "";
            this.deliveryAddress = "";
            this.deliveryTime = "";
        },

        searchRemoteCustomers(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(
                        `/caja/search_customers/search_customer_delivery?${parameters}`
                    )
                    .then(response => {
                        this.customers = response.data.persons;
                        this.loading_search = false;
                        if (this.customers.length == 0) {
                            this.customers = this.all_customers;
                        }
                    });
            } else {
                //this.customers = this.all_customers;
            }
        },
        async sendOrden() {
            if (this.localOrden.length == 0 && !this.variation) {
                this.$showSAlert(
                    "ALERTA",
                    "No Tienes Productos Para Cobrar",
                    "warning"
                );
                return;
            }
            if (!this.validateForm()) {
                return;
            }
            let orden = {
                status_orden_id: 1,
                table_id: this.clientTableData.id,
                to_carry: this.localToCarry,
                customer_id: this.form.customer_id
            };

            //this.ordenLoading = true;
            try {
                const responses = await this.$http.post(
                    "/caja/worker/send-orden",
                    {
                        id: this.clientTableData.orden_id,
                        ref: this.form.ref,
                        items: this.localOrden,
                        caja: true,
                        printing: true,
                        saleDirect: false,
                        orden: {
                            status_orden_id: 1,
                            table_id: this.clientTableData.id,
                            to_carry: this.localToCarry,
                            customer_id: this.form.customer_id,
                            delivery_address: this.form.delivery_address,
                            telephone: this.form.telephone,
                            reference: this.form.reference
                        }
                    }
                );

                // Check success property from response
                if (!responses.data.success) {
                    // Show error message from server
                    this.$showSAlert("ALERTA", responses.data.message, "error");
                    //this.$toast.error(responses.data.message);
                    //this.ordenLoading = false;
                    return;
                }

                let ordenId = responses.data.id;
                //this.ordenLoading = false;

                if (responses.status != 200) {
                    this.$toast.warning("Ocurrió un error");
                    return;
                }

                this.localToCarry = false;
                this.$emit("cancelOrden");
                this.$emit("update:isCreatingOrden", false);
                // Limpiar formulario de delivery
                this.form.customer_id = null;
                this.form.telephone = "";
                this.form.delivery_address = "";
                this.form.ref = "";
                // Lanzar evento para limpiar la lista de órdenes
                this.$emit("clearListOrden");

                let msg = "";
                if (this.clientTableData.orden_id) {
                    msg = `Se agregaron los pedidos a la orden ${ordenId}`;
                } else {
                    msg = `La orden ${ordenId} fue creada.`;
                }
                this.$toast.success(msg);
                this.$emit("limpiarForm");
                this.$emit("close");
            } catch (e) {
                //this.ordenLoading = false;
                if (e.response && e.response.data) {
                    // Show error message from server if available
                    this.$toast.error(e.response.data.message);
                } else {
                    this.$toast.error("Ocurrió un error");
                }
            }
        },
        async getTablesDelivery() {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    "/caja/tables/getTablesDelivery"
                );
                console.log("Respuesta del servidor:", response.data);

                if (response.status == 200) {
                    const { tables, ordenes, zones } = response.data;
                    console.log("Órdenes recibidas:", ordenes);
                    this.ordenes = ordenes;
                    this.zones = zones;

                    let { show_caja_table } = this.configuration;
                    if (!show_caja_table) {
                        this.all_tables = tables.filter(
                            f => f.number.toLowerCase() != "caja"
                        );
                    } else {
                        this.all_tables = tables;
                    }
                    // By default, show all tables
                    if (this.zone_id) {
                        this.filterZones(this.zone_id);
                    } else {
                        this.tables = this.all_tables;
                    }

                    // Asignar la mesa delivery automáticamente si existe
                    const mesaDelivery = this.all_tables.find(
                        t => t.number && t.number.toLowerCase() === "delivery"
                    );
                    if (mesaDelivery) {
                        this.clientTableData = mesaDelivery;
                    }

                    this.hasTableOcuped = this.all_tables.some(
                        s => s.status_table_id == 2
                    );
                } else {
                    this.$toast.warning("Ocurrió un error");
                }
                this.loading = false;
            } catch (e) {
                this.loading = false;
                console.log(e);
                this.$toast.warning("Ocurrió un error");
            }
        }
    }
};
</script>
