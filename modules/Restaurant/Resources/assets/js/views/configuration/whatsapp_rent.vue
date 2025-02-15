<template>
    <el-dialog
        title="Configuración de Mensajes"
        :visible="showDialog"
        append-to-body
        @close="close"
        @open="open"
        class="rounded-dialog"
        width="70%"
        v-loading="loading"
    >
        <div class="row">
            <!-- Sección Antes del Vencimiento -->
            <div class="col-12 mb-4">
                <h5>ANTES DEL VENCIMIENTO</h5>
                <div v-for="(message, index) in form.before_due" :key="'before_'+index" class="row align-items-center mb-4">
                    <div class="col-1">
                        {{ index + 1 }}° mensaje
                    </div>
                    <div class="col-5">
                        <label class="control-label">Contenido del mensaje</label>
                        <el-input
                            type="textarea"
                            v-model="message.content"
                            placeholder="Escriba el contenido del mensaje"
                            :rows="2"
                        ></el-input>
                    </div>
                    <div class="col-2">
                        <label class="control-label">Días de anticipación</label>
                        <el-input-number 
                            v-model="message.days"
                            :min="0"
                            placeholder="Ingrese días"
                            class="w-100"
                        ></el-input-number>
                    </div>
                    <div class="col-2">
                        <label class="control-label">Hora de envío</label>
                        <el-time-select
                            v-model="message.time"
                            placeholder="Seleccione hora"
                            :picker-options="{
                                start: '00:00',
                                step: '00:30',
                                end: '23:30'
                            }"
                        ></el-time-select>
                    </div>
                    <div class="col-2">
                        <label class="control-label">Estado</label>
                        <div class="d-flex gap-2">
                            <el-switch v-model="message.active"></el-switch>
                            <el-button 
                                type="success" 
                                @click="saveMessage(message, 'before_due', index + 1)"
                                :loading="message.saving"
                            >Guardar</el-button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección Después del Vencimiento -->
            <div class="col-12">
                <h5>DESPUÉS DEL VENCIMIENTO</h5>
                <div v-for="(message, index) in form.after_due" :key="'after_'+index" class="row align-items-center mb-4">
                    <div class="col-1">
                        {{ index + 1 }}° mensaje
                    </div>
                    <div class="col-5">
                        <label class="control-label">Contenido del mensaje</label>
                        <el-input
                            type="textarea"
                            v-model="message.content"
                            placeholder="Escriba el contenido del mensaje"
                            :rows="2"
                        ></el-input>
                    </div>
                    <div class="col-2">
                        <label class="control-label">Días después</label>
                        <el-input-number 
                            v-model="message.days"
                            :min="0"
                            placeholder="Ingrese días"
                            class="w-100"
                        ></el-input-number>
                    </div>
                    <div class="col-2">
                        <label class="control-label">Hora de envío</label>
                        <el-time-select
                            v-model="message.time"
                            placeholder="Seleccione hora"
                            :picker-options="{
                                start: '00:00',
                                step: '00:30',
                                end: '23:30'
                            }"
                        ></el-time-select>
                    </div>
                    <div class="col-2">
                        <label class="control-label">Estado</label>
                        <div class="d-flex gap-2">
                            <el-switch v-model="message.active"></el-switch>
                            <el-button 
                                type="success" 
                                @click="saveMessage(message, 'after_due', index + 1)"
                                :loading="message.saving"
                            >Guardar</el-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog"],
    data() {
        return {
            loading: false,
            form: {
                before_due: [
                    { content: 'Sr. Inquilino {{huesped}}  le comunica que ya se encuentra disponible su recibo de pago  correspondiente al mes {{mes}}  Evite  el cargo de moras por retraso,  recuerde que puede pagar a través de las plataformas de Yape {{yape/plin}} o a la  cuenta “{{banco}}”  y confirmar enviando el Boucher al numero de WhatsApp “{{numero_whatsapp}}”  Si ya pago omita este mensaje Atte. La Gerencia General', days: 0, time: '08:00', active: true, saving: false },
                    { content: 'Sr. Inquilino {{huesped}}  le comunica que ya se encuentra disponible su recibo de pago  correspondiente al mes {{mes}}  Evite  el cargo de moras por retraso,  recuerde que puede pagar a través de las plataformas de Yape {{yape/plin}} o a la  cuenta “{{banco}}”  y confirmar enviando el Boucher al numero de WhatsApp “{{numero_whatsapp}}”  Si ya pago omita este mensaje Atte. La Gerencia General', days: 0, time: '08:00', active: true, saving: false },
                    { content: 'Sr. Inquilino {{huesped}}  le comunica que ya se encuentra disponible su recibo de pago  correspondiente al mes {{mes}}  Evite  el cargo de moras por retraso,  recuerde que puede pagar a través de las plataformas de Yape {{yape/plin}} o a la  cuenta “{{banco}}”  y confirmar enviando el Boucher al numero de WhatsApp “{{numero_whatsapp}}”  Si ya pago omita este mensaje Atte. La Gerencia General', days: 0, time: '08:00', active: true, saving: false }
                ],
                after_due: [
                    { content: 'Sr. Inquilino {{huesped}}  le comunica que ya se encuentra VENCIDO su recibo de pago  correspondiente al mes {{mes}}  Tiene (1) día(s) de atraso,  recuerde que puede pagar a través de las plataformas de Yape “numero de registrado para yape” o a la  cuenta {{banco}}  y confirmar enviando el Boucher al número de WhatsApp {{numero_whatsapp}} Si ya pago omita este mensaje Atte. La Gerencia General', days: 0, time: '08:00', active: true, saving: false }
                ]
            }
        };
    },
    methods: {
        async saveMessage(message, type, order) {
            try {
                message.saving = true;
                const response = await this.$http.post('/caja/rent/whatsapp-settings', {
                    content: message.content,
                    days: message.days,
                    time: message.time,
                    active: message.active,
                    type: type,
                    message_order: order
                });

                if (response.data.success) {
                    this.$message.success('Mensaje guardado correctamente');
                } else {
                    this.$message.error(response.data.message);
                }
            } catch (error) {
                console.error(error);
                this.$message.error('Ocurrió un error al guardar el mensaje');
            } finally {
                message.saving = false;
            }
        },

        async getSettings() {
            try {
                this.loading = true;
                const response = await this.$http.get('/caja/rent/whatsapp-settings');
                if (response.data.success) {
                    const { before_due, after_due } = response.data.messages;
                    
                    // Función para formatear el tiempo
                    const formatTime = (datetime) => {
                        if (!datetime) return '08:00';
                        // Si viene con fecha, extraer solo la hora y minutos
                        if (datetime.includes('T')) {
                            return datetime.split('T')[1].substring(0, 5);
                        }
                        return datetime;
                    };

                    // Formatear los mensajes existentes
                    const formatMessages = (messages) => {
                        return messages.map(msg => ({
                            ...msg,
                            time: formatTime(msg.time),
                            saving: false
                        }));
                    };

                    // Aseguramos tener siempre 3 mensajes antes y 1 después
                    this.form.before_due = before_due.length > 0 ? formatMessages(before_due) : [
                    { content: 'Sr. Inquilino {{huesped}} le comunica que ya se encuentra disponible su recibo de pago  correspondiente al mes {{mes}}.  Evite  el cargo de moras por retraso,  recuerde que puede pagar a través de las plataformas de Yape {{yape/plin}} o a la  cuenta {{banco}}  y confirmar enviando el Boucher al numero de WhatsApp {{numero_whatsapp}}.  Si ya pago omita este mensaje Atte. La Gerencia General', days: 0, time: '08:00', active: true, saving: false },
                    { content: 'Sr. Inquilino {{huesped}} le comunica que ya se encuentra disponible su recibo de pago  correspondiente al mes {{mes}}.  Evite  el cargo de moras por retraso,  recuerde que puede pagar a través de las plataformas de Yape {{yape/plin}} o a la  cuenta {{banco}}  y confirmar enviando el Boucher al numero de WhatsApp {{numero_whatsapp}}.  Si ya pago omita este mensaje Atte. La Gerencia General', days: 0, time: '08:00', active: true, saving: false },
                    { content: 'Sr. Inquilino {{huesped}} le comunica que ya se encuentra disponible su recibo de pago  correspondiente al mes {{mes}}.  Evite  el cargo de moras por retraso,  recuerde que puede pagar a través de las plataformas de Yape {{yape/plin}} o a la  cuenta {{banco}}  y confirmar enviando el Boucher al numero de WhatsApp {{numero_whatsapp}}.  Si ya pago omita este mensaje Atte. La Gerencia General', days: 0, time: '08:00', active: true, saving: false }
                    ];

                    this.form.after_due = after_due.length > 0 ? formatMessages(after_due) : [
                    { content: 'Sr. Inquilino {{huesped}} le comunica que ya se encuentra VENCIDO su recibo de pago  correspondiente al mes {{mes}}.  Tiene (1) día(s) de atraso,  recuerde que puede pagar a través de las plataformas de Yape {{yape/plin}} o a la  cuenta {{banco}}  y confirmar enviando el Boucher al número de WhatsApp {{numero_whatsapp}}. Si ya pago omita este mensaje Atte. La Gerencia General', days: 0, time: '08:00', active: true, saving: false }
                    ];
                }
            } catch (error) {
                console.error("Error al cargar configuraciones:", error);
                this.$message.error('Error al cargar las configuraciones');
            } finally {
                this.loading = false;
            }
        },

        close() {
            this.$emit("update:showDialog", false);
        },

        open() {
            this.getSettings();
        }
    }
};
</script>

<style scoped>
.el-dialog {
    border-radius: 10px;
    overflow: hidden;
}

.el-textarea__inner {
    font-size: 13px;
}

h5 {
    color: #606266;
    font-size: 14px;
    margin-bottom: 15px;
}

.control-label {
    color: #606266;
    font-size: 13px;
    margin-bottom: 5px;
    display: block;
}

.el-input-number,
.el-time-select {
    width: 100%;
}

.gap-2 {
    gap: 0.5rem;
}

.el-button {
    margin-top: 0;
}
</style>
