{{--
    Sorteador (página pública) — Plataforma de Rifa
    Desenvolvido por @alequizao · alequizao.dev@gmail.com
--}}
@extends('layouts.app')

@php
    $tituloPagina = isset($salvo) && $salvo ? ' - Resultado do sorteio' : ' - Sorteador';
    $descricao = isset($salvo) && $salvo
        ? 'Resultado do sorteio realizado em ' . $salvo['quando'] . ' pelo sorteador online. Confira quem foi sorteado.'
        : 'Sorteador online grátis: sorteie números, nomes e equipes na hora, com contagem regressiva, resultado transparente e link para compartilhar.';
@endphp

@section('title', $tituloPagina)
@section('ogTitle', isset($salvo) && $salvo ? 'Resultado do sorteio' : 'Sorteador online grátis')
@section('metaDescription', $descricao)

@section('dadosEstruturados')
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebApplication',
        'name' => 'Sorteador',
        'applicationCategory' => 'UtilitiesApplication',
        'operatingSystem' => 'Web',
        'inLanguage' => 'pt-BR',
        'url' => route('sorteador'),
        'description' => 'Sorteador online grátis de números, nomes e equipes, com código de conferência.',
        'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'BRL'],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endsection

@section('content')
    <link rel="stylesheet"
        href="{{ asset('css/sorteador.css') }}?v={{ @filemtime(public_path('css/sorteador.css')) }}">
    <script>document.body.classList.add('pagina-sorteador');</script>
    <div class="container app-main" id="app-main">
        @include('sorteador.conteudo')
        @include('layouts.footer')
    </div>
@endsection
