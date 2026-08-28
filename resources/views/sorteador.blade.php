{{--
    Sorteador (página pública) — Plataforma de Rifa
    Desenvolvido por @alequizao · alequizao.dev@gmail.com
--}}
@extends('layouts.app')

@section('title', ' - Sorteador')
@section('ogTitle', 'Sorteador online grátis')
@section('metaDescription', 'Sorteador online grátis: sorteie números, nomes e equipes na hora, com resultado transparente e código de conferência.')

@section('dadosEstruturados')
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebApplication',
        'name' => 'Sorteador',
        'applicationCategory' => 'UtilitiesApplication',
        'operatingSystem' => 'Web',
        'inLanguage' => 'pt-BR',
        'url' => url()->current(),
        'description' => 'Sorteador online grátis de números, nomes e equipes, com código de conferência.',
        'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'BRL'],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endsection

@section('content')
    <link rel="stylesheet"
        href="{{ asset('css/sorteador.css') }}?v={{ @filemtime(public_path('css/sorteador.css')) }}">
    <div class="container app-main" id="app-main">
        @include('sorteador.conteudo')
        @include('layouts.footer')
    </div>
@endsection
