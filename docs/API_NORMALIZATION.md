# Normalización de Respuestas API para DNI/RUC

## Descripción

Este mixin (`ApiResponseNormalizer`) está diseñado para normalizar las respuestas de diferentes APIs de consulta de DNI y RUC, asegurando que independientemente de la estructura de la respuesta original, el sistema siempre reciba los datos en un formato consistente.

## Problema Solucionado

Antes de esta implementación, diferentes APIs devolvían estructuras ligeramente diferentes:

### API 1 - Respuesta:
```json
{
    "success": true,
    "data": {
        "numero": "78718846",
        "nombre_completo": "HUAMAN PEZO, JOSE OCTAVIO",
        "nombres": "JOSE OCTAVIO",
        "apellido_paterno": "HUAMAN",
        "apellido_materno": "PEZO",
        "ubigeo": ["19", "1903", "190306"]
    }
}
```

### API 2 - Respuesta:
```json
{
    "status": 200,
    "success": true,
    "data": {
        "numero": "93380568",
        "nombres": "DAYANA",
        "apellido_paterno": "VIVANCO",
        "apellido_materno": "SERALAYAN", 
        "nombre_completo": "VIVANCO SERALAYAN, DAYANA",
        "ubigeo": ["12", "1203", "120303"]
    }
}
```

## Solución Implementada

El mixin `ApiResponseNormalizer` normaliza ambas respuestas a una estructura consistente, garantizando que todos los campos necesarios estén disponibles con valores por defecto apropiados.

## Uso

### 1. Importar y usar el mixin:

```javascript
import ApiResponseNormalizer from "../../mixins/ApiResponseNormalizer";

export default {
    mixins: [ApiResponseNormalizer],
    // ... resto del componente
}
```

### 2. Usar en el método searchNumber:

```javascript
searchNumber(rawData) {
    // Normaliza los datos antes de procesarlos
    const data = this.normalizeApiResponse(rawData);
    
    // Ahora puedes usar data con garantía de estructura consistente
    this.form.name = (this.form.identity_document_type_id === "1")
        ? data.nombre_completo
        : data.nombre_o_razon_social;
        
    if (data.ubigeo && data.ubigeo.length > 0) {
        this.form.department_id = data.ubigeo[0];
        // ... más lógica
    }
}
```

## Archivos Actualizados

Los siguientes archivos han sido actualizados para usar la normalización:

1. `resources/js/views/persons/form.vue` - Archivo principal con normalización completa
2. `modules/Order/Resources/assets/js/views/dispatchers/form.vue`
3. `modules/Order/Resources/assets/js/views/drivers/form.vue`
4. `resources/js/views/dispatches/drivers/form.vue`
5. `resources/js/views/dispatches/dispatchers/form.vue`

## Campos Normalizados

La función `normalizeApiResponse()` garantiza que los siguientes campos estén siempre disponibles:

### Persona Natural (DNI):
- `numero`: Número de documento
- `nombre_completo`: Nombre completo formateado
- `nombres`: Nombres de la persona
- `apellido_paterno`: Apellido paterno
- `apellido_materno`: Apellido materno
- `fecha_nacimiento`: Fecha de nacimiento
- `sexo`: Sexo de la persona
- `estado_civil`: Estado civil

### Ubicación:
- `departamento`: Departamento
- `provincia`: Provincia
- `distrito`: Distrito
- `direccion`: Dirección específica
- `direccion_completa`: Dirección completa formateada
- `ubigeo`: Array con códigos de ubicación [dept, prov, dist]

### Persona Jurídica (RUC):
- `nombre_o_razon_social`: Razón social de la empresa
- `condicion`: Condición del contribuyente
- `estado`: Estado del contribuyente

## Beneficios

1. **Consistencia**: Independientemente de qué API responda, el frontend recibe siempre la misma estructura
2. **Mantenibilidad**: Un solo punto para manejar diferencias entre APIs
3. **Robustez**: Valores por defecto previenen errores por campos undefined
4. **Escalabilidad**: Fácil añadir nuevas APIs o campos

## Próximos Pasos Recomendados

1. **Aplicar a otros formularios**: Buscar otros archivos que usen `searchNumber` y aplicar la misma normalización
2. **Testing**: Crear tests unitarios para validar la normalización con diferentes estructuras de respuesta
3. **Documentación de Backend**: Documentar las diferencias entre APIs para facilitar futuras integraciones
4. **Logging**: Considerar añadir logging para monitorear qué API está respondiendo en cada consulta