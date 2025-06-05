# Exportación a Excel de Solicitudes

## Descripción
Esta funcionalidad permite exportar todos los datos de una solicitud de crédito individual a un archivo Excel con formato profesional.

## Archivos modificados/creados:

### 1. `exportSolicitudExcel.php`
- **Propósito**: Archivo principal que genera el archivo Excel
- **Funcionalidad**: 
  - Consulta todos los datos de la solicitud desde la base de datos
  - Incluye datos personales, laborales, financieros, del cónyuge, inmuebles y vehículos
  - Aplica formato profesional con colores y estilos
  - Formatea números como moneda colombiana
  - Genera un archivo Excel descargable

### 2. `editSolicitud.php` (modificado)
- **Cambios realizados**:
  - Agregado botón "Exportar a Excel" junto al botón de imprimir
  - Agregada función JavaScript `exportarExcel()` 
  - Mejorados los estilos CSS para los botones

## Características del Excel generado:

### Estructura del documento:
1. **Encabezado principal** - Título de la solicitud
2. **Información básica** - ID y fecha de solicitud
3. **Datos personales** - Información del asociado
4. **Datos del crédito** - Monto, plazo, línea de crédito
5. **Datos laborales** - Información de empleo
6. **Datos financieros** - Ingresos, egresos, activos y pasivos
7. **Relación de inmuebles** - Si existen
8. **Relación de vehículos** - Si existen
9. **Otros activos** - Ahorros adicionales
10. **Datos del cónyuge** - Información personal y laboral

### Formato aplicado:
- **Encabezados**: Fondo azul con texto blanco y fuente bold
- **Secciones**: Fondo azul claro con texto centrado
- **Etiquetas**: Fondo gris claro con texto bold
- **Valores monetarios**: Formato de moneda colombiana ($XXX.XXX)
- **Bordes**: Aplicados a todas las celdas
- **Ancho automático**: Columnas ajustadas automáticamente

## Cómo usar:

1. **Acceder a editar solicitud**: Ir a la página de edición de cualquier solicitud
2. **Hacer clic en "Exportar a Excel"**: El botón se encuentra en la parte superior derecha
3. **Descarga automática**: El archivo se descargará con el nombre `Solicitud_[CEDULA]_[FECHA].xlsx`

## Requisitos técnicos:

- **PhpSpreadsheet**: Librería instalada via Composer
- **PHP 7.4+**: Versión mínima requerida
- **Extensión ZIP**: Para generar archivos Excel
- **Permisos de escritura**: En el directorio temporal del servidor

## Nombre del archivo generado:
`Solicitud_[CEDULA_ASOCIADO]_[FECHA_ACTUAL].xlsx`

Ejemplo: `Solicitud_12345678_04-06-2025.xlsx`

## Manejo de errores:
- Verifica autenticación del usuario
- Valida que existe el ID de solicitud
- Maneja datos vacíos con valores por defecto
- Incluye manejo de errores de base de datos

## Datos incluidos:
✅ Todos los campos de datos personales
✅ Información del crédito solicitado  
✅ Datos laborales completos
✅ Información financiera (ingresos/egresos)
✅ Activos y pasivos
✅ Datos del cónyuge (si aplica)
✅ Relación de inmuebles
✅ Relación de vehículos
✅ Otros activos

La exportación incluye absolutamente toda la información disponible en el formulario de solicitud.
