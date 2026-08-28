{{--
    Sorteador — miolo compartilhado entre a página pública e o painel.
    Visual inspirado no sorteador.com.br.
    Desenvolvido por @alequizao · alequizao.dev@gmail.com
--}}
@php
    $logoSite = @$data['social']->logo ? asset('products/' . $data['social']->logo) : null;
    $nomeSite = @$data['social']->name ?: 'Sorteador';
    $temCampanha = $ehAdmin && count($campanhas);
    $salvoJson = isset($salvo) && $salvo ? json_encode($salvo, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : 'null';
@endphp
<div class="srt">
    <div class="srt-fundo">

        {{-- ============ ABAS ============ --}}
        <nav class="srt-nav" role="tablist" aria-label="Tipo de sorteio">
            <button type="button" class="srt-nav-numeros is-ativa" data-aba="numeros" role="tab">Números</button>
            <button type="button" class="srt-nav-nomes" data-aba="nomes" role="tab">Nomes</button>
            <button type="button" class="srt-nav-equipes" data-aba="equipes" role="tab">Equipes</button>
            @if ($temCampanha)
                <button type="button" class="srt-nav-campanha" data-aba="campanha" role="tab">Campanha</button>
            @endif
            <a class="srt-nav-rifas" href="{{ route('sorteios') }}">Rifas</a>
        </nav>

        <div class="srt-miolo">

            <div class="srt-logo">
                @if ($logoSite)
                    <img src="{{ $logoSite }}" alt="{{ $nomeSite }}">
                @else
                    <span>{{ $nomeSite }}</span>
                @endif
            </div>

            {{-- ============ NÚMEROS ============ --}}
            <form class="srt-tela is-ativa" id="tela-numeros" data-tipo="numeros" novalidate>
                <div class="srt-frase">
                    Sortear <input type="number" id="numQtd" class="srt-campo" value="1" min="1" max="1000" inputmode="numeric">
                    <span id="numPlural">número</span>
                    <div class="srt-linha">
                        entre <input type="number" id="numDe" class="srt-campo srt-campo-p" value="1" min="0" max="999999999" inputmode="numeric">
                        e <input type="number" id="numAte" class="srt-campo srt-campo-g" value="100" min="1" max="999999999" inputmode="numeric">
                    </div>
                </div>

                <div class="srt-acordeoes">
                    <div class="srt-acordeao">
                        <button type="button" class="srt-acordeao-btn"><span>Opções do Sorteio</span>@include('sorteador.chevron')</button>
                        <div class="srt-acordeao-corpo">
                            <label class="srt-opcao"><input type="checkbox" id="numOrdenar"> Ordenar resultados em ordem crescente</label>
                            <label class="srt-opcao"><input type="checkbox" id="numClicar"> Mostrar resultado ao clicar no item</label>
                            <label class="srt-opcao"><input type="checkbox" id="numContagem"> Adicionar contagem regressiva!</label>
                            <label class="srt-opcao"><input type="checkbox" id="numRepetir"> Permitir repetição de números</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="srt-botao">Sortear Agora!</button>

                <h1 class="srt-h1">Sorteador de números aleatórios gratuito!</h1>
                <p class="srt-sub">Sorteio 100% aleatório, na hora e sem cadastro. Salve o resultado para compartilhar o link com os participantes.</p>
            </form>

            {{-- ============ NOMES ============ --}}
            <form class="srt-tela" id="tela-nomes" data-tipo="nomes" novalidate>
                <h2 class="srt-titulo-grad">Sorteio de Nomes e Listas</h2>
                <div class="srt-frase">
                    Sortear <input type="number" id="nomeQtd" class="srt-campo" value="1" min="1" max="1000" inputmode="numeric">
                    <span id="nomePlural">item</span> da lista abaixo:
                    <textarea id="listaNomes" class="srt-textarea" placeholder="Escreva aqui os itens que gostaria de sortear, separados por vírgula ou quebra de linha (Enter)."></textarea>
                </div>
                <div class="srt-contador" id="contaNomes">0 itens na lista</div>

                <label class="srt-drop" id="dropNomes">
                    <input type="file" accept=".csv,.txt,text/plain,text/csv">
                    <div>Se preferir, arraste o arquivo <strong>.csv</strong> ou <strong>.txt</strong> para este espaço ou <u>clique aqui</u> para localizá-lo em seu computador!</div>
                </label>

                <div class="srt-acordeoes">
                    <div class="srt-acordeao">
                        <button type="button" class="srt-acordeao-btn"><span>Opções do Sorteio</span>@include('sorteador.chevron')</button>
                        <div class="srt-acordeao-corpo">
                            <label class="srt-opcao"><input type="checkbox" id="nomeOrdenar"> Ordenar resultados em ordem alfabética</label>
                            <label class="srt-opcao"><input type="checkbox" id="nomeClicar"> Mostrar resultado ao clicar no item</label>
                            <label class="srt-opcao"><input type="checkbox" id="nomeContagem"> Adicionar contagem regressiva!</label>
                            <label class="srt-opcao"><input type="checkbox" id="nomeDuplicados" checked> Ignorar itens repetidos na lista</label>
                            <label class="srt-opcao"><input type="checkbox" id="nomeSuplentes"> Sortear também 3 suplentes</label>
                        </div>
                    </div>
                    <div class="srt-acordeao">
                        <button type="button" class="srt-acordeao-btn"><span>Qual o critério de separação</span>@include('sorteador.chevron')</button>
                        <div class="srt-acordeao-corpo">
                            <label class="srt-opcao"><input type="radio" name="sepNomes" value="auto" checked> Automático <small>quebra de linha, vírgula ou ponto e vírgula</small></label>
                            <label class="srt-opcao"><input type="radio" name="sepNomes" value="linha"> Somente quebra de linha (Enter)</label>
                            <label class="srt-opcao"><input type="radio" name="sepNomes" value="virgula"> Vírgula ( , )</label>
                            <label class="srt-opcao"><input type="radio" name="sepNomes" value="pontovirgula"> Ponto e vírgula ( ; )</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="srt-botao">Sortear Agora!</button>
                <h2 class="srt-h1">Sorteador de nomes online grátis!</h2>
            </form>

            {{-- ============ EQUIPES ============ --}}
            <form class="srt-tela" id="tela-equipes" data-tipo="equipes" novalidate>
                <h2 class="srt-titulo-grad">Sorteio de Equipes</h2>
                <div class="srt-frase">
                    Informe abaixo a lista de participantes a ser sorteada:
                    <textarea id="listaEquipes" class="srt-textarea" placeholder="Um(a) participante por linha. Ex.:&#10;Participante 1&#10;Participante 2&#10;Participante 3..."></textarea>
                </div>
                <div class="srt-contador" id="contaEquipes">0 participantes</div>

                <label class="srt-drop" id="dropEquipes">
                    <input type="file" accept=".csv,.txt,text/plain,text/csv">
                    <div>Se preferir, arraste o arquivo <strong>.csv</strong> ou <strong>.txt</strong> para este espaço ou <u>clique aqui</u> para localizá-lo em seu computador!</div>
                </label>

                <div class="srt-frase">
                    Dividir aleatoriamente os participantes acima em:
                    <div class="srt-linha">
                        <input type="number" id="eqQtd" class="srt-campo" value="2" min="1" max="500" inputmode="numeric">
                        <select id="eqModo" class="srt-select">
                            <option value="equipes">Equipes</option>
                            <option value="por">Participantes por Equipe</option>
                        </select>
                    </div>
                </div>

                <div class="srt-acordeoes">
                    <div class="srt-acordeao">
                        <button type="button" class="srt-acordeao-btn"><span>Opções do Sorteio</span>@include('sorteador.chevron')</button>
                        <div class="srt-acordeao-corpo">
                            <label class="srt-opcao"><input type="checkbox" id="eqOrdenar"> Ordenar os participantes de cada equipe em ordem alfabética</label>
                            <label class="srt-opcao"><input type="checkbox" id="eqContagem"> Adicionar contagem regressiva!</label>
                            <label class="srt-opcao"><input type="checkbox" id="eqDuplicados" checked> Ignorar participantes repetidos</label>
                        </div>
                    </div>
                    <div class="srt-acordeao">
                        <button type="button" class="srt-acordeao-btn"><span>Qual o critério de separação</span>@include('sorteador.chevron')</button>
                        <div class="srt-acordeao-corpo">
                            <label class="srt-opcao"><input type="radio" name="sepEquipes" value="auto" checked> Automático <small>quebra de linha, vírgula ou ponto e vírgula</small></label>
                            <label class="srt-opcao"><input type="radio" name="sepEquipes" value="linha"> Somente quebra de linha (Enter)</label>
                            <label class="srt-opcao"><input type="radio" name="sepEquipes" value="virgula"> Vírgula ( , )</label>
                            <label class="srt-opcao"><input type="radio" name="sepEquipes" value="pontovirgula"> Ponto e vírgula ( ; )</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="srt-botao">Sortear Equipes</button>
                <h2 class="srt-h1">Sorteador de equipes online grátis!</h2>
            </form>

            {{-- ============ CAMPANHA (organizador) ============ --}}
            @if ($temCampanha)
                <form class="srt-tela" id="tela-campanha" data-tipo="campanha" novalidate>
                    <h2 class="srt-titulo-grad">Sorteio da Campanha</h2>
                    <div class="srt-frase">
                        Sortear <input type="number" id="campQtd" class="srt-campo" value="1" min="1" max="50" inputmode="numeric">
                        <span id="campPlural">ganhador</span> entre as cotas pagas de:
                        <div class="srt-linha">
                            <select id="campanhaId" class="srt-select srt-select-largo">
                                @foreach ($campanhas as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="srt-acordeoes">
                        <div class="srt-acordeao">
                            <button type="button" class="srt-acordeao-btn"><span>Opções do Sorteio</span>@include('sorteador.chevron')</button>
                            <div class="srt-acordeao-corpo">
                                <label class="srt-opcao"><input type="checkbox" id="campClicar"> Mostrar resultado ao clicar no item</label>
                                <label class="srt-opcao"><input type="checkbox" id="campContagem" checked> Adicionar contagem regressiva!</label>
                            </div>
                        </div>
                    </div>

                    <p class="srt-aviso"><b>Área do organizador.</b> Só entram as cotas <b>pagas</b>. O sorteio roda no servidor com gerador criptográfico e devolve um <b>código de conferência</b>.</p>

                    <button type="submit" class="srt-botao">Sortear Ganhador</button>
                </form>
            @endif

            {{-- ============ RESULTADO ============ --}}
            <section class="srt-tela" id="tela-resultado" aria-live="polite">
                <h2 class="srt-res-titulo" id="resTitulo">Resultado do Sorteio:</h2>
                <div id="resCorpo"></div>
                <button type="button" class="srt-copiar" id="btnCopiar">Copiar para Área de Transferência</button>

                <h3 class="srt-info-titulo">Informações do Sorteio</h3>
                <div class="srt-infos" id="resInfos"></div>

                <div id="resSalvo" hidden></div>

                <h3 class="srt-agora" id="resAgora">E agora, o que gostaria de fazer?</h3>
                <div class="srt-acoes" id="resAcoes">
                    <button type="button" class="srt-acao srt-acao-verde" id="btnSalvar">Salvar este resultado</button>
                    <button type="button" class="srt-acao srt-acao-indigo" id="btnSemRepetir">Sortear sem repetir o resultado</button>
                    <button type="button" class="srt-acao srt-acao-laranja" id="btnAlterar">Alterar sorteio</button>
                    <button type="button" class="srt-acao srt-acao-branca" id="btnVoltar">Voltar para o Sorteador</button>
                </div>
            </section>

            {{-- ============ TEXTO (SEO) ============ --}}
            <section class="srt-texto" id="srtTexto">
                <h2>Sorteador online grátis</h2>
                <p>Sorteie <b>números</b>, <b>nomes</b> ou forme <b>equipes</b> na hora, sem cadastro. Serve para promoções, brincadeiras, divisão de times, amigo secreto e qualquer decisão que precise de imparcialidade.</p>

                <h3>Como funciona</h3>
                <ol>
                    <li><span class="srt-num">1</span> Escolha o tipo de sorteio: números, nomes ou equipes</li>
                    <li><span class="srt-num">2</span> Informe a quantidade, o intervalo ou cole a sua lista</li>
                    <li><span class="srt-num">3</span> Clique em "Sortear Agora" e veja o resultado instantâneo</li>
                </ol>

                <h3>Recursos</h3>
                <ul>
                    <li><span class="srt-check">✓</span> 100% gratuito e sem limite de participantes</li>
                    <li><span class="srt-check">✓</span> Importação de listas via arquivo CSV ou TXT</li>
                    <li><span class="srt-check">✓</span> Salvar o resultado e compartilhar por link</li>
                    <li><span class="srt-check">✓</span> Contagem regressiva e revelação ao clicar, para mais emoção</li>
                </ul>

                <h3>O sorteio é realmente aleatório?</h3>
                <p>Sim. Os sorteios de números, nomes e equipes usam o gerador aleatório do seu navegador (<code>crypto.getRandomValues</code>), o mesmo tipo usado em segurança. O sorteio entre participantes de campanha roda no servidor com <code>random_int()</code> e devolve um <b>código de conferência</b>, para que o resultado possa ser auditado depois.</p>
            </section>
        </div>
    </div>
</div>

<script>
(function () {
    'use strict';

    var ROTA_CAMPANHA = '{{ $temCampanha ? route('sorteador.participantes') : '' }}';
    var ROTA_SALVAR = '{{ route('sorteador.salvar') }}';
    var ROTA_BASE = '{{ route('sorteador') }}';
    var TOKEN = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
    var SALVO = {!! $salvoJson !!};

    var $ = function (id) { return document.getElementById(id); };
    var raiz = document.querySelector('.srt');

    /* ---------- aleatoriedade criptográfica ---------- */
    function inteiro(min, max) {
        var faixa = max - min + 1;
        if (faixa <= 1) return min;
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

    function escapar(s) {
        return String(s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function agora() {
        var d = new Date();
        var meses = ['jan.', 'fev.', 'mar.', 'abr.', 'mai.', 'jun.', 'jul.', 'ago.', 'set.', 'out.', 'nov.', 'dez.'];
        var p = function (n) { return (n < 10 ? '0' : '') + n; };
        return d.getDate() + ' de ' + meses[d.getMonth()] + ' de ' + d.getFullYear() + ', ' + p(d.getHours()) + ':' + p(d.getMinutes());
    }

    function alerta(msg) {
        if (window.Swal) { Swal.fire({ icon: 'warning', text: msg, confirmButtonColor: '#f97316' }); }
        else { alert(msg); }
    }

    /* ---------- abas / telas ---------- */
    var abas = raiz.querySelectorAll('.srt-nav [data-aba]');
    var abaAtual = 'numeros';

    function mostrarTela(id) {
        raiz.querySelectorAll('.srt-tela').forEach(function (t) { t.classList.toggle('is-ativa', t.id === id); });
    }

    function irParaAba(nome, semRolar) {
        if (!$('tela-' + nome)) nome = 'numeros';
        abaAtual = nome;
        abas.forEach(function (a) { a.classList.toggle('is-ativa', a.dataset.aba === nome); });
        mostrarTela('tela-' + nome);
        $('srtTexto').hidden = false;
        if (history.replaceState) history.replaceState(null, '', ROTA_BASE + (nome === 'numeros' ? '' : '#' + nome));
        if (!semRolar) window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    abas.forEach(function (a) { a.addEventListener('click', function () { irParaAba(a.dataset.aba); }); });

    /* acordeões */
    raiz.querySelectorAll('.srt-acordeao-btn').forEach(function (b) {
        b.addEventListener('click', function () { b.parentNode.classList.toggle('is-aberto'); });
    });

    /* plural dinâmico da frase */
    function plural(idCampo, idAlvo, sing, plu) {
        var f = function () { $(idAlvo).textContent = (parseInt($(idCampo).value) || 1) > 1 ? plu : sing; };
        $(idCampo).addEventListener('input', f); f();
    }
    plural('numQtd', 'numPlural', 'número', 'números');
    plural('nomeQtd', 'nomePlural', 'item', 'itens');
    if ($('campQtd')) plural('campQtd', 'campPlural', 'ganhador', 'ganhadores');

    /* ---------- listas (nomes / equipes) ---------- */
    function separador(nomeRadio) {
        var r = raiz.querySelector('input[name="' + nomeRadio + '"]:checked');
        return r ? r.value : 'auto';
    }

    function lerLista(idArea, nomeRadio, removerDup) {
        var texto = $(idArea).value;
        var modo = separador(nomeRadio);
        var re = { auto: /[\n,;]+/, linha: /\n+/, virgula: /,+/, pontovirgula: /;+/ }[modo] || /[\n,;]+/;
        var itens = texto.split(re).map(function (s) { return s.trim(); }).filter(Boolean);
        if (removerDup) {
            var vistos = {}, saida = [];
            itens.forEach(function (i) { var c = i.toLowerCase(); if (!vistos[c]) { vistos[c] = 1; saida.push(i); } });
            itens = saida;
        }
        return itens;
    }

    function contar(idArea, nomeRadio, idConta, sing, plu) {
        var f = function () {
            var n = lerLista(idArea, nomeRadio, false).length;
            $(idConta).textContent = n + ' ' + (n === 1 ? sing : plu);
        };
        $(idArea).addEventListener('input', f);
        raiz.querySelectorAll('input[name="' + nomeRadio + '"]').forEach(function (r) { r.addEventListener('change', f); });
        f();
        return f;
    }
    var contaNomes = contar('listaNomes', 'sepNomes', 'contaNomes', 'item na lista', 'itens na lista');
    var contaEquipes = contar('listaEquipes', 'sepEquipes', 'contaEquipes', 'participante', 'participantes');

    /* arquivo .txt / .csv */
    function zonaArquivo(idDrop, idArea, aoLer) {
        var zona = $(idDrop), entrada = zona.querySelector('input[type=file]');
        function carregar(arquivo) {
            if (!arquivo) return;
            if (arquivo.size > 2 * 1024 * 1024) return alerta('Arquivo muito grande (máximo 2 MB).');
            var leitor = new FileReader();
            leitor.onload = function () {
                var texto = String(leitor.result).replace(/\r/g, '');
                // CSV: uma coluna por linha → junta tudo em uma lista
                if (/\.csv$/i.test(arquivo.name)) texto = texto.replace(/,/g, '\n').replace(/;/g, '\n');
                $(idArea).value = texto.trim();
                aoLer();
                var ok = zona.querySelector('.srt-drop-ok');
                if (!ok) { ok = document.createElement('span'); ok.className = 'srt-drop-ok'; zona.appendChild(ok); }
                ok.textContent = '✓ ' + arquivo.name + ' carregado';
            };
            leitor.readAsText(arquivo, 'UTF-8');
        }
        entrada.addEventListener('change', function () { carregar(entrada.files[0]); entrada.value = ''; });
        ['dragenter', 'dragover'].forEach(function (ev) { zona.addEventListener(ev, function (e) { e.preventDefault(); zona.classList.add('is-sobre'); }); });
        ['dragleave', 'drop'].forEach(function (ev) { zona.addEventListener(ev, function (e) { e.preventDefault(); zona.classList.remove('is-sobre'); }); });
        zona.addEventListener('drop', function (e) { carregar(e.dataTransfer.files[0]); });
    }
    zonaArquivo('dropNomes', 'listaNomes', contaNomes);
    zonaArquivo('dropEquipes', 'listaEquipes', contaEquipes);

    /* ---------- contagem regressiva ---------- */
    function contagem(segundos) {
        return new Promise(function (resolver) {
            var caixa = document.createElement('div');
            caixa.className = 'srt-contagem';
            caixa.innerHTML = '<div class="srt-contagem-rotulo">Sorteando em...</div><div class="srt-contagem-num"></div>';
            document.body.appendChild(caixa);
            var num = caixa.querySelector('.srt-contagem-num');
            var n = segundos;
            var tic = function () {
                if (n <= 0) { caixa.remove(); resolver(); return; }
                num.textContent = n;
                num.style.animation = 'none'; void num.offsetWidth; num.style.animation = '';
                n--; setTimeout(tic, 1000);
            };
            tic();
        });
    }

    /* ---------- toast ---------- */
    function toast(titulo, texto) {
        var antigo = document.querySelector('.srt-toast'); if (antigo) antigo.remove();
        var t = document.createElement('div');
        t.className = 'srt-toast';
        t.innerHTML = '<div class="srt-toast-icone">✓</div><div><b>' + escapar(titulo) + '</b><p>' + escapar(texto) + '</p></div>' +
            '<button type="button" class="srt-toast-fechar" aria-label="Fechar">×</button>';
        document.body.appendChild(t);
        t.querySelector('.srt-toast-fechar').addEventListener('click', function () { t.remove(); });
        setTimeout(function () { if (t.parentNode) t.remove(); }, 7000);
    }

    /* ---------- resultado ---------- */
    var resultado = null;      // último resultado (mesma estrutura salva no servidor)
    var excluidos = [];        // acumulado do "sortear sem repetir"
    var textoCopia = '';

    function bola(conteudo, classe, oculto, indice) {
        return '<span class="srt-bola ' + (classe || '') + (oculto ? ' is-oculta' : '') + '" style="animation-delay:' + (indice * 70) + 'ms" data-valor="' + escapar(conteudo) + '">' +
            (oculto ? '?' : conteudo) + '</span>';
    }

    function info(rotulo, valor, larga, nota) {
        return '<div class="srt-info' + (larga ? ' srt-info-larga' : '') + '"><div class="srt-info-rotulo">' + rotulo + '</div>' +
            '<div class="srt-info-valor">' + valor + '</div>' + (nota ? '<div class="srt-info-nota">' + nota + '</div>' : '') + '</div>';
    }

    function renderizar(r, opcoes) {
        opcoes = opcoes || {};
        resultado = r;
        var corpo = $('resCorpo'), infos = $('resInfos');
        var html = '', linhas = [];

        if (r.tipo === 'numeros') {
            html = '<div class="srt-bolas">' + r.itens.map(function (n, i) { return bola(n, '', opcoes.ocultar, i); }).join('') + '</div>';
            infos.innerHTML = info('Data do Sorteio:', escapar(r.quando), true, '(GMT-3, Horário de Brasília)') +
                info('Quantidade Sorteada:', r.itens.length) + info('Sorteio entre', r.info.de + ' e ' + r.info.ate);
            linhas = ['🎲 Resultado do sorteio: ' + r.itens.join(', '), 'Sorteio de ' + r.itens.length + ' entre ' + r.info.de + ' e ' + r.info.ate];
        }

        if (r.tipo === 'nomes' || r.tipo === 'campanha') {
            html = '<div class="srt-bolas">' + r.itens.map(function (it, i) {
                var texto = typeof it === 'string' ? escapar(it) : escapar(it.nome) + '<small>cota ' + escapar(it.numero) + (it.telefone ? ' · ' + escapar(it.telefone) : '') + '</small>';
                return bola(texto, 'srt-bola-nome', opcoes.ocultar, i);
            }).join('') + '</div>';
            if (r.suplentes && r.suplentes.length) {
                html += '<div class="srt-suplentes"><div class="srt-suplentes-titulo">Suplentes</div><div class="srt-bolas">' +
                    r.suplentes.map(function (s, i) { return bola(escapar(s), 'srt-bola-nome', false, i + r.itens.length); }).join('') + '</div></div>';
            }
            var nomesTexto = r.itens.map(function (it) { return typeof it === 'string' ? it : it.nome + ' (cota ' + it.numero + ')'; });
            if (r.tipo === 'nomes') {
                infos.innerHTML = info('Data do Sorteio:', escapar(r.quando), true, '(GMT-3, Horário de Brasília)') +
                    info('Quantidade Sorteada:', r.itens.length) + info('Participantes na lista', r.info.total);
                linhas = ['🎁 Resultado do sorteio: ' + nomesTexto.join(', ')];
                if (r.suplentes && r.suplentes.length) linhas.push('Suplentes: ' + r.suplentes.join(', '));
                linhas.push('Sorteio de ' + r.itens.length + ' entre ' + r.info.total + ' participantes');
            } else {
                infos.innerHTML = info('Campanha', escapar(r.info.campanha), true) +
                    info('Data do Sorteio:', escapar(r.quando), true, '(GMT-3, Horário de Brasília)') +
                    info('Ganhadores', r.itens.length) + info('Cotas pagas', r.info.total) +
                    info('Código de conferência', '<span class="srt-info-codigo">' + escapar(r.info.codigo) + '</span>', true);
                linhas = ['🏆 ' + r.info.campanha, 'Ganhador(es): ' + nomesTexto.join(', '), 'Cotas pagas: ' + r.info.total, 'Código de conferência: ' + r.info.codigo];
            }
        }

        if (r.tipo === 'equipes') {
            html = '<div class="srt-times">' + r.times.map(function (t, i) {
                return '<div class="srt-time" style="animation-delay:' + (i * 90) + 'ms"><div class="srt-time-nome">Equipe ' + (i + 1) + '</div><ol>' +
                    t.map(function (p) { return '<li>' + escapar(p) + '</li>'; }).join('') + '</ol></div>';
            }).join('') + '</div>';
            infos.innerHTML = info('Data do Sorteio:', escapar(r.quando), true, '(GMT-3, Horário de Brasília)') +
                info('Equipes formadas', r.times.length) + info('Participantes', r.info.total);
            linhas = ['👥 Equipes sorteadas:'].concat(r.times.map(function (t, i) { return 'Equipe ' + (i + 1) + ': ' + t.join(', '); }));
        }

        corpo.innerHTML = html;
        linhas.push('Sorteado em ' + r.quando + (r.url ? '\n' + r.url : ''));
        textoCopia = linhas.join('\n');

        $('resTitulo').textContent = r.tipo === 'equipes' ? 'Equipes Sorteadas:' : (r.tipo === 'campanha' ? 'Ganhador(es) da Campanha:' : 'Resultado do Sorteio:');

        // revelar ao clicar
        corpo.querySelectorAll('.srt-bola.is-oculta').forEach(function (b) {
            b.addEventListener('click', function () {
                b.classList.remove('is-oculta'); b.classList.add('is-revelada');
                b.innerHTML = b.dataset.valor;
            }, { once: true });
        });

        // modo "salvo": link permanente, sem botão de salvar/sem repetir
        var salvoCaixa = $('resSalvo');
        if (r.url) {
            salvoCaixa.hidden = false;
            salvoCaixa.innerHTML = caixaSalvo(r.url, opcoes.recemSalvo);
            $('btnSalvar').hidden = true;
            $('btnSemRepetir').hidden = !!opcoes.somenteLeitura;
            $('btnAlterar').hidden = !!opcoes.somenteLeitura;
            $('btnVoltar').textContent = opcoes.somenteLeitura ? 'Fazer um novo sorteio' : 'Voltar para o Sorteador';
        } else {
            salvoCaixa.hidden = true; salvoCaixa.innerHTML = '';
            $('btnSalvar').hidden = false; $('btnSalvar').disabled = false; $('btnSalvar').textContent = 'Salvar este resultado';
            $('btnSemRepetir').hidden = false; $('btnAlterar').hidden = false;
            $('btnVoltar').textContent = 'Voltar para o Sorteador';
        }

        abas.forEach(function (a) { a.classList.toggle('is-ativa', a.dataset.aba === r.tipo); });
        mostrarTela('tela-resultado');
        $('srtTexto').hidden = true;
        window.scrollTo({ top: 0, behavior: 'smooth' });
        if (!opcoes.silencioso) toast('Aqui está seu sorteio!', opcoes.ocultar ? 'Toque em cada item para revelar o resultado! 👆' : 'Lembre-se de salvar o seu sorteio se precisar compartilhar o resultado! 😉');
    }

    function caixaSalvo(url, recem) {
        var zap = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(textoCopia);
        return '<div class="srt-salvo"><div class="srt-salvo-titulo">' + (recem ? '✓ Resultado salvo! Este é o link permanente:' : '🔗 Resultado salvo — link permanente') + '</div>' +
            '<a class="srt-salvo-link" href="' + escapar(url) + '">' + escapar(url) + '</a>' +
            '<div class="srt-salvo-acoes"><button type="button" class="srt-acao srt-acao-laranja" id="btnCopiarLink">Copiar link</button>' +
            '<a class="srt-acao srt-acao-zap" href="' + zap + '" target="_blank" rel="noopener">WhatsApp</a></div></div>';
    }

    function copiar(texto, botao, rotuloOk, rotuloPadrao) {
        var ok = function () { botao.textContent = rotuloOk; setTimeout(function () { botao.textContent = rotuloPadrao; }, 1800); };
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(texto).then(ok, function () { copiarAntigo(texto); ok(); });
        } else { copiarAntigo(texto); ok(); }
    }

    function copiarAntigo(texto) {
        var t = document.createElement('textarea');
        t.value = texto; t.style.position = 'fixed'; t.style.opacity = '0';
        document.body.appendChild(t); t.select();
        try { document.execCommand('copy'); } catch (e) { }
        document.body.removeChild(t);
    }

    $('btnCopiar').addEventListener('click', function () { copiar(textoCopia, this, '✓ Copiado!', 'Copiar para Área de Transferência'); });
    document.addEventListener('click', function (e) {
        if (e.target && e.target.id === 'btnCopiarLink') copiar(resultado.url, e.target, '✓ Link copiado!', 'Copiar link');
    });

    /* ---------- sorteios ---------- */
    function sortearNumeros(excluir) {
        var qtd = parseInt($('numQtd').value) || 1;
        var de = parseInt($('numDe').value), ate = parseInt($('numAte').value);
        var repetir = $('numRepetir').checked, ordenar = $('numOrdenar').checked;
        if (isNaN(de) || isNaN(ate)) return alerta('Preencha o intervalo de números.');
        if (de > ate) { var t = de; de = ate; ate = t; $('numDe').value = de; $('numAte').value = ate; }
        if (qtd < 1) qtd = 1;
        if (qtd > 1000) return alerta('O máximo é 1000 números por sorteio.');

        var res = [];
        if (repetir) {
            for (var i = 0; i < qtd; i++) res.push(inteiro(de, ate));
        } else {
            var faixa = ate - de + 1;
            var excl = {}; (excluir || []).forEach(function (n) { excl[n] = 1; });
            var disponiveis = faixa - Object.keys(excl).length;
            if (qtd > disponiveis) {
                return alerta(excluir && excluir.length
                    ? 'Não sobraram números suficientes para sortear ' + qtd + ' sem repetir os anteriores.'
                    : 'Você pediu ' + qtd + ' números, mas entre ' + de + ' e ' + ate + ' só existem ' + faixa + '. Aumente o intervalo ou permita repetição.');
            }
            if (faixa <= 200000) {
                var pool = [];
                for (var n = de; n <= ate; n++) if (!excl[n]) pool.push(n);
                res = embaralhar(pool).slice(0, qtd);
            } else {
                var usados = {};
                while (res.length < qtd) { var v = inteiro(de, ate); if (!usados[v] && !excl[v]) { usados[v] = 1; res.push(v); } }
            }
        }
        if (ordenar) res.sort(function (a, b) { return a - b; });

        return { tipo: 'numeros', itens: res, info: { de: de, ate: ate, qtd: qtd }, quando: agora() };
    }

    function sortearNomes(excluir) {
        var lista = lerLista('listaNomes', 'sepNomes', $('nomeDuplicados').checked);
        var qtd = parseInt($('nomeQtd').value) || 1;
        if (excluir && excluir.length) {
            var ex = {}; excluir.forEach(function (n) { ex[String(n).toLowerCase()] = 1; });
            lista = lista.filter(function (n) { return !ex[n.toLowerCase()]; });
        }
        if (lista.length < 1) return alerta('Escreva ou cole pelo menos um item na lista.');
        if (lista.length < 2 && !excluir) return alerta('Coloque pelo menos 2 itens na lista para sortear.');
        if (qtd > lista.length) return alerta(excluir && excluir.length
            ? 'Não sobraram itens suficientes para sortear ' + qtd + ' sem repetir os anteriores.'
            : 'Você pediu ' + qtd + ' itens, mas a lista só tem ' + lista.length + '.');

        var mix = embaralhar(lista.slice());
        var ganhadores = mix.slice(0, qtd);
        var suplentes = $('nomeSuplentes').checked ? mix.slice(qtd, qtd + 3) : [];
        if ($('nomeOrdenar').checked) ganhadores.sort(function (a, b) { return a.localeCompare(b, 'pt-BR'); });

        return { tipo: 'nomes', itens: ganhadores, suplentes: suplentes, info: { total: lista.length, qtd: qtd }, quando: agora() };
    }

    function sortearEquipes() {
        var lista = lerLista('listaEquipes', 'sepEquipes', $('eqDuplicados').checked);
        var n = parseInt($('eqQtd').value) || 2;
        var modo = $('eqModo').value;
        if (lista.length < 2) return alerta('Informe pelo menos 2 participantes.');
        var qtdTimes = modo === 'por' ? Math.ceil(lista.length / Math.max(1, n)) : n;
        if (qtdTimes < 1) qtdTimes = 1;
        if (qtdTimes > lista.length) return alerta('Há menos participantes (' + lista.length + ') do que equipes (' + qtdTimes + ').');

        var mix = embaralhar(lista.slice());
        var times = [];
        for (var i = 0; i < qtdTimes; i++) times.push([]);
        mix.forEach(function (p, i) { times[i % qtdTimes].push(p); });
        if ($('eqOrdenar').checked) times.forEach(function (t) { t.sort(function (a, b) { return a.localeCompare(b, 'pt-BR'); }); });

        return { tipo: 'equipes', times: times, info: { total: lista.length, equipes: qtdTimes, modo: modo, n: n }, quando: agora() };
    }

    function sortearCampanha() {
        var botao = $('tela-campanha').querySelector('.srt-botao');
        botao.disabled = true; botao.textContent = 'Sorteando...';
        return fetch(ROTA_CAMPANHA, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': TOKEN },
            body: JSON.stringify({ campanha: $('campanhaId').value, quantidade: $('campQtd').value })
        }).then(function (r) { return r.json(); }).then(function (r) {
            if (!r.ok) { alerta(r.msg || 'Não foi possível sortear.'); return null; }
            return { tipo: 'campanha', itens: r.sorteados, info: { campanha: r.campanha, total: r.total, codigo: r.codigo, qtd: r.sorteados.length }, quando: r.quando };
        }).catch(function () { alerta('Falha ao falar com o servidor.'); return null; })
            .then(function (r) { botao.disabled = false; botao.textContent = 'Sortear Ganhador'; return r; });
    }

    function executar(tipo, excluir) {
        var usaContagem = { numeros: 'numContagem', nomes: 'nomeContagem', equipes: 'eqContagem', campanha: 'campContagem' }[tipo];
        var usaOcultar = { numeros: 'numClicar', nomes: 'nomeClicar', campanha: 'campClicar' }[tipo];
        var ocultar = !!(usaOcultar && $(usaOcultar) && $(usaOcultar).checked);
        var comContagem = !!(usaContagem && $(usaContagem) && $(usaContagem).checked);

        var pronto;
        if (tipo === 'numeros') pronto = Promise.resolve(sortearNumeros(excluir));
        else if (tipo === 'nomes') pronto = Promise.resolve(sortearNomes(excluir));
        else if (tipo === 'equipes') pronto = Promise.resolve(sortearEquipes());
        else pronto = sortearCampanha();

        pronto.then(function (r) {
            if (!r) return;
            var mostrar = function () { renderizar(r, { ocultar: ocultar }); };
            if (comContagem) contagem(3).then(mostrar); else mostrar();
        });
    }

    raiz.querySelectorAll('form.srt-tela').forEach(function (f) {
        f.addEventListener('submit', function (e) { e.preventDefault(); excluidos = []; executar(f.dataset.tipo); });
    });

    /* ---------- ações do resultado ---------- */
    $('btnSemRepetir').addEventListener('click', function () {
        if (!resultado) return;
        if (resultado.tipo === 'numeros' || resultado.tipo === 'nomes') {
            excluidos = excluidos.concat(resultado.itens);
            executar(resultado.tipo, excluidos);
        } else {
            executar(resultado.tipo);
        }
    });

    $('btnAlterar').addEventListener('click', function () { irParaAba(resultado ? resultado.tipo : 'numeros'); });

    $('btnVoltar').addEventListener('click', function () {
        excluidos = [];
        if (resultado && resultado.url && location.pathname !== new URL(ROTA_BASE, location.href).pathname) { location.href = ROTA_BASE; return; }
        irParaAba('numeros');
    });

    $('btnSalvar').addEventListener('click', function () {
        if (!resultado || resultado.url) return;
        var b = this; b.disabled = true; b.textContent = 'Salvando...';
        fetch(ROTA_SALVAR, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': TOKEN },
            body: JSON.stringify({ resultado: resultado })
        }).then(function (r) { return r.json(); }).then(function (r) {
            if (!r.ok) { alerta(r.msg || 'Não foi possível salvar.'); b.disabled = false; b.textContent = 'Salvar este resultado'; return; }
            resultado.url = r.url;
            resultado.codigo = r.codigo;
            renderizar(resultado, { silencioso: true, recemSalvo: true });
            toast('Resultado salvo!', 'Agora é só copiar o link e compartilhar com os participantes.');
        }).catch(function () { alerta('Falha ao falar com o servidor.'); b.disabled = false; b.textContent = 'Salvar este resultado'; });
    });

    /* ---------- estado inicial ---------- */
    if (SALVO) {
        renderizar(SALVO, { silencioso: true, somenteLeitura: true });
    } else {
        var h = (location.hash || '').replace('#', '');
        if (h && $('tela-' + h)) irParaAba(h, true);
    }
})();
</script>
