<?php

namespace App\Http\Controllers;

use App\AutoMessage;
use App\Customer;
use App\Environment;
use App\Models\Participante;
use App\Models\Product;
use App\Models\Raffle;
use App\WhatsappMensagem;
use App\Services\WhatsappBaileys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeAdminController extends Controller
{
    public function index()
    {
        $participantes = Participante::select('valor', 'reservados', 'pagos')->get();
        $rifas = Product::where('status', '=', 'Ativo')->get();

        return view('home-admin', [
            'participantes' => $participantes,
            'rifas' => $rifas
        ]);
    }

    public function wpp()
    {
        if(WhatsappMensagem::all()->count() == 0){
            for ($i=0; $i < 6; $i++) { 
                WhatsappMensagem::create([]);
            }
        }

        $wpp = new WhatsappBaileys();

        $data = [
            'wpp' => $wpp->status(),
            'wppSessao' => $wpp->sessao(),
            'msgs' => WhatsappMensagem::all(),
            'autoMessages' => AutoMessage::where('id', '>', 0)->where('destinatario', '=', 'cliente')->orderBy('destinatario')->get(),
            'config' => Environment::find(1)
        ];


        return view('wpp-msgs.index', $data);
    }

    public function wppSalvar(Request $request)
    {
        foreach ($request->id as $key => $value) {
            WhatsappMensagem::find($value)->update([
                'titulo' => $request->titulo[$value],
                'msg' => nl2br($request->msg[$value]),
            ]);
        }

        foreach ($request->idAuto as $key => $value) {
            AutoMessage::find($value)->update([
                'msg' => $request->msgAuto[$value]
            ]);
        }

        Environment::find(1)->update([
            'token_api_wpp' => $request->token_api_wpp
        ]);

        return redirect()->back()->with('success', 'Mensagens atualizadas com sucesso!');
    }

    public function clientes(Request $request)
    {
        if($request->search){
            $clientes = Customer::where('nome', 'like', '%'.$request->search.'%')->get();
        }
        else{
            $clientes = Customer::all();
        }

        $data = [
            'clientes' => $clientes,
            'search' => $request->search
        ];

        return view('clientes.index', $data);
    }

    public function editarCliente($id)
    {
        $cliente = Customer::find($id);

        $data = [
            'cliente' => $cliente
        ];

        return view('clientes.editar', $data);

    }

    public function updateCliente($id, Request $request)
    {
        $cliente = Customer::find($id);

        if($cliente->telephone != $request->telephone){
            if(Customer::where('telephone', '=', $request->telephone)->get()->count() > 0){
                return back()->withErrors('Telefone já cadastrado.');
            }
        }

        $cliente->update([
            'nome' => $request->nome,
            'telephone' => $request->telephone
        ]);

        Participante::where('customer_id', '=', $cliente->id)->update([
            'name' => $request->nome,
            'telephone' => $request->telephone
        ]);

        return redirect()->route('clientes')->with('success', 'Cliente atualizado com sucesso!');
    }

    /* ==========================================================
       Conexão WhatsApp (Baileys) — painel multi-dispositivos
       ========================================================== */

    /** Situação da sessão + QR. Consultado por AJAX a cada 3s. */
    public function wppStatus()
    {
        return response()->json((new WhatsappBaileys())->status());
    }

    /** Cria/reativa a sessão para o QR Code aparecer. */
    public function wppConectar()
    {
        $wpp = new WhatsappBaileys();
        $r = $wpp->conectar();

        return response()->json([
            'ok' => $r['ok'],
            'msg' => $r['ok'] ? 'Sessão iniciada. Aguarde o QR Code.' : $r['erro'],
            'dados' => $wpp->status(),
        ]);
    }

    /** Desconecta e apaga as credenciais (precisa ler o QR de novo). */
    public function wppDesconectar()
    {
        $wpp = new WhatsappBaileys();
        $r = $wpp->desconectar();

        return response()->json([
            'ok' => $r['ok'],
            'msg' => $r['ok'] ? 'WhatsApp desconectado.' : $r['erro'],
        ]);
    }

    /** Envia uma mensagem de teste para conferir se a conexão está de pé. */
    public function wppTeste(Request $request)
    {
        $wpp = new WhatsappBaileys();

        if (!$wpp->conectado()) {
            return response()->json(['ok' => false, 'msg' => 'WhatsApp não está conectado. Leia o QR Code primeiro.']);
        }

        $telefone = $request->input('telefone');
        $texto = $request->input('mensagem') ?: 'Teste de conexão do sistema de rifas. Se você recebeu isto, está tudo certo!';

        $r = $wpp->enviar($telefone, $texto);

        return response()->json([
            'ok' => $r['ok'],
            'msg' => $r['ok'] ? 'Mensagem enviada para ' . $telefone : ('Falha: ' . $r['erro']),
        ]);
    }

    /* ==========================================================
       Aparência — cores, tema claro/escuro, fonte e cantos
       ========================================================== */

    public function aparencia()
    {
        return view('aparencia', [
            'config' => Environment::find(1),
            'padrao' => Environment::paletaPadrao(),
        ]);
    }

    public function aparenciaSalvar(Request $request)
    {
        $campos = [
            'tema', 'cor_primaria', 'cor_cta', 'cor_fundo', 'cor_card',
            'cor_texto', 'cor_barra', 'cor_destaque', 'fonte_site', 'raio_borda',
        ];

        $dados = [];

        foreach ($campos as $c) {
            $v = $request->input($c);

            if ($v === null || trim($v) === '') {
                continue;
            }

            // cores precisam ser hexadecimais válidos
            if (strpos($c, 'cor_') === 0 && !preg_match('/^#[0-9a-fA-F]{6}$/', $v)) {
                continue;
            }

            $dados[$c] = $v;
        }

        if ($request->input('restaurar') == '1') {
            $dados = Environment::paletaPadrao();
        }

        Environment::find(1)->update($dados);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['ok' => true, 'msg' => 'Aparência salva com sucesso!']);
        }

        return redirect()->back()->with('success', 'Aparência salva com sucesso!');
    }

    /* ==========================================================
       Clientes — exportar e excluir
       ========================================================== */

    /** Baixa a lista de clientes em CSV (abre no Excel). */
    public function exportarClientes(Request $request)
    {
        $clientes = $request->search
            ? Customer::where('nome', 'like', '%' . $request->search . '%')
                ->orWhere('telephone', 'like', '%' . $request->search . '%')->get()
            : Customer::all();

        $arquivo = 'clientes-' . date('Y-m-d-His') . '.csv';

        $cabecalho = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $arquivo . '"',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ];

        $callback = function () use ($clientes) {
            $saida = fopen('php://output', 'w');

            // BOM para o Excel reconhecer os acentos
            fwrite($saida, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($saida, ['ID', 'Nome', 'Telefone', 'E-mail', 'CPF', 'Cadastrado em'], ';');

            foreach ($clientes as $c) {
                fputcsv($saida, [
                    $c->id,
                    $c->nome,
                    $c->telephone,
                    $c->email,
                    $c->cpf,
                    $c->created_at ? date('d/m/Y H:i', strtotime($c->created_at)) : '',
                ], ';');
            }

            fclose($saida);
        };

        return response()->stream($callback, 200, $cabecalho);
    }

    /** Exclui um cliente. As compras dele deixam de aparecer. */
    public function excluirCliente($id, Request $request)
    {
        $cliente = Customer::find($id);

        if (!$cliente) {
            if ($request->ajax()) {
                return response()->json(['ok' => false, 'msg' => 'Cliente não encontrado.']);
            }
            return back()->withErrors('Cliente não encontrado.');
        }

        $nome = $cliente->nome;
        $cliente->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['ok' => true, 'msg' => 'Cliente ' . $nome . ' excluído.']);
        }

        return back()->with('success', 'Cliente ' . $nome . ' excluído com sucesso!');
    }

    /** Histórico de versões do sistema (config/versao.php). */
    public function versoes()
    {
        return view('versoes', [
            'atual'     => config('versao.atual'),
            'dataAtual' => config('versao.data'),
            'historico' => config('versao.historico', []),
        ]);
    }

    /** Formulário de cadastro manual de cliente. */
    public function novoCliente()
    {
        return view('clientes.novo');
    }

    /** Grava um cliente cadastrado manualmente pelo painel. */
    public function salvarCliente(Request $request)
    {
        $nome = trim($request->input('nome'));
        $telefone = trim($request->input('telephone'));
        $email = trim($request->input('email'));
        $cpf = trim($request->input('cpf'));

        if ($nome === '') {
            return back()->withInput()->withErrors('Informe o nome do cliente.');
        }

        // o telefone é o identificador do cliente no sistema
        if (strlen(preg_replace('/\D/', '', $telefone)) < 10) {
            return back()->withInput()->withErrors('Informe um telefone válido com DDD.');
        }

        if (Customer::where('telephone', '=', $telefone)->count() > 0) {
            return back()->withInput()->withErrors('Já existe um cliente com este telefone.');
        }

        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->withInput()->withErrors('E-mail inválido.');
        }

        $cliente = Customer::create([
            'nome'      => $nome,
            'telephone' => $telefone,
            'email'     => $email ?: null,
            'cpf'       => $cpf ?: null,
        ]);

        return redirect()->route('clientes')
            ->with('success', 'Cliente ' . $cliente->nome . ' cadastrado com sucesso!');
    }
}

