<template>
<div class="card">
    <div class="card body">
        <div>
            <el-tooltip content="Top center" placement="top">
                <el-button>Texto</el-button>
            </el-tooltip>
            <el-tooltip content="Top center" placement="top">
                <el-img > Imagenes</el-img>
            </el-tooltip>
            <el-tooltip content="Top center" placement="top">
                <el-button>Dark</el-button>
            </el-tooltip>
            <el-tooltip content="Top center" placement="top">
                <el-button>Dark</el-button>
            </el-tooltip>
            <el-tooltip content="Top center" placement="top">
                <el-button>Dark</el-button>
            </el-tooltip>
            <el-tooltip content="Top center" placement="top">
                <el-button>Dark</el-button>
            </el-tooltip>
        </div>
        <div ref="canvasContainer" class="canvas-container">
            <canvas ref="canvas"></canvas>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: 'PaintCanvas',
    data() {
        return {
            isDrawing: false,
            ctx: null,
            lastPos: {
                x: 0,
                y: 0
            },
            currentColor: '#000000',
            lineWidth: 5,
        };
    },
    mounted() {
        const canvas = this.$refs.canvas;
        const canvasContainer = this.$refs.canvasContainer;
        canvas.width = canvasContainer.clientWidth;
        canvas.height = canvasContainer.clientHeight;
        this.ctx = canvas.getContext('2d');

        canvas.addEventListener('mousedown', this.startDrawing);
        canvas.addEventListener('mousemove', this.draw);
        canvas.addEventListener('mouseup', this.stopDrawing);
        canvas.addEventListener('mouseout', this.stopDrawing);
    },
    methods: {
        startDrawing(event) {
            this.isDrawing = true;
            this.lastPos = this.getMousePos(event);
        },
        draw(event) {
            if (!this.isDrawing) return;

            const mousePos = this.getMousePos(event);
            this.ctx.strokeStyle = this.currentColor;
            this.ctx.lineWidth = this.lineWidth;
            this.ctx.lineCap = 'round';
            this.ctx.beginPath();
            this.ctx.moveTo(this.lastPos.x, this.lastPos.y);
            this.ctx.lineTo(mousePos.x, mousePos.y);
            this.ctx.stroke();
            this.lastPos = mousePos;
        },
        stopDrawing() {
            this.isDrawing = false;
        },
        getMousePos(event) {
            const rect = this.$refs.canvas.getBoundingClientRect();
            return {
                x: event.clientX - rect.left,
                y: event.clientY - rect.top,
            };
        },
        setColor(color) {
            this.currentColor = color;
        },
        setLineWidth(width) {
            this.lineWidth = width;
        },
        clearCanvas() {
            this.ctx.clearRect(0, 0, this.$refs.canvas.width, this.$refs.canvas.height);
        }
    },
};
</script>

<style>
.canvas-container {
    width: 100%;
    height: 100%;
    border: 1px solid #000;
    position: relative;
}

canvas {
    display: block;
}
</style>
