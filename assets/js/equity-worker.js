/**
 * Motor de equity — OmahaLatam
 * Corre dentro de un Web Worker para no bloquear la interfaz.
 *
 * Carta = entero 0..51.  rango = c % 13 (0='2' .. 12='A').  palo = (c/13)|0
 * Palos: 0 picas, 1 corazones, 2 diamantes, 3 treboles.
 *
 * Validado el 29/08/2026 contra la distribucion de las 2.598.960 manos de
 * cinco cartas y contra equities publicadas de Hold'em. Ver INFORME-VALIDACION.
 */
'use strict';

var RC = new Int8Array(13);

function eval5(a, b, c, d, e) {
  RC.fill(0);
  var m = 0, s0 = 0, s1 = 0, s2 = 0, s3 = 0, r;
  r = a % 13; RC[r]++; m |= 1 << r; switch ((a/13)|0){case 0:s0++;break;case 1:s1++;break;case 2:s2++;break;default:s3++;}
  r = b % 13; RC[r]++; m |= 1 << r; switch ((b/13)|0){case 0:s0++;break;case 1:s1++;break;case 2:s2++;break;default:s3++;}
  r = c % 13; RC[r]++; m |= 1 << r; switch ((c/13)|0){case 0:s0++;break;case 1:s1++;break;case 2:s2++;break;default:s3++;}
  r = d % 13; RC[r]++; m |= 1 << r; switch ((d/13)|0){case 0:s0++;break;case 1:s1++;break;case 2:s2++;break;default:s3++;}
  r = e % 13; RC[r]++; m |= 1 << r; switch ((e/13)|0){case 0:s0++;break;case 1:s1++;break;case 2:s2++;break;default:s3++;}

  var flush = (s0 === 5 || s1 === 5 || s2 === 5 || s3 === 5);
  var st = -1, hi, need;
  for (hi = 12; hi >= 4; hi--) {
    need = (1<<hi)|(1<<(hi-1))|(1<<(hi-2))|(1<<(hi-3))|(1<<(hi-4));
    if ((m & need) === need) { st = hi; break; }
  }
  if (st < 0) { var w = (1<<12)|1|2|4|8; if ((m & w) === w) st = 3; }

  var quad = -1, trip = -1, p1 = -1, p2 = -1, kick = 0, x, n;
  for (x = 12; x >= 0; x--) {
    n = RC[x]; if (!n) continue;
    if (n === 4) quad = x;
    else if (n === 3) trip = x;
    else if (n === 2) { if (p1 < 0) p1 = x; else p2 = x; }
    else kick = kick * 16 + x;
  }
  var M = 1048576;
  if (flush && st >= 0) return 8*M + st;
  if (quad >= 0)        return 7*M + quad*16 + kick;
  if (trip >= 0 && p1 >= 0) return 6*M + trip*16 + p1;
  if (flush)            return 5*M + kick;
  if (st >= 0)          return 4*M + st;
  if (trip >= 0)        return 3*M + trip*256 + kick;
  if (p2 >= 0)          return 2*M + p1*256 + p2*16 + kick;
  if (p1 >= 0)          return 1*M + p1*4096 + kick;
  return kick;
}

var T3 = [[0,1,2],[0,1,3],[0,1,4],[0,2,3],[0,2,4],[0,3,4],[1,2,3],[1,2,4],[1,3,4],[2,3,4]];
var C75 = (function(){ var o=[],a,b,c,d,e;
  for(a=0;a<7;a++)for(b=a+1;b<7;b++)for(c=b+1;c<7;c++)for(d=c+1;d<7;d++)for(e=d+1;e<7;e++)o.push([a,b,c,d,e]);
  return o; })();

function pairsOf(n){ var o=[],i,j; for(i=0;i<n;i++) for(j=i+1;j<n;j++) o.push([i,j]); return o; }

function bestOmaha(h, pairs, b) {
  var best = 0, t, p, T, b0, b1, b2, P, v;
  for (t = 0; t < 10; t++) {
    T = T3[t]; b0 = b[T[0]]; b1 = b[T[1]]; b2 = b[T[2]];
    for (p = 0; p < pairs.length; p++) {
      P = pairs[p]; v = eval5(h[P[0]], h[P[1]], b0, b1, b2);
      if (v > best) best = v;
    }
  }
  return best;
}

var SEVEN = new Array(7);
function bestHoldem(h, b) {
  SEVEN[0]=h[0]; SEVEN[1]=h[1];
  for (var i=0;i<5;i++) SEVEN[2+i]=b[i];
  var best=0, C, v;
  for (i=0;i<21;i++){ C=C75[i]; v=eval5(SEVEN[C[0]],SEVEN[C[1]],SEVEN[C[2]],SEVEN[C[3]],SEVEN[C[4]]); if(v>best)best=v; }
  return best;
}

