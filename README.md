# METRA - Sistema SaaS de Gestión de Reservas

METRA es una plataforma premium diseñada para digitalizar y optimizar el flujo de reservaciones en cafeterías y restaurantes. Este ecosistema integra un Panel de Administración web para gerentes y una aplicación móvil nativa para el personal de sala (Staff), eliminando el uso de listas físicas y automatizando la ocupación de mesas.

## 🚀 Características Principales

- **Dashboard Analítico**: Estadísticas en tiempo real de ocupación, fidelidad de clientes y métricas de negocio.
- **Gestión de Reservas Digital**: Sistema intuitivo para comensales con confirmación vía email.
- **Panel de Superadmin**: Control global de cafeterías, planes de suscripción y validación de comprobantes.
- **Integración Staff**: App Android funcional para que el equipo operativo gestione el día a día desde sus dispositivos.
- **Marketing y Promociones**: Herramientas integradas para crear beneficios dinámicos según fechas y horarios.

## 🛠️ Requisitos Técnicos

- **PHP**: 8.2+
- **Framework**: Laravel 11.x
- **Base de Datos**: MySQL / MariaDB
- **Frontend**: Vite + CSS Vanilla (Variables) + JS Alpine/Vanilla
- **Servidor Web**: Apache (Laragon/XAMPP recomendado)

## 📦 Instalación Rápida

1. **Clonar el repositorio**:
   ```bash
   git clone https://github.com/Kenny-vg/METRA-app_web.git
   cd METRA-app_web
   ```

2. **Instalar dependencias**:
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Configuración del Entorno**:
   - Copia `.env.example` a `.env`.
   - Genera la Application Key: `php artisan key:generate`.
   - Configura las credenciales de tu base de datos en el archivo `.env`.

4. **Base de Datos**:
   ```bash
   php artisan migrate --seed
   ```

5. **Iniciar Servidor**:
   - Si usas el servidor interno de PHP: `php artisan serve`.
   - O vía Laragon apuntando al directorio `public/`.

## 🔒 Seguridad y Roles

La plataforma maneja tres niveles de acceso claramente definidos:
- **Superadmin**: Gestión global del SaaS.
- **Gerente**: Dueño del negocio / Cafetería.
- **Staff (App)**: Operativo del restaurante.

## 📬 Contacto y Soporte

Desarrollado para la mejora operativa de negocios modernos.

- **GitHub**: [Kenny-vg](https://github.com/Kenny-vg)
- **Repo**: [METRA Project](https://github.com/Kenny-vg/METRA-app_web)

---
*© 2026 METRA Platform. Todos los derechos reservados.*
