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
      <div class="jt-pill"><?php echo esc_html( jt_t('cta_pill') ); ?></div>
      <h2><?php echo esc_html( jt_t('cta_h2_a') ); ?><span class="jt-gold"><?php echo esc_html( jt_t('cta_h2_gold') ); ?></span><?php echo esc_html( jt_t('cta_h2_b') ); ?></h2>
      <p><?php echo esc_html( jt_t('cta_texto') ); ?></p>
      <div class="jt-cta-band__btns">
        <a href="<?php echo esc_url( jt_whatsapp_url() ); ?>" class="jt-btn-gold jt-btn-sweep" target="_blank" rel="noopener"><span>✆</span> <?php echo esc_html( jt_t('cta_wa') ); ?></a>
        <a href="<?php echo esc_url( jt_anchor_url('clubes') ); ?>" class="jt-btn-ghost"><?php echo esc_html( jt_t('cta_clubes') ); ?></a>
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
        <p class="jt-footer__desc"><?php echo esc_html( jt_t('f_desc') ); ?></p>
      </div>
      <!-- Links -->
      <div>
        <div class="jt-footer__heading"><?php echo esc_html( jt_t('f_enlaces') ); ?></div>
        <div class="jt-footer__links">
          <a href="<?php echo esc_url( jt_anchor_url('jhontra') ); ?>"><?php echo esc_html( jt_t('f_acerca') ); ?></a>
          <a href="<?php echo esc_url( jt_anchor_url('clubes') ); ?>">Suprema Poker</a>
          <a href="<?php echo esc_url( jt_anchor_url('clubes') ); ?>">PPPoker</a>
          <a href="<?php echo esc_url( jt_home_url('/blog/') ); ?>"><?php echo esc_html( jt_t('f_blog') ); ?></a>
          <a href="<?php echo esc_url( jt_anchor_url('empezar') ); ?>"><?php echo esc_html( jt_t('f_contacto') ); ?></a>
        </div>
      </div>
      <!-- Social -->
      <div>
        <div class="jt-footer__heading"><?php echo esc_html( jt_t('f_redes') ); ?></div>
        <div class="jt-footer__links">
          <a href="<?php echo esc_url( jt_youtube_url() ); ?>" target="_blank" rel="noopener">YouTube</a>
          <a href="#" target="_blank" rel="noopener">Instagram</a>
          <a href="#" target="_blank" rel="noopener">X (Twitter)</a>
          <a href="#" target="_blank" rel="noopener">TikTok</a>
          <a href="#" target="_blank" rel="noopener">Telegram</a>
        </div>
      </div>
      <!-- Legal -->
      <div>
        <div class="jt-footer__heading"><?php echo esc_html( jt_t('f_legal') ); ?></div>
        <div class="jt-footer__links">
          <a href="#"><?php echo esc_html( jt_t('f_terminos') ); ?></a>
          <a href="#"><?php echo esc_html( jt_t('f_privacidad') ); ?></a>
          <a href="#"><?php echo esc_html( jt_t('f_cookies') ); ?></a>
        </div>
      </div>
    </div>

    <!-- 18+ Warning -->
    <div class="jt-footer__age-warn">
      <div class="jt-footer__age-badge">18+</div>
      <p><?php echo esc_html( jt_t('f_edad') ); ?>
        <?php if ( jt_is_pt() ) : ?>
          <a href="https://jogadoresanonimos.org.br" target="_blank" rel="noopener">jogadoresanonimos.org.br</a> · <a href="https://www.cvv.org.br" target="_blank" rel="noopener">cvv.org.br</a>
        <?php else : ?>
          <a href="https://www.jugarbien.es" target="_blank" rel="noopener">jugarbien.es</a> · <a href="https://www.jugadoresanonimos.org" target="_blank" rel="noopener">jugadoresanonimos.org</a>
        <?php endif; ?></p>
    </div>

    <p class="jt-footer__affiliate"><?php echo esc_html( jt_t('f_afiliado') ); ?></p>
    <div class="jt-footer__copy">© <?php echo date('Y'); ?> Jhontra · PLO5 · <?php echo esc_html( jt_t('f_copy') ); ?></div>
  </div>
</footer>

<!-- WhatsApp FAB -->
<a href="<?php echo esc_url( jt_whatsapp_url() ); ?>" class="jt-fab" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( jt_t('f_wa_lbl') ); ?>">
  <span class="jt-fab__icon">✆</span> <span class="jt-fab__label" id="jt-fab-label">WhatsApp</span>
</a>

<?php wp_footer(); ?>
</body>
</html>
