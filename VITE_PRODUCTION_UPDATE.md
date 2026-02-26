# Actualización: Vite en Producción - METRA App

## Resumen de Cambios

Se ha actualizado completamente el proyecto para utilizar correctamente **Vite en producción**. Todos los cambios se han aplicado a las vistas Blade.

### ✅ Cambios Realizados

#### 1. **Agregación de `@vite` a vistas faltantes**
   
Las siguientes vistas ahora incluyen la directiva `@vite` para cargar CSS y JS compilados:
- ✅ `resources/views/public/registro-negocio.blade.php`
- ✅ `resources/views/public/confirmacion.blade.php`  
- ✅ `resources/views/public/layout_cliente.blade.php`

#### 2. **Eliminación de Cache Busting Manual**

Se ha removido `?v={{ time() }}` de todos los assets CSS locales. Vite maneja automáticamente el versionado en producción:

- ✅ `resources/views/superadmin/menu.blade.php`
- ✅ `resources/views/admin/menu.blade.php`
- ✅ `resources/views/public/login.blade.php`
- ✅ `resources/views/public/reservar.blade.php`
- ✅ `resources/views/public/bienvenida.blade.php`
- ✅ `resources/views/public/detalles.blade.php`
- ✅ `resources/views/public/confirmacion.blade.php`
- ✅ `resources/views/auth/register.blade.php`
- ✅ `resources/views/auth/login.blade.php`

#### 3. **Vistas Verificadas y Optimizadas**

Todas las vistas base ahora incluyen:
```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

### 📁 Estructura de Assets

**Ubicación en Producción:**
```
public/build/
├── manifest.json          (Mapeo de assets con hash)
└── assets/
    ├── app-[HASH].css     (CSS compilado y minificado)
    └── app-[HASH].js      (JS compilado y minificado)
```

### 🔄 Flujo de Compilación

**Desarrollo:**
```bash
npm run dev      # Inicia el servidor de Vite en http://localhost:5173
```

**Producción:**
```bash
npm run build    # Compila assets y genera manifest.json
```

### 📋 Checklist de Validación

- ✅ Todas las vistas principales tienen `@vite`
- ✅ Sin cache busting manual (`time()`)
- ✅ Manifest.json generado correctamente
- ✅ Assets compilados con hash único
- ✅ Bootstrap y Bootstrap Icons desde CDN (funcionalidad)
- ✅ Variables CSS (`variables.css`) cargadas sin `time()`
- ✅ Estilos globales (`estilos.css`) cargadas sin `time()`

### 🚀 Configuración Actual

**vite.config.js:**
```javascript
- laravel-vite-plugin configurado
- Tailwind CSS compilando
- Refresh mode habilitado
```

**package.json:**
```json
{
  "scripts": {
    "build": "vite build",
    "dev": "vite"
  },
  "devDependencies": {
    "laravel-vite-plugin": "^2.0.0",
    "tailwindcss": "^4.0.0",
    "vite": "^7.0.7"
  }
}
```

**Última Build (Verificada):**
```
✓ 53 modules transformed
✓ manifest.json: 0.33 kB (gzip: 0.17 kB)
✓ app.css: 47.61 kB (gzip: 8.93 kB)
✓ app.js: 36.37 kB (gzip: 14.68 kB)
✓ Built in 1.82s
```

### ⚙️ Variables de Entorno Recomendadas

Para producción, configurar en `.env`:

```env
APP_ENV=production
APP_DEBUG=false
ASSET_URL=/
VITE_ASSET_URL=/build/
```

### 📝 Notas Importantes

1. **Manifest.json es crítico**: En producción, Laravel busca `public/build/manifest.json`
2. **Build antes de deploy**: Ejecutar `npm run build` antes de desplegar
3. **Vite maneja versionado automáticamente**: No necesita cache busting adicional
4. **Assets CDN**: Bootstrap y Bootstrap Icons se cargan desde CDN para mejor rendimiento
5. **Tailwind configurado**: Configurado en `vite.config.js` para compilación automática

### 🔍 Para Verificar en Producción

Abrir DevTools → Network → Buscar `app-` en los archivos cargados. Deberían mostrar:
- Un archivo CSS con nombre: `app-[HASH].css`
- Un archivo JS con nombre: `app-[HASH].js`

Si los arquivos muestran hashes diferentes en cada build, ¡está funcionando correctamente!

---

**Fecha de Actualización:** 25 de Febrero, 2026
**Versión de Vite:** 7.0.7
**Versión de Laravel:** 12.0
