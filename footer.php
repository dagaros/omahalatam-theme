<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
</main>

<!-- CTA Band -->
<section class="jt-cta-band">
  <div class="jt-cta-band__inner">
    <div class="jt-cta-band__glow"></div>
    <div class="jt-cta-band__content">
      <div class="jt-pill">Promociones exclusivas</div>
      <h2>¿Quieres los <span class="jt-gold">mejores bonos</span> en las salas donde ya juegas?</h2>
      <p>Escríbele a Jhontra y accede a las condiciones y bonos de bienvenida más competitivos de LATAM en Suprema, PPPoker y más clubes asociados. Sin costo, sin letra pequeña.</p>
      <div class="jt-cta-band__btns">
        <a href="https://wa.me/573107114689" class="jt-btn-gold jt-btn-sweep" target="_blank" rel="noopener"><span>✆</span> Hablar con Jhontra</a>
        <a href="<?php echo esc_url( home_url('/#clubes') ); ?>" class="jt-btn-ghost">Ver clubes asociados</a>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="jt-footer">
  <div class="jt-footer__inner">
    <div class="jt-footer__grid" id="jt-footer-grid">
      <!-- Brand -->
      <div>
        <div class="jt-footer__brand">
          <div class="jt-logo__card jt-logo__card--sm">
            <div class="jt-logo__shadow"></div>
            <div class="jt-logo__face">
              <span class="jt-logo__corner jt-logo__corner--tl">J<br>♠</span>
              <span class="jt-logo__corner jt-logo__corner--br">J<br>♠</span>
              <svg viewBox="0 0 60 84" class="jt-logo__knave" aria-hidden="true"><line x1="10" y1="42" x2="50" y2="42" stroke="#2A2005" stroke-width="1.6"/><g fill="#2A2005"><g id="knaveFt"><path d="M24 13 h12 v3 l-2 -2 -2 2 -2 -2 -2 2 -2 -2 z"/><rect x="24" y="16" width="12" height="2.4"/><circle cx="30" cy="24" r="4.6"/><path d="M24.5 30 q5.5 -3 11 0 l2 10 h-15 z"/><path d="M40 40 l-3.5 -9 5 2.5 z"/></g><use href="#knaveFt" transform="rotate(180 30 42)"/></g></svg>
            </div>
          </div>
          <span class="jt-logo__name">Jhontra</span>
        </div>
        <p class="jt-footer__desc">Autoridad de Omaha 5 Cartas en Latinoamérica. Contenido gratuito, rakeback competitivo y comunidad.</p>
      </div>
      <!-- Links -->
      <div>
        <div class="jt-footer__heading">Enlaces rápidos</div>
        <div class="jt-footer__links">
          <a href="<?php echo esc_url( home_url('/#acerca') ); ?>">Acerca de Jhontra</a>
          <a href="<?php echo esc_url( home_url('/#clubes') ); ?>">Suprema Poker</a>
          <a href="<?php echo esc_url( home_url('/#clubes') ); ?>">PPPoker</a>
          <a href="<?php echo esc_url( home_url('/blog/') ); ?>">Blog · Análisis y Contenido</a>
          <a href="<?php echo esc_url( home_url('/#contacto') ); ?>">Contacto</a>
        </div>
      </div>
      <!-- Social -->
      <div>
        <div class="jt-footer__heading">Redes sociales</div>
        <div class="jt-footer__links">
          <a href="#" target="_blank" rel="noopener">YouTube</a>
          <a href="#" target="_blank" rel="noopener">Instagram</a>
          <a href="#" target="_blank" rel="noopener">X (Twitter)</a>
          <a href="#" target="_blank" rel="noopener">TikTok</a>
          <a href="#" target="_blank" rel="noopener">Telegram</a>
        </div>
      </div>
      <!-- Legal -->
      <div>
        <div class="jt-footer__heading">Legal</div>
        <div class="jt-footer__links">
          <a href="#">Términos y Condiciones</a>
          <a href="#">Política de Privacidad</a>
          <a href="#">Política de Cookies</a>
        </div>
      </div>
    </div>

    <!-- 18+ Warning -->
    <div class="jt-footer__age-warn">
      <div class="jt-footer__age-badge">18+</div>
      <p>El poker es un juego para mayores de 18 años. Juega con responsabilidad. Recursos de ayuda: <a href="https://www.jugarbien.es" target="_blank" rel="noopener">jugarbien.es</a> · <a href="https://www.jugadoresanonimos.org" target="_blank" rel="noopener">jugadoresanonimos.org</a></p>
    </div>

    <p class="jt-footer__affiliate">Este sitio contiene enlaces de afiliado. Jhontra recibe una comisión por los jugadores que se registran a través de sus códigos de referido. Esto no tiene costo adicional para ti.</p>
    <div class="jt-footer__copy">© <?php echo date('Y'); ?> Jhontra · PLO5 · Todos los derechos reservados.</div>
  </div>
</footer>

<!-- WhatsApp FAB -->
<a href="https://wa.me/573107114689" class="jt-fab" target="_blank" rel="noopener" aria-label="Contactar por WhatsApp">
  <span class="jt-fab__icon">✆</span> <span class="jt-fab__label" id="jt-fab-label">WhatsApp</span>
</a>

<script>
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
</script>
<?php wp_footer(); ?>
</body>
</html>
