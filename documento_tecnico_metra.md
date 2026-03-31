# DOCUMENTO TÉCNICO: SISTEMA DE GESTIÓN METRA
## Arquitectura de Base de Datos Avanzada

**Fecha:** 31 de marzo de 2026  
**Proyecto:** METRA (Manejo Eficiente de Tablas, Reservaciones y Analítica)  
**Categoría:** Auditoría de Base de Datos para SaaS Gastronómico

---

## 1. INTRODUCCIÓN
El sistema **METRA** es una plataforma tipo SaaS (Software as a Service) diseñada para la optimización operativa de cafeterías y restaurantes. Su núcleo tecnológico reside en una base de datos relacional (MySQL) que gestiona no solo el almacenamiento de datos, sino también la lógica de integridad y automatización mediante componentes avanzados como disparadores, vistas y procedimientos almacenados. Este documento detalla la implementación y justificación de dicha arquitectura.

---

## 2. DESCRIPCIÓN DEL MODELO RELACIONAL
La base de datos sigue un esquema normalizado para garantizar la consistencia de los datos. Las entidades principales se dividen en tres capas operativas:

### A. Capa de Configuración y SaaS
*   **users**: Almacena los perfiles de Gerentes, Staff y Superadministradores.
*   **cafeterias**: Entidad central que vincula la ubicación, configuración de tiempos y el **slug** único para el acceso público.
*   **planes & suscripciones**: Controlan el acceso a las funcionalidades según el nivel de pago.

### B. Capa Operativa (Core)
*   **zonas & mesas**: Definen la distribución física del establecimiento. La tabla `mesas` incluye un estado booleano `esta_ocupada` gestionado por triggers.
*   **reservaciones**: Tabla crítica que registra el flujo de clientes, integrando columnas generadas para el cálculo de tiempos.
*   **detalle_ocupaciones**: Gestiona la ocupación real en tiempo de ejecución, vinculando mesas específicas con reservaciones o clientes espontáneos (*walk-ins*).

### C. Capa de Auditoría y Analítica
*   **bitacora_reservaciones**: Registro histórico de cambios de estado generado automáticamente por disparadores.
*   **resenas**: Almacena la retroalimentación del cliente para cálculos de reputación mediante subconsultas.

---

## 3. COMPONENTES DE BASE DE DATOS AVANZADA

### 3.1 Triggers (Disparadores)
Se implementaron triggers en dos niveles para desacoplar la lógica de integridad del código de aplicación:
1.  **Auditoría de Reservaciones**: Un set de 3 triggers (`INSERT`, `UPDATE`, `DELETE`) en la tabla `reservaciones` que alimenta la `bitacora_reservaciones`. Esto garantiza que cada cambio de estado quede registrado con marca de tiempo precisa sin intervención manual del backend.
2.  **Automatización de Disponibilidad**: Triggers en `detalle_ocupaciones` que actualizan automáticamente el campo `esta_ocupada` en la tabla `mesas`. Esto previene condiciones de carrera (*race conditions*) y asegura que una mesa siempre refleje su estado real.

### 3.2 Vistas (Views)
El sistema utiliza vistas para simplificar consultas complejas y mejorar la seguridad:
*   **vw_reporte_diario**: Centraliza las métricas de operación diaria (total de reservas, cancelaciones, no-shows) agrupadas por cafetería, facilitando la generación de reportes gerenciales.
*   **vw_analitica_gerente_general**: Una abstracción que permite al backend consultar KPIs de rendimiento sin realizar costosos JOINS en cada petición.

### 3.3 Vista Materializada (Simulada)
Dada la ausencia de soporte nativo para vistas materializadas en MySQL, se implementó una **tabla de métricas mensuales** (`mv_metricas_mensuales`) que actúa como snapshot. Esta se actualiza periódicamente mediante el procedimiento almacenado `sp_refresh_mv_metricas_mensuales`, permitiendo consultas instantáneas sobre datos históricos masivos.

### 3.4 Columnas Generadas (Generated Columns)
Se optimizó el almacenamiento mediante el uso de columnas virtuales:
*   `duracion_min`: Calcula automáticamente la diferencia en minutos entre la hora de inicio y fin de una reserva.
*   `dias_vigencia`: En la tabla de promociones, calcula el periodo de validez sin necesidad de procesamiento en PHP.

### 3.5 Estrategia de Indexación
Para garantizar respuestas en milisegundos superiores a los estándares de la industria, se definieron:
*   **Índices Individuales**: En todas las llaves foráneas (FK) para optimizar los JOINS.
*   **Índices Combinados**: Especialmente en la tabla `reservaciones` (`cafe_id`, `fecha`, `estado`), lo cual acelera drásticamente el renderizado del dashboard diario.

---

## 4. COHERENCIA BACKEND Y BASE DE DATOS
La arquitectura de METRA sigue el principio de "Base de Datos Inteligente". Mientras que Laravel (PHP) gestiona la autenticación, validación de negocio compleja y las interfaces de usuario, la base de datos se encarga de la **integridad referencial** y la **consistencia del estado físico** (como la ocupación de mesas).

Se han evitado malas prácticas comunes:
*   **Eliminación de SELECT ***: Todas las consultas críticas seleccionan columnas específicas para reducir la carga de E/S.
*   **Subconsultas Optimizadas**: El uso de `Nested SELECTs` en controladores permite calcular estadísticas (como promedios de reseñas) en el motor de BD, donde es más eficiente.

---

## 5. CONCLUSIÓN TÉCNICA
La implementación de estas técnicas avanzadas en la base de datos de METRA permite que el sistema sea escalable, auditable y de alto rendimiento. El desacoplamiento de la lógica de auditoría y disponibilidad hacia la capa de datos asegura que la información permanezca íntegra incluso si se accede a ella desde múltiples clientes o interfaces, cumpliendo con los más altos estándares de desarrollo de software empresarial.
