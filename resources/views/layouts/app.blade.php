<!-- Stored in resources/views/layouts/master.blade.php -->

<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('/css/app-original-2.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Language" content="pt-br">

    <!-- Autoria -->
    <meta name="author" content="@alequizao">
    <meta name="developer" content="@alequizao — alequizao.dev@gmail.com">
    <meta name="contact" content="alequizao.dev@gmail.com">
    <link rel="me" href="https://instagram.com/alequizao">

    {{-- Indexação: o site é público e deve aparecer nas buscas --}}
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
    <meta name="googlebot" content="index, follow">

    <meta name="description" content="@yield('metaDescription', 'Participe das nossas rifas e sorteios online. Escolha seus números, pague por PIX e receba a confirmação na hora pelo WhatsApp.')">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph / redes sociais --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ @$data['social']->name }}">
    <meta property="og:title" content="@yield('ogTitle', @$data['social']->name)">
    <meta property="og:description" content="@yield('metaDescription', 'Participe das nossas rifas e sorteios online. Escolha seus números, pague por PIX e receba a confirmação na hora pelo WhatsApp.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="pt_BR">
    @if (@$data['social']->logo)
        <meta property="og:image" content="{{ asset('products/' . @$data['social']->logo) }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">

    {{-- Dados estruturados: ajudam Google e assistentes de IA a entender o site --}}
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Organization',
                '@id' => url('/') . '#organizacao',
                'name' => @$data['social']->name ?: config('app.name'),
                'url' => url('/'),
                'logo' => @$data['social']->logo ? asset('products/' . @$data['social']->logo) : null,
                'sameAs' => array_values(array_filter([
                    @$data['social']->instagram ? 'https://instagram.com/' . @$data['social']->instagram : null,
                    @$data['social']->facebook ? 'https://facebook.com/' . @$data['social']->facebook : null,
                ])),
            ],
            [
                '@type' => 'WebSite',
                '@id' => url('/') . '#site',
                'url' => url('/'),
                'name' => @$data['social']->name ?: config('app.name'),
                'inLanguage' => 'pt-BR',
                'publisher' => ['@id' => url('/') . '#organizacao'],
            ],
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    @yield('dadosEstruturados')

    <meta name="color-scheme" content="light only">
    <meta name="X-DarkMode-Default" value="false" />

    @yield('ogContent')


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- jQuery 1.8 or later, 33 KB -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>



    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>

    <!-- Fotorama from CDNJS, 19 KB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>

    <!--<script defer src="{{ mix('js/app.js') }}"></script>
    <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>-->

    <title><?php echo @$data['social']->name; ?> @yield('title')</title>


    <meta name="facebook-domain-verification" content="<?php echo @$data['social']->verify_domain_fb; ?>" />

    <?php echo @$data['social']->pixel; ?>


    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>
        const mp = new MercadoPago("<?php echo @$data['social']->key_pix_public; ?>");
    </script>

    <style>
        body{
            /* min-height: 105vh; */
        }
        @media (max-width: 768px) {
            .meus-numeros {
                margin-left: 50px !important;
            }

            .header-menu {
                justify-content: space-between !important;
            }
        }

        @media screen and (max-width: 768px) {
        .app-main {
            /* margin-top: 90px !important; */
            margin-top: 20px !important;
            position: absolute;
            z-index: 9999 !important;
        }

        .swal2-container{
            z-index: 99999;
        }
    }

        .app-main {
            margin-bottom: 0px !important;
            min-height: 100vh;
        }

        #loadingSystem {
            background: rgba(206, 206, 206, 0.5) url("../../images/loading.gif") no-repeat scroll center center;
            background-size: 150px 150px;
            height: 100%;
            left: 0;
            overflow: visible;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 9999999;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/menu2.css') }}">

    <!-- TEMA GEMEOS (deve ser o ULTIMO css) -->
    <meta name="theme-color" content="#00307a">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/tema-gemeos.css') }}?v={{ @filemtime(public_path('css/tema-gemeos.css')) }}">

    {{-- Cores e tema definidos no painel (Aparência) — sobrescreve os tokens padrão --}}
    @php $tema = \App\Environment::find(1); @endphp
    @if ($tema)
        @if ($tema->urlFonte())
            <link rel="stylesheet" href="{{ $tema->urlFonte() }}">
        @endif
        <style id="tema-personalizado">{!! $tema->cssVariaveis() !!}</style>
    @endif
