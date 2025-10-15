<template>
    <el-dialog v-loading="loading" append-to-body @close="close" @open="open" :visible="showDialog"
        title="Agregar Observación">
        <div class="d-flex flex-column" style="margin-top:15px">
            Observaciones Seleccionadas:
            <el-input readonly v-model="observation"> </el-input>

            <div class="mt-2 d-flex flex-row justify-content-end align-items-center">
                <el-input class="input-new-tag" @input="search" v-model="newTag"
                    placeholder="Ingrese Nueva observación a Agregar" size="medium" maxlength="25" show-word-limit>
                </el-input>
                <el-button class="btn_guardarsmall button-new-tag" size="small" type="primary"
                    @click="handleInputConfirm">+ Agregar</el-button>
            </div>

            <div class="card mt-3">
                <div class="d-flex flex-wrap justify-content-center p-2">
                    <el-tag role="button" :type="data.selected ? 'success' : 'primary'"
                        style="margin-right:5px;margin-top:5px" v-for="(data, idx) in tags" :key="idx"
                        :disable-transitions="true" @click="select(idx)">
                        {{ data.description }}
                    </el-tag>
                    <template v-if="tags.length == 0">
                        <el-tag type="" :disable-transitions="true">
                            <span> Presione <b>+ Agregar</b> para guardar la observación</span>
                        </el-tag>
                    </template>
                </div>
            </div>

            <div class="p-2 d-flex justify-content-end align-items-center" style="margin-top:25px">
                
                <button class="btn_cancelarsmall" type="danger" @click="close" style="margin-left:10px;">
                    <i class="el-icon-close" style="margin-right:5px;"></i>
                    Cerrar
                </button>
                <button class="btn_guardarsmall" type="primary" @click="addObservation" style="margin-left:10px;">
                    <i class="el-icon-check" style="margin-right:5px;"></i>
                    Guardar
                </button>
            </div>
        </div>
    </el-dialog>
</template>
<style>
.el-tag+.el-tag {
    margin-left: 10px;
}

.button-new-tag {
    margin-left: 10px;
    height: 32px;
    line-height: 30px;
    padding-top: 0;
    padding-bottom: 0;
}

.input-new-tag {
    width: 250px;
    margin-left: 10px;
    vertical-align: bottom;
}

@media (max-width: 320px) {
    .el-dialog {
        margin: 5px !important;
        width: 100% !important;
        min-width: 0 !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
    }
}

@media (max-width: 360px) {
    .el-dialog {
        margin: 5px !important;
        width: 100% !important;
        min-width: 0 !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
    }
}

@media (max-width: 412px) {
    .el-dialog {
        margin: 5px !important;
        width: 90% !important;
        min-width: 0 !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
    }
}

@media (max-width: 768px) {
    .el-dialog {
        margin: 10px !important;
        width: 80% !important;
        min-width: 0 !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
    }
}
</style>
<script>
export default {
    props: ["showDialog", "observations", "current", "ordenId", "configuration"],
    data() {
        return {
            observation: null,
            observationsArray: [],
            newTag: null,
            tags: [],
            loading: false
        };
    },
    mounted() { },
    methods: {
        search(input) {
            this.tags = this.observations
                .filter(
                    o => o.description.includes(input.toUpperCase()) && o.active
                )
                .slice(0, 10);
            if (input.length > 50) {
                this.newTag = input.slice(0, 50);
            }
        },
        addObservation() {
            this.$emit("addObservation", this.observation);
            this.close();
        },
        async handleInputConfirm() {
            if (this.newTag) {
                if (this.newTag.trim().length > 1) {
                    let toAdd = this.newTag.toUpperCase();

                    try {
                        this.loading = true;
                        const payload = {
                            description: toAdd,
                            active: 1
                        };

                        if (this.configuration.observer_item) {
                            payload.item_id = this.ordenId;
                        }

                        const response = await this.$http.post(
                            "../observations",
                            payload
                        );

                        if (response.status == 200) {
                            this.tags.push({
                                description: toAdd,
                                selected: true,
                                active: 1,
                                item_id: this.configuration.observer_item ? this.ordenId : null
                            });
                            this.addWord(toAdd);
                            this.formatObs();

                            this.$emit("update:observations", [
                                ...this.observations,
                                ...this.tags
                            ]);

                            // Filtrar nuevamente las observaciones si observer_item es true
                            if (this.configuration.observer_item) {
                                this.tags = this.observations
                                    .filter(o => o.active && o.item_id === this.ordenId)
                                    .slice(0, 10);
                            } else {
                                this.tags = this.observations.slice(0, 10);
                            }
                        } else {
                            if (response.status == 422) {
                                this.$toast.error("La obse ya existe.");
                            } else {
                                this.$toast.error("No se guardó la obs.");
                            }
                        }
                    } catch (e) {
                        console.log(e);
                        const { response } = e;
                        if (response.status == 422) {
                            this.$toast.error("La observación ya existe.");
                        } else {
                            this.$toast.error("No se guardó la obs.");
                        }
                    } finally {
                        this.loading = false;
                    }
                }
            }

            this.newTag = null;
        },
        select(idx) {
            this.tags[idx].selected = !this.tags[idx].selected;
            if (this.tags[idx].selected) {
                this.addWord(this.tags[idx].description);
            } else {
                this.removeWord(this.tags[idx].description);
            }
            this.formatObs();
        },
        open() {
            console.log("open ver si pasa el id", this.ordenId);

            if (this.configuration.observer_item) {
                // Filtrar observaciones relacionadas al item_id si observer_item es true
                this.tags = this.observations
                    .filter(o => o.active && o.item_id === this.ordenId)
                    .slice(0, 10)
                    .map(o => ({
                        ...o,
                        description: o.description.toUpperCase(),
                        selected: false
                    }));
            } else {
                this.tags = this.observations
                    .filter(o => o.active)
                    .slice(0, 10)
                    .map(o => ({
                        ...o,
                        description: o.description.toUpperCase(),
                        selected: false
                    }));
            }

            this.observation = null;
            this.observationsArray = [];
            this.newTag = null;

            if (this.current != null) {
                if (this.current.length > 1) {
                    this.observation = this.current;
                    this.restore();
                }
            }
        },
        restore() {
            let obs = this.observation.split(" / ");
            this.observationsArray = obs;
            let tgs = this.tags.map(t => t.description);
            let idxs = [];
            for (let i = 0; i < tgs.length; i++) {
                let wd = tgs[i];
                if (obs.some(t => t == wd)) {
                    idxs.push(i);
                }
            }
            if (idxs.length != 0) {
                idxs.forEach(i => {
                    this.tags[i].selected = true;
                });
            }
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        addWord(word) {
            this.observationsArray.push(word);
        },
        removeWord(word) {
            this.observationsArray = this.observationsArray.filter(
                o => o != word
            );
        },
        formatObs() {
            this.observation = this.observationsArray.join(" / ");
        }
    }
};
</script>
