{{-- HERO DA CAMPANHA — padrão Gêmeos Brasil --}}
<script>
    document.documentElement.classList.add('pagina-campanha');
    document.addEventListener('DOMContentLoaded', function() {
        document.body.classList.add('pagina-campanha');
    });
</script>

<div class="campanha-hero">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($productModel->fotos() as $key => $foto)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}" id="slide-foto-{{ $foto->id }}">
                    <img src="/products/{{ $foto->name }}" class="d-block w-100 campanha-hero-img"
                        alt="{{ $productModel->name }}">
                </div>
            @endforeach
        </div>
    </div>

    <div class="campanha-hero-info">
        <div class="campanha-hero-badges">
            {!! $productModel->status() !!}
            <span class="sorteio-codigo-operacao">{{ strtoupper(config('app.name')) }}/{{ str_pad($productModel->id, 3, '0', STR_PAD_LEFT) }}</span>
        </div>
        <h1 class="campanha-hero-title">{{ $productModel->name }}</h1>
        <p class="campanha-hero-desc">{{ $productModel->subname }}</p>
    </div>
</div>

<a href="#" data-bs-toggle="modal" data-bs-target="#consultar-reservas" class="campanha-barra-titulos">
    <i class="bi bi-cart-fill"></i> Meus títulos
</a>

<div class="campanha-preco text-center">
    <span class="campanha-preco-label">Por apenas</span>
    <span class="campanha-preco-valor">R$ {{ $product[0]->price }}</span>
</div>

@if ($productModel->draw_date)
    <div class="text-center campanha-data">
        <i class="bi bi-calendar-event"></i> Sorteio em
        {{ date('d/m/Y', strtotime($productModel->draw_date)) }}
    </div>
@endif
