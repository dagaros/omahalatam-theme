<?php
/**
 * Footer global: banda CTA, footer de 4 columnas, aviso 18+ y FAB de WhatsApp.
 * El JS de comportamiento está en assets/js/theme.js.
 *
 * @package jhontra-theme
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
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
        <a href="<?php echo esc_url( jt_whatsapp_url() ); ?>" class="jt-btn-gold jt-btn-sweep" target="_blank" rel="noopener"><span>✆</span> Hablar con Jhontra</a>
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
<a href="<?php echo esc_url( jt_whatsapp_url() ); ?>" class="jt-fab" target="_blank" rel="noopener" aria-label="Contactar por WhatsApp">
  <span class="jt-fab__icon">✆</span> <span class="jt-fab__label" id="jt-fab-label">WhatsApp</span>
</a>

<?php wp_footer(); ?>
</body>
</html>
