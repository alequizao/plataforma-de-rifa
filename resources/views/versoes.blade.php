{{--
    Histórico de versões — Plataforma de Rifa
    Desenvolvido por @alequizao · alequizao.dev@gmail.com
--}}
@extends('layouts.admin')

@section('content')
    <div class="container-fluid ver" style="max-width:900px">

        <header class="ver-capa">
            <div>
                <h1>🕒 Versões</h1>
                <p>Tudo o que mudou no sistema, da mais recente para a mais antiga.</p>
            </div>
            <div class="ver-atual">
                <small>versão atual</small>
                <b>{{ $atual }}</b>
                <span>{{ date('d/m/Y', strtotime($dataAtual)) }}</span>
            </div>
        </header>

        <div class="ver-legenda">
            <span class="et novo">novo</span> recurso novo
            <span class="et corrigido">corrigido</span> correção de problema
            <span class="et melhoria">melhoria</span> ajuste ou otimização
        </div>

        <div class="ver-linha">
            @foreach ($historico as $v)
                @php
                    $conta = ['novo' => 0, 'corrigido' => 0, 'melhoria' => 0];
                    foreach ($v['itens'] as $i) {
                        if (isset($conta[$i['tipo']])) { $conta[$i['tipo']]++; }
                    }
                @endphp

                <article class="ver-item {{ $loop->first ? 'atual' : '' }}">
                    <div class="ver-bolinha"></div>

                    <div class="ver-card">
                        <div class="ver-cab">
                            <h2>
                                {{ $v['versao'] }}
                                @if ($loop->first)<span class="tag-atual">atual</span>@endif
                            </h2>
                            <time>{{ date('d/m/Y', strtotime($v['data'])) }}</time>
                        </div>

                        <p class="ver-titulo">{{ $v['titulo'] }}</p>

                        <div class="ver-resumo">
                            @if ($conta['novo'])<span class="et novo">{{ $conta['novo'] }} novidade(s)</span>@endif
                            @if ($conta['corrigido'])<span class="et corrigido">{{ $conta['corrigido'] }} correção(ões)</span>@endif
                            @if ($conta['melhoria'])<span class="et melhoria">{{ $conta['melhoria'] }} melhoria(s)</span>@endif
                        </div>

                        <ul class="ver-lista">
                            @foreach ($v['itens'] as $i)
                                <li>
                                    <span class="et {{ $i['tipo'] }}">{{ $i['tipo'] }}</span>
                                    {{ $i['txt'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </article>
            @endforeach
        </div>

        <footer class="ver-rodape">
            Desenvolvido por
            <a href="https://instagram.com/alequizao" target="_blank" rel="noopener">@alequizao</a> ·
            <a href="https://wa.me/5582988717072" target="_blank" rel="noopener">(82) 98871-7072</a> ·
            <a href="mailto:alequizao.dev@gmail.com">alequizao.dev@gmail.com</a>
        </footer>
    </div>

    <style>
        .ver { padding: 18px 14px 60px; color: #252831; }

        .ver-capa {
            background: linear-gradient(135deg, #00307a, #0a4ba8); color: #fff;
            border-radius: 16px; padding: 22px; margin-bottom: 16px;
            display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;
        }
        .ver-capa h1 { margin: 0 0 4px; font-size: 1.5rem; font-weight: 700; }
        .ver-capa p { margin: 0; opacity: .85; font-size: .9rem; }
        .ver-atual {
            background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.2);
            border-radius: 12px; padding: 10px 18px; text-align: center; line-height: 1.25;
        }
        .ver-atual small { display: block; font-size: 10px; text-transform: uppercase; opacity: .7; letter-spacing: .06em; }
        .ver-atual b { display: block; font-size: 1.35rem; }
        .ver-atual span { font-size: 11px; opacity: .75; }

        .ver-legenda {
            font-size: 12px; color: #8a90a6; margin-bottom: 16px;
            display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
        }

        .et {
            display: inline-block; border-radius: 999px; padding: 2px 9px;
            font-size: 10.5px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .03em; margin-right: 4px; white-space: nowrap;
        }
        .et.novo      { background: #e3f2ff; color: #0a4ba8; }
        .et.corrigido { background: #ffe9e9; color: #b02a37; }
        .et.melhoria  { background: #eafaf1; color: #146c43; }

        .ver-linha { position: relative; padding-left: 26px; }
        .ver-linha::before {
            content: ""; position: absolute; left: 7px; top: 6px; bottom: 6px;
            width: 2px; background: #e3e6ef;
        }

        .ver-item { position: relative; margin-bottom: 16px; }
        .ver-bolinha {
            position: absolute; left: -26px; top: 18px; width: 16px; height: 16px;
            border-radius: 50%; background: #fff; border: 3px solid #c8cddb;
        }
        .ver-item.atual .ver-bolinha { border-color: #00307a; box-shadow: 0 0 0 4px rgba(0,48,122,.12); }

        .ver-card {
            background: #fff; border: 1px solid #e9ecf2; border-radius: 14px; padding: 18px;
        }
        .ver-item.atual .ver-card { border-color: #c9d8f0; box-shadow: 0 6px 20px rgba(0,48,122,.07); }

        .ver-cab { display: flex; align-items: baseline; justify-content: space-between; gap: 10px; }
        .ver-cab h2 { font-size: 1.15rem; font-weight: 700; margin: 0; }
        .ver-cab time { font-size: 12px; color: #8a90a6; white-space: nowrap; }
        .tag-atual {
            background: #00307a; color: #fff; font-size: 10px; font-weight: 700;
            border-radius: 999px; padding: 2px 8px; text-transform: uppercase;
            vertical-align: middle; margin-left: 6px;
        }

        .ver-titulo { font-size: .95rem; color: #545a6b; margin: 4px 0 10px; }
        .ver-resumo { margin-bottom: 12px; }

        .ver-lista { list-style: none; padding: 0; margin: 0; }
        .ver-lista li {
            font-size: .88rem; line-height: 1.5; color: #3b4152;
            padding: 7px 0; border-top: 1px solid #f2f4f8;
        }
        .ver-lista li:first-child { border-top: 0; }

        .ver-rodape { text-align: center; color: #8a90a6; font-size: 13px; padding-top: 18px; }
        .ver-rodape a { color: #00307a; font-weight: 600; }

        @media (max-width: 600px) {
            .ver-capa { flex-direction: column; align-items: flex-start; }
        }
    </style>
@endsection
