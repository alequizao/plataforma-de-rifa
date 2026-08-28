<?php

namespace App\Http\Controllers;

/**
 * Plataforma de Rifa — Sorteador
 *
 * @author  @alequizao <alequizao.dev@gmail.com>
 * @link    https://instagram.com/alequizao
 * @contact WhatsApp +55 82 98871-7072
 */

use App\Models\Product;
use App\Models\Raffle;
use App\Environment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SorteadorController extends Controller
{
    /** Página pública do sorteador. */
    public function index()
    {
        // A aba que sorteia o ganhador de uma campanha é restrita ao
        // organizador: o visitante comum só vê números, nomes e equipes.
        $ehAdmin = \Illuminate\Support\Facades\Auth::check();

        $campanhas = $ehAdmin
            ? Product::where('visible', '=', 1)->orderBy('id', 'desc')->get(['id', 'name', 'slug', 'status'])
            : collect();

        // Logado: abre dentro do painel, com a barra lateral.
        // Visitante: página pública, com o layout do site.
        $view = $ehAdmin ? 'painel.sorteador' : 'sorteador';

        return view($view, [
            'ehAdmin'   => $ehAdmin,
            'campanhas' => $campanhas,
            'config'    => Environment::find(1),
            'salvo'     => null,
        ]);
    }

    /**
     * Salva um resultado para gerar link permanente (/sorteador/resultado/{codigo}).
     *
     * O sorteio em si é feito no navegador; aqui só guardamos o que foi
     * sorteado, com data do servidor, para o participante conferir depois.
     */
    public function salvar(Request $request)
    {
        $r = $request->input('resultado');

        if (!is_array($r) || empty($r['tipo'])) {
            return response()->json(['ok' => false, 'msg' => 'Resultado inválido.']);
        }

        $tipo = (string) $r['tipo'];

        if (!in_array($tipo, ['numeros', 'nomes', 'equipes', 'campanha'], true)) {
            return response()->json(['ok' => false, 'msg' => 'Tipo de sorteio inválido.']);
        }

        // Só o organizador logado pode publicar resultado de campanha.
        if ($tipo === 'campanha' && !\Illuminate\Support\Facades\Auth::check()) {
            return response()->json(['ok' => false, 'msg' => 'Sem permissão.']);
        }

        $dados = [
            'tipo'      => $tipo,
            'itens'     => $this->limparLista($r['itens'] ?? [], $tipo === 'campanha'),
            'suplentes' => $this->limparLista($r['suplentes'] ?? []),
            'times'     => [],
            'info'      => [],
        ];

        foreach ((array) ($r['times'] ?? []) as $time) {
            $dados['times'][] = $this->limparLista($time);
        }

        foreach ((array) ($r['info'] ?? []) as $k => $v) {
            if (is_scalar($v)) {
                $dados['info'][preg_replace('/[^a-z]/', '', (string) $k)] = mb_substr(strip_tags((string) $v), 0, 120);
            }
        }

        $json = json_encode($dados, JSON_UNESCAPED_UNICODE);

        if ($json === false || strlen($json) > 60000) {
            return response()->json(['ok' => false, 'msg' => 'Resultado grande demais para salvar.']);
        }

        if (count($dados['itens']) === 0 && count($dados['times']) === 0) {
            return response()->json(['ok' => false, 'msg' => 'Nada para salvar.']);
        }

        // Limite simples por IP: 60 resultados por hora.
        $ip = substr((string) $request->ip(), 0, 45);
        $recentes = DB::table('sorteador_resultados')
            ->where('ip', $ip)
            ->where('created_at', '>=', date('Y-m-d H:i:s', time() - 3600))
            ->count();

        if ($recentes >= 60) {
            return response()->json(['ok' => false, 'msg' => 'Muitos resultados salvos em pouco tempo. Tente mais tarde.']);
        }

        do {
            $codigo = strtoupper(substr(bin2hex(random_bytes(6)), 0, 10));
        } while (DB::table('sorteador_resultados')->where('codigo', $codigo)->exists());

        DB::table('sorteador_resultados')->insert([
            'codigo'     => $codigo,
            'tipo'       => $tipo,
            'dados'      => $json,
            'ip'         => $ip,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return response()->json([
            'ok'     => true,
            'codigo' => $codigo,
            'url'    => route('sorteador.resultado', ['codigo' => $codigo]),
        ]);
    }

    /** Página pública de um resultado salvo. */
    public function resultado($codigo)
    {
        $codigo = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', (string) $codigo));

        $linha = DB::table('sorteador_resultados')->where('codigo', $codigo)->first();

        if (!$linha) {
            abort(404);
        }

        $dados = json_decode($linha->dados, true) ?: [];
        $dados['codigo'] = $linha->codigo;
        $dados['url'] = route('sorteador.resultado', ['codigo' => $linha->codigo]);
        $dados['quando'] = $this->dataBonita($linha->created_at);

        return view('sorteador', [
            'ehAdmin'   => false,
            'campanhas' => collect(),
            'config'    => Environment::find(1),
            'salvo'     => $dados,
        ]);
    }

    /** Lista de textos curtos (ou de ganhadores de campanha) sem HTML. */
    private function limparLista($lista, $objetos = false)
    {
        $saida = [];

        foreach (array_slice((array) $lista, 0, 1000) as $item) {
            if ($objetos && is_array($item)) {
                $saida[] = [
                    'nome'     => mb_substr(strip_tags((string) ($item['nome'] ?? '')), 0, 120),
                    'numero'   => mb_substr(strip_tags((string) ($item['numero'] ?? '')), 0, 20),
                    'telefone' => mb_substr(strip_tags((string) ($item['telefone'] ?? '')), 0, 20),
                ];
            } elseif (is_scalar($item)) {
                $saida[] = mb_substr(strip_tags((string) $item), 0, 200);
            }
        }

        return $saida;
    }

    /** 28 de ago. de 2026, 11:55 */
    private function dataBonita($sql)
    {
        $t = strtotime($sql);
        $meses = ['jan.', 'fev.', 'mar.', 'abr.', 'mai.', 'jun.', 'jul.', 'ago.', 'set.', 'out.', 'nov.', 'dez.'];

        return date('j', $t) . ' de ' . $meses[(int) date('n', $t) - 1] . ' de ' . date('Y', $t) . ', ' . date('H:i', $t);
    }

    /**
     * Sorteia entre as cotas pagas de uma campanha.
     *
     * O sorteio é feito no servidor com random_int() (gerador
     * criptográfico), e devolve um código de conferência para que o
     * resultado possa ser auditado depois.
     */
    public function participantes(Request $request)
    {
        $produtoId = (int) $request->input('campanha');
        $qtd = max(1, min(50, (int) $request->input('quantidade', 1)));

        $produto = Product::find($produtoId);

        if (!$produto) {
            return response()->json(['ok' => false, 'msg' => 'Campanha não encontrada.']);
        }

        $cotas = DB::table('raffles')
            ->join('participant', 'participant.id', '=', 'raffles.participant_id')
            ->where('raffles.product_id', '=', $produtoId)
            ->where('raffles.status', '=', 'Pago')
            ->select('raffles.number', 'participant.name', 'participant.telephone')
            ->get();

        if (count($cotas) === 0) {
            return response()->json([
                'ok'  => false,
                'msg' => 'Esta campanha ainda não tem cotas pagas para sortear.',
            ]);
        }

        if ($qtd > count($cotas)) {
            $qtd = count($cotas);
        }

        $lista = $cotas->all();
        $sorteados = [];
        $usados = [];

        while (count($sorteados) < $qtd) {
            $i = random_int(0, count($lista) - 1);

            if (isset($usados[$i])) {
                continue;
            }

            $usados[$i] = true;
            $c = $lista[$i];

            $sorteados[] = [
                'numero'   => $c->number,
                'nome'     => $c->name,
                'telefone' => $this->mascararTelefone($c->telephone),
            ];
        }

        return response()->json([
            'ok'        => true,
            'campanha'  => $produto->name,
            'total'     => count($cotas),
            'sorteados' => $sorteados,
            'quando'    => date('d/m/Y H:i:s'),
            'codigo'    => $this->codigoConferencia($produtoId, $sorteados),
        ]);
    }

    /** Esconde o miolo do telefone: (82) *****-1234 */
    private function mascararTelefone($tel)
    {
        $n = preg_replace('/\D/', '', (string) $tel);

        if (strlen($n) < 6) {
            return '';
        }

        return '(' . substr($n, 0, 2) . ') *****-' . substr($n, -4);
    }

    /** Código curto que permite conferir o resultado depois. */
    private function codigoConferencia($produtoId, array $sorteados)
    {
        $base = $produtoId . '|' . date('YmdHis') . '|';

        foreach ($sorteados as $s) {
            $base .= $s['numero'] . ',';
        }

        return strtoupper(substr(hash('sha256', $base), 0, 12));
    }
}
