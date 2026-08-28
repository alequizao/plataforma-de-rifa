{{--
    Manual / Tutoriais — Plataforma de Rifa
    Desenvolvido por @alequizao · alequizao.dev@gmail.com
--}}
@extends('layouts.admin')

@section('content')
    <div class="container-fluid tut" style="max-width:1100px">

        <header class="tut-capa">
            <h1>📚 Manual da Plataforma</h1>
            <p>Tudo o que você precisa para publicar rifas, vender cotas e pagar os ganhadores.</p>
        </header>

        {{-- índice --}}
        <nav class="tut-indice">
            <a href="#inicio">1. Primeiros passos</a>
            <a href="#aparencia">2. Aparência</a>
            <a href="#rifa">3. Criar uma rifa</a>
            <a href="#site">4. Como o cliente compra</a>
            <a href="#whatsapp">5. WhatsApp</a>
            <a href="#pagamentos">6. Pagamentos</a>
            <a href="#sorteio">7. Sorteio e ganhadores</a>
            <a href="#clientes">8. Clientes</a>
            <a href="#duvidas">9. Dúvidas</a>
            @if (count($videos))<a href="#videos">10. Vídeos</a>@endif
        </nav>

        {{-- 1 --}}
        <section class="tut-secao" id="inicio">
            <h2><span>1</span> Primeiros passos</h2>
            <div class="tut-grid">
                <div>
                    <p>O sistema tem duas partes:</p>
                    <ul>
                        <li><b>O site</b> — onde o cliente vê as rifas e compra as cotas.</li>
                        <li><b>O painel</b> — onde você cria rifas, acompanha vendas e sorteia.</li>
                    </ul>
                    <p>Você entra no painel por <code>/login</code>, com o usuário e a senha
                        que recebeu. Depois de entrar, use o menu da esquerda para navegar.</p>
                    <div class="tut-dica">
                        <b>Dica:</b> troque a senha em <b>Meu perfil</b> logo no primeiro acesso.
                    </div>
                </div>
                <figure>
                    <img src="{{ asset('images/tutorial/login.webp') }}" alt="Tela de login do painel" loading="lazy">
                    <figcaption>Tela de entrada do painel</figcaption>
                </figure>
            </div>
        </section>

        {{-- 2 --}}
        <section class="tut-secao" id="aparencia">
            <h2><span>2</span> Deixar o site com a sua cara</h2>
            <div class="tut-grid">
                <div>
                    <p>Em <b>Aparência do site</b> você muda tudo sem mexer em código:</p>
                    <ol>
                        <li>Escolha o <b>tema</b>: claro ☀️ ou escuro 🌙.</li>
                        <li>Ajuste as <b>cores</b> — primária, botão de compra, fundo, cards, texto.</li>
                        <li>Escolha a <b>fonte</b> e o formato dos <b>cantos</b>.</li>
                        <li>Confira na <b>prévia ao vivo</b>, ao lado, e clique em <b>Salvar</b>.</li>
                    </ol>
                    <p>A logo é trocada em <b>Meu perfil</b>.</p>
                    <div class="tut-dica">
                        <b>Se errar a mão:</b> o botão <b>Restaurar padrão</b> devolve as cores originais.
                    </div>
                </div>
                <figure>
                    <img src="{{ asset('images/tutorial/home.webp') }}" alt="Página inicial do site" loading="lazy">
                    <figcaption>É esta tela que muda de cor</figcaption>
                </figure>
            </div>
        </section>

        {{-- 3 --}}
        <section class="tut-secao" id="rifa">
            <h2><span>3</span> Criar uma rifa</h2>
            <div class="tut-passos">
                <div class="tut-passo"><b>1. Adicionar sorteio</b>
                    <p>Menu <b>Meus sorteios → Adicionar</b>. Preencha título, descrição curta,
                        preço da cota e quantidade de números.</p></div>
                <div class="tut-passo"><b>2. Fotos</b>
                    <p>Envie ao menos uma foto do prêmio. A primeira é a capa. Boa foto vende mais.</p></div>
                <div class="tut-passo"><b>3. Modo de jogo</b>
                    <p><b>Automático</b>: o site sorteia os números do cliente.
                        <b>Manual</b>: o cliente escolhe os números na tela.</p></div>
                <div class="tut-passo"><b>4. Mínimo e máximo</b>
                    <p>Quantas cotas cada pessoa pode comprar por vez. O mínimo já vem preenchido no site.</p></div>
                <div class="tut-passo"><b>5. Pacotes promocionais</b>
                    <p>São os botões <b>+100</b>, <b>+200</b>, <b>+500</b>. Marque um como
                        <b>popular</b> para ele aparecer em verde.</p></div>
                <div class="tut-passo"><b>6. Publicar</b>
                    <p>Deixe o status como <b>Ativo</b>. Para aparecer no topo do site, marque
                        a rifa como <b>destaque</b>.</p></div>
            </div>
        </section>

        {{-- 4 --}}
        <section class="tut-secao" id="site">
            <h2><span>4</span> Como o cliente compra</h2>
            <div class="tut-galeria">
                <figure>
                    <img src="{{ asset('images/tutorial/home.webp') }}" alt="Home com as campanhas" loading="lazy">
                    <figcaption><b>1.</b> Vê as campanhas e escolhe a quantidade direto na home</figcaption>
                </figure>
                <figure>
                    <img src="{{ asset('images/tutorial/campanha.webp') }}" alt="Tela da campanha" loading="lazy">
                    <figcaption><b>2.</b> Na campanha, ajusta a quantidade e clica em <b>Garantir números</b></figcaption>
                </figure>
                <figure>
                    <img src="{{ asset('images/tutorial/campanha-numeros.webp') }}" alt="Escolha de números" loading="lazy">
                    <figcaption><b>3.</b> No modo manual, escolhe os números na grade</figcaption>
                </figure>
            </div>
            <p class="mt-2">Depois disso ele informa o telefone, confirma a reserva e paga pelo PIX.
                A reserva fica presa por um tempo; se não pagar, os números voltam a ficar livres
                automaticamente.</p>
        </section>

        {{-- 5 --}}
        <section class="tut-secao" id="whatsapp">
            <h2><span>5</span> WhatsApp automático</h2>
            <div class="tut-grid">
                <div>
                    <p>O sistema avisa o cliente sozinho pelo <b>seu próprio número</b>. Para ligar:</p>
                    <ol>
                        <li>Menu <b>Mensagens WhatsApp</b>.</li>
                        <li>Clique em <b>Conectar / gerar QR</b>.</li>
                        <li>No celular: WhatsApp → <b>Aparelhos conectados</b> → <b>Conectar aparelho</b>.</li>
                        <li>Aponte a câmera para o QR. O status vira <b>Conectado</b> sozinho.</li>
                        <li>Mande uma <b>mensagem de teste</b> para confirmar.</li>
                    </ol>
                    <p>Na mesma tela você edita os textos das mensagens. Use as variáveis
                        <code>{nome}</code>, <code>{cotas}</code>, <code>{total}</code>,
                        <code>{sorteio}</code> e <code>{link}</code> — elas são trocadas pelos
                        dados reais na hora do envio.</p>
                    <div class="tut-aviso">
                        <b>Atenção:</b> não use para disparo em massa. O WhatsApp bloqueia números
                        que enviam muitas mensagens para quem não pediu.
                    </div>
                </div>
                <div class="tut-quadro">
                    <h4>Quando o cliente recebe</h4>
                    <ul>
                        <li>Ao <b>reservar</b> — com o link de pagamento</li>
                        <li>Ao <b>pagar</b> — confirmação com os números</li>
                        <li>Ao <b>ganhar</b> — aviso do prêmio</li>
                    </ul>
                    <p class="text-muted mb-0" style="font-size:12px">
                        A sessão fica salva: se o servidor reiniciar, reconecta sozinha.
                        Só precisa ler o QR de novo se você desconectar.
                    </p>
                </div>
            </div>
        </section>

        {{-- 6 --}}
        <section class="tut-secao" id="pagamentos">
            <h2><span>6</span> Receber por PIX</h2>
            <p>Em <b>Meu perfil</b> você cola as credenciais do seu gateway (Mercado Pago,
                Paggue ou Asaas). Sem isso o site não gera PIX e nenhuma venda é confirmada.</p>
            <div class="tut-aviso">
                <b>Importante:</b> o token que veio no pacote original é do vendedor anterior e
                <b>não funciona</b>. Pegue o seu em
                <i>mercadopago.com.br/developers → Suas integrações → Credenciais de produção →
                    Access Token</i> e cole no perfil.
            </div>
            <p>Quando o cliente paga, o sistema dá baixa sozinho em poucos minutos, marca as cotas
                como pagas e dispara a mensagem de confirmação.</p>
        </section>

        {{-- 7 --}}
        <section class="tut-secao" id="sorteio">
            <h2><span>7</span> Sorteio e ganhadores</h2>
            <div class="tut-grid">
                <div>
                    <ol>
                        <li>Abra a rifa em <b>Meus sorteios</b>.</li>
                        <li>Use <b>Definir ganhador</b> e informe o número sorteado
                            (geralmente pela Loteria Federal).</li>
                        <li>O sistema mostra quem comprou aquele número.</li>
                        <li>Confirme — o ganhador passa a aparecer na página pública.</li>
                        <li>Mude o status da rifa para <b>Finalizado</b>.</li>
                    </ol>
                    <p>A página <b>Ganhadores</b> fica pública e serve como prova social:
                        é ela que dá confiança para as próximas rifas.</p>
                </div>
                <figure>
                    <img src="{{ asset('images/tutorial/ganhadores.webp') }}" alt="Página de ganhadores" loading="lazy">
                    <figcaption>Página pública de ganhadores</figcaption>
                </figure>
            </div>
        </section>

        {{-- 8 --}}
        <section class="tut-secao" id="clientes">
            <h2><span>8</span> Clientes</h2>
            <div class="tut-grid">
                <div>
                    <p>Em <b>Clientes</b> ficam todos que já compraram. Você pode:</p>
                    <ul>
                        <li><b>Buscar</b> por nome ou telefone;</li>
                        <li><b>Editar</b> os dados de contato;</li>
                        <li><b>Exportar</b> a lista em CSV (abre no Excel);</li>
                        <li><b>Excluir</b> um cliente.</li>
                    </ul>
                    <div class="tut-aviso">
                        <b>Cuidado:</b> excluir é definitivo. O histórico de compras daquele
                        cliente deixa de aparecer.
                    </div>
                </div>
                <figure>
                    <img src="{{ asset('images/tutorial/sorteios.webp') }}" alt="Lista de campanhas" loading="lazy">
                    <figcaption>Listagens do sistema seguem este padrão</figcaption>
                </figure>
            </div>
        </section>

        {{-- 9 --}}
        <section class="tut-secao" id="duvidas">
            <h2><span>9</span> Dúvidas frequentes</h2>
            <details><summary>O cliente pagou e não recebeu os números</summary>
                <p>Verifique se o gateway está configurado em <b>Meu perfil</b>. Se estiver,
                    abra a rifa → <b>Compras</b>, procure o pedido e use <b>Dar baixa manual</b>.</p></details>
            <details><summary>As mensagens do WhatsApp pararam</summary>
                <p>Vá em <b>Mensagens WhatsApp</b> e veja o status. Se estiver
                    <b>Não conectado</b>, clique em Conectar e leia o QR de novo.</p></details>
            <details><summary>Quero mudar as cores do site</summary>
                <p>Menu <b>Aparência do site</b>. Ajuste, veja na prévia e salve.</p></details>
            <details><summary>Como coloco uma rifa em destaque?</summary>
                <p>Em <b>Meus sorteios</b>, marque a opção <b>destaque</b>. Ela sobe para o topo
                    da home com o botão grande de compra.</p></details>
            <details><summary>Alterei algo e o site continua igual</summary>
                <p>É cache do navegador. Segure <b>Ctrl</b> e aperte <b>F5</b>.</p></details>
        </section>

        {{-- 10 --}}
        @if (count($videos))
            <section class="tut-secao" id="videos">
                <h2><span>10</span> Vídeos</h2>
                <div class="tut-videos">
                    @foreach ($videos as $video)
                        <div class="tut-video">
                            <h6>{{ $video->title }}</h6>
                            <div class="tut-video-frame">
                                <iframe src="https://www.youtube.com/embed/{{ $video->link }}"
                                    title="{{ $video->title }}" frameborder="0" loading="lazy"
                                    allow="accelerometer; clipboard-write; encrypted-media; picture-in-picture"
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <footer class="tut-rodape">
            Precisa de ajuda?
            <a href="https://wa.me/5582988717072" target="_blank" rel="noopener">WhatsApp (82) 98871-7072</a> ·
            <a href="https://instagram.com/alequizao" target="_blank" rel="noopener">@alequizao</a> ·
            <a href="mailto:alequizao.dev@gmail.com">alequizao.dev@gmail.com</a>
        </footer>
    </div>

    <style>
        .tut { padding: 18px 14px 60px; color: #252831; }
        .tut-capa {
            background: linear-gradient(135deg, #00307a, #0a4ba8);
            color: #fff; border-radius: 16px; padding: 26px 22px; margin-bottom: 18px;
        }
        .tut-capa h1 { margin: 0 0 6px; font-size: 1.6rem; font-weight: 700; }
        .tut-capa p { margin: 0; opacity: .85; font-size: .95rem; }

        .tut-indice {
            display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 22px;
        }
        .tut-indice a {
            background: #fff; border: 1px solid #e3e6ef; border-radius: 999px;
            padding: 7px 14px; font-size: 13px; color: #00307a; text-decoration: none; font-weight: 600;
        }
        .tut-indice a:hover { background: #00307a; color: #fff; }

        .tut-secao {
            background: #fff; border: 1px solid #e9ecf2; border-radius: 14px;
            padding: 20px; margin-bottom: 16px; scroll-margin-top: 80px;
        }
        .tut-secao h2 {
            font-size: 1.2rem; font-weight: 700; margin: 0 0 14px;
            display: flex; align-items: center; gap: 10px;
        }
        .tut-secao h2 span {
            background: #00307a; color: #fff; width: 30px; height: 30px; flex: 0 0 30px;
            border-radius: 50%; display: inline-flex; align-items: center;
            justify-content: center; font-size: .9rem;
        }
        .tut-secao p, .tut-secao li { font-size: .92rem; line-height: 1.55; }
        .tut-secao code {
            background: #f1f3f8; color: #b5179e; padding: 1px 6px;
            border-radius: 5px; font-size: .85em;
        }

        .tut-grid { display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start; }
        .tut-grid figure { margin: 0; }
        .tut-grid img, .tut-galeria img {
            width: 100%; border-radius: 12px; border: 1px solid #e3e6ef;
            box-shadow: 0 6px 20px rgba(0,0,0,.08);
        }
        figcaption { font-size: 12px; color: #8a90a6; text-align: center; margin-top: 6px; }

        .tut-galeria { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
        .tut-galeria figure { margin: 0; }

        .tut-passos { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .tut-passo {
            background: #f8f9fc; border: 1px solid #edf0f6; border-left: 3px solid #00307a;
            border-radius: 10px; padding: 12px 14px;
        }
        .tut-passo b { font-size: .92rem; }
        .tut-passo p { margin: 4px 0 0; font-size: .86rem; color: #545a6b; }

        .tut-dica, .tut-aviso {
            border-radius: 10px; padding: 12px 14px; font-size: .87rem; margin-top: 12px;
        }
        .tut-dica { background: #eafaf1; border: 1px solid #b7e4c7; }
        .tut-aviso { background: #fff6e5; border: 1px solid #ffe0a3; }

        .tut-quadro { background: #f8f9fc; border: 1px solid #edf0f6; border-radius: 12px; padding: 16px; }
        .tut-quadro h4 { font-size: 1rem; font-weight: 700; margin-bottom: 8px; }

        .tut-secao details {
            border-bottom: 1px solid #eef1f6; padding: 10px 0;
        }
        .tut-secao details:last-child { border-bottom: 0; }
        .tut-secao summary { cursor: pointer; font-weight: 600; font-size: .92rem; }
        .tut-secao details p { margin: 8px 0 0; color: #545a6b; }

        .tut-videos { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .tut-video-frame { position: relative; padding-top: 56.25%; border-radius: 10px; overflow: hidden; }
        .tut-video-frame iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }

        .tut-rodape {
            text-align: center; color: #8a90a6; font-size: 13px; padding: 18px 0 0;
        }
        .tut-rodape a { color: #00307a; font-weight: 600; }

        @media (max-width: 900px) {
            .tut-grid, .tut-galeria, .tut-passos, .tut-videos { grid-template-columns: 1fr; }
        }
    </style>
@endsection
