/**
 * Mixin para normalizar respuestas de APIs de consulta DNI/RUC
 * Permite manejar diferentes estructuras de respuesta de APIs
 */
export default {
    methods: {
        /**
         * Normaliza las respuestas de diferentes APIs de consulta DNI/RUC
         * para que tengan la misma estructura
         * 
         * @param {Object} rawData - Los datos crudos recibidos de la API
         * @returns {Object} - Datos normalizados con estructura consistente
         */
        normalizeApiResponse(rawData) {
            // Verificar si los datos están dentro de una propiedad 'data'
            const data = rawData.data || rawData;
            
            // Estructura normalizada basada en el estándar más completo
            const normalized = {
                // Campos básicos de persona natural
                numero: data.numero || '',
                nombre_completo: data.nombre_completo || '',
                nombres: data.nombres || '',
                apellido_paterno: data.apellido_paterno || '',
                apellido_materno: data.apellido_materno || '',
                codigo_verificacion: data.codigo_verificacion || '',
                fecha_nacimiento: data.fecha_nacimiento || '',
                sexo: data.sexo || '',
                estado_civil: data.estado_civil || '',
                
                // Campos de ubicación
                departamento: data.departamento || '',
                provincia: data.provincia || '',
                distrito: data.distrito || '',
                direccion: data.direccion || '',
                direccion_completa: data.direccion_completa || '',
                ubigeo_reniec: data.ubigeo_reniec || '',
                ubigeo_sunat: data.ubigeo_sunat || '',
                ubigeo: Array.isArray(data.ubigeo) ? data.ubigeo : [],
                
                // Campos adicionales para RUC/empresas
                nombre_o_razon_social: data.nombre_o_razon_social || data.nombre_completo || '',
                condicion: data.condicion || '',
                estado: data.estado || ''
            };

            return normalized;
        }
    }
}