@extends('layouts.app')

<link rel="manifest" href="/manifest.json">
<script type="text/javascript" src="sw.js"></script>

@section('title', 'Ganhadores')

@section('sidebar')
@stop

@section('content')
    <div class="container app-main" id="app-main">
        <div class="row justify-content-center">
            <div class="col-md-6 col-12">
                <div class="app-title">
                    <h1>🏆 Ganhadores</h1>
                    <div class="app-title-desc">confira os sortudos</div>
                </div>

                @if (!empty($winners[0]))
                    @foreach ($winners as $winner)
                        <div class="ganhador-card">
                            <a class="ganhador-card-foto" href="{{ route('product', ['id' => $winner->id]) }}">
                                <img src="{{ asset('products/' . $winner->imagem()->name) }}"
                                    alt="{{ $winner->name }}" loading="lazy" decoding="async">
                            </a>
                            <div class="ganhador-card-info">
                                <div class="ganhador-card-nome">{!! $winner->winner !!}</div>
                                <div class="ganhador-card-premio">{{ $winner->name }}</div>
                                @if ($winner->draw_date)
                                    <div class="ganhador-card-linha">Data da premiação
                                        <b>{{ date('d/m/Y', strtotime($winner->draw_date)) }}</b>
                                    </div>
                                @endif
                                <div class="ganhador-card-linha">Sorteio
                                    <b>{{ strtoupper(config('app.name')) }}/{{ str_pad($winner->id, 3, '0', STR_PAD_LEFT) }}</b>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="campanha-btn-branco text-center">Nenhum ganhador divulgado ainda.</div>
                @endif
            </div>
        </div>
        <br>
        @include('layouts.footer')
    </div>
@stop
