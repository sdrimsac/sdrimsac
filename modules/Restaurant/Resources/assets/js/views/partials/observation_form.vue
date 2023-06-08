<template>
    <el-dialog
        v-loading="loading"
        append-to-body
        @close="close"
        @open="open"
        :visible="showDialog"
    >
        <div class="d-flex flex-column" style="margin-top:15px">
            <el-input readonly v-model="observation"> </el-input>
            <div class="d-flex flex-wrap justify-content-center p-2">
                <el-tag
                    role="button"
                    :type="data.selected ? 'success' : 'primary'"
                    style="margin-right:5px;margin-top:5px"
                    v-for="(data, idx) in tags"
                    :key="idx"
                    :disable-transitions="true"
                    @click="select(idx)"
                >
                    {{ data.description }}
                </el-tag>
                <template v-if="tags.length == 0">
                    <el-tag type="danger" :disable-transitions="true">
                        <span
                            >NO EXISTE SU OBSERVACIÓN, PULSE
                            <b>+ AGREGAR</b> PARA GUARDARLA
                        </span>
                    </el-tag>
                </template>
            </div>

            <div class="d-flex justify-content-end align-items-center">
                <el-input
                    class="input-new-tag"
                    @input="search"
                    v-model="newTag"
                    placeholder="Nueva obs.."
                    size="medium"
                >
                </el-input>
                <el-button
                    class="button-new-tag"
                    size="small"
                    type="primary"
                    @click="handleInputConfirm"
                    >+ Agregar</el-button
                >
            </div>
            <div class="p-2 d-flex justify-content-end" style="margin-top:25px">
                <span slot="footer" class="dialog-footer">
                    <button
                        class="btn btn-sm btn-primary"
                        @click="addObservation"
                    >
                        Guardar
                    </button>
                    <button class="btn btn-sm btn-light" @click="close">
                        Cerrar
                    </button>
                </span>
            </div>
        </div>
    </el-dialog>
</template>
<style>
.el-tag + .el-tag {
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
</style>
<script>
export default {
    props: ["showDialog", "observations", "current"],
    data() {
        return {
            observation: null,
            observationsArray: [],
            newTag: null,
            tags: [],
            loading: false
        };
    },
    mounted() {},
    methods: {
        search(input) {
            this.tags = this.observations
                .filter(o => o.description.includes(input.toUpperCase()))
                .slice(0, 10);
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
                        const response = await this.$http.post(
                            "../observations",
                            {
                                description: toAdd,
                                active: 1
                            }
                        );
                        if (response.status == 200) {
                            this.tags.push({
                                description: toAdd,
                                selected: true,
                                active: 1
                            });
                            this.addWord(toAdd);
                            this.formatObs();

                            this.$emit("update:observations", [
                                ...this.observations,
                                ...this.tags
                            ]);
                            this.tags = this.observations.slice(0, 10);
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
            this.tags = this.observations.slice(0, 10).map(o => ({
                ...o,
                description: o.description.toUpperCase(),
                selected: false
            }));
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
