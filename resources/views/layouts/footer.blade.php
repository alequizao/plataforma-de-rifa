{{--
    Rodapé público — Plataforma de Rifa
    Desenvolvido por @alequizao
    Instagram: @alequizao · WhatsApp: 55 82 98871-7072 · alequizao.dev@gmail.com
--}}
@if (!env('HIDE_FOOTER'))
    <footer class="app-footer-dev">
        <div class="dev-marca">
            Desenvolvido por
            <a href="https://instagram.com/alequizao" target="_blank" rel="noopener noreferrer">@alequizao</a>
        </div>

        <div class="dev-contatos">
            <a href="https://instagram.com/alequizao" target="_blank" rel="noopener noreferrer"
                aria-label="Instagram @alequizao" title="Instagram @alequizao">
                <i class="bi bi-instagram"></i>
            </a>
            <a href="https://wa.me/5582988717072" target="_blank" rel="noopener noreferrer"
                aria-label="WhatsApp (82) 98871-7072" title="WhatsApp (82) 98871-7072">
                <i class="bi bi-whatsapp"></i>
            </a>
            <a href="mailto:alequizao.dev@gmail.com" aria-label="alequizao.dev@gmail.com"
                title="alequizao.dev@gmail.com">
                <i class="bi bi-envelope-fill"></i>
            </a>
        </div>
    </footer>
@endif
