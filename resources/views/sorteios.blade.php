@extends('layouts.app')

<link rel="manifest" href="/manifest.json">
<script type="text/javascript" src="sw.js"></script>
<style>
    body {
        /* fundo pelo tema-gemeos.css */
    }
</style>

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
    @media (max-width: 768px) {
        .app-main {
            margin-top: 50px !important;
        }
    }

    .rifas{
        min-height: 100vh;
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

                <div class="campanha-abas">
                    <span class="campanha-aba is-ativa" id="btn-ativos" onclick="showAtivos(this)">Ativos</span>
                    <span class="campanha-aba" id="btn-concluidos" onclick="showConcluidos(this)">Concluídos</span>
                </div>

                {{-- Outras Rifas --}}
                @foreach ($products->where('favoritar', '=', 0) as $product)
                    @php $urlProduto = route('product', ['id' => $product->slug]); @endphp
                    <div
                        class="sorteio-mini is-concluido sorteio sorteio-{{ strtolower($product->status) }} {{ $product->status == 'Finalizado' ? 'd-none' : '' }}">
                        <div class="w-100 d-flex flex-column">
                            <div class="w-100 d-flex">
                                <div class="sorteio-mini-imagem">
                                    <a href="{{ $urlProduto }}">
                                        <img src="/products/{{ $product->imagem()->name }}" alt="{{ $product->name }}"
                                            loading="lazy" decoding="async">
                                    </a>
                                </div>
                                <div class="d-flex flex-column justify-content-center flex-fill min-w-0">
                                    <div class="sorteio-mini-status">
                                        {!! $product->status() !!}
                                        <span
                                            class="sorteio-codigo-operacao">{{ strtoupper(config('app.name')) }}/{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</span>
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
            </div>
        </div>

        @include('layouts.footer')
    </div>

    <script>
        function showAtivos(el) {
            document.getElementById('btn-concluidos').classList.remove('is-ativa');
            el.classList.add('is-ativa');

            document.querySelectorAll('.sorteio').forEach((el) => {
                el.classList.add('d-none')
            });

            document.querySelectorAll('.sorteio-ativo').forEach((el) => {
                el.classList.remove('d-none')
            });
        }

        function showConcluidos(el) {
            document.getElementById('btn-ativos').classList.remove('is-ativa');
            el.classList.add('is-ativa');

            document.querySelectorAll('.sorteio').forEach((el) => {
                el.classList.add('d-none')
            });

            document.querySelectorAll('.sorteio-finalizado').forEach((el) => {
                el.classList.remove('d-none')
            });
        }
    </script>

    <br><br>
@endsection
