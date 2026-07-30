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


---

# Aplicado en producción el 30/07/2026

Hecho desde Apariencia → Editor de archivos del tema, con `wp-admin`.

1. **`header.php` reescrito.** Pasó de 463 a 4198 caracteres. Header completo con
   age gate, logo J♠ y la nav unificada de 6 items. Verificado en vivo: la nav
   sale en todas las páginas del blog y marca "Blog / Noticias" como activa.

2. **`front-page.html` corregido.** 16 reemplazos, 73000 → 73202 caracteres:
   los 9 WhatsApp rotos, "Blog / Noticias" en la nav de escritorio y móvil, y
   los 5 enlaces que apuntaban a `href="#"` ahora van a `/blog/`.
   Verificado en vivo: 9 enlaces de WhatsApp, 0 rotos.

3. **`functions.php` reparado.** Tenía doble codificación UTF-8: los bytes
   correctos habían pasado por un `utf8_encode()` de más en algún guardado
   anterior. Las migas de pan salían como `Inicio â€º Blog â€º Mindset`.
   Se decodificó a UTF-8 real (4504 → 4483 caracteres, que coincide exactamente
   con el archivo de este repo) y se guardó. Verificado en vivo:
   `Inicio › Blog › Mindset › …`.

4. **Página "Inicio"** creada vacía, id 21. La página "Blog" es la id 6.

5. **Caché de LiteSpeed purgada.**

## Lo único que falta

**Ajustes → Lectura.** El control de seguridad de la sesión de Claude bloquea
modificar ajustes del sitio, así que este paso lo tiene que dar una persona:

- Tu página de inicio muestra: **Una página estática**
- Página de inicio: **Inicio**
- Página de entradas: **Blog**
- Guardar cambios

Sin esto, `/blog/` sigue siendo una página vacía y las 6 entradas no tienen
listado. La portada NO cambia de aspecto: `front-page.php` la sigue
interceptando con `readfile()` + `exit`.

Después conviene purgar LiteSpeed otra vez.

## Aviso sobre la codificación

Cualquier herramienta que vuelva a guardar los archivos del tema pasándolos por
`utf8_encode()` va a repetir el problema de las migas de pan. Si vuelves a ver
`â€º` o `Ã©` en el sitio, es eso. Los archivos de este repositorio están en
UTF-8 correcto.

## Medición de la nav

Con 6 items la nav de escritorio necesita 866 px. El breakpoint que la muestra
está en 860 px, así que entre 860 y 900 px va justa (0 px de margen a 860 px,
34 px a 900 px). De 900 px en adelante sobra espacio. Si se quiere margen de
seguridad, subir el breakpoint de 860 a 900 px en `assets/js/theme.js`.
