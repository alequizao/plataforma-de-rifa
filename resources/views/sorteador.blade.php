{{--
    Sorteador — Plataforma de Rifa
    Desenvolvido por @alequizao · alequizao.dev@gmail.com
--}}
@extends('layouts.app')

@section('title', ' - Sorteador')
@section('ogTitle', 'Sorteador online grátis')
@section('metaDescription', 'Sorteador online grátis: sorteie números, nomes e equipes na hora, com resultado transparente e código de conferência.')

@section('dadosEstruturados')
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebApplication',
        'name' => 'Sorteador',
        'applicationCategory' => 'UtilitiesApplication',
        'operatingSystem' => 'Web',
        'inLanguage' => 'pt-BR',
        'url' => url()->current(),
        'description' => 'Sorteador online grátis de números, nomes e equipes, com código de conferência.',
        'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'BRL'],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endsection

@section('content')
    <div class="container app-main" id="app-main">
        <div class="row justify-content-center">
            <div class="col-md-6 col-12">

                <div class="app-title">
                    <h1>🎲 Sorteador</h1>
                    <div class="app-title-desc">Rápido, grátis e transparente</div>
                </div>

                {{-- abas --}}
                <div class="srt-abas" role="tablist">
                    <button class="srt-aba is-ativa" data-alvo="numeros">Números</button>
                    <button class="srt-aba" data-alvo="nomes">Nomes</button>
                    <button class="srt-aba" data-alvo="equipes">Equipes</button>
                    @if ($ehAdmin && count($campanhas))
                        <button class="srt-aba" data-alvo="campanha">Campanha 🔒</button>
                    @endif
                </div>

                {{-- ============ NÚMEROS ============ --}}
                <section class="srt-painel is-ativo" id="painel-numeros">
                    <div class="srt-frase">
                        Sortear
                        <input type="number" id="numQtd" value="1" min="1" max="1000" class="srt-campo">
                        número(s) entre
                        <input type="number" id="numDe" value="1" class="srt-campo">
                        e
                        <input type="number" id="numAte" value="100" class="srt-campo">
                    </div>

                    <details class="srt-opcoes">
                        <summary>Opções do sorteio</summary>
                        <label class="srt-check">
                            <input type="checkbox" id="numRepetir"> Permitir números repetidos
                        </label>
                        <label class="srt-check">
                            <input type="checkbox" id="numOrdenar"> Mostrar o resultado em ordem crescente
                        </label>
                    </details>

                    <button class="srt-botao" id="btnNumeros">🎲 Sortear agora</button>
                </section>

                {{-- ============ NOMES ============ --}}
                <section class="srt-painel" id="painel-nomes">
                    <label class="srt-rotulo">Cole a lista — um nome por linha</label>
                    <textarea id="listaNomes" class="srt-textarea" rows="7"
                        placeholder="Maria&#10;João&#10;Ana&#10;Pedro"></textarea>
                    <div class="srt-contador" id="contaNomes">0 nomes</div>

                    <div class="srt-frase">
                        Sortear
                        <input type="number" id="nomeQtd" value="1" min="1" class="srt-campo">
                        vencedor(es)
                    </div>

                    <details class="srt-opcoes">
                        <summary>Opções do sorteio</summary>
                        <label class="srt-check">
                            <input type="checkbox" id="nomeSuplentes"> Sortear também 3 suplentes
                        </label>
                        <label class="srt-check">
                            <input type="checkbox" id="nomeRemoverDup" checked> Ignorar nomes repetidos
                        </label>
                    </details>

                    <button class="srt-botao" id="btnNomes">🎁 Sortear agora</button>
                </section>

                {{-- ============ EQUIPES ============ --}}
                <section class="srt-painel" id="painel-equipes">
                    <label class="srt-rotulo">Cole os participantes — um por linha</label>
                    <textarea id="listaEquipes" class="srt-textarea" rows="7"
                        placeholder="Maria&#10;João&#10;Ana&#10;Pedro"></textarea>
                    <div class="srt-contador" id="contaEquipes">0 participantes</div>

                    <div class="srt-frase">
                        Dividir em
                        <input type="number" id="qtdEquipes" value="2" min="2" max="20" class="srt-campo">
                        equipes
                    </div>

                    <button class="srt-botao" id="btnEquipes">👥 Formar equipes</button>
                </section>

                {{-- ============ CAMPANHA ============ --}}
                @if ($ehAdmin && count($campanhas))
                    <section class="srt-painel" id="painel-campanha">
                        <label class="srt-rotulo">Sortear entre quem já pagou as cotas</label>
                        <select id="campanhaId" class="srt-select">
                            @foreach ($campanhas as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>

                        <div class="srt-frase">
                            Sortear
                            <input type="number" id="campQtd" value="1" min="1" max="50" class="srt-campo">
                            ganhador(es)
                        </div>

                        <p class="srt-aviso">
                            <b>Área do organizador.</b> Só entram as cotas <b>pagas</b>. O sorteio é
                            feito no servidor e gera um código de conferência.
                        </p>

                        <button class="srt-botao" id="btnCampanha">🏆 Sortear ganhador</button>
                    </section>
                @endif

                {{-- ============ RESULTADO ============ --}}
                <div class="srt-resultado" id="resultado" hidden>
                    <div class="srt-resultado-topo">
                        <span id="resTitulo">Resultado</span>
                        <button class="srt-copiar" id="btnCopiar" title="Copiar resultado">
                            <i class="bi bi-files"></i> Copiar
                        </button>
                    </div>
                    <div id="resCorpo"></div>
                    <div class="srt-selo" id="resSelo"></div>
                </div>

                {{-- ============ TEXTO (SEO) ============ --}}
                <section class="srt-texto">
                    <h2>Sorteador online grátis</h2>
                    <p>Use para sortear <b>números</b>, <b>nomes</b> ou formar <b>equipes</b> na hora,
                        sem cadastro. Serve para promoções, brincadeiras, divisão de times, amigo
                        secreto e qualquer decisão que precise de imparcialidade.</p>

                    <h3>O sorteio é realmente aleatório?</h3>
                    <p>Sim. Os sorteios de números, nomes e equipes usam o gerador aleatório do seu
                        navegador (<code>crypto.getRandomValues</code>), o mesmo tipo usado em
                        segurança. O sorteio entre participantes de campanha roda no servidor com
                        <code>random_int()</code> e devolve um <b>código de conferência</b>, para
                        que o resultado possa ser auditado depois.</p>

                    <h3>Como provar o resultado para os participantes?</h3>
                    <p>Use o botão <b>Copiar</b>: o texto sai com a data, a hora e o código de
                        conferência do sorteio, pronto para publicar no grupo ou nas redes.</p>
                </section>
            </div>
        </div>
        <br>
        @include('layouts.footer')
    </div>

    <script>
        (function () {
            var rotaCampanha = '{{ route('sorteador.participantes') }}';
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            /* ---------- aleatoriedade criptográfica ---------- */
            function inteiro(min, max) {
                var faixa = max - min + 1;
                if (faixa <= 0) return min;
                var limite = Math.floor(4294967296 / faixa) * faixa;
                var v, buf = new Uint32Array(1);
                do { crypto.getRandomValues(buf); v = buf[0]; } while (v >= limite);
                return min + (v % faixa);
            }

            function embaralhar(a) {
                for (var i = a.length - 1; i > 0; i--) {
                    var j = inteiro(0, i);
                    var t = a[i]; a[i] = a[j]; a[j] = t;
                }
                return a;
            }

            /* ---------- abas ---------- */
            document.querySelectorAll('.srt-aba').forEach(function (b) {
                b.addEventListener('click', function () {
                    document.querySelectorAll('.srt-aba').forEach(function (x) { x.classList.remove('is-ativa'); });
                    document.querySelectorAll('.srt-painel').forEach(function (x) { x.classList.remove('is-ativo'); });
                    b.classList.add('is-ativa');
                    document.getElementById('painel-' + b.dataset.alvo).classList.add('is-ativo');
                    esconder();
                });
            });

            /* ---------- resultado ---------- */
            var caixa = document.getElementById('resultado');
            var corpo = document.getElementById('resCorpo');
            var selo = document.getElementById('resSelo');
            var titulo = document.getElementById('resTitulo');
            var textoCopia = '';

            function esconder() { caixa.hidden = true; }

            function mostrar(tit, html, rodape, copia) {
                titulo.textContent = tit;
                corpo.innerHTML = html;
                selo.innerHTML = rodape;
                textoCopia = copia;
                caixa.hidden = false;
                caixa.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            function agora() {
                var d = new Date();
                return d.toLocaleDateString('pt-BR') + ' às ' + d.toLocaleTimeString('pt-BR');
            }

            /* animação: números girando antes de parar */
            function girar(elementos, finais, aoTerminar) {
                var passos = 22, i = 0;
                var t = setInterval(function () {
                    elementos.forEach(function (el, k) {
                        el.textContent = (i >= passos - 1)
                            ? finais[k]
                            : String(inteiro(0, 99)).padStart(String(finais[k]).length, '0');
                    });
                    if (++i >= passos) { clearInterval(t); if (aoTerminar) aoTerminar(); }
                }, 55);
            }

            function bolas(valores) {
                return '<div class="srt-bolas">' +
                    valores.map(function (v) { return '<span class="srt-bola">' + v + '</span>'; }).join('') +
                    '</div>';
            }

            /* ---------- NÚMEROS ---------- */
            document.getElementById('btnNumeros').addEventListener('click', function () {
                var qtd = parseInt(document.getElementById('numQtd').value) || 1;
                var de = parseInt(document.getElementById('numDe').value);
                var ate = parseInt(document.getElementById('numAte').value);
                var repetir = document.getElementById('numRepetir').checked;
                var ordenar = document.getElementById('numOrdenar').checked;

                if (isNaN(de) || isNaN(ate)) return alert('Preencha o intervalo.');
                if (de > ate) { var t = de; de = ate; ate = t; }

                var disponiveis = ate - de + 1;
                if (!repetir && qtd > disponiveis) {
                    return alert('Você pediu ' + qtd + ' números, mas entre ' + de + ' e ' + ate +
                        ' só existem ' + disponiveis + '. Aumente o intervalo ou permita repetição.');
                }

                var res = [];
                if (repetir) {
                    for (var i = 0; i < qtd; i++) res.push(inteiro(de, ate));
                } else {
                    var pool = [];
                    for (var n = de; n <= ate; n++) pool.push(n);
                    res = embaralhar(pool).slice(0, qtd);
                }
                if (ordenar) res.sort(function (a, b) { return a - b; });

                mostrar('Resultado do sorteio', bolas(res.map(function () { return '—'; })), '', '');
                var els = [].slice.call(corpo.querySelectorAll('.srt-bola'));
                girar(els, res, function () {
                    var quando = agora();
                    selo.innerHTML = 'Sorteado em ' + quando + ' · entre ' + de + ' e ' + ate;
                    textoCopia = '🎲 Sorteio de números\n' + res.join(', ') +
                        '\nIntervalo: ' + de + ' a ' + ate + '\n' + quando;
                });
            });

            /* ---------- NOMES ---------- */
            function lerLista(id, removerDup) {
                var itens = document.getElementById(id).value.split('\n')
                    .map(function (s) { return s.trim(); }).filter(Boolean);
                if (removerDup) {
                    var vistos = {}, saida = [];
                    itens.forEach(function (i) {
                        var c = i.toLowerCase();
                        if (!vistos[c]) { vistos[c] = 1; saida.push(i); }
                    });
                    itens = saida;
                }
                return itens;
            }

            function contar(idArea, idConta, rotulo) {
                var f = function () {
                    var n = lerLista(idArea, false).length;
                    document.getElementById(idConta).textContent = n + ' ' + rotulo;
                };
                document.getElementById(idArea).addEventListener('input', f);
                f();
            }
            contar('listaNomes', 'contaNomes', 'nomes');
            contar('listaEquipes', 'contaEquipes', 'participantes');

            document.getElementById('btnNomes').addEventListener('click', function () {
                var dup = document.getElementById('nomeRemoverDup').checked;
                var lista = lerLista('listaNomes', dup);
                var qtd = parseInt(document.getElementById('nomeQtd').value) || 1;
                var comSuplentes = document.getElementById('nomeSuplentes').checked;

                if (lista.length < 2) return alert('Coloque pelo menos 2 nomes na lista.');
                if (qtd > lista.length) return alert('Você pediu mais vencedores do que nomes na lista.');

                var mix = embaralhar(lista.slice());
                var ganhadores = mix.slice(0, qtd);
                var suplentes = comSuplentes ? mix.slice(qtd, qtd + 3) : [];

                var html = '<ol class="srt-lista">' +
                    ganhadores.map(function (g) { return '<li>' + escapar(g) + '</li>'; }).join('') + '</ol>';
                if (suplentes.length) {
                    html += '<div class="srt-sub">Suplentes</div><ol class="srt-lista srt-lista-sub">' +
                        suplentes.map(function (s) { return '<li>' + escapar(s) + '</li>'; }).join('') + '</ol>';
                }

                var quando = agora();
                mostrar('Vencedor(es)', html,
                    'Sorteado em ' + quando + ' · entre ' + lista.length + ' participantes',
                    '🎁 Sorteio de nomes\n' + ganhadores.join(', ') +
                    (suplentes.length ? '\nSuplentes: ' + suplentes.join(', ') : '') +
                    '\nParticipantes: ' + lista.length + '\n' + quando);
            });

            /* ---------- EQUIPES ---------- */
            document.getElementById('btnEquipes').addEventListener('click', function () {
                var lista = lerLista('listaEquipes', false);
                var n = parseInt(document.getElementById('qtdEquipes').value) || 2;

                if (lista.length < n) return alert('Há menos participantes do que equipes.');

                var mix = embaralhar(lista.slice());
                var times = [];
                for (var i = 0; i < n; i++) times.push([]);
                mix.forEach(function (p, i) { times[i % n].push(p); });

                var html = '<div class="srt-times">' + times.map(function (t, i) {
                    return '<div class="srt-time"><b>Equipe ' + (i + 1) + '</b><ul>' +
                        t.map(function (p) { return '<li>' + escapar(p) + '</li>'; }).join('') + '</ul></div>';
                }).join('') + '</div>';

                var quando = agora();
                mostrar('Equipes formadas', html,
                    'Sorteado em ' + quando + ' · ' + lista.length + ' participantes',
                    '👥 Equipes\n' + times.map(function (t, i) {
                        return 'Equipe ' + (i + 1) + ': ' + t.join(', ');
                    }).join('\n') + '\n' + quando);
            });

            /* ---------- CAMPANHA ---------- */
            var btnCamp = document.getElementById('btnCampanha');
            if (btnCamp) {
                btnCamp.addEventListener('click', function () {
                    var b = this;
                    b.disabled = true; b.textContent = 'Sorteando...';

                    fetch(rotaCampanha, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({
                            campanha: document.getElementById('campanhaId').value,
                            quantidade: document.getElementById('campQtd').value
                        })
                    })
                        .then(function (r) { return r.json(); })
                        .then(function (r) {
                            if (!r.ok) return alert(r.msg);

                            var html = '<ol class="srt-lista">' + r.sorteados.map(function (s) {
                                return '<li><b>' + escapar(s.nome) + '</b>' +
                                    '<span class="srt-cota">cota ' + escapar(s.numero) + '</span>' +
                                    '<small>' + escapar(s.telefone) + '</small></li>';
                            }).join('') + '</ol>';

                            mostrar('Ganhador(es) da campanha', html,
                                'Sorteado em ' + r.quando + ' · entre ' + r.total +
                                ' cotas pagas<br>Código de conferência: <b>' + r.codigo + '</b>',
                                '🏆 ' + r.campanha + '\n' + r.sorteados.map(function (s) {
                                    return s.nome + ' — cota ' + s.numero;
                                }).join('\n') + '\nCotas pagas: ' + r.total +
                                '\n' + r.quando + '\nConferência: ' + r.codigo);
                        })
                        .catch(function () { alert('Falha ao falar com o servidor.'); })
                        .then(function () { b.disabled = false; b.textContent = '🏆 Sortear ganhador'; });
                });
            }

            /* ---------- copiar ---------- */
            document.getElementById('btnCopiar').addEventListener('click', function () {
                var b = this;
                var ok = function () {
                    b.innerHTML = '<i class="bi bi-check-lg"></i> Copiado';
                    setTimeout(function () { b.innerHTML = '<i class="bi bi-files"></i> Copiar'; }, 1800);
                };
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(textoCopia).then(ok, function () { });
                } else {
                    var t = document.createElement('textarea');
                    t.value = textoCopia; document.body.appendChild(t); t.select();
                    document.execCommand('copy'); document.body.removeChild(t); ok();
                }
            });

            function escapar(s) {
                var d = document.createElement('div');
                d.textContent = s;
                return d.innerHTML;
            }
        })();
    </script>
@endsection
