<template>
    <el-dialog
        :visible="showDialog"
        @open="openDialog"
        @close="closeDialog"
        title="Actualizar datos"
        append-to-body
        v-loading="loading"
    >
        <div class="row mt-2">
            <div class="col-md-6">
                <label for="type">Tipo</label>
                <el-select v-model="form.type">
                    <el-option value="antena" label="Antena" id="antena">
                    </el-option>
                    <el-option value="fibra" label="Fibra" id="fibra">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-6">
                <label for="id">Id Precinto</label>
                <el-input
                    v-model="form.identifier"
                    placeholder="Id Precinto"
                ></el-input>
            </div>
            <div class="col-md-6">
                <label for="mac">MAC</label>
                <el-input
                    v-model="form.mac"
                    @input="transformMac"
                    placeholder="MAC"
                ></el-input>
            </div>
            <div class="col-md-6">
                <label for="supplie">Suministro eléctrico</label>
                <el-input
                    v-model="form.supplie"
                    placeholder="Suministro eléctrico"
                >
                </el-input>
            </div>
            <div class="col-md-6">
                <label for="ip">Dirección</label>
                <el-input
                    v-model="form.installation_address"
                    placeholder="Dirección"
                ></el-input>
            </div>
            <div class="col-md-6">
                <label for="ip">Referencia</label>
                <el-input
                    v-model="form.reference_installation_address"
                    placeholder="Referencia"
                ></el-input>
            </div>
            <div class="col-md-6">
                <label for="ip">Celular</label>
                <el-input
                    v-model="form.telephone"
                    placeholder="Celular"
                ></el-input>
            </div>
        </div>
        <div slot="footer" class="dialog-footer">
            <el-button @click="closeDialog">Cancelar</el-button>
            <el-button type="primary" @click="submit">Guardar</el-button>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "record"],
    data() {
        return {
            form: {},
            loading: false
        };
    },
    methods: {
        transformMac(mac) {
            mac = mac.replace(/:/g, "");
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
                .join(" ");

            this.form.mac = formatedMac;
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
