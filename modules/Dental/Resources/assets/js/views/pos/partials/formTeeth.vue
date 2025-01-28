<template>
    <el-dialog  
    :title="titleDialog"
    :visible="showDialog"
    :close-on-click-modal="false"
    @close="close"
    @open="create"
    append-to-body
    
    >
    <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">
                            Diente N°: {{ current_tooth }}
                        </h5>
                        <h5
                            role="button"
                            class="text-right"
                            @click="changeView"
                        >
                            {{ adding ? "Registros" : "Agregar" }}
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div v-show="!adding" class="container">
                            <div class="row">
                                <div class="table-responsive mb-1">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">
                                                    Registro
                                                </th>
                                                <th class="text-center">
                                                    Estado
                                                </th>
                                                <th class="text-center">
                                                    Opciones
                                                </th>
                                                <th class="text-center">
                                                    Lados
                                                </th>
                                                <th class="text-center">
                                                    Observacion
                                                </th>
                                                <th class="text-center">
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(value,
                                                name,
                                                index) in teeth[current_tooth]"
                                                v-show="name != 'details'"
                                                v-bind:key="name"
                                            >
                                                <td class="text-center">
                                                    {{ index }}
                                                </td>
                                                <td class="text-center">
                                                    {{ name }}
                                                </td>
                                                <td class="text-center">
                                                    {{
                                                        teeth[current_tooth][
                                                            name
                                                        ]["state"]
                                                    }}
                                                </td>
                                                <td class="text-center">
                                                    {{
                                                        formatOptions(
                                                            teeth[
                                                                current_tooth
                                                            ][name]
                                                        )
                                                    }}
                                                </td>
                                                <td class="text-center">
                                                    <el-tag
                                                        size="mini"
                                                        v-for="side in teeth[
                                                            current_tooth
                                                        ][name]['sides']"
                                                        :key="side"
                                                    >
                                                        {{ side }}
                                                    </el-tag>
                                                </td>
                                                <td class="text-center">
                                                    {{
                                                        teeth[current_tooth][
                                                            name
                                                        ]["observation"]
                                                    }}
                                                </td>
                                                <td class="text-center">
                                                    <button
                                                        class="btn btn-danger btn-sm"
                                                        @click="
                                                            deleteDetail(name)
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-trash"
                                                        ></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div v-show="adding" class="container">
                            <div class="row">
                                <div
                                    id="general"
                                    :class="
                                        this.tooth_info.position == 'below'
                                            ? 'wrap-tooth rotate'
                                            : 'wrap-tooth'
                                    "
                                >
                                    <img
                                        :src="
                                            `images/odontogram/teeth/${tooth_info.image}.png`
                                        "
                                    />
                                    <div id="tooth" class="tooth"></div>
                                </div>

                                <div
                                    class="col-sm-6 col-md-8 d-flex align-items-center"
                                >
                                    <el-autocomplete
                                        class="inline-input"
                                        v-model="itemSelected"
                                        :fetch-suggestions="querySearch"
                                        placeholder="Ingrese el motivo.."
                                        :trigger-on-focus="false"
                                        @select="handleSelect"
                                    ></el-autocomplete>
                                </div>
                                <div
                                    class="col-md-2 col-sm-4 d-flex align-items-center"
                                >
                                    <button class="btn btn-sm btn-primary">
                                        Buscar
                                    </button>
                                </div>
                            </div>
                            <div class="details">
                                <div v-if="detailState" class="row mb-1">
                                    <div class="col-md-6">
                                        <el-radio-group
                                            v-model="stateSelected"
                                            @change="changeState"
                                        >
                                            <el-radio-button
                                                v-for="state in [
                                                    'Bueno',
                                                    'Malo'
                                                ]"
                                                :label="state"
                                                :key="state"
                                            ></el-radio-button>
                                        </el-radio-group>
                                    </div>
                                </div>
                                <div
                                    v-if="hasOptions && !hasAcronym"
                                    class="row mb-1"
                                >
                                    <div class="col md-6">
                                        <div
                                            class="btn-group flex-wrap"
                                            role="group"
                                            aria-label="Basic example"
                                        >
                                            <el-radio-group
                                                v-model="optionSelected"
                                            >
                                                <el-radio-button
                                                    v-for="option in options"
                                                    :label="option"
                                                    :key="option"
                                                ></el-radio-button>
                                            </el-radio-group>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="hasAcronym" class="row mb-1">
                                    <div class="col md-6">
                                        <el-checkbox-group
                                            v-model="optionsSelected"
                                            size="mini"
                                        >
                                            <el-checkbox-button
                                                v-for="option in options"
                                                :label="option"
                                                :key="option"
                                                >{{
                                                    option
                                                }}</el-checkbox-button
                                            >
                                        </el-checkbox-group>
                                    </div>
                                </div>
                                <div v-if="range" class="row mb-1">
                                    <div class="col md-6">
                                        <el-checkbox-group
                                            v-model="rangeSelected"
                                            size="mini"
                                        >
                                            <el-checkbox-button
                                                v-for="teeth in ranges"
                                                :label="teeth"
                                                :key="teeth"
                                                @change="
                                                    updateRangeSelected(teeth)
                                                "
                                                >{{ teeth }}</el-checkbox-button
                                            >
                                        </el-checkbox-group>
                                    </div>
                                </div>
                                <div v-if="side" class="row mb-1">
                                    <div class="col md-6">
                                        <el-checkbox-group
                                            v-model="sidesSelected"
                                        >
                                            <el-checkbox-button
                                                v-for="side in sides"
                                                :label="side.name"
                                                :key="side.name"
                                                @change="setCavitie(side)"
                                                >{{
                                                    side.name
                                                }}</el-checkbox-button
                                            >
                                        </el-checkbox-group>
                                    </div>
                                </div>
                                <hr />
                                <div v-if="current_item" class="row mb-1">
                                    <el-input
                                        type="textarea"
                                        :autosize="{ minRows: 2 }"
                                        placeholder="Observación"
                                        v-model="observation"
                                    >
                                    </el-input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            @click="deleteDetails"
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Cerrar
                        </button>
                        <button
                            v-show="adding"
                            type="button"
                            data-dismiss="modal"
                            @click="saveDetails"
                            class="btn btn-primary"
                        >
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
    </el-dialog>
