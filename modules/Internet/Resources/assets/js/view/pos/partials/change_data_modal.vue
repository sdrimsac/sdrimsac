<template>
    <el-dialog :visible="showDialog" @open="openDialog" @close="closeDialog" append-to-body v-loading="loading">
        <template #title>
            <span>
                <i class="el-icon-s-operation" style="margin-right:8px;"></i>
                Actualizar datos de instalación
            </span>
        </template>

        <div class="row mt-2">
            <div class="col-md-6 mb-3">
                <label for="type">
                    <i class="el-icon-s-platform" style="font-size: 20px; margin-right: 6px;"></i>
                    Tipo de servicio
                </label>
                <el-select v-model="form.type">
                    <el-option value="antena" label="Antena" id="antena"></el-option>
                    <el-option value="fibra" label="Fibra" id="fibra"></el-option>
                </el-select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="id">
                    <i class="el-icon-suitcase" style="font-size: 20px; margin-right: 6px;"></i>
                    Id Precinto
                </label>
                <el-input v-model="form.identifier" placeholder="Id Precinto"></el-input>
            </div>
            <div class="col-md-6 mb-3">
                <label for="mac">
                    <i class="el-icon-connection" style="font-size: 20px; margin-right: 6px;"></i>
                    MAC
                </label>
                <div class="mac-input-wrapper" style="position: relative;">
                    <input type="text" v-model="form.mac" @input="transformMac($event.target.value)" placeholder="MAC"
                        maxlength="17"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 38px; background: transparent; color: transparent; caret-color: #333; border: 1px solid #dcdfe6; border-radius: 4px; z-index: 2; padding: 0 15px; font-size: 16px;"
                        autocomplete="off" />
                    <div class="mac-visual" v-html="formattedMac || '&nbsp;'"
                        style="pointer-events: none; position: absolute; top: 0; left: 0; width: 100%; height: 38px; line-height: 38px; padding: 0 15px; font-size: 16px; color: #333; background: white; border: 1px solid #dcdfe6; border-radius: 4px; z-index: 1; white-space: pre;">
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="supplie">
                    <i class="el-icon-cpu" style="font-size: 20px; margin-right: 6px;"></i>
                    Suministro Eléctrico
                </label>
                <el-input v-model="form.supplie" placeholder="Suministro eléctrico"></el-input>
            </div>
            <div class="col-md-12 mb-3">
                <label for="ip">
                    <i class="el-icon-location-outline" style="font-size: 20px; margin-right: 6px;"></i>
                    Dirección
                </label>
                <el-input v-model="form.installation_address" placeholder="Dirección"></el-input>
            </div>
            <div class="col-md-12 mb-3">
                <label for="ip">
                    <i class="el-icon-map-location" style="font-size: 20px; margin-right: 6px;"></i>
                    Referencia (Vivienda, Local, Oficina, etc.)
                </label>
                <el-input v-model="form.reference_installation_address" placeholder="Referencia"></el-input>
            </div>
            <div class="col-md-6 mb-3">
                <label for="ip">
                    <i class="el-icon-mobile-phone" style="font-size: 20px; margin-right: 6px;"></i>
                    Celular
                </label>
                <el-input v-model="form.telephone" placeholder="Celular"></el-input>
            </div>
        </div>
        <div slot="footer" class="dialog-footer">
            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                <el-button class="btn_cancelarsmall" @click="closeDialog">
                    <i class="fas fa-times fa-lg" style="margin-right: 4px;"></i>
                    Cancelar
                </el-button>
                <el-button class="btn_guardarsmall" type="primary" @click="submit">
                    <i class="fas fa-save fa-lg" style="margin-right: 4px;"></i>
                    Guardar
                </el-button>
            </div>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "record"],
    data() {
        return {
            form: {},
            loading: false,
            formattedMac: ''
        };
    },
    methods: {
        transformMac(mac) {
            // Limitar a 12 caracteres alfanuméricos
            mac = (mac || '').replace(/[^a-zA-Z0-9]/g, '').slice(0, 12);
            const regex = /\b([\w:]+)\b/g;
            const words = [];

            mac.replace(regex, (_, word) => {
                if (/^[a-zA-Z0-9:]+$/.test(word)) {
                    words.push(word);
                }
            });

            const formatedMac = words
                .map(word => {
                    if (word.length > 2) {
                        const chars = word.split("");
                        const two = [];
                        for (let i = 0; i < chars.length; i += 2) {
                            two.push(chars.slice(i, i + 2).join(""));
                        }
                        return two.join(":");
                    } else {
                        return word;
                    }
                })
                .join(":");

            this.form.mac = formatedMac;

            // Formatear para mostrar los : de otro color y con espacio antes y después
            this.formattedMac = formatedMac
                .split("")
                .map(char => {
                    if (char === ":") {
                        return '<span style="color: #ff6600; font-weight:bold; margin: 0 4px;"> : </span>';
                    } else {
                        return char;
                    }
                })
                .join("");
        },
        async getRecord() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/internet/register/data/${this.record.id}`
                );
                if (response.status == 200) {
                    const { register } = response.data;
                    this.form = register;
                    // Formatear la MAC al cargar el registro
                    this.transformMac(this.form.mac || '');
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        openDialog() {
            this.getRecord();
        },
        closeDialog() {
            this.$emit("update:showDialog", false);
        },
        validate() {
            let fail = false;

            let errors = {
                type: "El tipo de instalación es obligatorio",
                mac: "La MAC es obligatoria",
                installation_address: "La dirección es obligatoria",
                identifier: "El id es obligatorio",
                supplie: "El suministro eléctrico es obligatorio"
            };

            for (let error of Object.keys(errors).reverse()) {
                if (!this.form[error]) {
                    fail = true;
                    this.$toast.error(errors[error]);
                }
            }
            if (!this.form.telephone) {
                fail = true;
                this.$toast.error("El teléfono es obligatorio");
            } else {
                if (this.form.telephone.length != 9) {
                    fail = true;
                    this.$toast.error("El teléfono debe tener 9 dígitos");
                }
            }
            if (this.form.mac) {
                let mac = this.form.mac;
                mac = mac.split(":");
                if (mac.length != 6) {
                    fail = true;
                    this.$toast.error(
                        "La MAC debe tener 6 pares de caracteres separados por dos puntos (:)"
                    );
                } else {
                    for (let i = 0; i < mac.length; i++) {
                        if (mac[i].length != 2) {
                            fail = true;
                            this.$toast.error(
                                "La MAC debe tener 6 pares de caracteres separados por dos puntos (:)"
                            );
                        }
                    }
                }
            }
            if (this.form.supplie) {
                if (Number.isNaN(this.form.supplie)) {
                    fail = true;
                    this.$toast.error("El suministro debe ser numérico");
                }

                if (this.form.supplie.toString().length != 8) {
                    fail = true;
                    this.$toast.error("El suministro debe tener 8 dígitos");
                }
            }

            return fail;
        },
        async submit() {
            if (this.validate()) return;
            try {
                this.loading = true;
                const response = await this.$http.post(
                    `/internet/register/data`,
                    this.form
                );

                if (response.status == 200) {
                    this.$toast.success("Datos actualizados");
                    this.$emit("getRecords");
                    this.$emit("update:showDialog", false);
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
