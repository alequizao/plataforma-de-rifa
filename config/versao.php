<?php

/**
 * Plataforma de Rifa — histórico de versões.
 *
 * Ao alterar o sistema: suba a versão em 'atual' e acrescente uma entrada no
 * topo de 'historico'. A tela do painel (menu → Versões) lê este arquivo.
 *
 * @author @alequizao <alequizao.dev@gmail.com>
 */

return [

    'atual' => '2.3.0',
    'data'  => '2026-08-28',

    'historico' => [

        [
            'versao' => '2.3.0',
            'data'   => '2026-08-28',
            'titulo' => 'Sorteador com a cara do sorteador.com.br',
            'tipo'   => 'menor',
            'itens'  => [
                ['tipo' => 'novo', 'txt' => 'Visual novo do Sorteador, inspirado no sorteador.com.br: abas coloridas (Números, Nomes, Equipes, Rifas), fundo aquarela, frase grande "Sortear 1 número entre 1 e 100" e botão laranja.'],
                ['tipo' => 'novo', 'txt' => 'Opções do sorteio em acordeão: ordem crescente/alfabética, mostrar resultado ao clicar no item, contagem regressiva, permitir repetição, ignorar repetidos e suplentes.'],
                ['tipo' => 'novo', 'txt' => 'Tela de resultado com bolas, cards de informação (data, quantidade, intervalo) e ações: salvar, sortear sem repetir, alterar e voltar.'],
                ['tipo' => 'novo', 'txt' => 'Salvar resultado gera um link permanente (/sorteador/resultado/CODIGO) para compartilhar por WhatsApp; a página salva mostra o mesmo resultado com data do servidor.'],
                ['tipo' => 'novo', 'txt' => 'Importação de lista por arquivo .txt ou .csv (clique ou arraste) e escolha do critério de separação (linha, vírgula ou ponto e vírgula).'],
                ['tipo' => 'novo', 'txt' => 'Equipes podem ser divididas por número de equipes ou por participantes por equipe.'],
                ['tipo' => 'melhoria', 'txt' => 'Botão laranja "Sorteador" no menu do site e no menu do celular; o menu horizontal nunca mais quebra linha em telas pequenas.'],
            ],
        ],

        [
            'versao' => '2.2.2',
            'data'   => '2026-08-28',
            'titulo' => 'Sorteador dentro do painel',
            'tipo'   => 'correcao',
            'itens'  => [
                ['tipo' => 'melhoria', 'txt' => 'O Sorteador agora abre dentro do painel, na barra lateral, para quem está logado. O link foi retirado do menu do site.'],
                ['tipo' => 'corrigido', 'txt' => 'O visual do Sorteador não carregava dentro do painel: os estilos viviam no tema do site, que o painel não usa. Foram movidos para um arquivo próprio, usado nos dois lugares.'],
                ['tipo' => 'corrigido', 'txt' => 'Na tela da campanha automática, um script tentava preencher a grade de números que só existe nas rifas manuais — dava erro e ainda baixava a lista inteira de cotas sem necessidade.'],
                ['tipo' => 'corrigido', 'txt' => 'A máscara de telefone e o SDK de pagamento quebravam o restante do JavaScript nas páginas onde os campos não existem.'],
            ],
        ],

        [
            'versao' => '2.2.1',
            'data'   => '2026-08-28',
            'titulo' => 'Correção de segurança no Sorteador',
            'tipo'   => 'correcao',
            'itens'  => [
                ['tipo' => 'corrigido', 'txt' => 'O sorteio entre os participantes de uma campanha estava aberto ao público: qualquer visitante poderia sortear o ganhador da rifa. Agora exige login de organizador, tanto na tela quanto no servidor.'],
                ['tipo' => 'melhoria', 'txt' => 'Atalho para o Sorteador no menu do painel.'],
            ],
        ],

        [
            'versao' => '2.2.0',
            'data'   => '2026-08-28',
            'titulo' => 'Sorteador próprio e site indexável no Google',
            'tipo'   => 'menor',
            'itens'  => [
                ['tipo' => 'novo', 'txt' => 'Aba Sorteador: sorteio de números, de nomes (com suplentes), formação de equipes e sorteio entre os participantes de uma campanha.'],
                ['tipo' => 'novo', 'txt' => 'Cada resultado sai com data, hora e código de conferência, e pode ser copiado pronto para publicar no grupo.'],
                ['tipo' => 'corrigido', 'txt' => 'O site inteiro estava bloqueado para o Google por um meta robots noindex.'],
                ['tipo' => 'novo', 'txt' => 'Sitemap automático, robots.txt, descrições, Open Graph e dados estruturados para buscadores e assistentes de IA.'],
                ['tipo' => 'corrigido', 'txt' => 'Tokens de pagamento que estavam escritos dentro do código foram removidos.'],
            ],
        ],

        [
            'versao' => '2.1.0',
            'data'   => '2026-08-28',
            'titulo' => 'Cadastro manual de clientes e fotos reais nas campanhas',
            'tipo'   => 'menor',
            'itens'  => [
                ['tipo' => 'novo', 'txt' => 'Cadastro manual de cliente pelo painel, com máscara de telefone e CPF e checagem de telefone repetido.'],
                ['tipo' => 'melhoria', 'txt' => 'As 10 campanhas demonstrativas agora usam fotos reais dos prêmios, no lugar das capas geradas por código.'],
                ['tipo' => 'corrigido', 'txt' => 'Blocos de promoção e da barra de progresso ficavam por cima dos vizinhos na tela da campanha: havia margens negativas escritas direto no HTML, que nenhum CSS conseguia sobrescrever.'],
                ['tipo' => 'melhoria', 'txt' => 'Barra de progresso da campanha com o acabamento do tema (cantos arredondados e cores dos tokens).'],
            ],
        ],

        [
            'versao' => '2.0.0',
            'data'   => '2026-08-28',
            'titulo' => 'Novo visual, WhatsApp próprio e personalização',
            'tipo'   => 'maior',
            'itens'  => [
                ['tipo' => 'novo', 'txt' => 'Visual completamente refeito no padrão Gêmeos Brasil: cabeçalho azul fixo, miolo arredondado de 600px, cards de campanha, botão verde de compra e carrossel de ganhadores.'],
                ['tipo' => 'novo', 'txt' => 'Tela de campanha reconstruída: capa em tela cheia, barra "Meus títulos", seletor de quantidade, grade de pacotes e botão com preço unitário e total.'],
                ['tipo' => 'novo', 'txt' => 'Compra rápida direto na página inicial, com os atalhos +200 / +300 e o total calculado na hora.'],
                ['tipo' => 'novo', 'txt' => 'WhatsApp próprio via QR Code (Baileys), no lugar da API paga de terceiros. Conexão, status ao vivo e envio de teste na tela de mensagens.'],
                ['tipo' => 'novo', 'txt' => 'Tela "Aparência do site": troca de cores, tema claro/escuro, fonte e cantos, com prévia ao vivo.'],
                ['tipo' => 'novo', 'txt' => 'Manual completo com imagens em Tutoriais.'],
                ['tipo' => 'novo', 'txt' => 'Clientes: exportação em CSV e exclusão direto na listagem.'],
                ['tipo' => 'novo', 'txt' => 'Página de ganhadores redesenhada, com foto, prêmio e data da premiação.'],
                ['tipo' => 'novo', 'txt' => 'Esta tela de versões.'],
                ['tipo' => 'corrigido', 'txt' => 'Erro "Failed to fetch" ao excluir fotos e em outras ações do painel: o sistema gerava endereços http:// dentro de páginas https:// e o navegador bloqueava.'],
                ['tipo' => 'corrigido', 'txt' => 'Ícones que sumiam no menu do painel — o sistema usava nomes do FontAwesome 6 com a biblioteca 5 instalada. Tudo migrado para bootstrap-icons.'],
                ['tipo' => 'corrigido', 'txt' => 'Conteúdo encolhia para metade da largura em tablets e computadores.'],
                ['tipo' => 'corrigido', 'txt' => 'Botões flutuantes de WhatsApp e Instagram cobriam os cards.'],
                ['tipo' => 'corrigido', 'txt' => 'Rolagem horizontal indevida em telas estreitas (testado de 280px a 2560px).'],
                ['tipo' => 'corrigido', 'txt' => 'Alinhamento e espaçamento dos blocos da tela de campanha.'],
                ['tipo' => 'corrigido', 'txt' => 'Rota de Tutoriais não existia e caía na tela de login.'],
                ['tipo' => 'corrigido', 'txt' => 'CSS antigo preso no cache do navegador — agora cada alteração gera um endereço novo automaticamente.'],
                ['tipo' => 'melhoria', 'txt' => 'Site mais rápido: FontAwesome removido do site público, imagens com carregamento adiado, de 110 para 36 requisições.'],
                ['tipo' => 'melhoria', 'txt' => 'Rodapé com a assinatura do desenvolvedor e canais de contato.'],
            ],
        ],

        [
            'versao' => '1.0.0',
            'data'   => '2023-11-27',
            'titulo' => 'Versão original',
            'tipo'   => 'maior',
            'itens'  => [
                ['tipo' => 'novo', 'txt' => 'Sistema de rifas com cotas automáticas e manuais, fazendinha, checkout PIX, área de afiliados e painel administrativo.'],
            ],
        ],
    ],
];