</head>

<body>
    @section('sidebar')
    @show

    <?php
    $subDomain = explode('.', request()->getHost());
    ?>
    <div id="loadingSystem" class="d-none"></div>


    <header class="app-header-gemeos">
        <div class="app-header-container">
            <div class="container container-600 font-mdd">
                <div class="app-header-wrap">
                    <div class="row align-items-center w-100 gx-0">
                        <div class="col">
                            <button type="button" aria-label="Menu" class="btn btn-link text-white font-lgg ps-0"
                                data-bs-toggle="modal" data-bs-target="#mobileMenu" style="margin-top:5px">
                                <i class="bi bi-filter-left"></i>
                            </button>
                        </div>
                        <div class="col-5 text-center">
                            <a class="text-center d-block" aria-label="Página inicial" href="{{ route('inicio') }}">
                                @if (@$data['social']->logo)
                                    <img src="{{ asset('products/' . @$data['social']->logo) }}"
                                        class="app-header-brand" alt="{{ @$data['social']->name }}">
                                @else
                                    <span class="text-white">{{ @$data['social']->name }}</span>
                                @endif
                            </a>
                        </div>
                        <div class="col text-end">
                            <a class="btn btn-link text-white pe-0 text-decoration-none txtSuporte"
                                href="https://api.whatsapp.com/send?phone={{ @$data['user']->telephone }}" target="_blank">
                                <div class="suporte d-flex justify-content-end opacity-50"><i
                                        class="bi bi-chat-right-dots-fill"></i></div>
                                <div class="suporte text-yellow font-xss">Suporte</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-principal-horizontal">
                <hr class="my-1">
                <div class="container container-600 font-md">
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav-horizontal-header px-0 py-3 font-xs">
                                <li><a class="{{ request()->is('/') ? 'active' : '' }}" href="{{ route('inicio') }}"><i
                                            class="icone bi bi-stars"></i> Campanhas</a></li>
                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#consultar-reservas">Meus
                                        títulos</a></li>
                                @if (env('AFILIADOS'))
                                    <li><a href="{{ route('afiliado.home') }}">Afiliados</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="black-bar"></div>

    <menu id="mobileMenu" class="modal fade modal-fluid mobile-menu-v2" tabindex="-1"
        aria-labelledby="mobileMenuLabel" style="z-index:99999" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <header class="modal-header">
                    <div class="mobile-menu-topbar">
                        <a aria-label="Ir para página inicial" href="{{ route('inicio') }}">
                            @if (@$data['social']->logo)
                                <img src="{{ asset('products/' . @$data['social']->logo) }}" class="app-brand"
                                    alt="{{ @$data['social']->name }}">
                            @else
                                <span class="text-white">{{ @$data['social']->name }}</span>
                            @endif
                        </a>
                        <button type="button" class="mobile-menu-close" data-bs-dismiss="modal" aria-label="Fechar menu">
                            <i class="bi bi-x-lg" aria-hidden="true"></i>
                        </button>
                    </div>
                </header>
                <div class="modal-body">
                    <div class="mobile-menu-shell">
                        <div class="mobile-menu-guest-card">
                            <p class="mobile-menu-guest-title">Entre para acompanhar seus números</p>
                            <p class="mobile-menu-guest-desc">Consulte compras, números e prêmios em um só lugar.</p>
                            <div class="mobile-menu-guest-actions">
                                <a class="mobile-menu-btn-light" href="/login"><i class="bi bi-box-arrow-in-right"
                                        aria-hidden="true"></i>Entrar</a>
                                <a class="mobile-menu-btn-outline" href="#" data-bs-toggle="modal"
                                    data-bs-target="#consultar-reservas">Meus números</a>
                            </div>
                        </div>

                        <a class="mobile-menu-primary-cta" aria-label="Ver campanhas ativas" href="{{ route('inicio') }}">
                            <i class="bi bi-stars" aria-hidden="true"></i><span>Ver campanhas ativas</span>
                        </a>

                        <nav aria-label="Menu principal">
                            <section class="mobile-menu-section">
                                <h3 class="mobile-menu-section-title">Principal</h3>
                                <ul class="mobile-menu-list" role="list">
                                    <li><a class="mobile-menu-link" href="{{ route('inicio') }}"><i
                                                class="bi bi-house mobile-menu-icon"></i><span>Início</span></a></li>
                                    <li><a class="mobile-menu-link" href="/sorteios"><i
                                                class="bi bi-card-list mobile-menu-icon"></i><span>Sorteios</span></a>
                                    </li>
                                    <li><a class="mobile-menu-link" href="#" data-bs-toggle="modal"
                                            data-bs-target="#consultar-reservas"><i
                                                class="bi bi-ui-checks mobile-menu-icon"></i><span>Meus
                                                números</span></a></li>
                                    <li><a class="mobile-menu-link" href="{{ route('ganhadores') }}"><i
                                                class="bi bi-trophy mobile-menu-icon"></i><span>Ganhadores</span></a>
                                    </li>
                                </ul>
                            </section>

                            @if (env('AFILIADOS'))
                                <section class="mobile-menu-section">
                                    <h3 class="mobile-menu-section-title">Minha conta</h3>
                                    <ul class="mobile-menu-list" role="list">
                                        <li><a class="mobile-menu-link" href="{{ route('afiliado.home') }}"><i
                                                    class="bi bi-cash-coin mobile-menu-icon"></i><span>Área de
                                                    afiliados</span></a></li>
                                    </ul>
                                </section>
                            @endif

                            <section class="mobile-menu-section">
                                <h3 class="mobile-menu-section-title">Comunidade</h3>
                                <ul class="mobile-menu-list" role="list">
                                    @if (@$data['social']->instagram)
                                        <li><a class="mobile-menu-link" target="_blank"
                                                href="https://www.instagram.com/{{ @$data['social']->instagram }}"><i
                                                    class="bi bi-instagram mobile-menu-icon"></i><span>Instagram</span></a>
                                        </li>
                                    @endif
                                    <li><a class="mobile-menu-link" target="_blank"
                                            href="https://api.whatsapp.com/send?phone={{ @$data['user']->telephone }}"><i
                                                class="bi bi-headset mobile-menu-icon"></i><span>Suporte</span></a></li>
                                </ul>
                            </section>
                        </nav>

                        <div class="mobile-menu-legal">
                            <h3 class="mobile-menu-legal-title">Legal</h3>
                            <ul class="mobile-menu-legal-links">
                                <li><a href="{{ route('politica') }}">Privacidade</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </menu>

    

    <!-- Modal  consultar -->
    <div class="modal fade" id="consultar-reservas" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="z-index: 9999999;">
        <div class="modal-dialog">
            <div class="modal-content" style="border: none;">
                <div class="modal-header" style="background-color: #020f1e;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;">CONSULTAR RESERVAS</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        style="color: #fff;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color: #020f1e;">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('minhasReservas') }}" method="POST" style="display: flex;">
                                {{ csrf_field() }}
                                <input type="text" name="telephone" id="telephone"
                                    style="background-color: #fff;border: none;color: #000000;margin-right:5px;"
                                    aria-describedby="passwordHelpBlock" maxlength="15" placeholder="Celular com DDD"
                                    class="form-control" required>
                                <button type="submit" class="btn btn-danger">Buscar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .botao-flutuante {
            position: fixed;
            width: 100px;
            height: 30px;
            bottom: 16px;
            right: 10px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 5px;
            text-align: center;
            align-items: center;
            /* font-size: 30px; */
            box-shadow: 1px 1px 2px #888;
            z-index: 99999;
            text-decoration: none;
        }

        .botao-flutuante:hover {
            text-decoration: none;
        }

        .botao-flutuante-insta {
            position: fixed;
            width: 100px;
            height: 30px;
            bottom: 56px;
            right: 10px;
            background-color: #CF235F;
            color: #FFF;
            border-radius: 5px;
            text-align: center;
            align-items: center;
            /* font-size: 30px; */
            box-shadow: 1px 1px 2px #888;
            z-index: 99999;
            text-decoration: none;
        }

        .botao-flutuante-insta:hover {
            text-decoration: none;
        }
    </style>

    @if (@$data['social']->group_whats != null)
        <a href="{{ @$data['social']->group_whats }}" class="botao-flutuante" target="_blank">
            <i style="margin-top:8px" class="bi bi-whatsapp"></i>&nbsp; GRUPO
        </a>
    @endif

    @if (@$data['social']->instagram != null)
        <a href="https://www.instagram.com/{{ @$data['social']->instagram }}" class="botao-flutuante-insta" target="_blank">
            <i style="margin-top:8px" class="bi bi-instagram"></i>
        </a>
    @endif

    @yield('content')

    {{-- @if (!env('HIDE_FOOTER'))
        <footer class="footer "
            style="height:auto;background-color: #000;margin-top:0px!important; text-align: center;">
            @if (env('AGENCY_RAUEN'))
                <a href="https://agencyrauen.com/" target="_blank" style="text-decoration: none"><span
                        class="text-muted" style="color: #fff!important; font-size: 12px;">Desenvolvido por Agency
                        Rauen</span></a>
                </div>
            @else
                <a href="https://agencyrauen.com/" target="_blank" style="text-decoration: none"><span
                        class="text-muted" style="color: #fff!important; font-size: 12px;">Desenvolvido por Agency
                        Rauen</span></a>
                </div>
            @endif
        </footer>
    @endif --}}

    {{-- @if (!env('HIDE_FOOTER'))
        @if (@$data['social']->footer == null)
            <footer class="footer"
                style="height:auto;background-color: #000;margin-top:0px!important; padding-top: 10px; padding-bottom: 10px;">
                <div class="container" style="text-align: center; padding-top: 5px;padding-bottom: 5px;">
                    <!-- Facebook -->
                    <a class="btn btn-primary" style="background-color: #2760AE;border: none;font-size: 20px;"
                        href="https://www.facebook.com/{{ @$data['social']->facebook }}" target="_blank"
                        rel="noreferrer noopener" role="button"><i class="bi bi-facebook"></i></a>
                    <!-- Instagram -->
                    <a class="btn btn-primary" style="background-color: #CF235F;border: none;font-size: 20px;"
                        href="https://www.instagram.com/{{ @$data['social']->instagram }}" target="_blank"
                        rel="noreferrer noopener" role="button"><i class="bi bi-instagram"></i></a>
                    <!-- Whatsapp -->
                    <a class="btn btn-primary" style="background-color: #25d366;border: none;"
                        href="https://api.whatsapp.com/send?phone={{ @$data['user']->telephone }}" target="_blank"
                        rel="noreferrer noopener" role="button"><i class="bi bi-whatsapp"
                            style="font-size: 20px;"></i></a>
                    @if (env('APP_NAME') == 'Laravel')
                        <img src="{{ asset('images/original.png') }}" title="Sistema Original Agency Rauen"
                            style="opacity: 0.2; float: right" width="50" alt="">
                    @endif
                    @if (env('FOOTER_CLIENTE'))
                        <br>
                        <a href="https://api.whatsapp.com/send?phone=5514998977909" target="_blank" style="text-decoration: none"><span
                                class="text-muted" style="color: #fff!important; font-size: 12px;">Desenvolvido por Fácil Script</span></a>
                    @endif
                </div>
            </footer>
        @else
            <footer class="footer " style="height:auto;background-color: #000;margin-top:0px!important;">
                <div class="container" style="text-align: center; padding-top: 5px;padding-bottom: 5px;">
                    <span class="text-muted" style="color: #fff!important;">{{ @$data['social']->footer }}</span>
                    @if (env('FOOTER_CLIENTE'))
                        <br>
                        <a href="https://api.whatsapp.com/send?phone=5514998977909" target="_blank" style="text-decoration: none"><span
                                class="text-muted" style="color: #fff!important; font-size: 12px;">Desenvolvido por Fácil Script</span></a>
                    @endif
                </div>
            </footer>
        @endif
    @endif --}}

    <script>
        document.getElementById('telephone').addEventListener('input', function(e) {
            var aux = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            e.target.value = !aux[2] ? aux[1] : '(' + aux[1] + ') ' + aux[2] + (aux[3] ? '-' + aux[3] : '');
        });

        document.getElementById('telephone1').addEventListener('input', function(e) {
            var aux = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            e.target.value = !aux[2] ? aux[1] : '(' + aux[1] + ') ' + aux[2] + (aux[3] ? '-' + aux[3] : '');
        });

        function loading() {
            var el = document.getElementById('loadingSystem');
            el.classList.toggle("d-none");
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
