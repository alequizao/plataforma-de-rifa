@extends('layouts.admin')

@section('content')
    <div class="container mt-3" style="max-width:100%">
        <div class="row mb-3">
            <div class="col d-flex justify-content-center">
                <h2>🎨 Aparência <b>do site</b></h2>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('aparencia.salvar') }}" method="POST" id="formAparencia">
            @csrf
            <input type="hidden" name="restaurar" id="restaurar" value="0">

            <div class="row">
                {{-- ============ CONTROLES ============ --}}
                <div class="col-lg-7">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="mb-3">Tema</h5>
                            <div class="d-flex flex-wrap" style="gap:10px">
                                @foreach (['light' => '☀️ Claro', 'dark' => '🌙 Escuro'] as $valor => $rotulo)
                                    <label class="opcao-tema {{ $config->tema == $valor ? 'ativa' : '' }}">
                                        <input type="radio" name="tema" value="{{ $valor }}"
                                            {{ $config->tema == $valor ? 'checked' : '' }} hidden>
                                        {{ $rotulo }}
                                    </label>
                                @endforeach
                            </div>
                            <p class="text-muted mt-2 mb-0" style="font-size:12.5px">
                                O tema escuro inverte fundo, cards e texto automaticamente — a menos que
                                você defina cores próprias abaixo.
                            </p>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="mb-3">Cores</h5>

                            @php
                                $cores = [
                                    'cor_primaria' => ['Primária', 'Cabeçalho, botões e chips'],
                                    'cor_cta'      => ['Botão de compra', 'O verde do "Garantir números"'],
                                    'cor_fundo'    => ['Fundo da página', 'Atrás dos cards'],
                                    'cor_card'     => ['Cards', 'Fundo dos blocos brancos'],
                                    'cor_texto'    => ['Texto', 'Títulos e descrições'],
                                    'cor_barra'    => ['Barra escura', 'Faixa "Meus títulos"'],
                                    'cor_destaque' => ['Destaque', 'Ícones e detalhes no cabeçalho'],
                                ];
                            @endphp

                            @foreach ($cores as $campo => $info)
                                <div class="linha-cor">
                                    <input type="color" name="{{ $campo }}" id="{{ $campo }}"
                                        value="{{ $config->$campo ?: $padrao[$campo] }}"
                                        data-var="{{ $campo }}">
                                    <div class="linha-cor-txt">
                                        <b>{{ $info[0] }}</b>
                                        <small>{{ $info[1] }}</small>
                                    </div>
                                    <code class="linha-cor-hex">{{ $config->$campo ?: $padrao[$campo] }}</code>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="mb-3">Tipografia e cantos</h5>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label style="font-size:13px"><b>Fonte</b></label>
                                    <select name="fonte_site" id="fonte_site" class="form-control">
                                        @foreach (['Montserrat', 'Inter', 'Poppins', 'Roboto', 'Open Sans', 'Nunito', 'Lato', 'Rubik'] as $f)
                                            <option value="{{ $f }}"
                                                {{ ($config->fonte_site ?: 'Montserrat') == $f ? 'selected' : '' }}>
                                                {{ $f }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label style="font-size:13px"><b>Cantos arredondados</b></label>
                                    <select name="raio_borda" id="raio_borda" class="form-control">
                                        @foreach (['0px' => 'Reto', '6px' => 'Suave', '10px' => 'Padrão', '16px' => 'Bem redondo'] as $v => $r)
                                            <option value="{{ $v }}"
                                                {{ ($config->raio_borda ?: '10px') == $v ? 'selected' : '' }}>
                                                {{ $r }} ({{ $v }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap" style="gap:8px">
                        <button type="submit" class="btn btn-success">💾 Salvar aparência</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnRestaurar">
                            ↺ Restaurar padrão
                        </button>
                        <a href="{{ route('inicio') }}" target="_blank" class="btn btn-outline-primary">
                            🔗 Ver o site
                        </a>
                    </div>
                </div>

                {{-- ============ PRÉVIA AO VIVO ============ --}}
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Prévia ao vivo</h5>
                            <div class="previa" id="previa">
                                <div class="previa-header">
                                    <span class="previa-menu">☰</span>
                                    <span class="previa-logo">SUA LOGO</span>
                                    <span class="previa-suporte">Suporte</span>
                                </div>
                                <div class="previa-nav"><span class="previa-nav-on">✦ Campanhas</span>
                                    <span>Meus títulos</span>
                                </div>
                                <div class="previa-corpo">
                                    <div class="previa-titulo">⚡ Campanhas <small>Escolha sua sorte</small></div>
                                    <div class="previa-card">
                                        <div class="previa-img">imagem do prêmio</div>
                                        <div class="previa-card-txt">
                                            <b>Edição 001 — Carro 0km</b>
                                            <small>1x Veículo 2026</small>
                                        </div>
                                        <div class="previa-cta">➜ GARANTIR MEUS NÚMEROS</div>
                                    </div>
                                    <div class="previa-barra">🛒 Meus títulos</div>
                                </div>
                            </div>
                            <p class="text-muted mt-2 mb-0" style="font-size:12px">
                                A prévia muda enquanto você escolhe. As alterações só valem no site
                                depois de <b>salvar</b>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        .opcao-tema {
            border: 2px solid #dfe3ec; border-radius: 10px; padding: 10px 18px;
            cursor: pointer; font-weight: 600; margin: 0; transition: all .15s;
        }
        .opcao-tema.ativa { border-color: #198754; background: #eafaf1; }

        .linha-cor {
            display: flex; align-items: center; gap: 12px;
            padding: 8px 0; border-bottom: 1px solid #f0f2f5;
        }
        .linha-cor:last-child { border-bottom: 0; }
        .linha-cor input[type=color] {
            width: 46px; height: 34px; border: 1px solid #dfe3ec;
            border-radius: 8px; padding: 2px; cursor: pointer; background: #fff;
        }
        .linha-cor-txt { flex: 1 1 auto; line-height: 1.2; }
        .linha-cor-txt small { display: block; color: #8a90a6; font-size: 12px; }
        .linha-cor-hex { font-size: 12px; color: #8a90a6; }

        /* prévia */
        .previa {
            border-radius: 12px; overflow: hidden; border: 1px solid #dfe3ec;
            font-family: var(--pv-fonte, Montserrat), sans-serif;
        }
        .previa-header {
            background: var(--pv-primaria); color: #fff; display: flex;
            align-items: center; justify-content: space-between; padding: 12px 14px; font-size: 13px;
        }
        .previa-logo { font-weight: 800; letter-spacing: .5px; }
        .previa-suporte { color: var(--pv-destaque); font-size: 11px; }
        .previa-nav {
            background: var(--pv-primaria); color: rgba(255,255,255,.65);
            display: flex; gap: 14px; padding: 0 14px 12px; font-size: 12px;
        }
        .previa-nav-on { color: #fff; font-weight: 600; }
        .previa-corpo {
            background: var(--pv-fundo); padding: 14px 12px 18px;
            border-radius: 16px 16px 0 0; margin-top: -6px;
        }
        .previa-titulo { color: var(--pv-texto); font-weight: 600; font-size: 14px; margin-bottom: 8px; }
        .previa-titulo small { color: var(--pv-texto); opacity: .6; font-weight: 400; }
        .previa-card {
            background: var(--pv-card); border-radius: var(--pv-raio); overflow: hidden; margin-bottom: 10px;
        }
        .previa-img {
            height: 90px; display: flex; align-items: center; justify-content: center;
            background: repeating-linear-gradient(45deg, #d9dde6, #d9dde6 8px, #e6e9f0 8px, #e6e9f0 16px);
            color: #7b8194; font-size: 11px;
        }
        .previa-card-txt { padding: 8px 10px 4px; color: var(--pv-texto); font-size: 13px; }
        .previa-card-txt small { display: block; opacity: .6; font-size: 11px; }
        .previa-cta {
            margin: 8px 10px 10px; background: var(--pv-cta); color: #fff; text-align: center;
            padding: 10px; border-radius: var(--pv-raio); font-size: 12px; font-weight: 700;
        }
        .previa-barra {
            background: var(--pv-barra); color: #fff; text-align: center;
            padding: 9px; font-size: 12px; font-weight: 600; border-radius: 8px;
        }
    </style>

    <script>
        (function () {
            var previa = document.getElementById('previa');
            var mapa = {
                cor_primaria: '--pv-primaria',
                cor_cta: '--pv-cta',
                cor_fundo: '--pv-fundo',
                cor_card: '--pv-card',
                cor_texto: '--pv-texto',
                cor_barra: '--pv-barra',
                cor_destaque: '--pv-destaque'
            };

            function aplicar() {
                Object.keys(mapa).forEach(function (campo) {
                    var el = document.getElementById(campo);
                    if (!el) return;
                    previa.style.setProperty(mapa[campo], el.value);
                    var hex = el.closest('.linha-cor').querySelector('.linha-cor-hex');
                    if (hex) hex.textContent = el.value;
                });
                previa.style.setProperty('--pv-fonte', document.getElementById('fonte_site').value);
                previa.style.setProperty('--pv-raio', document.getElementById('raio_borda').value);
            }

            Object.keys(mapa).forEach(function (campo) {
                var el = document.getElementById(campo);
                if (el) el.addEventListener('input', aplicar);
            });
            document.getElementById('fonte_site').addEventListener('change', function () {
                aplicar();
                carregarFonte(this.value);
            });
            document.getElementById('raio_borda').addEventListener('change', aplicar);

            // tema claro/escuro: destaca a opção e ajusta a prévia
            document.querySelectorAll('.opcao-tema').forEach(function (l) {
                l.addEventListener('click', function () {
                    document.querySelectorAll('.opcao-tema').forEach(function (x) { x.classList.remove('ativa'); });
                    l.classList.add('ativa');
                    l.querySelector('input').checked = true;

                    var escuro = l.querySelector('input').value === 'dark';
                    var padraoClaro = { cor_fundo: '#e4e4e4', cor_card: '#ffffff', cor_texto: '#171717' };
                    var padraoEscuro = { cor_fundo: '#0d0f16', cor_card: '#1b1f2a', cor_texto: '#eef1f8' };
                    var de = escuro ? padraoClaro : padraoEscuro;
                    var para = escuro ? padraoEscuro : padraoClaro;

                    Object.keys(de).forEach(function (c) {
                        var el = document.getElementById(c);
                        if (el && el.value.toLowerCase() === de[c]) el.value = para[c];
                    });
                    aplicar();
                });
            });

            function carregarFonte(nome) {
                var id = 'fonte-previa';
                var link = document.getElementById(id);
                if (!link) {
                    link = document.createElement('link');
                    link.id = id; link.rel = 'stylesheet';
                    document.head.appendChild(link);
                }
                link.href = 'https://fonts.googleapis.com/css2?family=' +
                    nome.replace(/ /g, '+') + ':wght@400;600;800&display=swap';
            }

            document.getElementById('btnRestaurar').addEventListener('click', function () {
                if (!confirm('Restaurar todas as cores e o tema para o padrão?')) return;
                document.getElementById('restaurar').value = '1';
                document.getElementById('formAparencia').submit();
            });

            carregarFonte(document.getElementById('fonte_site').value);
            aplicar();
        })();
    </script>
@endsection
