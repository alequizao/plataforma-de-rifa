@extends('layouts.admin')

@section('content')
    <div class="container mt-3" style="max-width:100%;min-height:100%;">
        <div class="table-wrapper ">
            <div class="table-title">
                <div class="row mb-3">
                    <div class="col d-flex justify-content-center">
                        <h2>Whatsapp <b>Mensagens</b></h2>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ session('success') }}</li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        {{-- ============ CONEXÃO WHATSAPP (Baileys) ============ --}}
        <div class="card mb-3 wpp-conexao" id="wppConexao">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
                    <h5 class="mb-0"><i class="bi bi-whatsapp text-success"></i> Conexão do WhatsApp</h5>
                    <span class="badge wpp-badge" id="wppBadge">verificando...</span>
                </div>

                <p class="text-muted mb-3" style="font-size:13px">
                    As mensagens automáticas (reserva, pagamento, ganhador) são enviadas por esta
                    conexão. Sessão: <code>{{ $wppSessao }}</code>.
                </p>

                <div class="row align-items-center">
                    <div class="col-md-5 text-center">
                        <div id="wppQrArea">
                            <div class="wpp-qr-vazio">
                                <i class="bi bi-qr-code"></i>
                                <div>Clique em <b>Conectar</b> para gerar o QR Code</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div id="wppInfo" class="mb-3"></div>

                        <button type="button" class="btn btn-success btn-sm" id="wppBtnConectar">
                            <i class="bi bi-qr-code-scan"></i> Conectar / gerar QR
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" id="wppBtnDesconectar">
                            <i class="bi bi-box-arrow-right"></i> Desconectar
                        </button>

                        <hr>

                        <label class="mb-1" style="font-size:13px"><b>Enviar mensagem de teste</b></label>
                        <div class="d-flex" style="gap:6px">
                            <input type="text" class="form-control form-control-sm" id="wppTelTeste"
                                placeholder="(82) 99999-9999">
                            <button type="button" class="btn btn-primary btn-sm" id="wppBtnTeste"
                                style="white-space:nowrap">Enviar</button>
                        </div>
                        <div id="wppTesteMsg" class="mt-2" style="font-size:13px"></div>
                    </div>
                </div>

                <ol class="text-muted mt-3 mb-0" style="font-size:12.5px">
                    <li>Clique em <b>Conectar</b> e espere o QR Code aparecer.</li>
                    <li>No celular: WhatsApp → <b>Aparelhos conectados</b> → <b>Conectar aparelho</b>.</li>
                    <li>Aponte a câmera para o QR. O status vira <b>Conectado</b> sozinho.</li>
                    <li>Deixe o celular com internet — a sessão fica salva e reconecta sozinha.</li>
                </ol>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-md-3 p-2 rounded" style="background-color: darkblue; color: #fff">
                <center><h4>Varíaveis</h4></center>
                <span>{id}: Código da compra</span> <br>
                <span>{nome}: Nome do cliente</span> <br>
                <span>{valor}: Valor por cota</span> <br>
                <span>{total}: Total da compra</span> <br>
                <span>{cotas}: Cotas da compra</span> <br>
                <span>{sorteio}: Título do sorteio</span> <br>
                <span>{link}: Link de pagamento</span> <br>
            </div>
        </div>

        <form action="{{ route('wpp.salvar') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">
                    <nav>
                        <ul class="nav nav-tabs" id="myTab" role="tablist" style="font-size: 12px;">
                            <li class="nav-item" >
                                <a class="nav-link active" id="botoes-tab" data-toggle="tab" href="#botoes" role="tab"
                                    aria-controls="botoes" aria-selected="true"><strong>Botões Menu Compras</strong></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="automatica-tab" data-toggle="tab" href="#automatica" role="tab"
                                    aria-controls="automatica" aria-selected="true"><strong>Msg Automáticas - Clientes</strong></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="token-tab" data-toggle="tab" href="#token" role="tab"
                                    aria-controls="token" aria-selected="true"><strong>Token API Criar Whats</strong></a>
                            </li>
                        </ul>
                    </nav>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="botoes" role="tabpanel" aria-labelledby="botoes-tab">
                            @foreach ($msgs as $msg)
                                <hr>
                                <input type="hidden" name="id[{{ $msg->id }}]" value="{{ $msg->id }}">
                                <div class="col-md-12 mt-2">
                                    <label>Título</label>
                                    <input type="text" name="titulo[{{ $msg->id }}]" class="form-control"
                                        value="{{ $msg->titulo }}">
                                </div>
                                <div class="col-md-12 mt-2 mb-2">
                                    <label>Mensagem</label>
                                    <textarea name="msg[{{ $msg->id }}]" rows="10" class="form-control" style="resize: none">{{ $msg->clearBreak() }}</textarea>
                                </div>
                            @endforeach
                        </div>

                        <div class="tab-pane fade" id="automatica" role="tabpanel" aria-labelledby="automatica-tab">
                            <div class="row">
                                @foreach ($autoMessages as $auto)
                                    <input type="hidden" name="idAuto[{{ $auto->id }}]" value="{{ $auto->id }}">
                                    <div class="col-md-6 mt-2">
                                        <label>Disparo:</label> {{ $auto->descricao }}<br>
                                        <label>Mensagem</label>
                                        <textarea name="msgAuto[{{ $auto->id }}]" rows="10" class="form-control" style="resize: none">{{ $auto->msg }}</textarea>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="tab-pane fade" id="token" role="tabpanel" aria-labelledby="token-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Token Criar Whats</label>
                                    <input type="text" name="token_api_wpp" class="form-control" value="{{ $config->token_api_wpp }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <button type="submit" class="btn btn-sm btn-success mt-2 mb-4 float-right">Salvar</button>
        </form>
    
    <style>
        .wpp-conexao { border: 1px solid #e3e6ef; border-radius: 12px; }
        .wpp-badge { font-size: 12px; padding: 6px 12px; border-radius: 999px; background: #6c757d; color: #fff; }
        .wpp-badge.on { background: #198754; }
        .wpp-badge.qr { background: #ffc107; color: #3b2f00; }
        .wpp-badge.off { background: #dc3545; }
        .wpp-qr-vazio {
            border: 2px dashed #ccd2e3; border-radius: 12px; padding: 28px 12px;
            color: #8a90a6; font-size: 13px;
        }
        .wpp-qr-vazio i { font-size: 42px; display: block; margin-bottom: 8px; opacity: .6; }
        #wppQrArea img { width: 100%; max-width: 260px; border-radius: 10px; border: 1px solid #e3e6ef; }
        .wpp-me { background: #eafaf1; border: 1px solid #b7e4c7; border-radius: 10px; padding: 10px; font-size: 13px; }
    </style>

    <script>
        (function () {
            var rotaStatus = '{{ route('wpp.status') }}';
            var rotaConectar = '{{ route('wpp.conectar') }}';
            var rotaDesconectar = '{{ route('wpp.desconectar') }}';
            var rotaTeste = '{{ route('wpp.teste') }}';
            var token = document.querySelector('meta[name="csrf-token"]');
            token = token ? token.getAttribute('content') : '{{ csrf_token() }}';

            var badge = document.getElementById('wppBadge');
            var qrArea = document.getElementById('wppQrArea');
            var info = document.getElementById('wppInfo');
            var timer = null;

            function post(url, dados) {
                return fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(dados || {})
                }).then(function (r) { return r.json(); });
            }

            function pintar(d) {
                var st = d.status || 'offline';

                if (st === 'open') {
                    badge.className = 'wpp-badge on';
                    badge.textContent = 'Conectado';
                    qrArea.innerHTML = '<div class="wpp-qr-vazio" style="border-color:#b7e4c7;color:#198754">' +
                        '<i class="bi bi-check-circle-fill"></i><div>WhatsApp conectado</div></div>';
                    var nome = d.me && (d.me.name || d.me.pushName) ? (d.me.name || d.me.pushName) : '';
                    var num = d.me && d.me.id ? String(d.me.id).split(':')[0].split('@')[0] : '';
                    info.innerHTML = '<div class="wpp-me"><b>' + (nome || 'Aparelho conectado') + '</b>' +
                        (num ? '<br>Número: +' + num : '') + '</div>';
                } else if (st === 'qr' && d.qr) {
                    badge.className = 'wpp-badge qr';
                    badge.textContent = 'Aguardando leitura do QR';
                    qrArea.innerHTML = '<img src="' + d.qr + '" alt="QR Code do WhatsApp">';
                    info.innerHTML = '<div class="text-muted" style="font-size:13px">' +
                        'Escaneie o código ao lado. Ele se renova sozinho a cada poucos segundos.</div>';
                } else if (st === 'connecting') {
                    badge.className = 'wpp-badge qr';
                    badge.textContent = 'Conectando...';
                    info.innerHTML = '';
                } else if (st === 'offline') {
                    badge.className = 'wpp-badge off';
                    badge.textContent = 'Painel indisponível';
                    info.innerHTML = '<div class="text-danger" style="font-size:13px">' +
                        (d.erro || 'Não foi possível falar com o painel WhatsApp.') + '</div>';
                } else {
                    badge.className = 'wpp-badge';
                    badge.textContent = st === 'inexistente' ? 'Não conectado' : st;
                    info.innerHTML = '';
                }
            }

            function checar() {
                fetch(rotaStatus, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(function (r) { return r.json(); })
                    .then(pintar)
                    .catch(function () {
                        badge.className = 'wpp-badge off';
                        badge.textContent = 'Erro de conexão';
                    });
            }

            document.getElementById('wppBtnConectar').addEventListener('click', function () {
                var b = this; b.disabled = true; b.textContent = 'Iniciando...';
                post(rotaConectar).then(function (r) {
                    if (r.dados) pintar(r.dados);
                    if (!r.ok) alert(r.msg || 'Falha ao iniciar a sessão');
                }).catch(function () { alert('Falha ao falar com o servidor'); })
                    .then(function () {
                        b.disabled = false;
                        b.innerHTML = '<i class="bi bi-qr-code-scan"></i> Conectar / gerar QR';
                    });
            });

            document.getElementById('wppBtnDesconectar').addEventListener('click', function () {
                if (!confirm('Desconectar o WhatsApp? Será preciso ler o QR Code de novo.')) return;
                var b = this; b.disabled = true;
                post(rotaDesconectar).then(function (r) {
                    alert(r.msg || '');
                    checar();
                }).then(function () { b.disabled = false; });
            });

            document.getElementById('wppBtnTeste').addEventListener('click', function () {
                var tel = document.getElementById('wppTelTeste').value.trim();
                var alvo = document.getElementById('wppTesteMsg');
                if (!tel) { alvo.innerHTML = '<span class="text-danger">Informe o telefone.</span>'; return; }
                var b = this; b.disabled = true; b.textContent = 'Enviando...';
                post(rotaTeste, { telefone: tel }).then(function (r) {
                    alvo.innerHTML = '<span class="' + (r.ok ? 'text-success' : 'text-danger') + '">' + r.msg + '</span>';
                }).catch(function () {
                    alvo.innerHTML = '<span class="text-danger">Falha ao falar com o servidor.</span>';
                }).then(function () { b.disabled = false; b.textContent = 'Enviar'; });
            });

            checar();
            timer = setInterval(checar, 3000);
            window.addEventListener('beforeunload', function () { clearInterval(timer); });
        })();
    </script>
@endsection
