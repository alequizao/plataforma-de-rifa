# Perguntas frequentes

## O que é a Plataforma de Rifa?

É um sistema web para criar e administrar rifas e sorteios online. O organizador
cadastra a campanha e o prêmio; o comprador escolhe quantas cotas quer, paga por
PIX e recebe os números no WhatsApp. Ao final, o organizador informa o número
sorteado e o ganhador é publicado no site.

## Como funciona o pagamento por PIX?

O sistema se integra a gateways brasileiros (Mercado Pago, Paggue e Asaas). Ao
finalizar a compra, o comprador recebe um QR Code PIX. Quando o pagamento é
identificado, as cotas passam de "reservadas" para "pagas" automaticamente, sem
ninguém precisar enviar comprovante. Um cron confere os pagamentos pendentes a
cada minuto e libera as reservas que expiraram.

## Preciso pagar uma API de WhatsApp?

Não. O sistema usa o protocolo Baileys (o mesmo do WhatsApp Web
multi-dispositivos): você lê um QR Code no painel e as mensagens passam a sair do
seu próprio número. Não há mensalidade nem token de terceiros. A sessão fica
salva e reconecta sozinha se o servidor reiniciar.

## Quais mensagens são enviadas automaticamente?

Três momentos: quando o comprador **reserva** (com o link de pagamento), quando o
pagamento é **confirmado** (com os números adquiridos) e quando alguém **ganha**.
Os textos são editáveis no painel e aceitam variáveis como `{nome}`, `{cotas}`,
`{total}`, `{sorteio}` e `{link}`.

## Dá para mudar as cores do site sem programar?

Sim. A tela **Aparência do site**, no painel, troca cor primária, cor do botão de
compra, fundo, cards, texto, barra, destaque, fonte e o arredondamento dos cantos,
além de alternar entre tema claro e escuro — tudo com prévia ao vivo. Por baixo,
o tema é escrito em variáveis CSS (design tokens), então a mudança vale para o
site inteiro de uma vez.

## Qual a diferença entre modo automático e modo manual?

No **automático**, o comprador escolhe apenas a quantidade e o sistema sorteia
quais números ele recebe — é o formato mais usado em campanhas grandes. No
**manual**, ele vê a grade completa e escolhe os números que quiser, o que
funciona melhor em rifas pequenas, onde as pessoas têm números de preferência.

## Quantos números uma campanha pode ter?

Não há limite rígido: o sistema já roda campanhas de 1 milhão de números. Em
quantidades muito altas, prefira o modo automático — renderizar uma grade com um
milhão de botões trava o navegador do comprador.

## O que é preciso para instalar?

PHP 7.4, MySQL e um servidor web (Apache ou Nginx) apontando para a pasta
`public/`. Depois é `composer install`, copiar o `.env.example` para `.env` com
os dados do banco, gerar a chave da aplicação e importar o banco. Um agendamento
no cron cuida de liberar reservas vencidas e confirmar os PIX.

## Roda em PHP 8?

Não sem ajustes. O projeto usa Laravel 5.8, que não é compatível com PHP 8 —
principalmente por causa da biblioteca de datas (Carbon). Use PHP 7.4.

## Posso usar em produção comercial?

O código é proprietário e está disponível para leitura e avaliação. Uso
comercial, cópia ou redistribuição exigem autorização do autor. Além disso,
rifas e sorteios são atividades reguladas no Brasil: quem opera a plataforma é
responsável pelas autorizações legais e pela restrição de idade.

## Como faço para ter um sistema como este?

Fale com o desenvolvedor: **alequizao.dev@gmail.com** ou WhatsApp
[(82) 98871-7072](https://wa.me/5582988717072).
