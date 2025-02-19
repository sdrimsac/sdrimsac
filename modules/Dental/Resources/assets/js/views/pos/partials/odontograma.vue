<template>
    <div class="row">
        <!-- Button trigger modal -->

        <el-dialog
            :title="`Radiografia N° ${currentImage}`"
            :visible.sync="centerDialogVisible"
            center
            append-to-body
            width="800px"
        >
            <div class="card" style="width: 100%; height: 600px; overflow: hidden;">
            <img
                class="select-photo"
                :src="`/images/radiografia/${currentImage}.jpg`"
                alt="s"
                style="width: 100%; height: 100%; object-fit: contain;"
            />
            </div>
        </el-dialog>
        <div class="col md-12">
            <div class="card p-2 bg-white">
                <!-- <div class="card-header">
                    <span role="button" class="text-primary text-right">
                        <i
                            class="fa fa-folder-plus fa-2x"
                            aria-hidden="true"
                        ></i>
                    </span>
                </div> -->
                <el-carousel :interval="4000" type="card" height="150px">
                    <el-carousel-item v-for="item in 4" :key="item">
                        <div class="card photo" @click="openImage(item)">
                            <div class="test">
                                <span>Radiografia N° {{ item }}</span>
                            </div>
                            <img
                                :src="`/images/radiografia/${item}.jpg`"
                                alt="s"
                            />
                        </div>
                    </el-carousel-item>
                </el-carousel>
            </div>
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-white">ODONTOGRAMA</h4>
                    <h4 class="text-white text-right">
                        Nombre del paciente | N° Historia 454136
                    </h4>
                </div>
                <div class="odontogram-wrap m-1">
                    <img
                        class="img-fluid"
                        src="/images/odontogram/odontograma.png"
                        alt=""
                    />

                    <div class="teeth-content">
                        <div class="adult-above" id="line-1">
                            <div class="teeth t-18" id="18" @click="openTeethModal('18', 1)"></div>
                            <div class="teeth t-17" id="17" @click="openTeethModal('17', 1)"></div>
                            <div class="teeth t-16" id="16" @click="openTeethModal('16', 1)"></div>
                            <div class="teeth t-15" id="15" @click="openTeethModal('15', 1)"></div>
                            <div class="teeth t-14" id="14" @click="openTeethModal('14', 1)"></div>
                            <div class="teeth t-13" id="13" @click="openTeethModal('13', 1)"></div>
                            <div class="teeth t-12" id="12" @click="openTeethModal('12', 1)"></div>
                            <div class="teeth t-11" id="11" @click="openTeethModal('11', 1)"></div>
                            <div class="teeth t-21" id="21" @click="openTeethModal('21', 1)"></div>
                            <div class="teeth t-22" id="22" @click="openTeethModal('22', 1)"></div>
                            <div class="teeth t-23" id="23" @click="openTeethModal('23', 1)"></div>
                            <div class="teeth t-24" id="24" @click="openTeethModal('24', 1)"></div>
                            <div class="teeth t-25" id="25" @click="openTeethModal('25', 1)"></div>
                            <div class="teeth t-26" id="26" @click="openTeethModal('26', 1)"></div>
                            <div class="teeth t-27" id="27" @click="openTeethModal('27', 1)"></div>
                            <div class="teeth t-28" id="28" @click="openTeethModal('28', 1)"></div>
                        </div>
                        <div class="child-above" id="line-2">
                            <div class="teeth t-55" id="55" @click="openTeethModal('55', 2)"></div>
                            <div class="teeth t-54" id="54" @click="openTeethModal('54', 2)"></div>
                            <div class="teeth t-53" id="53" @click="openTeethModal('53', 2)"></div>
                            <div class="teeth t-52" id="52" @click="openTeethModal('52', 2)"></div>
                            <div class="teeth t-51" id="51" @click="openTeethModal('51', 2)"></div>
                            <div class="teeth t-65" id="65" @click="openTeethModal('65', 2)"></div>
                            <div class="teeth t-64" id="64" @click="openTeethModal('64', 2)"></div>
                            <div class="teeth t-63" id="63" @click="openTeethModal('63', 2)"></div>
                            <div class="teeth t-62" id="62" @click="openTeethModal('62', 2)"></div>
                            <div class="teeth t-61" id="61" @click="openTeethModal('61', 2)"></div>
                        </div>
                        <div class="child-below" id="line-3">
                            <div class="teeth t-85 rotate" id="85" @click="openTeethModal('85', 3)"></div>
                            <div class="teeth t-84 rotate" id="84" @click="openTeethModal('84', 3)"></div>
                            <div class="teeth t-83 rotate" id="83" @click="openTeethModal('83', 3)"></div>
                            <div class="teeth t-82 rotate" id="82" @click="openTeethModal('82', 3)"></div>
                            <div class="teeth t-81 rotate" id="81" @click="openTeethModal('81', 3)"></div>
                            <div class="teeth t-75 rotate" id="75" @click="openTeethModal('75', 3)"></div>
                            <div class="teeth t-74 rotate" id="74" @click="openTeethModal('74', 3)"></div>
                            <div class="teeth t-73 rotate" id="73" @click="openTeethModal('73', 3)"></div>
                            <div class="teeth t-72 rotate" id="72" @click="openTeethModal('72', 3)"></div>
                            <div class="teeth t-71 rotate" id="71" @click="openTeethModal('71', 3)"></div>
                        </div>
                        <div class="adult-below" id="line-4">
                            <div class="teeth t-48 rotate" id="48" @click="openTeethModal('48', 4)"></div>
                            <div class="teeth t-47 rotate" id="47" @click="openTeethModal('47', 4)"></div>
                            <div class="teeth t-46 rotate" id="46" @click="openTeethModal('46', 4)"></div>
                            <div class="teeth t-45 rotate" id="45" @click="openTeethModal('45', 4)"></div>
                            <div class="teeth t-44 rotate" id="44" @click="openTeethModal('44', 4)"></div>
                            <div class="teeth t-43 rotate" id="43" @click="openTeethModal('43', 4)"></div>
                            <div class="teeth t-42 rotate" id="42" @click="openTeethModal('42', 4)"></div>
                            <div class="teeth t-41 rotate" id="41" @click="openTeethModal('41', 4)"></div>
                            <div class="teeth t-31 rotate" id="31" @click="openTeethModal('31', 4)"></div>
                            <div class="teeth t-32 rotate" id="32" @click="openTeethModal('32', 4)"></div>
                            <div class="teeth t-33 rotate" id="33" @click="openTeethModal('33', 4)"></div>
                            <div class="teeth t-34 rotate" id="34" @click="openTeethModal('34', 4)"></div>
                            <div class="teeth t-35 rotate" id="35" @click="openTeethModal('35', 4)"></div>
                            <div class="teeth t-36 rotate" id="36" @click="openTeethModal('36', 4)"></div>
                            <div class="teeth t-37 rotate" id="37" @click="openTeethModal('37', 4)"></div>
                            <div class="teeth t-38 rotate" id="38" @click="openTeethModal('38', 4)"></div>
                        </div>
                    </div>
                </div>
                <form-teeth
                    ref="modalTooth"
                    @deleteDetail="deleteDetail"
                    :line="line"
                    :ranges.sync="ranges"
                    :repaint="repaint"
                    v-bind:teeth="teeth"
                    :tooth_info="tooth_info"
                    :current_tooth.sync="current_tooth"
                    :tooth_details="tooth_details"
                    :id.sync="id"
                ></form-teeth>
                <button
                    style="display: none"
                    id="lauch_modal"
                    type="button"
                    class="btn btn-primary"
                    data-toggle="modal"
                    data-target="#staticBackdrop"
                ></button>
            </div>
        </div>
    </div>
