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

    'atual' => '2.2.0',
    'data'  => '2026-08-28',

    'historico' => [

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
