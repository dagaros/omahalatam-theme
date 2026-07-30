# Jhontra PLO5 — tema WordPress de omahalatam.com

Tema a medida para [omahalatam.com](https://omahalatam.com), el sitio del Coach Jhontra: autoridad de **Omaha 5 Cartas (PLO5)** en Latinoamérica. Dark mode premium, blog editorial y embudo de afiliación a los clubes de Suprema y PPPoker.

Carpeta en el servidor: `wp-content/themes/jhontra-theme/`
Deploy: auto-deploy de Hostinger desde este repositorio.

---

## Estructura

```
jhontra-theme/
├── style.css                  Metadatos del tema (NO carga CSS)
├── functions.php              Solo carga los módulos de /inc
│
├── inc/
│   ├── setup.php              Soportes, tamaños de imagen, menús
│   ├── enqueue.php            CSS y JS  ← ojo con el ORDEN de carga
│   ├── template-tags.php      jt_reading_time, jt_breadcrumbs, jt_whatsapp…
│   ├── schema.php             JSON-LD (Article / WebSite)
│   └── cleanup.php            Head, extractos, comentarios, query, buscador
│
├── assets/
│   ├── css/
│   │   ├── base.css           Reset, tokens, tipografía, utilidades, botones
│   │   ├── layout.css         Nav, logo J♠, age gate, breadcrumbs, CTA, footer, FAB
│   │   ├── blog.css           Archivo, buscador, grid, sidebar, post
│   │   └── motion.css         prefers-reduced-motion  ← siempre de último
│   ├── js/
│   │   ├── theme.js           Age gate, menú móvil, breakpoints, progreso, reveal
│   │   └── single-toc.js      Tabla de contenidos del post
│   └── img/
│
├── template-parts/
│   ├── card-post.php          Tarjeta de post (variantes: full · compact)
│   └── sidebar-blog.php       Sidebar del blog
│
├── front-page.html            Portada: export estático, servido tal cual
├── front-page.php             Sirve front-page.html (con fallback)
├── home.php                   /blog/            → require archive.php
├── archive.php                Listado: blog, categorías y búsqueda
├── search.php                 Búsqueda         → require archive.php
├── single.php                 Post individual
├── page.php                   Páginas estáticas
├── 404.php                    Error 404
├── index.php                  Respaldo de la jerarquía
├── header.php                 Age gate + nav sticky
└── footer.php                 Banda CTA + footer + FAB de WhatsApp
```

---

## Reglas que no se rompen

**1. El orden del CSS.**
`base → layout → blog → motion`. Está definido con dependencias en `inc/enqueue.php`. `motion.css` tiene que quedar de último para que `prefers-reduced-motion` gane la cascada. Si metes un archivo nuevo, encadénalo con `array( 'jt-blog' )` o donde corresponda; no lo sueltes sin dependencia.

**2. La portada es un archivo estático.**
`front-page.html` se sirve con `readfile()` y `exit`, sin pasar por `wp_head()` ni `wp_footer()`. Trae su propio CSS y su propio JS embebidos. Ni WordPress ni los plugins le inyectan nada, y por eso el diseño se mantiene pixel a pixel.

Consecuencias prácticas:

- Para editar la portada, se edita `front-page.html`. No hay atajo.
- Los plugins de SEO, analytics o consentimiento **no** actúan ahí. Si necesitas un pixel o un tag, se pega a mano dentro del HTML.
- El editor de WordPress y Elementor no la ven.

**3. Los valores del CSS no se tocan a ojo.**
`assets/css/*` salió 1:1 del diseño aprobado. Verificación hecha: mismo conjunto de 244 reglas, mismos valores, `prefers-reduced-motion` de último. Cambiar un `padding` para "cuadrar" algo suele romper otra vista.

**4. El número de WhatsApp está centralizado.**
Se cambia en un solo lugar: `jt_whatsapp()` en `inc/template-tags.php`. De ahí sale a la nav, el footer, el FAB, los CTAs y el sidebar. No lo escribas a mano en las plantillas.

---

## Cómo hacer las cosas

### Publicar un artículo

Los posts viven en la base de datos, no en este repositorio. Se publican desde el escritorio de WordPress o por la REST API. Lo que sí se ajusta aquí es cómo se ven.

Al publicar:

- Asigna **una categoría** (alimenta el badge de la tarjeta, los breadcrumbs y los relacionados).
- Sube **imagen destacada** de 1200×675. Sin ella la tarjeta muestra el placeholder ♠.
- Escribe el **extracto** a mano; el automático corta en 30 palabras.
- Usa `H2` para las secciones: la tabla de contenidos del post se arma sola a partir de ellos.

### Crear una página nueva (Acerca, Suprema, PPPoker, Contacto)

Crea la página en WordPress y `page.php` la maqueta con el mismo sistema visual del post. Si una página necesita un layout propio, se agrega una plantilla con el encabezado `Template Name:` y se elige desde el editor. No hace falta CSS nuevo: reutiliza `jt-post-header`, `jt-prose`, `jt-aff`, `jt-inline-cta`.

### Agregar estilos

Al final de `assets/css/blog.css` si es del blog, de `layout.css` si es chrome global. Nombra las clases con el prefijo `jt-`. Sube la versión en `JT_ASSET_VER` (`inc/enqueue.php`) para romper la caché.

---

## Pendientes

- [ ] La nav del blog (Inicio · Acerca de · Clubes · Blog · Contacto) no coincide con la de la portada (Método · Jhontra · Clubes · Contenido · Empezar). Unificar.
- [ ] Enlaces de redes sociales en el footer: están en `#`.
- [ ] Páginas legales: Términos, Privacidad y Cookies apuntan a `#`.
- [ ] Faltan las páginas Acerca de, Suprema, PPPoker y Contacto como páginas reales (hoy son anclas de la portada).
- [ ] `screenshot.png` (1200×900) para el selector de temas de WordPress.
- [ ] Migrar la portada a plantilla PHP o a Elementor cuando se necesite editarla sin tocar código.

---

## Historial

- **2.1.0** — Reestructura: `/inc`, `/assets`, `/template-parts`. CSS dividido en 4 archivos manteniendo la cascada exacta. JS inline movido a archivos. Nuevas plantillas `page.php`, `404.php`, `search.php`, `front-page.php`. `front-page.html` recuperado del sitio en producción y puesto bajo control de versiones.
- **2.0.0** — Blog completo: archivo, post individual, sidebar.
- **1.0.0** — Versión inicial.
