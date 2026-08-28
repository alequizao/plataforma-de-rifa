@extends('layouts.admin')

@section('content')
    <style>
        .hidden {
            display: none;
        }

        .promo {
            border: solid;
            border-width: thin;
            border-radius: 10px;
            padding: 20px;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
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


            {{-- START TABELA MEUS SORTEIOS --}}
            <div class="container mt-3" style="max-width:100%;min-height:100%;">
                <div class="table-wrapper ">
                    <div class="table-title">
                        <div class="row mb-3">
                            <div class="col d-flex justify-content-center">
                                <h2>Clientes</b></h2>
                            </div>
                            <div class="row-12 mb-3 d-flex flex-wrap align-items-center"
                                style="justify-content: space-between; gap:8px">

                                <form method="GET" action="{{ route('clientes') }}" class="form-inline my-2 my-lg-0">
                                    <input class="form-control mr-sm-2" type="search" name="search"
                                        placeholder="Buscar por nome ou telefone" aria-label="Buscar"
                                        value="{{ $search }}">
                                    <button class="btn btn-outline-secondary border border-secondary text-dark"
                                        type="submit"><i class="bi bi-search"></i> Buscar</button>
                                    @if ($search)
                                        <a href="{{ route('clientes') }}" class="btn btn-link">limpar</a>
                                    @endif
                                </form>

                                <div class="d-flex align-items-center" style="gap:8px">
                                    <span class="text-muted" style="font-size:13px">
                                        {{ count($clientes) }} cliente(s)
                                    </span>
                                    <a href="{{ route('clientes.novo') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-lg"></i> Novo cliente
                                    </a>
                                    <a href="{{ route('clientes.exportar', ['search' => $search]) }}"
                                        class="btn btn-success btn-sm">
                                        <i class="bi bi-download"></i> Exportar CSV
                                    </a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-responsive-sm table-hover"
                            id="table_rifas">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Telefone</th>
                                    <th>E-mail</th>
                                    <th style="width: 160px">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($clientes as $cliente)
                                    <tr id="cliente-{{ $cliente->id }}">
                                        <td>{{ $cliente->nome }}</td>
                                        <td>{{ $cliente->telephone }}</td>
                                        <td>{{ $cliente->email }}</td>
                                        <td style="white-space:nowrap">
                                            <a href="{{ route('clientes.editar', $cliente->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i> Editar
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger btn-excluir-cliente"
                                                data-id="{{ $cliente->id }}"
                                                data-nome="{{ $cliente->nome }}">
                                                <i class="bi bi-trash"></i> Excluir
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            Nenhum cliente cadastrado ainda.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                   
                </div>
            </div>
            <!-- ./row -->
            <script src="https://code.jquery.com/jquery-3.7.0.min.js"
                integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
            <script>
                function openRanking(id) {
                    //$('#content-modal-ranking').html('')
                    $.ajax({
                        url: "{{ route('ranking.admin') }}",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            "id": id
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.html) {
                                $('#content-modal-ranking').html(response.html)
                                $('#modal-ranking').modal('show')
                            }
                        },
                        error: function(error) {

                        }
                    })
                }

                document.getElementById("input-add-foto").addEventListener("change", function(el) {
                    $('#form-foto').submit();
                });

                function addFoto(el) {
                    $('#rifa-id').val(el.dataset.id)
                    $('#input-add-foto').click()
                }

                function excluirFoto(el) {
                    if (el.dataset.qtd <= 1) {
                        alert('A rifa precisa de pelo menos 1 foto, adicione outra antes de exlcuir!')
                        return;
                    }

                    const data = {
                        id: el.dataset.id
                    }

                    var id = el.dataset.id;
                    var url = '{{ route('excluirFoto') }}'

                    Swal.fire({
                        title: 'Tem certeza que deseja excluir a foto ?',
                        html: `<input type="hidden" id="id" class="swal2-input" value="` + id + `">`,
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        backdrop: true,
                        showCancelButton: true,
                        confirmButtonText: 'Excluir',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        preConfirm: (id) => {
                            return fetch(url, {
                                    headers: {
                                        "Content-Type": "application/json",
                                        "Accept": "application/json",
                                        "X-Requested-With": "XMLHttpRequest",
                                        "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
                                    },
                                    method: 'POST',
                                    dataType: 'json',
                                    body: JSON.stringify(data)
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(response.statusText)
                                    }
                                    return response.json()
                                })
                                .catch(error => {
                                    Swal.showValidationMessage(
                                        `Request failed: ${error}`
                                    )
                                })
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.value.success) {
                            Swal.fire({
                                title: `Foto excluida com sucesso`,
                                icon: 'success',
                            }).then(() => {
                                $(`#foto-${id}`).remove();
                            })
                        } else {
                            Swal.fire({
                                title: `Erro ao excluir tente novamente`,
                                text: 'Erro: ' + result.value.error,
                                icon: 'error',
                            })
                        }
                    })
                }

                function definirGanhador(id) {
                    $('#content-modal-definir-ganhador').html('')
                    $.ajax({
                        url: "{{ route('definirGanhador') }}",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            "id": id
                        },
                        success: function(response) {
                            if (response.html) {
                                $('#content-modal-definir-ganhador').html(response.html)
                                $('#modal-definir-ganhador').modal('show');
                            }
                        },
                        error: function(error) {

                        }
                    })
                }

                function verGanhadores(id) {
                    $('#content-modal-ver-ganhadores').html('')
                    $.ajax({
                        url: "{{ route('verGanhadores') }}",
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            "id": id
                        },
                        success: function(response) {
                            if (response.html) {
                                $('#content-modal-ver-ganhadores').html(response.html)
                                $('#modal-ver-ganhadores').modal('show');
                            }
                        },
                        error: function(error) {

                        }
                    })
                }

                function formatarMoeda() {
                    var elemento = document.getElementById('price');
                    var valor = elemento.value;


                    valor = valor + '';
                    valor = parseInt(valor.replace(/[\D]+/g, ''));
                    valor = valor + '';
                    valor = valor.replace(/([0-9]{2})$/g, ",$1");

                    if (valor.length > 6) {
                        valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
                    }

                    elemento.value = valor;
                    if (valor == 'NaN') elemento.value = '';

                }

                function copyResumoLink(link) {
                    const element = document.querySelector('#copy-link');
                    const storage = document.createElement('textarea');
                    storage.value = link;
                    element.appendChild(storage);

                    // Copy the text in the fake `textarea` and remove the `textarea`
                    storage.select();
                    storage.setSelectionRange(0, 99999);
                    document.execCommand('copy');
                    element.removeChild(storage);

                    alert("LINK para resumo copiado com sucesso.");
                }

                function duplicar(el) {
                    var id = el.dataset.id;
                    var name = el.dataset.name
                    $('#id-duplicar').val(id);
                    $('#titulo-duplicar').text(`Copiando dados da rifa: ${name}`);

                    $('#duplicar-modal').modal('show')
                }
            </script>

            @if (session()->has('sorteio'))
                <script>
                    $(function(e) {
                        verGanhadores('{{ session('sorteio') }}')
                    })
                </script>
            @endif



        
    <script>
        document.querySelectorAll('.btn-excluir-cliente').forEach(function (b) {
            b.addEventListener('click', function () {
                var id = b.dataset.id, nome = b.dataset.nome;

                if (!confirm('Excluir o cliente "' + nome + '"?\n\nEssa ação não pode ser desfeita.')) return;

                b.disabled = true;

                fetch('{{ url('cliente/excluir') }}/' + id, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(function (r) { return r.json(); })
                    .then(function (r) {
                        if (r.ok) {
                            var linha = document.getElementById('cliente-' + id);
                            if (linha) linha.remove();
                        } else {
                            alert(r.msg || 'Não foi possível excluir.');
                            b.disabled = false;
                        }
                    })
                    .catch(function () {
                        alert('Falha ao falar com o servidor.');
                        b.disabled = false;
                    });
            });
        });
    </script>
@endsection
