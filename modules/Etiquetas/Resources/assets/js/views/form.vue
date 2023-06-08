<template>
    <el-dialog
        @open="open"
        @close="close"
        show-close
        :visible="showDialog"
        v-loading="loading"
        width="80%"
    >
        <div class="row p-3">
            <label for="" class="control-label">
                Ingrese la palabra
            </label>
            <el-input maxlength="20" @input="murci" v-model="word"> </el-input>
        </div>
        <div class="d-flex flex-column align-items-center">
            <!-- <div class="word text-center text-uppercase h3">
                {{ word }}
            </div> -->

            <table>
                <tbody>
                    <td
                        class="text-uppercase h3"
                        v-for="(w, idx) in arr_word"
                        :key="idx"
                    >
                        <div
                            class="d-flex flex-column align-items-center justify-content-between"
                        >
                            <span :class="w.isUnique ? 'unique' : 'repeat'">
                                {{ w.letter }}</span
                            >
                            <span>{{ w.isUnique ? w.value : "&nbsp;" }}</span>
                        </div>
                    </td>
                </tbody>
            </table>

            <el-button type="success" class="m-2" @click="saveWord">
                Guardar
            </el-button>

            <!-- <table>
                    <tbody>
                        <td></td>
                    </tbody>
                </table> -->
        </div>
    </el-dialog>
</template>

<style scoped>
.unique {
    color: black;
}
.repeat {
    color: darkgray;
}
</style>
<script>
export default {
    props: ["showDialog", "words"],
    data() {
        return {
            loading: false,
            word: null,
            length_table: null,
            arr_word: [],
            resource: "etiquetas"
        };
    },
    methods: {
        murci() {
            this.length_table = this.word.length;
            this.createArr();
        },
        createArr() {
            let obj = [];

            let arr = this.word
                .toUpperCase()

                .split("");

            let unique = {};
            let indx = 0;
            for (let i = 0; i < arr.length; i++) {
                let w = arr[i].trim();
                if (w.length > 0 && unique[w] == undefined && 11 > indx + 1) {
                    unique[w] = indx + 1;
                    ++indx;
                }
            }
            let upper = this.word.toUpperCase().split("");
            let idx = 0;
            for (let i = 0; i < upper.length; i++) {
                let letter = upper[i];

                let isUnique = false;

                if (unique[letter] != undefined && unique[letter] == idx + 1) {
                    isUnique = true;
                    ++idx;
                }
                let insert = {};
                insert.letter = letter;
                insert.isUnique = isUnique;
                if (isUnique) {
                    insert.value = idx == 10 ? 0 : idx;
                }
                obj.push(insert);
            }

            this.arr_word = obj;
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        open() {
            this.word = null;
        },

        async saveWord() {
            if (!this.arr_word.some(a => a.value == 0)) {
                this.$toast.error("La palabra necesita 10 letras únicas");
                return;
            }
            let indice = this.arr_word
                .filter(a => a.isUnique)
                .map(b => b.letter)
                .join("");

            this.loading = true;
            try {
                const response = await this.$http.post(
                    `${this.resource}/palabra`,
                    {
                        word: this.word,
                        indice
                    }
                );
                const { data } = response;
                if (data.success) {
                    this.$toast.success(data.message);
                    this.loading = false;
                    let newWords = [
                        {
                            id: data.id,
                            palabra: this.word.toUpperCase(),
                            indice
                        },
                        ...this.words
                    ];
                    this.$emit("update:words", newWords);
                    this.close();
                    return;
                } else {
                    this.$toast.error(data.message);
                }

                this.loading = false;
            } catch (e) {
                const {
                    data: { message }
                } = e.response;
                this.$toast.error(message);
                this.loading = false;
            }
        }
    }
};
</script>
