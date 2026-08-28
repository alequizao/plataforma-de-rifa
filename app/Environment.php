<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Environment extends Model
{
    protected $table = 'consulting_environments';

    protected $fillable = [
        'token_api_wpp',
        'tema',
        'cor_primaria',
        'cor_cta',
        'cor_fundo',
        'cor_card',
        'cor_texto',
        'cor_barra',
        'cor_destaque',
        'fonte_site',
        'raio_borda',
    ];

    /** Paleta padrão (tema Gêmeos) usada quando algum campo está vazio. */
    public static function paletaPadrao()
    {
        return [
            'tema'         => 'light',
            'cor_primaria' => '#00307a',
            'cor_cta'      => '#198754',
            'cor_fundo'    => '#e4e4e4',
            'cor_card'     => '#ffffff',
            'cor_texto'    => '#171717',
            'cor_barra'    => '#202020',
            'cor_destaque' => '#fad601',
            'fonte_site'   => 'Montserrat',
            'raio_borda'   => '10px',
        ];
    }

    /**
     * Monta o <style> com os tokens do tema a partir das cores salvas.
     * É injetado no layout depois do tema-gemeos.css, então sobrescreve
     * os valores padrão sem precisar reescrever o CSS.
     */
    public function cssVariaveis()
    {
        $p = self::paletaPadrao();

        $v = [];
        foreach ($p as $campo => $padrao) {
            $v[$campo] = trim((string) $this->{$campo}) !== '' ? $this->{$campo} : $padrao;
        }

        $escuro = $v['tema'] === 'dark';

        // No tema escuro o fundo/carta/texto padrão invertem, a menos que o
        // dono tenha escolhido cores próprias diferentes do padrão claro.
        if ($escuro) {
            if ($v['cor_fundo'] === $p['cor_fundo']) { $v['cor_fundo'] = '#0d0f16'; }
            if ($v['cor_card']  === $p['cor_card'])  { $v['cor_card']  = '#1b1f2a'; }
            if ($v['cor_texto'] === $p['cor_texto']) { $v['cor_texto'] = '#eef1f8'; }
        }

        $rgb = function ($hex) {
            $h = ltrim((string) $hex, '#');
            if (strlen($h) === 3) {
                $h = $h[0] . $h[0] . $h[1] . $h[1] . $h[2] . $h[2];
            }
            if (strlen($h) < 6) {
                return [0, 0, 0];
            }
            return [hexdec(substr($h, 0, 2)), hexdec(substr($h, 2, 2)), hexdec(substr($h, 4, 2))];
        };

        // texto suave/fraco derivados da cor de texto, para manter contraste
        list($tr, $tg, $tb) = $rgb($v['cor_texto']);
        list($cr, $cg, $cb) = $rgb($v['cor_cta']);

        $css = ':root{'
            . '--incrivel-primaria:' . $v['cor_primaria'] . ';'
            . '--incrivel-primariaDarken:' . $v['cor_fundo'] . ';'
            . '--incrivel-bg:' . $v['cor_fundo'] . ';'
            . '--incrivel-cardBg:' . $v['cor_card'] . ';'
            . '--incrivel-cardColor:' . $v['cor_texto'] . ';'
            . '--incrivel-modalBg:' . $v['cor_card'] . ';'
            . '--incrivel-modalColor:' . $v['cor_texto'] . ';'
            . '--incrivel-formBg:' . $v['cor_card'] . ';'
            . '--incrivel-tinta:' . $v['cor_texto'] . ';'
            . '--incrivel-texto-forte:' . $v['cor_texto'] . ';'
            . '--incrivel-texto:' . $v['cor_texto'] . ';'
            . '--incrivel-texto-suave:rgba(' . $tr . ',' . $tg . ',' . $tb . ',.70);'
            . '--incrivel-texto-fraco:rgba(' . $tr . ',' . $tg . ',' . $tb . ',.54);'
            . '--incrivel-borda-sutil:rgba(' . $tr . ',' . $tg . ',' . $tb . ',.09);'
            . '--incrivel-borda-media:rgba(' . $tr . ',' . $tg . ',' . $tb . ',.17);'
            . '--incrivel-borda-forte:rgba(' . $tr . ',' . $tg . ',' . $tb . ',.34);'
            . '--incrivel-bgColor:' . $v['cor_texto'] . ';'
            . '--incrivel-bgLink:' . $v['cor_texto'] . ';'
            . '--incrivel-cta-bg:' . $v['cor_cta'] . ';'
            . '--incrivel-cta-brilho:rgba(' . $cr . ',' . $cg . ',' . $cb . ',.30);'
            . '--incrivel-raio:' . $v['raio_borda'] . ';'
            . '--tema-barra:' . $v['cor_barra'] . ';'
            . '--tema-destaque:' . $v['cor_destaque'] . ';'
            . '--tema-fonte:' . $v['fonte_site'] . ',sans-serif;'
            . 'color-scheme:' . ($escuro ? 'dark' : 'light') . ';'
            . '}'
            . 'body{font-family:var(--tema-fonte)!important;}'
            . '.campanha-barra-titulos{background:var(--tema-barra)!important;}'
            . '.nav-horizontal-header .icone,.text-yellow{color:var(--tema-destaque)!important;}';

        return $css;
    }

    /** Fonte do Google a carregar, quando não for uma fonte de sistema. */
    public function urlFonte()
    {
        $f = trim((string) $this->fonte_site) ?: 'Montserrat';

        if (in_array($f, ['system-ui', 'Arial', 'Helvetica', 'Georgia', 'Verdana'])) {
            return null;
        }

        return 'https://fonts.googleapis.com/css2?family=' . str_replace(' ', '+', $f)
            . ':wght@400;500;600;700;800&display=swap';
    }
}
