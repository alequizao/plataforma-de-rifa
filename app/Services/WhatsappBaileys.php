<?php

namespace App\Services;

/**
 * Plataforma de Rifa
 *
 * @author  @alequizao <alequizao.dev@gmail.com>
 * @link    https://instagram.com/alequizao
 * @contact WhatsApp +55 82 98871-7072
 */

/**
 * Cliente do painel WhatsApp (Baileys) em publishdev.com.br/whatsapp.
 *
 * O sistema de rifas NÃO roda Baileys por conta própria: ele conversa com o
 * painel multi-dispositivos já existente, que mantém a sessão viva (pm2),
 * guarda as credenciais em sessions/<id>/ e reconecta sozinho.
 *
 * Fluxo de conexão: criarSessao() -> status() devolve o QR em data:image ->
 * o usuário escaneia -> status() passa a 'open' -> enviar() funciona.
 */
class WhatsappBaileys
{
    /** @var string URL base da API (sem barra final) */
    protected $base;
    /** @var string usuário do Basic Auth */
    protected $user;
    /** @var string senha do Basic Auth */
    protected $pass;
    /** @var string id da sessão/dispositivo usado pelo sistema de rifas */
    protected $sessao;
    /** @var int timeout das chamadas, em segundos */
    protected $timeout;

    public function __construct()
    {
        $this->base    = rtrim(env('WPP_API_URL', 'https://publishdev.com.br/whatsapp/api'), '/');
        $this->user    = env('WPP_API_USER', 'admin');
        $this->pass    = env('WPP_API_PASS', 'whatsapp');
        $this->sessao  = env('WPP_SESSAO', 'rifa');
        $this->timeout = (int) env('WPP_TIMEOUT', 20);
    }

    public function sessao()
    {
        return $this->sessao;
    }

    /**
     * Situação da sessão: ['status' => qr|open|connecting|logged_out|offline,
     *                      'qr' => data:image|null, 'me' => [...]|null]
     */
    public function status()
    {
        $r = $this->request('GET', '/sessions');

        if (!$r['ok'] || !is_array($r['body'])) {
            return [
                'status' => 'offline',
                'qr'     => null,
                'me'     => null,
                'erro'   => $r['erro'] ?: 'Painel WhatsApp indisponível',
            ];
        }

        foreach ($r['body'] as $s) {
            if (isset($s['id']) && $s['id'] === $this->sessao) {
                return [
                    'status' => $s['status'] ?? 'offline',
                    'qr'     => $s['qr'] ?? null,
                    'me'     => $s['me'] ?? null,
                    'erro'   => null,
                ];
            }
        }

        // sessão ainda não existe no painel
        return ['status' => 'inexistente', 'qr' => null, 'me' => null, 'erro' => null];
    }

    /** Cria (ou reativa) a sessão. Depois disso o QR aparece em status(). */
    public function conectar()
    {
        return $this->request('POST', '/sessions', ['id' => $this->sessao]);
    }

    /** Faz logout e apaga as credenciais — exige novo QR. */
    public function desconectar()
    {
        return $this->request('DELETE', '/sessions/' . rawurlencode($this->sessao));
    }

    public function conectado()
    {
        return $this->status()['status'] === 'open';
    }

    /**
     * Envia uma mensagem de texto.
     *
     * @param string $telefone  em qualquer formato: (82) 99999-9999, 82999999999, 5582...
     * @param string $mensagem  texto já com as variáveis substituídas
     * @return array ['ok' => bool, 'erro' => string|null]
     */
    public function enviar($telefone, $mensagem)
    {
        $jid = $this->jid($telefone);

        if (!$jid) {
            return ['ok' => false, 'erro' => 'Telefone inválido: ' . $telefone];
        }

        if (trim(strip_tags($mensagem)) === '') {
            return ['ok' => false, 'erro' => 'Mensagem vazia'];
        }

        $r = $this->request('POST', '/' . rawurlencode($this->sessao) . '/send', [
            'jid'  => $jid,
            'text' => $this->limparTexto($mensagem),
        ], true);

        return ['ok' => $r['ok'], 'erro' => $r['erro'], 'resposta' => $r['body']];
    }

    /**
     * Normaliza o telefone em JID do WhatsApp.
     * Aceita com/sem DDI, com máscara, e assume Brasil (55) quando faltar.
     */
    public function jid($telefone)
    {
        $n = preg_replace('/\D/', '', (string) $telefone);

        if ($n === '') {
            return null;
        }

        // já veio com DDI 55
        if (strpos($n, '55') === 0 && strlen($n) >= 12) {
            $numero = $n;
        } elseif (strlen($n) >= 10 && strlen($n) <= 11) {
            $numero = '55' . $n;                 // DDD + número
        } else {
            $numero = $n;                        // internacional, deixa como veio
        }

        if (strlen($numero) < 12) {
            return null;
        }

        return $numero . '@s.whatsapp.net';
    }

    /** Converte o HTML das mensagens salvas em texto puro de WhatsApp. */
    public function limparTexto($msg)
    {
        $t = str_replace(['<br />', '<br/>', '<br>'], "\n", (string) $msg);
        $t = html_entity_decode(strip_tags($t), ENT_QUOTES, 'UTF-8');

        return trim($t);
    }

    /**
     * Chamada HTTP à API. $multipart=true usa campos de formulário
     * (o endpoint /send é multipart por causa do upload de arquivo).
     */
    protected function request($metodo, $rota, array $dados = [], $multipart = false)
    {
        $url = $this->base . $rota;
        $ch  = curl_init();

        $opts = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => $metodo,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_USERPWD        => $this->user . ':' . $this->pass,
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
        ];

        if (!empty($dados)) {
            if ($multipart) {
                $opts[CURLOPT_POSTFIELDS] = $dados;
            } else {
                $opts[CURLOPT_POSTFIELDS] = json_encode($dados);
                $opts[CURLOPT_HTTPHEADER] = ['Content-Type: application/json'];
            }
        }

        curl_setopt_array($ch, $opts);

        $raw  = curl_exec($ch);
        $cod  = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl = curl_error($ch);
        curl_close($ch);

        if ($raw === false) {
            return ['ok' => false, 'body' => null, 'codigo' => 0, 'erro' => $curl ?: 'Falha de conexão'];
        }

        $body = json_decode($raw, true);
        $ok   = $cod >= 200 && $cod < 300;

        $erro = null;
        if (!$ok) {
            $erro = is_array($body) && isset($body['error'])
                ? $body['error']
                : 'HTTP ' . $cod . ' — ' . substr(strip_tags($raw), 0, 180);
        }

        return ['ok' => $ok, 'body' => $body, 'codigo' => $cod, 'erro' => $erro];
    }
}
