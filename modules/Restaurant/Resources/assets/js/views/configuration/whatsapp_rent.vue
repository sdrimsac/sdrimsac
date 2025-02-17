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
                    <div class="col-12 mb-3">
                        <label class="control-label">Imagen del mensaje</label>
                        <div class="d-flex align-items-center gap-2">
                            <el-upload
                                class="upload-demo"
                                :action="`/caja/rent/whatsapp-settings/upload-temp`"
                                :on-success="(response) => handleUploadSuccess(response, 'before_due', index)"
                                :on-error="handleUploadError"
                                :before-upload="beforeUpload"
                                :headers="headers"
                                :show-file-list="false"
                            >
                                <el-button size="small" type="primary">
                                    <i class="fas fa-upload"></i> Subir imagen
                                </el-button>
                            </el-upload>
                            <div v-if="message.temp_path || message.image_path" class="image-preview">
                                <img 
                                    :src="message.temp_path ? message.temp_path : `/storage/${message.image_path}`" 
                                    class="preview-img"
                                >
                                <el-button 
                                    type="danger" 
                                    size="mini" 
                                    icon="el-icon-delete"
                                    @click="removeImage('before_due', index)"
                                ></el-button>
                            </div>
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
                    <div class="col-12 mb-3">
                        <label class="control-label">Imagen del mensaje</label>
                        <div class="d-flex align-items-center gap-2">
                            <el-upload
                                class="upload-demo"
                                :action="`/caja/rent/whatsapp-settings/upload-temp`"
                                :on-success="(response) => handleUploadSuccess(response, 'after_due', index)"
                                :on-error="handleUploadError"
                                :headers="headers"
                                :before-upload="beforeUpload"
                                :show-file-list="false"
                            >
                                <el-button size="small" type="primary">
                                    <i class="fas fa-upload"></i> Subir imagen
                                </el-button>
                            </el-upload>
                            <div v-if="message.temp_path || message.image_path" class="image-preview">
                                <img 
                                    :src="message.temp_path ? message.temp_path : `/storage/${message.image_path}`" 
                                    class="preview-img"
                                >
                                <el-button 
                                    type="danger" 
                                    size="mini" 
                                    icon="el-icon-delete"
                                    @click="removeImage('after_due', index)"
                                ></el-button>
                            </div>
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
            headers: headers_token,
            form: {
                before_due: [
                    { content: 'Sr. Inquilino {{huesped}}  le comunica que ya se encuentra disponible su recibo de pago  correspondiente al mes {{mes}}  Evite  el cargo de moras por retraso,  recuerde que puede pagar a través de las plataformas de Yape {{yape/plin}} o a la  cuenta “{{banco}}”  y confirmar enviando el Boucher al numero de WhatsApp “{{numero_whatsapp}}”  Si ya pago omita este mensaje Atte. La Gerencia General', days: 0, time: '08:00', active: true, saving: false, temp_path: null, temp_name: null },
                    { content: 'Sr. Inquilino {{huesped}}  le comunica que ya se encuentra disponible su recibo de pago  correspondiente al mes {{mes}}  Evite  el cargo de moras por retraso,  recuerde que puede pagar a través de las plataformas de Yape {{yape/plin}} o a la  cuenta “{{banco}}”  y confirmar enviando el Boucher al numero de WhatsApp “{{numero_whatsapp}}”  Si ya pago omita este mensaje Atte. La Gerencia General', days: 0, time: '08:00', active: true, saving: false, temp_path: null, temp_name: null },
                    { content: 'Sr. Inquilino {{huesped}}  le comunica que ya se encuentra disponible su recibo de pago  correspondiente al mes {{mes}}  Evite  el cargo de moras por retraso,  recuerde que puede pagar a través de las plataformas de Yape {{yape/plin}} o a la  cuenta “{{banco}}”  y confirmar enviando el Boucher al numero de WhatsApp “{{numero_whatsapp}}”  Si ya pago omita este mensaje Atte. La Gerencia General', days: 0, time: '08:00', active: true, saving: false, temp_path: null, temp_name: null }
                ],
                after_due: [
                    { content: 'Sr. Inquilino {{huesped}}  le comunica que ya se encuentra VENCIDO su recibo de pago  correspondiente al mes {{mes}}  Tiene (1) día(s) de atraso,  recuerde que puede pagar a través de las plataformas de Yape “numero de registrado para yape” o a la  cuenta {{banco}}  y confirmar enviando el Boucher al número de WhatsApp {{numero_whatsapp}} Si ya pago omita este mensaje Atte. La Gerencia General', days: 0, time: '08:00', active: true, saving: false, temp_path: null, temp_name: null }
                ]
            }
        };
    },
    methods: {
        beforeUpload(file) {
            const isImage = file.type.startsWith('image/');
            const isLt2M = file.size / 1024 / 1024 < 2;

            if (!isImage) {
                this.$message.error('Solo se permiten imágenes!');
                return false;
            }
            if (!isLt2M) {
                this.$message.error('La imagen no debe pesar más de 2MB!');
                return false;
            }
            this.$forceUpdate();
            return true;
        },

        handleUploadSuccess(response, type, index) {
            if (response.success) {
                this.form[type][index].temp_path = response.temp_url;
                this.form[type][index].temp_name = response.temp_name;
                this.$message.success('Imagen subida correctamente');
                this.$forceUpdate();
            } else {
                this.$message.error('Error al subir la imagen');
            }
        },

        handleUploadError() {
            this.$message.error('Error al subir la imagen');
        },

        removeImage(type, index) {
            if (this.form[type][index].image_path) {
                // Si la imagen ya está guardada, llamar al endpoint para eliminarla
                this.$http.delete(`/caja/rent/whatsapp-settings/remove-image/${this.form[type][index].id}`)
                    .then(() => {
                        this.form[type][index].image_path = null;
                        this.$message.success('Imagen eliminada correctamente');
                    })
                    .catch(() => {
                        this.$message.error('Error al eliminar la imagen');
                    });
            }
            this.form[type][index].temp_path = null;
            this.form[type][index].temp_name = null;
        },

        async saveMessage(message, type, order) {
            try {
                message.saving = true;
                const formData = new FormData();
                formData.append('content', message.content);
                formData.append('days', message.days);
                formData.append('time', message.time);
                formData.append('active', message.active);
                formData.append('type', type);
                formData.append('message_order', order);
                if (message.temp_name) {
                    formData.append('temp_name', message.temp_name);
                }

                const response = await this.$http.post('/caja/rent/whatsapp-settings', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                if (response.data.success) {
                    this.$message.success('Mensaje guardado correctamente');
                    if (response.data.image_path) {
                        message.image_path = response.data.image_path;
                        message.temp_path = null;
                        message.temp_name = null;
                    }
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
                    { content: 'Sr. Inquilino {{huesped}} le comunica que ya se encuentra disponible su recibo de pago  correspondiente al mes {{mes}}.  Evite  el cargo de moras por retraso,  recuerde que puede pagar a través de las plataformas de Yape {{yape/plin}} o a la  cuenta {{banco}}  y confirmar enviando el Boucher al numero de WhatsApp {{numero_whatsapp}}.  Si ya pago omita este mensaje Atte. La Gerencia General', days: 0, time: '08:00', active: true, saving: false, temp_path: null, temp_name: null },
                    { content: 'Sr. Inquilino {{huesped}} le comunica que ya se encuentra disponible su recibo de pago  correspondiente al mes {{mes}}.  Evite  el cargo de moras por retraso,  recuerde que puede pagar a través de las plataformas de Yape {{yape/plin}} o a la  cuenta {{banco}}  y confirmar enviando el Boucher al numero de WhatsApp {{numero_whatsapp}}.  Si ya pago omita este mensaje Atte. La Gerencia General', days: 0, time: '08:00', active: true, saving: false, temp_path: null, temp_name: null },
                    { content: 'Sr. Inquilino {{huesped}} le comunica que ya se encuentra disponible su recibo de pago  correspondiente al mes {{mes}}.  Evite  el cargo de moras por retraso,  recuerde que puede pagar a través de las plataformas de Yape {{yape/plin}} o a la  cuenta {{banco}}  y confirmar enviando el Boucher al numero de WhatsApp {{numero_whatsapp}}.  Si ya pago omita este mensaje Atte. La Gerencia General', days: 0, time: '08:00', active: true, saving: false, temp_path: null, temp_name: null }
                    ];

                    this.form.after_due = after_due.length > 0 ? formatMessages(after_due) : [
                    { content: 'Sr. Inquilino {{huesped}} le comunica que ya se encuentra VENCIDO su recibo de pago  correspondiente al mes {{mes}}.  Tiene (1) día(s) de atraso,  recuerde que puede pagar a través de las plataformas de Yape {{yape/plin}} o a la  cuenta {{banco}}  y confirmar enviando el Boucher al número de WhatsApp {{numero_whatsapp}}. Si ya pago omita este mensaje Atte. La Gerencia General', days: 0, time: '08:00', active: true, saving: false, temp_path: null, temp_name: null }
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

.image-preview {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-left: 10px;
}

.preview-img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 4px;
}

.el-upload {
    width: auto !important;
}
</style>
