# WhatsApp (Baileys) — Plataforma de Rifa

Documento de referência da integração de WhatsApp do sistema.
Última atualização: 28/08/2026.

## O que mudou

Antes o sistema dependia de uma **API de terceiros** (`api.whatapi.com.br`), com um
`token_api_wpp` guardado em `consulting_environments` e um `Authorization: Bearer`
fixo no código. Se o serviço caísse ou o token vencesse, nenhuma mensagem saía —
e não havia como saber.

Agora o envio é feito por uma **sessão própria do WhatsApp, pareada por QR Code**
(protocolo Baileys, WhatsApp Web multi-dispositivos). Não há mensalidade, token de
terceiro nem intermediário: as mensagens saem do número do próprio dono da rifa.

## Arquitetura

O sistema de rifas **não roda Baileys por conta própria**. Ele conversa com o painel
multi-dispositivos que já existe no servidor:

```
Plataforma de Rifa (Laravel 5.8/PHP 7.4)
        │  HTTP + Basic Auth
        ▼
Painel WhatsApp (Node 24 + Baileys 7 + pm2 "whatsapp-painel")
https://publishdev.com.br/whatsapp/api
        │  WebSocket
        ▼
WhatsApp (aparelho pareado por QR)
```

Motivo: o painel já mantém a sessão viva sob pm2, guarda as credenciais em
`sessions/<id>/`, reconecta sozinho e resolve as armadilhas do protocolo
(JIDs `@lid`, 9º dígito brasileiro, ack 463 da Baileys 6.x). Duplicar isso dentro
do Laravel seria manter dois clientes WhatsApp no mesmo servidor.

A sessão usada pela rifa chama-se **`rifa`** (configurável em `WPP_SESSAO`).

## Configuração (`.env`)

```env
WPP_API_URL=https://publishdev.com.br/whatsapp/api
WPP_API_USER=admin
WPP_API_PASS=whatsapp
WPP_SESSAO=rifa
WPP_TIMEOUT=20
```

## Como conectar (uso normal)

1. Entre no painel → **WhatsApp Mensagens** (`/wpp-mensagens`).
2. Clique em **Conectar / gerar QR**.
3. No celular: WhatsApp → **Aparelhos conectados** → **Conectar aparelho**.
4. Aponte a câmera para o QR. O status vira **Conectado** sozinho (a tela consulta
   o status a cada 3 segundos, sem precisar recarregar).
5. Envie uma **mensagem de teste** pelo campo ao lado para confirmar.

A sessão fica salva. Se o servidor reiniciar, o pm2 sobe o painel e a conexão volta
sozinha — não precisa ler o QR de novo. Só é preciso reparear se alguém clicar em
**Desconectar** ou remover o aparelho pelo celular.

## Arquivos

| Arquivo | Papel |
|---|---|
| `app/Services/WhatsappBaileys.php` | Cliente da API: `status()`, `conectar()`, `desconectar()`, `enviar()`, `jid()`, `limparTexto()` |
| `app/Http/Controllers/HomeAdminController.php` | `wpp()`, `wppSalvar()`, `wppStatus()`, `wppConectar()`, `wppDesconectar()`, `wppTeste()` |
| `resources/views/wpp-msgs/index.blade.php` | Tela: painel de conexão com QR ao vivo + editor das mensagens |
| `app/WhatsappMensagem.php` | Modelo das mensagens e substituição de variáveis (inalterado) |

### Rotas (todas sob `auth` + `isAdmin`)

```
GET  /wpp-mensagens              → tela
POST /wpp-mensagens/salvar       → salva textos das mensagens
GET  /wpp-mensagens/status       → JSON {status, qr, me}   (polling de 3s)
POST /wpp-mensagens/conectar     → cria/reativa a sessão
POST /wpp-mensagens/desconectar  → logout + apaga credenciais
POST /wpp-mensagens/teste        → envia mensagem de teste
```

Estados possíveis em `status`: `inexistente` (nunca conectou) · `starting` ·
`qr` (QR disponível para leitura) · `connecting` · `open` (conectado) ·
`logged_out` (precisa reparear) · `offline` (painel fora do ar).

## Envio programático

```php
$wpp = new \App\Services\WhatsappBaileys();

if ($wpp->conectado()) {
    $r = $wpp->enviar('(82) 99999-9999', "Olá!\nSua reserva foi confirmada.");
    // $r = ['ok' => true|false, 'erro' => string|null]
}
```

`enviar()` normaliza o telefone sozinho (aceita `(82) 99999-9999`, `82999999999` ou
`5582999999999`; assume DDI 55 quando falta) e converte o HTML das mensagens salvas
(`<br />`) em quebras de linha reais.

## Onde as mensagens automáticas disparam

Os quatro pontos que antes chamavam a API de terceiros passaram a usar o serviço:

- `app/Product.php` — pagamento confirmado
- `app/Models/Product.php` — `mensagemWPPRecebido()`
- `app/Http/Controllers/ProductController.php` — confirmação de compra
- `app/Http/Controllers/MySweepstakesController.php` — envio pelo painel

A condição de disparo mudou de `if ($config->token_api_wpp != null)` para
`if ((new WhatsappBaileys())->conectado())`. Falhas de envio não quebram o fluxo da
compra: são registradas com `Log::warning` em `storage/logs/laravel.log`.

## Armadilhas

1. **Baileys precisa ser ≥ 7.x** — a 6.x não entrega mensagens (ack `463` silencioso)
   por causa da migração LID do WhatsApp. Quem cuida disso é o painel; não mexa na
   versão dele por causa da rifa.
2. **O painel exige Basic Auth** em todas as rotas — sem `WPP_API_USER`/`WPP_API_PASS`
   corretos, tudo volta 401 e o status aparece como `offline`.
3. **Não existe envio em massa seguro** — o WhatsApp bane números que disparam muito.
   Mantenha os envios atrelados a eventos reais (reserva, pagamento, sorteio).
4. **`php artisan` não roda na CLI deste servidor** (PHP 8 x Laravel 5.8 / Carbon).
   Teste pela web; as views Blade recompilam por mtime.
5. **Timeout**: o painel pode demorar alguns segundos ao criar a sessão. O
   `WPP_TIMEOUT` de 20s cobre isso; abaixo disso o QR pode não chegar na primeira
   tentativa (a tela repete o polling e resolve sozinha).

## Diagnóstico rápido

```bash
# a API responde?
curl -u admin:whatsapp https://publishdev.com.br/whatsapp/api/sessions

# a sessão da rifa está de pé?
curl -s -u admin:whatsapp https://publishdev.com.br/whatsapp/api/sessions \
  | python3 -m json.tool

# painel caiu?
pm2 logs whatsapp-painel
pm2 restart whatsapp-painel
```