</template>
<script>
import FormTeeth from "./formTeeth.vue";
export default {
    components: {
        FormTeeth
    },
    data() {
        return {
            currentImage: 1,
            centerDialogVisible: false,
            teeth: [],
            tooth_info: {
                type: 'above',
                position: 'above',
                image: ''
            },
            tooth_details: [],
            current_tooth: null,
            ranges: [],
            line: 1,
            id: 0
        };
    },
    created() {
        this.getTeeth(); // Agregar este método para cargar datos iniciales si es necesario
    },
    mounted() {
        const modal = document.getElementById("lauch_modal");
        /* this.getTeeth(); */
    },
    methods: {
        getTeeth() {
            // Obtener datos del odontograma si existen
            this.$http.get('odontogram').then(response => {
                this.teeth = response.data || [];
            });
        },
        openImage(image) {
            this.centerDialogVisible = true;
            this.currentImage = image;
        },
        openTeethModal(toothId, lineNumber) {
            this.current_tooth = toothId;
            this.line = lineNumber;
            
            // Establecer la información del diente
            this.tooth_info = {
                type: lineNumber <= 2 ? 'above' : 'below',
                position: lineNumber <= 2 ? 'above' : 'below',
                image: toothId
            };
            
            // Abrir el modal usando la referencia
            this.$refs.modalTooth.open();
        },
        clearAll() {
            const lines = ["line-1", "line-2", "line-3", "line-4"];
            lines.forEach(line => {
                const test = document.getElementById(line);
                [...test.children].forEach(e => {
                    e.innerHTML = "";
                });
            });
        },
        deleteDetail(detail) {
            this.$delete(this.teeth[this.current_tooth], detail);
        },
        repaint() {
            this.clearAll();
            //iterando sobre todo los dientes
            Object.keys(this.teeth).forEach(t => {
                const elementTooth = document.getElementById(t);
                //elementTooth.innerHTML = "";

                let acronyms = [];
                //iterando sobre todas las enfermedades del diente actual
                Object.keys(this.teeth[t]).forEach(a => {
                    //guardo la enfermedad
                    const appl = this.teeth[t][a];
                    //si la enfermedad acepta rango y este tiene dientes
                    if (appl.range && appl.range.length != 0) {
                        //elijo todos los dientes menos el primero (actual)
                        const ids = appl.range.slice(1);
                        //busco la enfermedad actual en la lista de todas las enfermedades
                        const problem = problems.find(p => p.value == a);

                        //separo sus clases
                        const classes = problem.classes.split(" ");
                        appl.state == "Malo" && classes.push("bad");
                        //si la enfermedad tiene figura para su inicio intermedio y final
                        if (problem.startToEnd) {
                            //obtengo la linea del diente actual
                            const { _, line } = details.getTeethRight(
                                Number(t)
                            );

                            //obtengo el ultimo diente del rango
                            const lastId = ids[ids.length - 1];
                            //itero sobre los dientes del rango
                            ids.forEach(id => {
                                const element = document.getElementById(id);

                                const detail = document.createElement("div");
                                //PROPIEDAD PROPIEDAD POSITION-1 XXX
                                //PROPIEDAD PROPIEDAD POSITION-2 XXX

                                if (id != lastId) {
                                    //si el diente actual no es el ultimo le pongo figura de intermedio

                                    classes.forEach(c => {
                                        detail.classList.add(
                                            c.replace("start", "middle")
                                        );
                                    });
                                } else {
                                    //si el diente es el ultimo le agrego figura de final
                                    classes.forEach(c => {
                                        detail.classList.add(
                                            c.replace("start", "end")
                                        );
                                    });
                                }
                                //si el diente esta en la fila 3 o 4 invierto la posicion
                                [3, 4].some(f => f == line) &&
                                    detail.classList.add("flipX");
                                // classes.forEach((c) => {

                                // });

                                element.appendChild(detail);
                            });
                        } else {
                            if (appl.state == "Malo") {
                                classes.push("bad");
                            }
                            ids.forEach(id => {
                                const element = document.getElementById(id);

                                const detail = document.createElement("div");

                                classes.forEach(c => {
                                    detail.classList.add(c);
                                });

                                element.appendChild(detail);
                            });
                        }
                    }
                    appl.acronym &&
                        appl.acronym.length != 0 &&
                        (acronyms = [...acronyms, ...appl.acronym]);
                });
                const allDetails = this.teeth[t].details.flat(1);

                allDetails.forEach(d => {
                    const detail = document.createElement("div");

                    d.split(" ").forEach(c => {
                        c.includes("note") &&
                            (detail.innerText = acronyms.join("-"));
                        detail.classList.add(c);
                    });

                    elementTooth.appendChild(detail);
                });
            });
        }
    }
};
</script>

<style scoped>
.teeth {
    cursor: pointer;
}
.teeth:hover {
    opacity: 0.8;
}
</style>
