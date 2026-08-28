{{--
    Cadastro manual de cliente — Plataforma de Rifa
    Desenvolvido por @alequizao · alequizao.dev@gmail.com
--}}
@extends('layouts.admin')

@section('content')
    <div class="container mt-3" style="max-width:760px">
        <div class="row mb-3">
            <div class="col d-flex justify-content-center">
                <h2>👤 Novo <b>cliente</b></h2>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('clientes.salvar') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-7 mb-3">
                            <label for="nome"><b>Nome</b> <span class="text-danger">*</span></label>
                            <input type="text" name="nome" id="nome" class="form-control"
                                value="{{ old('nome') }}" placeholder="Nome completo" required autofocus>
                        </div>

                        <div class="col-md-5 mb-3">
                            <label for="telephone"><b>Telefone</b> <span class="text-danger">*</span></label>
                            <input type="text" name="telephone" id="telephone" class="form-control"
                                value="{{ old('telephone') }}" placeholder="(82) 99999-9999" maxlength="15" required>
                            <small class="text-muted">É por ele que o cliente consulta os títulos.</small>
                        </div>

                        <div class="col-md-7 mb-3">
                            <label for="email"><b>E-mail</b> <small class="text-muted">(opcional)</small></label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ old('email') }}" placeholder="cliente@email.com">
                        </div>

                        <div class="col-md-5 mb-3">
                            <label for="cpf"><b>CPF</b> <small class="text-muted">(opcional)</small></label>
                            <input type="text" name="cpf" id="cpf" class="form-control"
                                value="{{ old('cpf') }}" placeholder="000.000.000-00" maxlength="14">
                        </div>
                    </div>

                    <div class="alert alert-warning py-2" style="font-size:13px">
                        O telefone não pode se repetir: se já existir um cliente com o mesmo número,
                        o cadastro é recusado. Para alterar os dados de quem já comprou, use
                        <b>Editar</b> na lista de clientes.
                    </div>

                    <div class="d-flex flex-wrap" style="gap:8px">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-lg"></i> Cadastrar cliente
                        </button>
                        <a href="{{ route('clientes') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var tel = document.getElementById('telephone');
            tel.addEventListener('input', function (e) {
                var a = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
                e.target.value = !a[2] ? a[1] : '(' + a[1] + ') ' + a[2] + (a[3] ? '-' + a[3] : '');
            });

            var cpf = document.getElementById('cpf');
            cpf.addEventListener('input', function (e) {
                var v = e.target.value.replace(/\D/g, '').slice(0, 11);
                v = v.replace(/(\d{3})(\d)/, '$1.$2')
                     .replace(/(\d{3})(\d)/, '$1.$2')
                     .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                e.target.value = v;
            });
        })();
    </script>
@endsection
