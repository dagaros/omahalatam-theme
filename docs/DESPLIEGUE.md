# Estado del servidor vs este repositorio

Revisado el 30/07/2026 desde Apariencia → Editor de archivos del tema.

## Qué está desincronizado

| Archivo | Servidor | Repo | Estado |
|---|---|---|---|
| `functions.php` | 4504 car. | 4504 car. | igual |
| `archive.php` | 8760 car. | igual | igual |
| `footer.php` | 8686 car. | igual | igual |
| `single.php` | igual | igual | igual |
| `blog-styles.css` | 29337 car. | igual | igual |
| `front-page.html` | 73284 bytes | recuperado | igual (antes del arreglo) |
| **`header.php`** | **463 car.** | 3775 car. | **ROTO** |

El `header.php` del servidor es un esqueleto: abre el documento y `<main>`. Sin nav,
sin logo, sin age gate. Por eso el blog no muestra menú.

## Bug encontrado en producción

Los 9 enlaces de WhatsApp de `front-page.html` tenían el número duplicado:

    wa.me/573107114689573107114689   →   wa.me/573107114689

WhatsApp responde "el número no está en WhatsApp". Ninguna conversión de la
portada llegaba. Corregido en este repo.

## Ajustes de Lectura

Portada = "Tus últimas entradas", así que `/blog/` es una página vacía y los 6
artículos publicados no tienen listado. Hay que dejarlo así:

- Tu portada muestra: **Una página estática**
- Página de inicio: **Inicio** (crear vacía; `front-page.php` la intercepta igual)
- Página de entradas: **Blog**

`front-page.php` hace `readfile()` + `exit`, así que la portada estática se sigue
sirviendo idéntica. Lo único que cambia es que `/blog/` pasa a renderizar
`home.php` → `archive.php`.

Después: purgar caché de LiteSpeed.

## Cómo aplicar el header en el servidor

`docs/header-para-servidor.php` es la versión **autónoma**: no llama a
`jt_nav_items()`, `jt_anchor_url()` ni `jt_whatsapp_url()`, porque el
`functions.php` del servidor todavía es el antiguo y esas funciones no existen
ahí. Pegar su contenido en Apariencia → Editor de archivos del tema → header.php.

Produce exactamente el mismo marcado que el `header.php` de este repo. Cuando se
despliegue el repo completo, el de `/inc` toma el relevo sin cambio visual.
