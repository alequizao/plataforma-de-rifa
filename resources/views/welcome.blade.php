@extends('layouts.app')

<link rel="manifest" href="/manifest.json">
<script type="text/javascript" src="sw.js"></script>
<script>
    // tema (light/dark) controlado pelos tokens do tema-gemeos.css
    document.addEventListener('DOMContentLoaded', function() {
        @if (@$config->tema == 'dark')
            document.body.classList.add('tema-dark');
        @endif
    });
</script>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script>
    $(function(e) {
        // if (isIOS()) {
        //     $('#app-main').attr('style', 'margin-top: 100px !important');
        // }
    })

    function isIOS() {
        var ua = navigator.userAgent.toLowerCase();

        //Lista de dispositivos que acessar
        var iosArray = ['iphone', 'ipod'];

        var isApple = false;

        if (ua.includes('iphone') || ua.includes('ipod')) {
            isApple = true
        }

        return isApple;
    }

    function duvidas() {
        window.open('https://api.whatsapp.com/send?phone={{ $user->telephone }}', '_blank');
    }

    function verRifa(route) {
        window.location.href = route
    }
</script>


<style>
    

    @media only screen and (-webkit-min-device-pixel-ratio: 1) {

        ::i-block-chrome,
        .app-main {
            margin-top: 100px !important;
        }
    }

    .app-main {
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
        max-width: 600px;
        margin-top: 40px;
        margin-bottom: 50px;
        border-bottom-right-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .app-main a {
        text-decoration: none;
    }

    .app-main a:hover {
        text-decoration: none;
    }

    .app-title {
        display: flex;
        align-items: self-end;
        padding-bottom: 10px;
    }

    .app-title h1 {
        color: rgba(0, 0, 0, .9);
        padding-right: 5px;
        font-weight: 600;
        font-size: 1.3em;
        margin: 0;
        padding-top: 10px;
    }

    .app-title .app-title-desc {
        color: rgba(0, 0, 0, .5);
        padding-top: 6px;
        font-size: .9em;
    }


    /* *************************************************************** */
    /* Card Rifa em Destaque */
    /* *************************************************************** */
    .rifas {
        background: #e4e4e4;
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
        position: absolute;
        border-bottom-right-radius: 20px;
        border-bottom-left-radius: 20px;
        min-height: 100vh;
    }

    .rifa-dark {
        background-color: #383838;
    }

    .card-rifa-destaque .img-rifa-destaque img {
        width: 100%;
        height: 290px;
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
    }

    .card-rifa-destaque {
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
        padding-bottom: 10px;
        background: #fff;
        margin-bottom: 10px;
        border-bottom-right-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .title-rifa-destaque {
        padding-top: 5px;
        padding-left: 10px;
    }

    .title-rifa-destaque h1 {
        color: #202020;
        -webkit-line-clamp: 2 !important;
        margin-bottom: 1px;
        font-weight: 500;
        font-size: 1em;
    }

    .title-rifa-destaque p {
        color: rgba(0, 0, 0, .7);
        font-size: .75em;
        max-width: 96%;
        margin: 0;
    }

    /* *************************************************************** */


    /* *************************************************************** */
    /* Card Rifa Normal */
    /* *************************************************************** */
    .card-rifa img {
        width: 100px;
        height: 100px;
        border-radius: 10px;
    }

    .card-rifa {
        background: #fff;
        padding: 5px;
        margin-bottom: 10px;
        border-radius: 10px;
        display: flex
    }

    .title-rifa {
        margin-left: 15px;
        width: 100%;
    }

    .blink {
        margin-top: 5px;
        animation: animate 1.5s linear infinite;
    }



    @keyframes animate {
        0% {
            opacity: 0;
        }

        50% {
            opacity: 0.7;
        }

        100% {
            opacity: 0;
        }
    }
</style>


@section('content')
    <style>
        .duvida {
            background-color: #ffffff5e;
            border-radius: 10px;
            height: 60px;
            align-items: center;
            justify-content: center;
            margin-top: 7px;
            cursor: pointer;
        }

        .icone-duvidas {
            width: 50px;
            justify-content: center;
            align-items: center;
            background-color: #b9b9b9;
            height: 35px;
            border-radius: 10px;
            text-align: center;
            font-size: 20px;
        }

        .text-duvidas {
            display: flex !important;
            flex-direction: column;
            justify-content: center
        }

        .f-15 {
            font-size: 15px;
        }

        .f-12 {
            font-size: 12px;
        }

        .data-sorteio {
            /* float: right; */
            padding-right: 10px;
            font-weight: thin;
            text-align: center;
            /* margin-top: 10px; */
            color: #000;
        }

        .rifas.dark {
            background: #383838;
        }

        .app-title.dark h1 {
            color: #fff;
        }

        .app-title-desc.dark {
            color: #fff;
        }

        .card-rifa-destaque.dark {
            background: #222222;
        }

        .title-rifa-destaque.dark h1 {
            color: #fff;
        }

        .title-rifa-destaque.dark p {
            color: #fff;
        }

        .card-rifa.dark {
            background: #222222;
        }

        .text-duvidas.dark h6 {
            color: #fff;
        }

        .text-duvidas.dark p {
            color: #fff !important;
        }

        .data-sorteio.dark {
            color: #fff !important;
        }

        .app-title.dark {
            color: #fff;
        }
    </style>

    <div class="container app-main" id="app-main">

        <div class="row justify-content-center">
            <div class="col-md-6 col-12 rifas {{ $config->tema }}">
                <div class="app-title {{ $config->tema }}">
                    <h1>⚡ Campanhas</h1>
                    <div class="app-title-desc {{ $config->tema }}">Escolha sua sorte</div>
                </div>

                {{-- Rifa em destaque --}}
                @foreach ($products->where('favoritar', '=', 1) as $product)
                    <div class="card-rifa-destaque {{ $config->tema }}">
                        <div class="img-rifa-destaque">
                            <a href="{{ route('product', ['slug' => $product->slug]) }}">
                                <img src="/products/{{ $product->imagem()->name }}" alt="{{ $product->name }}" loading="lazy" decoding="async">
                            </a>
                            <div class="infos-flutuante">
                                <div>{!! $product->status() !!}</div>
                                @if ($product->draw_date)
                                    <span class="badge bg-dark bg-opacity-50 font-xsss">
                                        Sorteio {{ date('d/m/Y', strtotime($product->draw_date)) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="title-rifa-destaque {{ $config->tema }}">
                            <h1><a href="{{ route('product', ['slug' => $product->slug]) }}">{{ $product->name }}</a></h1>
                            <p>{{ $product->subname }}</p>
                            <div class="mt-2">
                                <a class="btn-participar-sorteio btn justify-content-between w-100"
                                    href="{{ route('product', ['slug' => $product->slug]) }}">
                                    <div class="d-flex align-items-center justify-content-center py-1">
                                        <div class="btn-icon me-2"><i class="bi bi-arrow-right-circle-fill"></i></div>
                                        <div class="text-start lh-1">
                                            <div class="btn-texto-principal font-weight-600 mb-1">Garantir meus números</div>
                                            <div class="btn-texto-apoio font-xssss opacity-75"><i
                                                    class="bi bi-patch-check-fill me-1"></i> Compra segura e rápida</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($ganhadores->count() > 0 || $winners->count() > 0)
                    <section aria-label="Ganhadores recentes" class="mt-3">
                        <header class="winners-header">
                            <div class="app-title mb-0 {{ $config->tema }}">
                                <h1>🎉 Ganhadores</h1>
                                <div class="app-title-desc {{ $config->tema }}">Pessoas reais, prêmios reais.</div>
                            </div>
                        </header>
                        <div class="winners-scroller d-flex">
                            @foreach ($winners as $winner)
                                <a class="winners-card rounded-10"
                                    href="{{ route('product', ['id' => $winner->slug]) }}">
                                    <div class="winners-media">
                                        <img src="{{ asset('images/sem-foto.jpg') }}" alt="{{ $winner->winner }}">
                                    </div>
                                    <div class="winners-content">
                                        <div class="winners-nome">{{ $winner->winner }}</div>
                                        <div class="winners-premio">{{ $winner->name }}</div>
                                        <div class="winners-meta">
                                            <span>{{ date('d/m/Y', strtotime($winner->draw_date)) }}</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                            @foreach ($ganhadores as $ganhador)
                                <a class="winners-card rounded-10"
                                    href="{{ route('product', ['id' => $ganhador->rifa()->slug]) }}">
                                    <div class="winners-media">
                                        @if ($ganhador->foto)
                                            <img src="{{ asset($ganhador->foto) }}" alt="{{ $ganhador->ganhador }}">
                                        @else
                                            <img src="{{ asset('images/sem-foto.jpg') }}"
                                                alt="{{ $ganhador->ganhador }}">
                                        @endif
                                    </div>
                                    <div class="winners-content">
                                        <div class="winners-nome">{{ $ganhador->ganhador }}</div>
                                        <div class="winners-premio">{{ $ganhador->descricao }}</div>
                                        <div class="winners-meta">
                                            <b>{{ $ganhador->cota }}</b>
                                            <span>{{ date('d/m/Y', strtotime($ganhador->rifa()->draw_date)) }}</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Outras Rifas --}}
                @foreach ($products->where('favoritar', '=', 0) as $product)
                    @php
                        $ativo = $product->status == 'Ativo';
                        $qtdIni = max((int) ($product->minimo ?: 1), 1);
                        $preco = (float) str_replace(',', '.', $product->price);
                        $urlProduto = route('product', ['id' => $product->slug]);
                    @endphp
                    <div class="sorteio-mini {{ $ativo ? 'is-ativo' : 'is-concluido' }}"
                        data-preco="{{ $preco }}" data-url="{{ $urlProduto }}"
                        data-min="{{ $qtdIni }}">
                        <div class="w-100 d-flex flex-column">
                            <div class="w-100 {{ $ativo ? '' : 'd-flex' }}">
                                @if (!$ativo)
                                    <div class="sorteio-mini-imagem">
                                        <a href="{{ $urlProduto }}">
                                            <img src="/products/{{ $product->imagem()->name }}"
                                                alt="{{ $product->name }}" loading="lazy" decoding="async">
                                        </a>
                                    </div>
                                @endif
                                <div class="d-flex flex-column justify-content-center flex-fill min-w-0">
                                    <div class="sorteio-mini-status">
                                        {!! $product->status() !!}
                                        <span class="sorteio-codigo-operacao"
                                            title="Código da operação">{{ strtoupper(config('app.name')) }}/{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    <h1 class="sorteio-mini-title"><a href="{{ $urlProduto }}">{{ $product->name }}</a>
                                    </h1>
                                    <div class="mb-1">
                                        <a href="{{ $urlProduto }}">
                                            <p class="sorteio-mini-descricao" style="margin-bottom:1px">
                                                {{ $product->subname }}</p>
                                        </a>
                                    </div>
                                    <div class="sorteio-mini-sutis">
                                        @if ($product->draw_date)
                                            <span class="dt-sorteio-mini"><i class="bi bi-calendar-event"></i>
                                                {{ date('d/m', strtotime($product->draw_date)) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if ($ativo)
                                <div class="d-flex w-100 align-items-center mt-1">
                                    <div class="sorteio-mini-imagem">
                                        <a href="{{ $urlProduto }}">
                                            <img src="/products/{{ $product->imagem()->name }}"
                                                alt="{{ $product->name }}" loading="lazy" decoding="async">
                                        </a>
                                    </div>
                                    <div class="w-100">
                                        <div class="vendas-express-geral d-flex">
                                            <div class="vendas-express-numeros-container d-flex align-items-center">
                                                <div class="ve-quick bg-gradient-green3" data-add="200">+200</div>
                                                <div class="ve-quick bg-gradient-green2" data-add="300">+300</div>
                                            </div>
                                            <div class="vendasExpressNums w-100 font-xs">
                                                <div class="d-flex align-items-center justify-content-center font-xss p-0">
                                                    <div class="left pointer font-xs">
                                                        <div class="numeroChange text-dark ps-1" data-step="-1"><i
                                                                class="bi bi-dash-circle"></i></div>
                                                    </div>
                                                    <div class="center">
                                                        <input class="form-control text-center py-1 ve-qtd"
                                                            aria-label="Quantidade de números" readonly
                                                            value="{{ $qtdIni }}">
                                                    </div>
                                                    <div class="right pointer">
                                                        <div class="numeroChange text-cor-primaria pe-0"
                                                            data-step="1"><i class="bi bi-plus-circle-fill"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-1">
                                            <button type="button"
                                                class="btn-participar-sorteio font-xss btn btn-success w-100 p-2 d-flex align-items-center justify-content-center text-uppercase ve-comprar">
                                                <div class="quero-participar font-md me-2"><span><i
                                                            class="bi bi-check-circle-fill"></i> Comprar</span></div>
                                                <div class="preco"><span>(R$ <span
                                                            class="ve-total">{{ number_format($preco * $qtdIni, 2, ',', '.') }}</span>)</span>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                {{-- Fale Conosco --}}
                <div onclick="duvidas()" class="container d-flex duvida" style="">
                    <div class="row">
                        <div class="d-flex icone-duvidas">🤷</div>
                        <div class="col text-duvidas {{ $config->tema }}">
                            <h6 class="mb-0 font-md f-15">Dúvidas?</h6>
                            <p class="mb-0  font-sm f-12 text-muted">Fale conosco</p>
                        </div>
                    </div>
                </div>

                {{-- Ganhadores --}}
                {{-- Perguntas ferquentes --}}
                @if (!env('HIDE_FAQ'))
                    <div class="perguntas-frequentes pb-2">
                        <div class="app-title {{ $config->tema }}">
                            <h1>🤷 Perguntas frequentes</h1>
                        </div>
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-sm btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapseOne" aria-expanded="false"
                                            aria-controls="collapseOne">
                                            Acessando suas compras
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        Existem <strong>duas</strong> formas de você conseguir acessar suas compras, a
                                        primeira é logando no site, clicando no carrinho de compras no menu superior e a
                                        segunda é visitando o sorteio e clicando em "Ver meus números".
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion mt-2" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-sm btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            Como envio o comprovante ?
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        Caso você tenha feito o pagamento via PIX QR Code ou copiando o código, não é
                                        necessário enviar o comprovante, aguardando até 5 minutos após o pagamento, o
                                        sistema irá dar baixa automaticamente, para mais dúvidas entre em contato conosco
                                        pelo whatsapp.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
        <br>
        @include('layouts.footer')
    </div>
    
    <br>

    <script>
        (function() {
            function fmt(v) {
                return v.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            document.querySelectorAll('.sorteio-mini.is-ativo').forEach(function(card) {
                var input = card.querySelector('.ve-qtd');
                var total = card.querySelector('.ve-total');
                var preco = parseFloat(card.dataset.preco) || 0;
                var min = parseInt(card.dataset.min) || 1;

                function render() {
                    if (total) total.textContent = fmt(preco * (parseInt(input.value) || min));
                }

                card.querySelectorAll('[data-add]').forEach(function(b) {
                    b.addEventListener('click', function() {
                        input.value = (parseInt(input.value) || 0) + parseInt(b.dataset.add);
                        render();
                    });
                });

                card.querySelectorAll('[data-step]').forEach(function(b) {
                    b.addEventListener('click', function() {
                        var v = (parseInt(input.value) || min) + parseInt(b.dataset.step);
                        input.value = v < min ? min : v;
                        render();
                    });
                });

                var btn = card.querySelector('.ve-comprar');
                if (btn) btn.addEventListener('click', function() {
                    window.location.href = card.dataset.url + '?qtd=' + (parseInt(input.value) || min);
                });

                render();
            });
        })();
    </script>
@endsection
