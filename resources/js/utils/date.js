// Utilidades de fecha
// Funciones pequeñas y seguras para parsear cadenas 'YYYY-MM-DD' como fecha local

export function parseLocalDateFromYYYYMMDD(dateStr) {
  if (!dateStr) return null;
  if (typeof dateStr === 'string' && /^\d{4}-\d{2}-\d{2}$/.test(dateStr)) {
    const parts = dateStr.split('-').map(Number);
    return new Date(parts[0], parts[1] - 1, parts[2]);
  }
  const d = new Date(dateStr);
  return isNaN(d.getTime()) ? null : d;
}

export function formatDateLongES(date) {
  if (!date) return '';
  const d = date instanceof Date ? date : new Date(date);
  if (isNaN(d.getTime())) return '';
  const options = { weekday: 'long', day: 'numeric', month: 'long' };
  let str = d.toLocaleDateString('es-ES', options);
  str = str.charAt(0).toUpperCase() + str.slice(1);
  str = str.replace(/,|\sde\s/g, ' ');
  str = str.replace(/\s+/g, ' ').trim();
  return str;
}

export default {
  parseLocalDateFromYYYYMMDD,
  formatDateLongES
};