</template>
<script>
export default {
    props: [
        "current_tooth",
        "tooth_details",
        "tooth_info",
        "teeth",
        "repaint",
        "ranges",
        "line",
        "id"
    ],
    data() {
        return {
            showDialog: false,
            titleDialog: 'Historia clinica de Paciente',
            loading: false,
            observation: "",
            current_item: null,
            optionSelected: null,
            optionsSelected: [],
            sidesSelected: [],
            stateSelected: "Bueno",
            details: [],
            below: null,
            range: false,
            rangeSelected: [],
            sides: [
                { id: 1, name: "Vestibular", selected: false },
                { id: 2, name: "Palatino", selected: false },
                { id: 3, name: "Distal", selected: false },
                { id: 4, name: "Mesial", selected: false },
                { id: 5, name: "Oclusal", selected: false }
            ],
            options: [],
            acronyms: [],
            detailState: false,
            hasOptions: false,
            hasAcronym: false,
            side: false,
            adding: false,
            itemSelected: "",
            tooth: null
        }
    },
    methods: {
        open() {
            this.showDialog = true;
        },
        close() {
            this.showDialog = false;
        },
        create() {
            console.log('open');
        },
        formatOptions(tooth) {
            if (tooth["option"]) {
                return tooth["option"];
            }
            if (tooth["acronym"]) {
                return tooth["acronym"].join(",");
            }

            return "";
        },
        updateRangeSelected(teeth) {
            const idx = this.ranges.indexOf(teeth);
            this.rangeSelected = Array.from(this.ranges.slice(0, idx + 1));
        },
        async save() {
            this.loading = true;
            const toSave = JSON.stringify(this.teeth[this.current_tooth]);

            // await this.$http.post('/api/odontogram');
            let token = localStorage.getItem("token");
            const form = {
                tooth: Number(this.current_tooth),
                patient_id: this.id,
                data: toSave
            };

            const response = await this.$http.post("/api/odontogram", form, {
                headers: {
                    Authorization: "Bearer " + token
                }
            });
            console.log(response);
            this.loading = false;
        },
        async saveDetails() {
            this.adding = false;

            //diente no existe
            if (!this.teeth[this.current_tooth]) {
                //creo el diente y le agrego como propiedad la
                //enfermedad que se eligió
                this.teeth[this.current_tooth] = {
                    details: [],
                    [this.itemSelected]: {
                        observation: "",
                        sides: [],
                        option: null,
                        state: null,
                        range: [],
                        acronym: []
                    }
                };
            }
            //diente existe
            else {
                //si la enfermedad no existe en el diente
                if (!this.teeth[this.current_tooth][this.itemSelected]) {
                    //agrego la enfermedad
                    this.teeth[this.current_tooth][this.itemSelected] = {
                        observation: "",
                        sides: [],
                        option: null,
                        state: null,
                        range: [],
                        acronym: []
                    };
                }
            }
            this.teeth[this.current_tooth]["details"] = this.details;

            this.teeth[this.current_tooth][this.itemSelected][
                "observation"
            ] = this.observation;

            this.teeth[this.current_tooth][this.itemSelected]["sides"] = [
                ...this.sidesSelected
            ];

            this.optionSelected &&
                (this.teeth[this.current_tooth][this.itemSelected][
                    "option"
                ] = this.optionSelected);
            this.stateSelected &&
                (this.teeth[this.current_tooth][this.itemSelected][
                    "state"
                ] = this.stateSelected);
            this.rangeSelected.length != 0 &&
                (this.teeth[this.current_tooth][this.itemSelected][
                    "range"
                ] = this.rangeSelected);
            if (this.acronyms.length > 1) {
                const result = this.optionsSelected.map(a => {
                    let index = this.options.indexOf(a);
                    return this.acronyms[index];
                });

                this.teeth[this.current_tooth][this.itemSelected][
                    "acronym"
                ] = result;
            } else if (this.acronyms.length == 1) {
                this.teeth[this.current_tooth][this.itemSelected]["acronym"] = [
                    this.acronyms[0]
                ];
            }
            // this.acronyms.length != 0 &&
            //   (this.teeth[this.current_tooth][this.itemSelected]["acronym"] =
            //     this.acronyms);

            await this.save();
            this.resetDetails();
            this.deleteDetails();
            this.repaint();
        },
        deleteDetails() {
            this.adding = false;
            this.resetDetails();
            const elementTooth = document.getElementById("tooth");
            elementTooth && (elementTooth.innerHTML = "");
        },

        resetDetails() {
            this.observation = "";
            this.rangeSelected = [];
            this.itemSelected = "";
            this.current_item = null;
            this.sidesSelected = [];
            this.options = [];
            this.acronyms = [];
            this.hasAcronym = false;
            this.detailState = false;
            this.hasOptions = false;
            this.side = false;
            this.details = [];
            this.range = false;
            this.optionSelected = null;
            this.stateSelected = "Bueno";
            this.optionsSelected = [];
            this.sides = this.sides.map(s => {
                s.selected = false;
                return s;
            });
        },
        setCavitie(side) {
            const elementTooth = document.getElementById("tooth");
            side.selected = !side.selected;
            const cativie = document.createElement("div");
            cativie.classList.add(
                this.current_item.classes,
                `${this.tooth_info.type}-${side.name}`,
                `${this.tooth_info.type}-${side.name}-${this.current_item.classes}`
            );
            cativie.id = `${this.tooth_info.type}-${side.name}`;

            side.selected
                ? elementTooth.appendChild(cativie)
                : elementTooth.removeChild(
                      document.getElementById(
                          `${this.tooth_info.type}-${side.name}`
                      )
                  );

            side.selected
                ? this.details.push(
                      `${this.current_item.classes} ${this.tooth_info.type}-${side.name} ${this.tooth_info.type}-${side.name}-${this.current_item.classes}`
                  )
                : (this.details = this.details.filter(
                      d =>
                          d !=
                          `${this.current_item.classes} ${this.tooth_info.type}-${side.name} ${this.tooth_info.type}-${side.name}-${this.current_item.classes}`
                  ));
        },

        changeView() {
            this.adding = !this.adding;
            this.adding && this.setDetails(this.current_tooth);
        },
        setDetails(tooth, classes) {
            const elementTooth = document.getElementById("tooth");
            elementTooth.innerHTML = "";
            let allDetails = [];

            this.teeth[tooth] &&
                (allDetails = this.teeth[tooth].details.flat(1));

            if (classes && classes.includes("note")) {
                const lineClass =
                    this.line == 1
                        ? "first-line"
                        : this.line == 2
                        ? "second-line"
                        : this.line == 3
                        ? "third-line"
                        : "fourth-line";
                if (this.stateSelected == "Malo") {
                    classes = `note ${lineClass} bad`;
                } else {
                    classes = `note ${lineClass}`;
                }
            } else if (classes == "appliances geminacion") {
                const lineClass =
                    this.line == 1
                        ? "g1"
                        : this.line == 2
                        ? "g2"
                        : this.line == 3
                        ? "g3"
                        : "g4";

                classes = `${classes} ${lineClass}`;
            } else if (
                classes == "appliances clavija" ||
                classes == "appliances supernumeraria"
            ) {
                const lineClass =
                    this.line == 1
                        ? "c1"
                        : this.line == 2
                        ? "c2"
                        : this.line == 3
                        ? "c3"
                        : "c4";
                classes = `${classes} ${lineClass}`;
            } else if (classes == "appliances prosthesis prth-start") {
                if (this.line == 3 || this.line == 4) {
                    const lineClass = "prth-end";
                    classes = `${classes.split(" ")[0]} ${
                        classes.split(" ")[1]
                    } ${lineClass}`;
                }
            } else if (classes == "appliances appliance-fixed appfixed-start") {
                if (this.line == 3 || this.line == 4) {
                    const lineClass = "appfixed-end";
                    classes = `${classes.split(" ")[0]} ${
                        classes.split(" ")[1]
                    } ${lineClass}`;
                }
            } else if (classes == "appliances fusion") {
                const lineClass =
                    this.line == 1
                        ? "f1"
                        : this.line == 2
                        ? "f2"
                        : this.line == 3
                        ? "f3"
                        : "f4";
                classes = `${classes} ${lineClass}`;
            } else if (classes == "appliances transposition") {
                const lineClass =
                    this.line == 1
                        ? "t1"
                        : this.line == 2
                        ? "t2"
                        : this.line == 3
                        ? "t3"
                        : "t4";
                classes = `${classes} ${lineClass}`;
            }

            classes && classes != "cavities" && allDetails.push(classes);

            //this.teeth[tooth][`${this.itemSelected}`].
            allDetails.forEach(d => {
                const cativie = document.createElement("div");
                d.split(" ").forEach(c => {
                    cativie.classList.add(c);
                });
                cativie.id = d.split(" ")[1];
                elementTooth.appendChild(cativie);
            });
            this.details = allDetails.flat(1);

            this.below = this.tooth_info.position == "below";
        },
        handleSelect(item) {
            const elementTooth = document.getElementById("tooth");
            elementTooth.innerHTML = "";
            this.current_item = item;

            // if (this.stateSelected == "Malo") {
            //   //seteando estilos anteriores

            //   this.setDetails(this.current_tooth, item.classes + " bad");
            // } else {
            //seteando estilos anteriores
            this.setDetails(this.current_tooth, item.classes);
            // }
            //EL PROBLEMA ESTA EN EL WATCH Y LA CONDICION DE ARRIBA
            //si el diente existe
            if (this.teeth[this.current_tooth]) {
                //si la enfermedad no existe
                if (!this.teeth[this.current_tooth][this.itemSelected]) {
                    //se crea enfermedad
                    this.teeth[this.current_tooth][this.itemSelected] = {
                        details: [],
                        sides: [],
                        option: null,
                        state: this.stateSelected,
                        range: [],
                        acronym: []
                    };
                }
                //si la enfermedad en el diente tiene siglas
                this.acronyms = this.teeth[this.current_tooth][
                    this.itemSelected
                ].acronym;
                //si la enfermedad en el diente tiene rango de dientes
                this.rangeSelected = this.teeth[this.current_tooth][
                    this.itemSelected
                ].range;

                this.optionSelected = this.teeth[this.current_tooth][
                    this.itemSelected
                ].option;
                this.stateSelected = this.teeth[this.current_tooth][
                    this.itemSelected
                ].state;
                this.sidesSelected = this.teeth[this.current_tooth][
                    this.itemSelected
                ].sides;
                this.sides = this.sides.map(s => {
                    this.teeth[this.current_tooth][this.itemSelected].sides &&
                        this.teeth[this.current_tooth][
                            this.itemSelected
                        ].sides.some(side => side == s.name) &&
                        (s.selected = true);

                    return s;
                });

                this.optionsSelected = this.acronyms.map(a => {
                    let acronym = item.acronym.indexOf(a);

                    return item.options[acronym];
                });
            }

            this.detailState = item.state;
            this.side = item.sides;
            this.range = item.range;
            this.hasAcronym = !!item.acronym;
            //  this.side && (this.teeth[this.current_tooth][this.itemSelected].sides)
            this.hasOptions = !!item.options;
            item.options && (this.options = item.options);
            item.acronym && (this.acronyms = item.acronym);

            // if (this.hasAcronym && !this.hasOptions) {
            //   this.optionsSelected = item.acronym;
            //   this.options = [item.value];
            // }
        },
        querySearch(queryString, cb) {
            const filter = queryString
                ? results.filter(r =>
                      r.value.toLowerCase().includes(queryString.toLowerCase())
                  )
                : results;
            cb(filter);
        },

        changeState() {
            const elementTooth = document.getElementById("tooth");
            let lastDetail = this.details[this.details.length - 1];
            if (elementTooth.lastElementChild.classList.contains("bad")) {
                this.details[this.details.length - 1] = lastDetail.substr(
                    0,
                    lastDetail.length - 4
                );
                elementTooth.lastElementChild.classList.remove("bad");
            } else {
                this.details[this.details.length - 1] = lastDetail + " bad";

                elementTooth.lastElementChild.classList.add("bad");
            }
        },
        async deleteDetail(detail) {
            //obtener el diente, buscar la enfermedad y ver si tiene rango
            //si tiene iterar el rango y eliminar la enfermedad por su clase
            const appl = results.find(r => r.value == detail);

            if (appl.range) {
                const ids = this.teeth[this.current_tooth][detail].range;
                const state = this.teeth[this.current_tooth][detail].state;
                let classes = appl.classes;
                state == "Malo" && classes + "bad";
                if (appl.startToEnd) {
                    const first = ids[0];
                    const last = ids[ids.length - 1];
                    ids.forEach(id => {
                        let newClasses = classes;
                        if (id == last) {
                            newClasses = classes.replace("start", "end");
                        } else if (id != first && id != last) {
                            newClasses = classes.replace("start", "middle");
                        }
                        const tooth = document.getElementById(id);
                        const toDelete = document.getElementsByClassName(
                            newClasses
                        )[0];
                        this.teeth[this.current_tooth].details = this.teeth[
                            this.current_tooth
                        ].details.filter(d => d != toDelete.className);

                        tooth.removeChild(toDelete);
                    });
                    //la clase que me trae la enfermedad por default es la de start
                    //debo sacar el primer y ultimo id para borrarlos, cambiando la clase para el ultimo
                    //los demás borrarlos por middle
                } else {
                    ids.forEach(id => {
                        const tooth = document.getElementById(id);
                        const toDelete = document.getElementsByClassName(
                            classes
                        )[0];
                        this.teeth[this.current_tooth].details = this.teeth[
                            this.current_tooth
                        ].details.filter(d => d != toDelete.className);

                        tooth.removeChild(toDelete);
                    });
                }
            } else if (appl.sides) {
                const state = this.teeth[this.current_tooth][detail].state;
                let classes = appl.classes;

                state == "Malo" && classes + "bad";
                const tooth = document.getElementById(
                    Number(this.current_tooth)
                );
                const toDelete = [...document.getElementsByClassName(classes)];

                for (let del of toDelete) {
                    this.teeth[this.current_tooth].details = this.teeth[
                        this.current_tooth
                    ].details.filter(d => d != del.className);

                    tooth.removeChild(del);
                }
            } else if (appl.forLine) {
                const state = this.teeth[this.current_tooth][detail].state;
                let classes = appl.classes;

                state == "Malo" && classes + "bad";
                const tooth = document.getElementById(
                    Number(this.current_tooth)
                );

                const children = [...tooth.children];

                const toDelete = children.find(c =>
                    c.className.includes(classes)
                );

                // const toDelete = document.getElementsByClassName(classes)[0];

                //toDelete :classname: appliance fusion
                const detailClass = toDelete.className
                    .split(" ")
                    .slice(0, -1)
                    .join(" ");

                this.teeth[this.current_tooth].details = this.teeth[
                    this.current_tooth
                ].details.filter(d => !d.includes(detailClass));

                tooth.removeChild(toDelete);
            } else {
                const state = this.teeth[this.current_tooth][detail].state;
                let classes = appl.classes;

                state == "Malo" && classes + "bad";
                const tooth = document.getElementById(
                    Number(this.current_tooth)
                );
                const toDelete = document.getElementsByClassName(classes)[0];
                this.teeth[this.current_tooth].details = this.teeth[
                    this.current_tooth
                ].details.filter(d => d != toDelete.className);

                tooth.removeChild(toDelete);
            }

            this.$emit("deleteDetail", detail);
            this.loading = true;
            await this.save();
            this.loading = false;
            this.$forceUpdate();
        }
    },
}
</script>