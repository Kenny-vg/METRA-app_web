// public/js/metra-utils.js

/**
 * Obtiene el slug de la cafetería directamente desde la URL actual.
 * Esto permite desacoplar el frontend de los parámetros inyectados por Blade.
 */
function getSlugFromUrl() {
    const segments = window.location.pathname
        .split('/')
        .filter(segment => segment.length > 0);

    // Asume que el slug siempre es el último segmento de la URL 
    // (Ej: /reservar/el-cafe-slug o /detalles/el-cafe-slug)
    return segments[segments.length - 1];
}
