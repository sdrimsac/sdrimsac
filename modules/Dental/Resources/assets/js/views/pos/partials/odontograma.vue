<template>
    <div class="row">
        <!-- Button trigger modal -->

        <el-dialog
            :title="`Radiografia N° ${currentImage}`"
            :visible.sync="centerDialogVisible"
            center
        >
            <img
                class="select-photo"
                :src="`/images/radiografia/${currentImage}.jpg`"
                alt="s"
            />
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
                            <div class="teeth t-18" id="18"></div>
                            <div class="teeth t-17" id="17"></div>
                            <div class="teeth t-16" id="16"></div>
                            <div class="teeth t-15" id="15"></div>
                            <div class="teeth t-14" id="14"></div>
                            <div class="teeth t-13" id="13"></div>
                            <div class="teeth t-12" id="12"></div>
                            <div class="teeth t-11" id="11"></div>
                            <div class="teeth t-21" id="21"></div>
                            <div class="teeth t-22" id="22"></div>
                            <div class="teeth t-23" id="23"></div>
                            <div class="teeth t-24" id="24"></div>
                            <div class="teeth t-25" id="25"></div>
                            <div class="teeth t-26" id="26"></div>
                            <div class="teeth t-27" id="27"></div>
                            <div class="teeth t-28" id="28"></div>
                        </div>
                        <div class="child-above" id="line-2">
                            <div class="teeth t-55" id="55"></div>
                            <div class="teeth t-54" id="54"></div>
                            <div class="teeth t-53" id="53"></div>
                            <div class="teeth t-52" id="52"></div>
                            <div class="teeth t-51" id="51"></div>
                            <div class="teeth t-65" id="65"></div>
                            <div class="teeth t-64" id="64"></div>
                            <div class="teeth t-63" id="63"></div>
                            <div class="teeth t-62" id="62"></div>
                            <div class="teeth t-61" id="61"></div>
                        </div>
                        <div class="child-below" id="line-3">
                            <div class="teeth t-85 rotate" id="85"></div>
                            <div class="teeth t-84 rotate" id="84"></div>
                            <div class="teeth t-83 rotate" id="83"></div>
                            <div class="teeth t-82 rotate" id="82"></div>
                            <div class="teeth t-81 rotate" id="81"></div>
                            <div class="teeth t-75 rotate" id="75"></div>
                            <div class="teeth t-74 rotate" id="74"></div>
                            <div class="teeth t-73 rotate" id="73"></div>
                            <div class="teeth t-72 rotate" id="72"></div>
                            <div class="teeth t-71 rotate" id="71"></div>
                        </div>
                        <div class="adult-below" id="line-4">
                            <div class="teeth t-48 rotate" id="48"></div>
                            <div class="teeth t-47 rotate" id="47"></div>
                            <div class="teeth t-46 rotate" id="46"></div>
                            <div class="teeth t-45 rotate" id="45"></div>
                            <div class="teeth t-44 rotate" id="44"></div>
                            <div class="teeth t-43 rotate" id="43"></div>
                            <div class="teeth t-42 rotate" id="42"></div>
                            <div class="teeth t-41 rotate" id="41"></div>
                            <div class="teeth t-31 rotate" id="31"></div>
                            <div class="teeth t-32 rotate" id="32"></div>
                            <div class="teeth t-33 rotate" id="33"></div>
                            <div class="teeth t-34 rotate" id="34"></div>
                            <div class="teeth t-35 rotate" id="35"></div>
                            <div class="teeth t-36 rotate" id="36"></div>
                            <div class="teeth t-37 rotate" id="37"></div>
                            <div class="teeth t-38 rotate" id="38"></div>
                        </div>
                    </div>
                </div>
                <Form-Teeth
                    ref="modalTooth"
                    
                    :line="line"
                    :ranges.sync="ranges"
                    :repaint="repaint"
                    v-bind:teeth="teeth"
                    :tooth_info="tooth_info"
                    :current_tooth.sync="current_tooth"
                    :tooth_details="tooth_details"
                    :id.sync="id"
                ></Form-Teeth>
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
        FormTeeth,
    },
    data() {
        return {
            currentImage: 1,
            centerDialogVisible: false,
            teeth: [],
            tooth_info: {},
            tooth_details: [],
            current_tooth: {},
            ranges: [],
            line: 1,
            id: 0,
            repaint: false,
            currentImage: null
        };
    },
    mounted() {
        const modal = document.getElementById("lauch_modal");
        /* this.getTeeth(); */
    },
    methods: {
        openImage(image) {
            this.centerDialogVisible = true;
            this.currentImage = image;
        }
    }
};
</script>
