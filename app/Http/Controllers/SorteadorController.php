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
        ]);
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
