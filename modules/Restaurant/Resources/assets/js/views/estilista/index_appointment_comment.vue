<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8" v-if="!completed">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"
                        style="color: white;"
                        >Valorar la atención recibida</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group text-center mb-4">
                            <label class="form-label d-block mb-3 h5">¿Cómo calificas tu experiencia de {{ user_name }} el día {{ appointment_date }}?</label>
                            <div class="rating-stars">
                                <i 
                                    v-for="star in 5" 
                                    :key="star"
                                    :class="[
                                        'fa-2x', 
                                        'far', 
                                        star <= qualification ? 'fa-star text-warning' : 'fa-star',
                                        { 'fas': star <= qualification }
                                    ]"
                                    @click="setRating(star)"
                                    @mouseover="hoverRating(star)"
                                    @mouseleave="resetHover()"
                                ></i>
                            </div>
                            <div class="mt-2 text-muted">
                                {{ ratingText }}
                            </div>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label class="form-label h5" for="comment">Comentarios adicionales</label>
                            <textarea 
                                id="comment" 
                                v-model="comment" 
                                class="form-control" 
                                rows="4" 
                                placeholder="Comparte tu experiencia con el servicio recibido..."
                            ></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <div>
                                <span v-if="appointment && appointment.service" class="text-primary">
                                    <i class="icofont-cut mr-1"></i> Servicio: {{ appointment.service.description }}
                                </span>
                                <div v-if="appointment" class="text-muted small mt-2">
                                    <i class="far fa-calendar-alt mr-1"></i> {{ formatDate(appointment.appointment_date) }}
                                    <i class="far fa-clock ml-2 mr-1"></i> {{ formatTime(appointment.start_time) }}
                                </div>
                            </div>
                            <button 
                                class="btn btn-primary btn-lg" 
                                :disabled="isSubmitDisabled || loading" 
                                @click="submitRating"
                            >
                                <i class="fas fa-paper-plane mr-2"></i>
                                <span v-if="!loading">Enviar valoración</span>
                                <span v-else><i class="fas fa-spinner fa-spin"></i> Enviando...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8" v-else>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0" style="color: white;">
                            ¡Muchas gracias por tu valoración!
                        </h4>
                    </div>
                    <div class="card-body">
                        <p class="lead">
                            ¡Tu opinión ha sido enviada exitosamente! Gracias por ayudarnos a mejorar.
                        </p>
                        <p>
                            Te esperamos pronto.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["appointment", "user"],
    data() {
        return {
            qualification: 4,
            hoverQualification: 0,  
            comment: "",
            loading: false,
            submitted: false,
            user_name: this.appointment.user_name,
            service_name: this.appointment.service_name,
            appointment_date: this.appointment.appointment_date,
            completed: this.appointment.completed,
            uuid: this.appointment.uuid
        };
    },
    computed: {
        isSubmitDisabled() {
            return this.qualification === 0 || this.comment.trim() === '' || this.submitted;
        },
        ratingText() {
            const rating = this.hoverQualification > 0 ? this.hoverQualification : this.qualification;
            const texts = [
                '',
                'Muy malo',
                'Malo',
                'Regular',
                'Bueno',
                'Excelente'
            ];
            return texts[rating];
        }
    },
    mounted() {
        
    },
    methods: {
        setRating(value) {
            this.qualification = value;
        },
        hoverRating(value) {
            this.hoverQualification = value;
        },
        resetHover() {
            this.hoverQualification = 0;
        },
        formatDate(date) {
            if (!date) return '';
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(date).toLocaleDateString('es-ES', options);
        },
        formatTime(time) {
            if (!time) return '';
            return time;
        },
        async submitRating() {
            if (this.isSubmitDisabled) return;
            
            this.loading = true;
            
            try {
                const response = await this.$http.post('/caja/estilista/appointment-comment', {
                    uuid: this.uuid,
                    comment: this.comment,
                    qualification: this.qualification,
                    completed: true
                });
                
                this.submitted = true;
                this.loading = false;
                
                this.$showSAlert('¡Gracias por tu valoración!', 'Tu opinión es muy importante para nosotros');
                
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
                
            } catch (error) {
                this.loading = false;
                console.error('Error al enviar la valoración:', error);
                this.$swal({
                    title: 'Error',
                    text: 'No se pudo enviar tu valoración. Por favor, intenta de nuevo.',
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
            }
        }
    }
};
</script>

<style>
.rating-stars {
    display: inline-flex;
    gap: 10px;
    cursor: pointer;
}
.rating-stars i {
    transition: all 0.2s ease;
}
.rating-stars i:hover {
    transform: scale(1.2);
}
</style>
