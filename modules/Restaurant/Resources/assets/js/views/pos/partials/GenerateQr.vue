<template>
    <el-dialog 
        :visible.sync="showDialog"
        :title="`Generar QR Yape`"
        width="400px"
        @close="close"
        append-to-body

    >
        <div class="row">
            <div class="col-12">
                <label for="amount">Monto</label>
                <el-input
                    v-model="amount"
                    type="number"
                    placeholder="Ingrese el monto"
                    @keyup.enter="generateYapeQR"
                ></el-input>
            </div>
        </div>
        <div class="row mt-3" v-if="qrCode">
            <div class="col-12 text-center">
                <img :src="qrCode" alt="QR Code" id="qr-image"/>
            </div>
        </div>
    </el-dialog>
</template>

<script>
export default {
    name: 'GenerateQr',
    props: {
        showDialog: {
            type: Boolean,
            required: true
        },
        initialAmount: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            amount: this.initialAmount,
            qrCode: null
        }
    },
    watch: {
        initialAmount: {
            immediate: true,
            handler(newVal) {
                this.amount = newVal;
            }
        },
        showDialog: {
            immediate: true,
            async handler(newVal) {
                if (newVal && this.amount > 0) {
                    await this.generateYapeQR();
                }
            }
        }
    },
    methods: {
        close() {
            this.$emit('update:showDialog', false);
        },
        async generateYapeQR() {
            try {
                if (!this.amount) {
                    this.$message.error('Por favor ingrese un monto');
                    return;
                }
                const response = await axios.post(`/caja/generateYapeQR/${this.amount}`);
                
                console.log('Respuesta completa:', response);
                console.log('Data de la respuesta:', response.data);

                // Verificar si la respuesta tiene la estructura esperada
                if (!response.data) {
                    console.error('La respuesta no tiene data');
                    this.$message.error('Error: Respuesta del servidor inválida');
                    return;
                }

                if (!response.data.qr) {
                    console.error('No se recibió el código QR en la respuesta');
                    return;
                }

                // Crear un div temporal para parsear el HTML
                const div = document.createElement('div');
                div.innerHTML = response.data.qr;

                const table = div.querySelector('table');
                if (!table) {
                    console.error('No se encontró la tabla en el HTML del QR');
                    return;
                }
                
                console.log('HTML de la tabla:', table.outerHTML);
                
                // Crear un canvas para dibujar el QR
                const canvas = document.createElement('canvas');
                const rows = table.querySelectorAll('tr');
                console.log('Número de filas encontradas:', rows.length);
                
                const firstRow = rows[0];
                const cells = firstRow.querySelectorAll('td');
                console.log('Número de celdas en la primera fila:', cells.length);
                
                const cellSize = 4; // Tamaño de cada celda según el estilo en la tabla

                // Establecer el tamaño del canvas basado en la tabla
                canvas.width = rows[0].querySelectorAll('td').length * cellSize;
                canvas.height = rows.length * cellSize;

                const ctx = canvas.getContext('2d');
                ctx.fillStyle = '#FFFFFF'; // Fondo blanco
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                // Iterar sobre cada celda de la tabla y dibujar en el canvas
                rows.forEach((row, y) => {
                    const cells = row.querySelectorAll('td');
                    cells.forEach((cell, x) => {
                        // Verificar si la celda es negra (QR activo) considerando múltiples casos
                        const backgroundColor = cell.style.backgroundColor;
                        const isBlack = cell.classList.contains('on') || 
                                      backgroundColor === 'rgb(0, 0, 0)' || 
                                      backgroundColor === '#000000' ||
                                      backgroundColor === '#000' ||
                                      cell.getAttribute('bgcolor') === '#000000' ||
                                      cell.getAttribute('bgcolor') === '#000';
                        
                        if (isBlack) {
                            ctx.fillStyle = '#000000';
                            ctx.fillRect(x * cellSize, y * cellSize, cellSize, cellSize);
                            console.debug(`Celda negra encontrada en (${x}, ${y})`);
                        }
                    });
                });

                // Convertir el canvas a una imagen base64
                this.qrCode = canvas.toDataURL('image/png');

                // Mostrar diálogo con el QR
                this.dialogVisible = true;
                
            } catch (error) {
                console.error('Error completo al generar QR:', error);
                console.error('Detalles de la respuesta en error:', error.response);
                this.$message.error('Error al generar el QR');
            }
        }
    }
}
</script>

<style scoped>
.mt-2 {
    margin-top: 0.5rem;
}
.mt-3 {
    margin-top: 1rem;
}
.text-center {
    text-align: center;
}
</style>