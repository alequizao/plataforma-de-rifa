{{--
    Sorteador (dentro do painel) — Plataforma de Rifa
    Mesma ferramenta da página pública, com a barra lateral do painel
    e a aba de sorteio entre participantes liberada.
    Desenvolvido por @alequizao · alequizao.dev@gmail.com
--}}
@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="{{ asset('css/sorteador.css') }}?v={{ @filemtime(public_path('css/sorteador.css')) }}">
    <div class="container-fluid sorteador-painel" style="max-width:760px;padding:18px 14px 40px">
        @include('sorteador.conteudo')
    </div>
@endsection
