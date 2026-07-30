/**
 * Jhontra PLO5 — theme.js
 * Age gate, menu movil, breakpoints por JS, barra de progreso y reveal on scroll.
 * Extraido 1:1 del <script> inline de footer.php. Sin cambios de comportamiento.
 */
(function(){
  /* Age gate */
  var ag = document.getElementById('jt-age-gate');
  try { if(localStorage.getItem('jt_age_ok')!=='1') ag.style.display=''; } catch(e){ ag.style.display=''; }
  document.getElementById('jt-age-yes').addEventListener('click', function(){
    try { localStorage.setItem('jt_age_ok','1'); } catch(e){}
    ag.style.display='none';
  });

  /* Mobile menu */
  var btn = document.getElementById('jt-mobile-btn');
  var menu = document.getElementById('jt-mobile-menu');
  btn.addEventListener('click', function(){
    var open = menu.style.display !== 'none';
    menu.style.display = open ? 'none' : 'flex';
    btn.setAttribute('aria-expanded', !open);
  });
  document.addEventListener('keydown', function(e){
    if(e.key==='Escape' && menu.style.display!=='none'){ menu.style.display='none'; btn.setAttribute('aria-expanded','false'); btn.focus(); }
  });

  /* Responsive */
  function applyR(){
    var w = window.matchMedia('(min-width:860px)').matches;
    var m = window.matchMedia('(min-width:620px)').matches;
    document.getElementById('jt-desktop-nav').style.display = w ? 'flex' : 'none';
    document.getElementById('jt-desktop-cta').style.display = w ? 'inline-flex' : 'none';
    document.getElementById('jt-mobile-btn').style.display = w ? 'none' : 'grid';
    if(w) menu.style.display = 'none';
    var fg = document.getElementById('jt-footer-grid');
    if(fg) fg.style.gridTemplateColumns = w ? '1.4fr 1fr 1fr 1fr' : (m ? '1fr 1fr' : '1fr');
    var ag2 = document.querySelectorAll('[data-archive-grid]');
    ag2.forEach(function(el){ el.style.gridTemplateColumns = window.matchMedia('(min-width:900px)').matches ? 'minmax(0,1fr) 320px' : '1fr'; });
    var pg = document.querySelectorAll('[data-post-grid]');
    pg.forEach(function(el){ el.style.gridTemplateColumns = m ? 'repeat(2,1fr)' : '1fr'; });
    var sg = document.querySelectorAll('[data-single-grid]');
    sg.forEach(function(el){ el.style.gridTemplateColumns = window.matchMedia('(min-width:960px)').matches ? 'minmax(0,1fr) 300px' : '1fr'; });
    var toc = document.querySelectorAll('[data-toc-wrap]');
    toc.forEach(function(el){ el.style.position = window.matchMedia('(min-width:960px)').matches ? 'sticky' : 'static'; el.style.top = '90px'; });
    var rg = document.querySelectorAll('[data-related-grid]');
    rg.forEach(function(el){ el.style.gridTemplateColumns = m ? 'repeat(3,1fr)' : '1fr'; });
    var fl = document.getElementById('jt-fab-label');
    if(fl) fl.style.display = m ? 'inline' : 'none';
  }
  applyR();
  window.addEventListener('resize', applyR);

  /* Scroll progress bar (single post) */
  var bar = document.querySelector('[data-progress]');
  if(bar){
    window.addEventListener('scroll', function(){
      var d = document.documentElement;
      var max = (d.scrollHeight - d.clientHeight) || 1;
      bar.style.width = (Math.max(0, Math.min(1, (window.pageYOffset||d.scrollTop)/max)) * 100).toFixed(1) + '%';
    }, {passive:true});
  }

  /* Reveal on scroll */
  var els = Array.from(document.querySelectorAll('[data-reveal]'));
  els.forEach(function(el){ el.style.opacity='0'; el.style.transform='translateY(26px)'; el.style.transition='opacity 0.7s cubic-bezier(0.16,1,0.3,1), transform 0.7s cubic-bezier(0.16,1,0.3,1)'; });
  if('IntersectionObserver' in window){
    var io = new IntersectionObserver(function(entries){
      entries.forEach(function(e){
        if(e.isIntersecting){
          var el = e.target;
          var sibs = el.parentElement ? Array.from(el.parentElement.querySelectorAll(':scope > [data-reveal]')) : [el];
          el.style.transitionDelay = Math.min(Math.max(0, sibs.indexOf(el)) * 80, 320) + 'ms';
          el.style.opacity='1'; el.style.transform='none';
          io.unobserve(el);
        }
      });
    }, {threshold:0.12, rootMargin:'0px 0px -6% 0px'});
    els.forEach(function(el){ io.observe(el); });
  } else {
    els.forEach(function(el){ el.style.opacity='1'; el.style.transform='none'; });
  }
})();
