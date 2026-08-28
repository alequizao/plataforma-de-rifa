<?php

namespace App\Console\Commands;

use App\Models\Participante;
use App\Models\Raffle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckPagamentos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pix:check-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificando pagamentos pendentes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $codeKeyPIX = DB::table('consulting_environments')
            ->select('key_pix')
            ->where('user_id', '=', 1)
            ->first();

        $secretKey = $codeKeyPIX ? $codeKeyPIX->key_pix : null;

        if (empty($secretKey)) {
            $this->warn('Token do Mercado Pago nao configurado. Nada a verificar.');
            return 0;
        }

        try {
            \MercadoPago\SDK::setAccessToken($secretKey);
        } catch (\Throwable $th) {
            // Token invalido/expirado: registra e sai sem derrubar o agendador.
            \Log::error('pix:check-payment - token do Mercado Pago invalido: ' . $th->getMessage());
            $this->error('Token do Mercado Pago invalido ou expirado. Atualize em Perfil > Integracao.');
            return 1;
        }

        $pendentes = DB::table('payment_pix')->where('status', '=', 'Pendente')->where('key_pix', '!=', '')->get();

        foreach ($pendentes as $value) {
            try {
                // Verificando se existe participante (se nao exister ja exclui o pedido)
                $checkReserva = Participante::find($value->participant_id);
                if ($checkReserva) {
                    $realPixID = $value->key_pix;

                    $payment = \MercadoPago\Payment::find_by_id($realPixID);

                    if ($payment) {
                        if ($payment->status == 'cancelled') {
                            DB::table('payment_pix')->where('id', '=', $value->id)->delete();
                        } else if ($payment->status == 'approved') {

                            $participante = Participante::find($payment->external_reference);
                            if ($participante) {
                                $rifa = $participante->rifa();
                                $rifa->confirmPayment($participante->id);

                                DB::table('payment_pix')->where('id', '=', $value->id)->update([
                                    'status' => 'Aprovado'
                                ]);
                            } else {
                                DB::table('payment_pix')->where('id', '=', $value->id)->delete();
                            }
                        }
                    }
                }
                else{
                    DB::table('payment_pix')->where('id', '=', $value->id)->delete();
                }
            } catch (\Throwable $th) {
                //dd($value);
            }
        }
    }
}
