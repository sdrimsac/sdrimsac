<template>
<v-stage ref="stage" :config="config" @click="addText">
    <v-layer ref="layer">
        <v-rect :config="{
            x: 0,
            y: 0,
            width: config.width,
            height: config.height,
            fill: 'white'
          }" />
        <v-text v-for="(text, index) in texts" :key="index" :config="text" @dblclick="editText(index)" draggable />
        <v-image v-for="(image, index) in images" :key="index" :config="image" draggable />
    </v-layer>
</v-stage>
</template>

  
<script>
import {
    Stage,
    Layer,
    Rect,
    Text,
    Image
} from 'vue-konva';
import Konva from 'konva';

export default {
    name: 'PaintCanvas',
    components: {
        'v-stage': Stage,
        'v-layer': Layer,
        'v-rect': Rect,
        'v-text': Text,
        'v-image': Image,
    },
    data() {
        return {
            config: {
                width: window.innerWidth,
                height: window.innerHeight,
            },
            texts: [],
            images: [],
        };
    },
    methods: {
        addText() {
            const text = {
                x: this.config.width / 2,
                y: this.config.height / 2,
                text: 'Double click to edit text',
                fontSize: 20,
                draggable: true,
                fill: 'black',
            };
            this.texts.push(text);
        },
        editText(index) {
            const newText = prompt('Edit text:', this.texts[index].text);
            if (newText) {
                this.$set(this.texts, index, {
                    ...this.texts[index],
                    text: newText
                });
            }
        },
        addImage() {
            const imageObj = new Image();
            imageObj.onload = () => {
                const konvaImage = new Konva.Image({
                    x: 50,
                    y: 50,
                    image: imageObj,
                    width: 100,
                    height: 100,
                    draggable: true,
                });
                this.images.push(konvaImage);
            };
            imageObj.src = 'URL_DE_LA_IMAGEN'; // Reemplaza con la URL de tu imagen
        },
    },
};
</script>

  
<style>
.canvas-container {
    width: 100%;
    height: 100%;
    position: relative;
}
</style>
