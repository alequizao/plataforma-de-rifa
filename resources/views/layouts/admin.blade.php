<!-- Stored in resources/views/layouts/master.blade.php -->

<html style="height: auto;">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css') }}">
    <link href="{{ asset('/dist/css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/summernote/summernote-bs4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/codemirror/codemirror.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/codemirror/theme/monokai.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('/plugins/simplemde/simplemde.min.css') }}" rel="stylesheet"> --}}

    <link href="{{ asset('/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Designi Alequizao: fonte Inter + camada visual (carregar por ultimo) -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('/dist/css/designi-alequizao.css') }}?v=1" rel="stylesheet">

    <title>{{ @$data['social']->name ?: 'Painel' }}</title>

    <style>
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
</head>

<body class="sidebar-mini layout-fixed layout-navbar-fixed" style="height: auto;">

    <div id="loadingSystem" class="d-none"></div>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="bi bi-list"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('inicio') }}">
                        <span class="badge bg-primary">VER SITE</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">
                        <form name="logout" action="{{ route('logout') }}" method="POST">
                            {{ csrf_field() }}
                            <span class="badge badge-warning" onclick="javascript:logout.submit()">SAIR</span>
                        </form>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <form name="logout" action="{{ route('logout') }}" method="POST">
                            {{ csrf_field() }}
                            <span class="badge badge-warning navbar-badge" onclick="javascript:logout.submit()"
                                style="font-size: 14px;">SAIR</span>
                        </form>
                    </a>
                </li> --}}
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: #010140">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-link text-center"
                style="background: #010140; text-decoration: none">
                <span class="brand-text font-weight-light">Painel</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Menu lateral (Designi Alequizao: itens planos, ativo em azul) -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-speedometer2"></i>
                                <p>Painel</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mySweepstakes') }}" class="nav-link {{ request()->is('meus-sorteios*') || request()->is('resumo-rifa*') || request()->is('compras*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-ticket-perforated"></i>
                                <p>Minhas Rifas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('clientes') }}" class="nav-link {{ request()->is('clientes*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-people-fill"></i>
                                <p>Clientes</p>
                            </a>
                        </li>
                        @if (!env('HIDE_GANHADORES'))
                            <li class="nav-item">
                                <a href="{{ route('painel.ganhadores') }}" class="nav-link {{ request()->is('admin-ganhadores*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-trophy"></i>
                                    <p>Ganhadores</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('wpp.index') }}" class="nav-link {{ request()->is('wpp-mensagens*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-whatsapp"></i>
                                <p>Mensagens WhatsApp</p>
                            </a>
                        </li>
                        @if (env('AFILIADOS'))
                            <li class="nav-item">
                                <a href="{{ route('afiliados') }}" class="nav-link {{ request()->is('lista-afiliados*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-arrow-left-right"></i>
                                    <p>Afiliados</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('painel.solicitacaoAfiliados') }}" class="nav-link {{ request()->is('solicitacao-pagamento*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-currency-dollar"></i>
                                    <p>Solicitação de Pgto</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('sorteador') }}" class="nav-link {{ request()->is('sorteador*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-dice-5"></i>
                                <p>Sorteador</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('versoes') }}" class="nav-link {{ request()->is('versoes*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-clock-history"></i>
                                <p>Versões</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('aparencia') }}" class="nav-link {{ request()->is('aparencia*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-palette"></i>
                                <p>Aparência do site</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tutoriais') }}" class="nav-link {{ request()->is('tutoriais*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-play-circle"></i>
                                <p>Tutoriais</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('profile') }}" class="nav-link {{ request()->is('perfil*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-gear"></i>
                                <p>Meu perfil</p>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Rodape da gaveta: sair + versao -->
                <div class="sidebar-footer">
                    <form name="logoutSidebar" action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="btn-sair">
                            <i class="bi bi-box-arrow-right"></i> Sair
                        </button>
                    </form>
                    <a href="{{ route('versoes') }}" class="versao">Versão {{ config('versao.atual') }}</a>
                    <a href="https://instagram.com/alequizao" target="_blank" rel="noopener"
                        class="assinatura-dev" title="Desenvolvido por @alequizao">
                        Desenvolvido por <b>@alequizao</b>
                    </a>
                </div>
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content -->

        <div id="sidebar-overlay"></div>

        <!-- Tab bar de aplicativo (somente mobile) -->
        <nav class="tabbar" aria-label="Navegação principal">
            <a href="{{ route('home') }}" class="{{ request()->is('home') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i><span>Painel</span>
            </a>
            <a href="{{ route('mySweepstakes') }}" class="{{ request()->is('meus-sorteios*') ? 'active' : '' }}">
                <i class="bi bi-ticket-perforated"></i><span>Rifas</span>
            </a>
            <a href="{{ route('adminProduct') }}" class="fab" aria-label="Criar nova rifa">
                <i class="bi bi-plus-lg"></i><span>Nova</span>
            </a>
            <a href="{{ route('clientes') }}" class="{{ request()->is('clientes*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i><span>Clientes</span>
            </a>
            <button type="button" id="btnMenuMobile" aria-label="Abrir menu">
                <i class="bi bi-list"></i><span>Menu</span>
            </button>
        </nav>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark" style="background: #010140 !important">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
    <script>
        // Tab bar mobile: o item "Menu" abre a gaveta lateral do AdminLTE.
        document.addEventListener('DOMContentLoaded', function () {
            var btn = document.getElementById('btnMenuMobile');
            if (btn) {
                btn.addEventListener('click', function () {
                    document.body.classList.toggle('sidebar-open');
                    document.body.classList.remove('sidebar-collapse');
                });
            }
        });
    </script>
    <script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('/plugins/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('/plugins/codemirror/mode/css/css.js') }}"></script>
    <script src="{{ asset('/plugins/codemirror/mode/xml/xml.js') }}"></script>
    <script src="{{ asset('/plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
    {{-- <script src="{{ asset('/build/js/Layout.js') }}"></script> --}}
    {{-- <script src="{{ asset('/build/js/adminlte.js') }}"></script> --}}

    <script src="{{ asset('/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    @stack('scripts')

    <script>
        $(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })

        // Marca o item ativo do menu antigo. Os ids não existem em todas as
        // páginas (o menu novo usa classes), por isso a checagem de nulo:
        // sem ela o erro parava o restante do JavaScript do painel.
        var url_atual = window.location.pathname;
        var idAtivo = { '/home': 'home', '/adicionar-sorteio': 'adicionar-sorteio', '/meus-sorteios': 'meus-sorteios', '/perfil': 'perfil' }[url_atual];
        var itemAtivo = idAtivo ? document.getElementById(idAtivo) : null;
        if (itemAtivo) itemAtivo.className += " active";

        //console.log(url_atual);
    </script>

    <!--<script>
        $(function() {
            // Summernote
            $('#summernote').summernote()

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>-->

    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    @stack('datetimepicker')

    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function(e) {
            document.querySelectorAll('.summernote').forEach((el) => {
                $('#' + el.id).summernote({
                    toolbar: [
                        // [groupName, [list of button]]
                        ['style', ['bold', 'italic', 'underline', 'clear', 'fontname']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['misc', ['fullscreen']],
                        ['link']
                    ]
                })
            });


            $('#summernote').summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear', 'fontname']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['misc', ['fullscreen']],
                    ['link']
                ]
            })
        })

        function loading() {
            var el = document.getElementById('loadingSystem');
            el.classList.toggle("d-none");
        }
    </script>
</body>

</html>
