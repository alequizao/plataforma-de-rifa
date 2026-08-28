# Arquitetura

## Visão geral

Aplicação Laravel monolítica, renderizada no servidor com Blade. Não há build de
front-end: o CSS e o JavaScript são servidos direto de `public/`, o que mantém o
deploy simples (enviar arquivos e pronto).

```
Comprador (celular)  ──►  Site público  ──►  Gateway PIX
                                │
Organizador ─────────►  Painel administrativo
                                │
                                └──►  API WhatsApp (Baileys)  ──►  WhatsApp do organizador
```

## Estrutura de pastas

| Caminho | Conteúdo |
|---|---|
| `app/Models/`, `app/` | Modelos Eloquent: `Product` (campanha), `Participante` (compra), `Raffle` (cota), `Customer`, `Premio`, `Environment` (configurações) |
| `app/Http/Controllers/` | `ProductController` (site), `CheckoutController` (pagamento), `HomeAdminController` e `MySweepstakesController` (painel) |
| `app/Services/WhatsappBaileys.php` | Cliente HTTP da API de WhatsApp |
| `resources/views/` | Telas em Blade; `rifas/` guarda as partes da tela de campanha |
| `public/css/tema-gemeos.css` | Tema visual completo, em variáveis CSS |
| `config/versao.php` | Histórico de versões exibido no painel |
| `routes/web.php` | Rotas públicas e do painel (grupos `auth` e `isAdmin`) |

## Modelo de dados

- **`products`** — a campanha: nome, prêmio, preço da cota, quantidade, status, modo de jogo, data do sorteio
- **`raffles`** — uma linha por cota; guarda o número, o status (`Disponivel`, `Reservado`, `Pago`) e a quem pertence
- **`participant`** — a compra: comprador, campanha, valor, quantidade e situação do pagamento
- **`customers`** — cadastro de clientes, identificados pelo telefone
- **`premios`** — os ganhadores divulgados
- **`compras_automaticas`** — os pacotes promocionais de cada campanha
- **`consulting_environments`** — configurações gerais: logo, redes sociais, credenciais dos gateways e as cores do tema

## Fluxo de compra

1. O comprador escolhe a quantidade (ou os números) e informa o telefone
2. O sistema cria o `participant` e marca as cotas como **reservadas**
3. O gateway gera o PIX; o comprador paga
4. O cron confirma o pagamento, marca as cotas como **pagas** e dispara a mensagem no WhatsApp
5. Reservas não pagas expiram e as cotas voltam a ficar disponíveis

## Tema visual

Todo o visual sai de variáveis CSS (`--incrivel-*`) definidas em um único bloco
`:root`. O painel grava as cores escolhidas no banco e o layout injeta um
`<style>` que sobrescreve esses tokens — por isso trocar a identidade do site
inteiro não exige tocar em CSS.

O miolo tem largura máxima de 600px em qualquer tela: a experiência foi desenhada
para o celular, de onde vem praticamente todo o tráfego desse tipo de campanha.

## Agendamento

```cron
* * * * * cd /caminho/do/projeto && php artisan schedule:run >> /dev/null 2>&1
```

Responsável por liberar reservas vencidas e confirmar pagamentos PIX pendentes.
