{{-- COMPRA AUTOMÁTICA — padrão Gêmeos Brasil --}}
<?php $resultNumber = $totalPago; ?>

<div class="campanha-compra">

    {{-- Stepper principal --}}
    <div class="campanha-stepper">
        <button type="button" class="stepper-limpar" onclick="document.getElementById('numbersA').value='{{ $productModel->minimo }}';numerosAleatorio();"
            aria-label="Limpar">
            <i class="bi bi-x-lg"></i>
        </button>
        <button type="button" class="stepper-btn stepper-menos" onclick="addQtd('-')" aria-label="Diminuir">
            <i class="bi bi-dash-lg"></i>
        </button>
        <input type="number" id="numbersA" class="stepper-input" value="{{ $productModel->minimo }}"
            min="{{ $productModel->minimo }}" max="{{ $productModel->maximo }}" onblur="numerosAleatorio();"
            onkeyup="numerosAleatorio()" aria-label="Quantidade de números">
        <button type="button" class="stepper-btn stepper-mais" onclick="addQtd('+')" aria-label="Aumentar">
            <i class="bi bi-plus-lg"></i>
        </button>
    </div>

    {{-- Grade de seleção rápida --}}
    <div class="campanha-grid">
        @foreach ($productModel->comprasAuto()->where('qtd', '>', 0) as $compra)
            <div class="campanha-grid-item {{ $compra->popular ? 'is-popular' : '' }}"
                onclick="addQtd('{{ $compra->qtd }}')">
                @if ($compra->popular)
                    <span class="campanha-grid-badge">POPULAR</span>
                @endif
                <div class="campanha-grid-qtd">+{{ $compra->qtd }}</div>
                <div class="campanha-grid-label">Selecionar</div>
            </div>
        @endforeach
    </div>

    {{-- CTA --}}
    <button type="button" class="btn-participar-sorteio btn w-100 campanha-cta" onclick="validarQtd()">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="d-flex align-items-center">
                <div class="btn-icon me-2"><i class="bi bi-arrow-right-circle-fill"></i></div>
                <div class="text-start lh-1">
                    <div class="btn-texto-principal font-weight-600 mb-1">Garantir números</div>
                    <div class="btn-texto-apoio font-xssss opacity-75"><i class="bi bi-patch-check-fill me-1"></i>
                        Compra segura e rápida</div>
                </div>
            </div>
            <div class="text-end lh-1 campanha-cta-preco">
                <div class="font-xssss opacity-75">R$ {{ $product[0]->price }}/un</div>
                <div class="fw-bold" id="numberSelectedTotalHome"></div>
            </div>
        </div>
    </button>

    {{-- Descrição / Regulamento --}}
    @if (env('REQUIRED_DESCRIPTION'))
        <button class="campanha-btn-branco" type="button" data-bs-toggle="collapse"
            data-bs-target="#descricaoRegulamento" aria-expanded="false">
            <i class="bi bi-clipboard-check"></i> Descrição/Regulamento
        </button>
        <div class="collapse" id="descricaoRegulamento">
            <div class="campanha-descricao">{!! $productDescription !!}</div>
        </div>
    @endif

    {{-- Aviso 18+ --}}
    <div class="campanha-aviso18">
        <span class="badge-18">18+</span> Permitido para maiores de 18 anos
    </div>

    {{-- Compartilhar --}}
    <div class="campanha-share">
        <a class="share-btn" style="background:#2760AE"
            href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}" target="_blank"
            rel="noreferrer noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
        <a class="share-btn" style="background:#2F9DDF" href="https://telegram.me/share/url?url={{ Request::url() }}"
            target="_blank" rel="noreferrer noopener" aria-label="Telegram"><i class="bi bi-telegram"></i></a>
        <a class="share-btn" style="background:#25d366" href="https://api.whatsapp.com/send?text={{ Request::url() }}"
            target="_blank" rel="noreferrer noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
        <a class="share-btn" style="background:#34B3F7"
            href="https://twitter.com/intent/tweet?text=Vc%20pode%20ser%20o%20Próximo%20Ganhador%20{{ Request::url() }}"
            target="_blank" rel="noreferrer noopener" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
    </div>
</div>
