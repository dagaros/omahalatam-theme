/**
 * Jhontra PLO5 — single-toc.js
 * Genera la tabla de contenidos del post a partir de los <h2> del contenido.
 * Extraido 1:1 del <script> inline de single.php.
 */
(function(){
  var prose = document.querySelector('.jt-prose');
  var nav = document.getElementById('jt-toc-nav');
  if(!prose || !nav) return;
  var h2s = prose.querySelectorAll('h2');
  if(!h2s.length) { var tw = document.querySelector('[data-toc-wrap]'); if(tw) tw.style.display='none'; return; }
  h2s.forEach(function(h,i){
    var id = 's-' + (i+1);
    h.id = id;
    var a = document.createElement('a');
    a.href = '#' + id;
    a.textContent = h.textContent;
    nav.appendChild(a);
  });
})();