/* ---------- bloqueadores ---------- */
/**
 * Cuenta cuantas combinaciones de 2 cartas hacen la mejor mano posible en la
 * mesa, y cuantas de ellas bloquea el jugador con sus propias cartas.
 * Funciona en flop, turn y river; con la mesa incompleta se evalua contra las
 * cartas visibles, que es la lectura que hace un jugador en mesa.
 */
function blockers(heroCards, board, variant) {
  if (board.length < 3) return null;
  var avail = [], i, j;
  for (i = 0; i < 52; i++) if (board.indexOf(i) === -1) avail.push(i);

  var best = -1, combos = [];
  var full = board.length === 5;

  for (i = 0; i < avail.length; i++) {
    for (j = i+1; j < avail.length; j++) {
      var v;
      if (variant === 2) {
        if (!full) continue;
        v = bestHoldem([avail[i], avail[j]], board);
      } else {
        v = 0;
        if (full) {
          for (var t = 0; t < 10; t++) {
            var T = T3[t];
            var x = eval5(avail[i], avail[j], board[T[0]], board[T[1]], board[T[2]]);
            if (x > v) v = x;
          }
        } else if (board.length === 3) {
          v = eval5(avail[i], avail[j], board[0], board[1], board[2]);
        } else {
          var c4 = [[0,1,2],[0,1,3],[0,2,3],[1,2,3]];
          for (var k = 0; k < 4; k++) {
            var Q = c4[k];
            var y = eval5(avail[i], avail[j], board[Q[0]], board[Q[1]], board[Q[2]]);
            if (y > v) v = y;
          }
        }
      }
      if (v > best) { best = v; combos = [[avail[i], avail[j]]]; }
      else if (v === best) combos.push([avail[i], avail[j]]);
    }
  }
  if (best < 0) return null;
  var set = {}; for (i = 0; i < heroCards.length; i++) set[heroCards[i]] = 1;
  var blocked = 0;
  for (i = 0; i < combos.length; i++) if (set[combos[i][0]] || set[combos[i][1]]) blocked++;
  return { total: combos.length, bloqueadas: blocked, categoria: (best/1048576)|0, exacto: full };
}

/* ---------- bucle principal ---------- */
self.onmessage = function (ev) {
  var d = ev.data;
  if (d.cmd === 'blockers') {
    self.postMessage({ type: 'blockers', data: blockers(d.hero, d.board, d.variant) });
    return;
  }

  var hands = d.hands, board = d.board || [], variant = hands[0].length;
  var holdem = variant === 2, pairs = pairsOf(variant);
  var known = board.concat.apply(board, hands);
  var deck = [], i, j;
  for (i = 0; i < 52; i++) if (known.indexOf(i) === -1) deck.push(i);

  var need = 5 - board.length;
  var exact = need <= 2;
  var n = hands.length;
  var eq = new Float64Array(n), win = new Float64Array(n), tie = new Float64Array(n);
  var b5 = new Array(5), sc = new Array(n);
  for (i = 0; i < board.length; i++) b5[i] = board[i];

  var boards = [];
  if (exact) {
    if (need === 0) boards = [[]];
    else if (need === 1) { for (i=0;i<deck.length;i++) boards.push([deck[i]]); }
    else { for (i=0;i<deck.length;i++) for (j=i+1;j<deck.length;j++) boards.push([deck[i],deck[j]]); }
  }
  var total = exact ? boards.length : (d.iters || 26000);
  var done = 0, t0 = Date.now();
  var CHUNK = exact ? 400 : 900;

  function emit(final) {
    var out = [];
    for (var p = 0; p < n; p++) out.push({
      equity: 100*eq[p]/done, gana: 100*win[p]/done, empata: 100*tie[p]/done
    });
    self.postMessage({
      type: final ? 'done' : 'progress',
      pct: 100*done/total, done: done, total: total,
      metodo: exact ? 'exacto' : 'montecarlo',
      ms: Date.now() - t0,
      margen: exact ? 0 : 100*Math.sqrt(0.25/done)*1.96,
      jugadores: out
    });
  }

  function step() {
    var end = Math.min(done + CHUNK, total);
    for (; done < end; done++) {
      if (exact) { for (i=0;i<need;i++) b5[board.length+i] = boards[done][i]; }
      else {
        for (i = board.length; i < 5; i++) {
          var c, dup;
          do { c = deck[(Math.random()*deck.length)|0]; dup = false;
               for (j = board.length; j < i; j++) if (b5[j] === c) { dup = true; break; } } while (dup);
          b5[i] = c;
        }
      }
      var max = -1, nw = 0, p;
      for (p = 0; p < n; p++) {
        var v = holdem ? bestHoldem(hands[p], b5) : bestOmaha(hands[p], pairs, b5);
        sc[p] = v;
        if (v > max) { max = v; nw = 1; } else if (v === max) nw++;
      }
      for (p = 0; p < n; p++) if (sc[p] === max) { eq[p] += 1/nw; if (nw === 1) win[p]++; else tie[p]++; }
    }
    if (done < total) { emit(false); setTimeout(step, 0); }
    else emit(true);
  }
  step();
};
