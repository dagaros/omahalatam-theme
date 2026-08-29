/**
 * Calculadora de equity — interfaz
 * El calculo vive en equity-worker.js. Aqui solo esta la interaccion.
 *
 * Configuracion desde PHP: window.JT_CALC = { variant, lang, workerUrl, i18n }
 */
(function () {
  'use strict';
  var CFG = window.JT_CALC;
  if (!CFG) return;
  var root = document.getElementById('jt-calc');
  if (!root) return;

  var T = CFG.i18n;
  var V = CFG.variant;
  var RANKS = ['A','K','Q','J','T','9','8','7','6','5','4','3','2'];
  var RV    = [12,11,10,9,8,7,6,5,4,3,2,1,0];
  var SUITS = [{g:'\u2660',c:'jt-sS',k:'s'},{g:'\u2665',c:'jt-sH',k:'h'},
               {g:'\u2666',c:'jt-sD',k:'d'},{g:'\u2663',c:'jt-sC',k:'c'}];

  var glyph = function (i) { return { r: RANKS[12 - i % 13], p: SUITS[(i/13)|0].g, c: SUITS[(i/13)|0].c }; };
  var label = function (i) { return RANKS[12 - i % 13] + SUITS[(i/13)|0].k; };

  var POS = [{id:'UTG',x:32,y:5},{id:'HJ',x:96,y:32},{id:'CO',x:88,y:82},
             {id:'BTN',x:50,y:100},{id:'SB',x:12,y:82},{id:'BB',x:4,y:32}];

  var seats = POS.map(function (p, i) { return { id:p.id, x:p.x, y:p.y, i:i, on:(i===3||i===5), cards:[] }; });
  var board = [], target = { t:'seat', i:3 }, pendingRank = null, running = false;
  var worker = null;

  var $ = function (s) { return root.querySelector(s); };
  var used = function () {
    var u = {}; board.forEach(function (c) { u[c] = 1; });
    seats.forEach(function (s) { if (s.on) s.cards.forEach(function (c) { u[c] = 1; }); });
    return u;
  };

  function cardEl(idx, cb, extra) {
    var d = document.createElement('div');
    if (idx == null) { d.className = 'jt-card is-slot ' + (extra || ''); }
    else {
      var g = glyph(idx);
      d.className = 'jt-card ' + g.c + ' ' + (extra || '');
      d.innerHTML = '<span class="r">' + g.r + '</span><span class="p">' + g.p + '</span>';
    }
    d.onclick = function (e) { e.stopPropagation(); cb(); };
    return d;
  }
  function miniEl(idx) {
    var g = glyph(idx), d = document.createElement('div');
    d.className = 'jt-mini ' + g.c;
    d.innerHTML = '<span class="r">' + g.r + '</span><span class="p">' + g.p + '</span>';
    return d;
  }
  function nextSlot() {
    if (target.t === 'board') return board.length < 5 ? board.length : -1;
    var s = seats[target.i];
    return s.cards.length < V ? s.cards.length : -1;
  }

  function renderTable() {
    var felt = $('.jt-felt');
    Array.prototype.slice.call(felt.querySelectorAll('.jt-seat')).forEach(function (e) { e.remove(); });

    seats.forEach(function (s) {
      var el = document.createElement('div');
      el.className = 'jt-seat' + (target.t === 'seat' && target.i === s.i ? ' is-sel' : '') + (s.on ? '' : ' is-off');
      el.style.left = s.x + '%'; el.style.top = s.y + '%';
      el.onclick = function () { if (!s.on) s.on = true; target = { t:'seat', i:s.i }; pendingRank = null; draw(); };

      var inner = document.createElement('div'); inner.className = 'jt-seat-inner';
      var head = document.createElement('div'); head.className = 'jt-seat-head';
      head.innerHTML = '<span class="jt-pos">' + s.id + '</span>';
      var eq = document.createElement('span'); eq.className = 'jt-seat-eq'; eq.id = 'jt-eq' + s.i; eq.textContent = '\u2014';
      head.appendChild(eq);
      var tg = document.createElement('button');
      tg.type = 'button'; tg.className = 'jt-toggle'; tg.textContent = s.on ? '\u2212' : '+';
      tg.setAttribute('aria-label', s.on ? T.retirar : T.activar);
      tg.onclick = function (e) {
        e.stopPropagation(); s.on = !s.on;
        if (!s.on) s.cards = []; else target = { t:'seat', i:s.i };
        reset(); draw();
      };
      head.appendChild(tg); inner.appendChild(head);

      var hand = document.createElement('div'); hand.className = 'jt-hand';
      var isT = target.t === 'seat' && target.i === s.i, ns = isT ? nextSlot() : -1;
      for (var i = 0; i < V; i++) {
        (function (i) {
          if (s.cards[i] != null) {
            hand.appendChild(cardEl(s.cards[i], function () {
              s.cards.splice(i, 1); target = { t:'seat', i:s.i }; reset(); draw();
            }));
          } else {
            hand.appendChild(cardEl(null, function () { target = { t:'seat', i:s.i }; draw(); }, i === ns ? 'is-next' : ''));
          }
        })(i);
      }
      inner.appendChild(hand);
      var bar = document.createElement('div'); bar.className = 'jt-eqbar-mini';
      bar.innerHTML = '<i id="jt-mb' + s.i + '"></i>'; inner.appendChild(bar);
      el.appendChild(inner); felt.appendChild(el);
    });

    var bs = $('.jt-board-slots'); bs.innerHTML = '';
    var ns = target.t === 'board' ? nextSlot() : -1;
    for (var i = 0; i < 5; i++) {
      (function (i) {
        if (i === 3 || i === 4) { var g = document.createElement('div'); g.className = 'jt-street-gap'; bs.appendChild(g); }
        if (board[i] != null) bs.appendChild(cardEl(board[i], function () { board.splice(i,1); target={t:'board'}; reset(); draw(); }));
        else bs.appendChild(cardEl(null, function () { target = { t:'board' }; draw(); }, i === ns ? 'is-next' : ''));
      })(i);
    }
  }

  function renderDeck() {
    var deck = $('.jt-deck'); deck.innerHTML = ''; var u = used();
    SUITS.forEach(function (s, si) {
      var row = document.createElement('div'); row.className = 'jt-deck-row';
      RANKS.forEach(function (r, ri) {
        var idx = si * 13 + RV[ri];
        var el = document.createElement('div');
        el.className = 'jt-dcard ' + s.c + (u[idx] ? ' is-used' : '') + (pendingRank === RV[ri] ? ' is-hl' : '');
        el.setAttribute('role', 'button');
        el.setAttribute('aria-label', r + ' ' + s.k);
        el.innerHTML = '<span>' + r + '</span><span>' + s.g + '</span>';
        el.onclick = function () { assign(idx); };
        row.appendChild(el);
      });
      deck.appendChild(row);
    });
    var t = target.t === 'board' ? T.mesa : seats[target.i].id;
    var n = nextSlot();
    var pend = pendingRank != null ? ' <span class="pend">' + RANKS[12 - pendingRank] + '_ ?</span>' : '';
    $('.jt-target').innerHTML = (n < 0 ? t + ' \u00b7 ' + T.completo : t + ' \u00b7 ' + T.carta + ' ' + (n + 1)) + pend;
  }

  function draw() { renderTable(); renderDeck(); $('.jt-calc-go').disabled = running; }

  function assign(idx) {
    if (used()[idx]) { toast(T.repetida); return; }
    if (nextSlot() < 0) { advance(); if (nextSlot() < 0) { toast(T.sinsitio); return; } }
    if (target.t === 'board') board.push(idx); else seats[target.i].cards.push(idx);
    pendingRank = null; reset();
    if (nextSlot() < 0) advance();
    draw();
  }
  function advance() {
    var nx;
    if (target.t === 'seat') {
      nx = seats.filter(function (s) { return s.on && s.cards.length < V && s.i !== target.i; });
      if (nx.length) { target = { t:'seat', i:nx[0].i }; return; }
      if (board.length < 5) { target = { t:'board' }; return; }
    } else {
      nx = seats.filter(function (s) { return s.on && s.cards.length < V; });
      if (nx.length) target = { t:'seat', i:nx[0].i };
    }
  }
  function moveTarget(dir) {
    var order = seats.filter(function (s) { return s.on; }).map(function (s) { return { t:'seat', i:s.i }; });
    order.push({ t:'board' });
    var k = -1;
    order.forEach(function (o, i) { if (o.t === target.t && (o.t === 'board' || o.i === target.i)) k = i; });
    k = (k + dir + order.length) % order.length;
    target = order[k]; pendingRank = null; draw();
  }
  function backspace() {
    if (target.t === 'board') { if (board.length) { board.pop(); reset(); draw(); return; } }
    else { var s = seats[target.i]; if (s.cards.length) { s.cards.pop(); reset(); draw(); return; } }
    moveTarget(-1);
  }
  function reset() {
    seats.forEach(function (s) {
      var e = document.getElementById('jt-eq' + s.i); if (e) { e.textContent = '\u2014'; e.classList.remove('is-lead'); }
      var b = document.getElementById('jt-mb' + s.i); if (b) b.style.width = '0';
    });
    $('.jt-results').innerHTML = '<div class="jt-res-empty">' + T.cambio + '</div>';
    $('.jt-meta').innerHTML = '';
  }

  var RMAP = {a:12,k:11,q:10,j:9,t:8,'9':7,'8':6,'7':5,'6':4,'5':3,'4':2,'3':1,'2':0};
  var SMAP = {s:0,h:1,d:2,c:3};
  document.addEventListener('keydown', function (e) {
    if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
    if (!root.getBoundingClientRect().height) return;
    var k = e.key.toLowerCase();
    if (e.key === 'Enter')      { e.preventDefault(); calcular(); return; }
    if (e.key === 'ArrowRight') { e.preventDefault(); moveTarget(1); return; }
    if (e.key === 'ArrowLeft')  { e.preventDefault(); moveTarget(-1); return; }
    if (e.key === 'Backspace' || e.key === 'Delete') { e.preventDefault(); backspace(); return; }
    if (e.key === 'Escape')     { pendingRank = null; draw(); return; }
    if (pendingRank == null && RMAP[k] != null) { pendingRank = RMAP[k]; draw(); return; }
    if (pendingRank != null && SMAP[k] != null) { assign(SMAP[k] * 13 + pendingRank); return; }
    if (pendingRank != null && RMAP[k] != null) { pendingRank = RMAP[k]; draw(); }
  });

  function calcular() {
    if (running) return;
    var ps = seats.filter(function (s) { return s.on && s.cards.length === V; });
    if (ps.length < 2) { toast(T.faltan); return; }
    if (board.length === 1 || board.length === 2) { toast(T.mesa345); return; }

    running = true; $('.jt-calc-go').disabled = true; $('.jt-prog').classList.add('is-on');

    if (worker) worker.terminate();
    worker = new Worker(CFG.workerUrl);
    worker.onmessage = function (ev) {
      var d = ev.data;
      if (d.type === 'blockers') { paintBlockers(d.data, ps); return; }
      paint(ps, d);
      $('.jt-prog i').style.width = d.pct + '%';
      if (d.type === 'done') {
        running = false; $('.jt-calc-go').disabled = false; $('.jt-prog').classList.remove('is-on');
        $('.jt-meta').innerHTML =
          '<b>' + T.metodo + ':</b> ' + (d.metodo === 'exacto' ? T.exacto : 'Monte Carlo') +
          ' \u00b7 ' + d.total.toLocaleString(CFG.lang === 'pt' ? 'pt-BR' : 'es') + ' boards<br>' +
          '<b>' + T.precision + ':</b> ' + (d.metodo === 'exacto' ? T.sinmargen : '\u00b1' + d.margen.toFixed(2) + ' ' + T.puntos) + '<br>' +
          '<b>' + T.tiempo + ':</b> ' + Math.round(d.ms) + ' ms \u00b7 ' + CFG.nombre;
        if (board.length >= 3) {
          var hero = ps.filter(function (p) { return p.i === target.i; })[0] || ps[0];
          worker.postMessage({ cmd:'blockers', hero: hero.cards, board: board, variant: V });
          window.__jtHero = hero;
        }
      }
    };
    worker.postMessage({ hands: ps.map(function (p) { return p.cards; }), board: board });
  }

  function paint(ps, d) {
    var R = $('.jt-results'); R.innerHTML = '';
    var max = 0; d.jugadores.forEach(function (j) { if (j.equity > max) max = j.equity; });
    ps.forEach(function (p, i) {
      var j = d.jugadores[i], lead = j.equity === max;
      var row = document.createElement('div'); row.className = 'jt-res-row';
      var top = document.createElement('div'); top.className = 'jt-res-top';
      top.innerHTML = '<span class="jt-res-pos">' + p.id + '</span>' +
                      '<span class="jt-res-pct' + (lead ? ' is-lead' : '') + '">' + j.equity.toFixed(2) + '%</span>';
      row.appendChild(top);
      var cw = document.createElement('div'); cw.className = 'jt-res-cards';
      p.cards.forEach(function (c) { cw.appendChild(miniEl(c)); });
      row.appendChild(cw);
      var bar = document.createElement('div'); bar.className = 'jt-bar';
      bar.innerHTML = '<i class="w" style="width:' + j.gana + '%"></i><i class="t" style="width:' + j.empata + '%"></i>';
      row.appendChild(bar);
      var sub = document.createElement('div'); sub.className = 'jt-res-sub';
      sub.innerHTML = '<span><span class="k">' + T.gana + '</span><b>' + j.gana.toFixed(1) + '%</b></span>' +
                      '<span class="tie"><span class="k">' + T.empata + '</span><b>' + j.empata.toFixed(1) + '%</b></span>';
      row.appendChild(sub); R.appendChild(row);
      var se = document.getElementById('jt-eq' + p.i);
      if (se) { se.textContent = j.equity.toFixed(1) + '%'; se.classList.toggle('is-lead', lead); }
      var mb = document.getElementById('jt-mb' + p.i); if (mb) mb.style.width = j.equity + '%';
    });
  }

  function paintBlockers(b, ps) {
    if (!b) return;
    var hero = window.__jtHero || ps[0];
    var nota = b.exacto ? '' : '<br><span style="opacity:.7">' + T.blk_aprox + '</span>';
    $('.jt-results').insertAdjacentHTML('beforeend',
      '<div class="jt-blockers"><div class="t">' + T.bloqueadores + ' \u00b7 ' + hero.id + '</div><p>' +
      T.blk_texto.replace('%1', '<b>' + b.bloqueadas + '</b>').replace('%2', '<b>' + b.total + '</b>') +
      nota + '</p></div>');
  }

  function toast(m) {
    var t = document.getElementById('jt-toast');
    t.textContent = m; t.classList.add('is-on');
    clearTimeout(t._x); t._x = setTimeout(function () { t.classList.remove('is-on'); }, 2600);
  }
  $('.jt-calc-go').onclick = calcular;
  $('.jt-calc-clear').onclick = function () {
    seats.forEach(function (s) { s.cards = []; }); board = [];
    target = { t:'seat', i:3 }; pendingRank = null; reset(); draw();
  };
  $('.jt-calc-random').onclick = function () {
    var d = [], i, j;
    for (i = 0; i < 52; i++) d.push(i);
    for (i = 51; i > 0; i--) { j = (Math.random() * (i + 1)) | 0; var tmp = d[i]; d[i] = d[j]; d[j] = tmp; }
    var k = 0;
    seats.forEach(function (s) { s.cards = s.on ? d.slice(k, k + V) : []; if (s.on) k += V; });
    board = []; pendingRank = null; reset(); draw();
  };
  $('.jt-calc-share').onclick = function () {
    var q = [];
    seats.forEach(function (s) { if (s.on && s.cards.length) q.push(s.id.toLowerCase() + '=' + s.cards.map(label).join('')); });
    if (board.length) q.push('b=' + board.map(label).join(''));
    var url = location.origin + location.pathname + (q.length ? '?' + q.join('&') : '');
    if (navigator.clipboard) navigator.clipboard.writeText(url);
    toast(T.copiado);
  };

  (function () {
    var p = new URLSearchParams(location.search);
    if (!p.toString()) { draw(); return; }
    var map = {}; RANKS.forEach(function (r, i) { map[r] = RV[i]; });
    var toCards = function (str) {
      var out = [], m = str.toUpperCase().match(/../g) || [];
      m.forEach(function (x) {
        var r = map[x[0]], s = 'SHDC'.indexOf(x[1]);
        if (r != null && s >= 0) out.push(s * 13 + r);
      });
      return out;
    };
    seats.forEach(function (s) {
      var v = p.get(s.id.toLowerCase());
      if (v) { s.cards = toCards(v).slice(0, V); s.on = true; }
    });
    if (!seats.some(function (s) { return s.on; })) { seats[3].on = true; seats[5].on = true; }
    var b = p.get('b'); if (b) board = toCards(b).slice(0, 5);
    draw();
  })();
})();
