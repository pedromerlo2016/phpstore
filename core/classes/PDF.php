<?php

namespace core\classes;

use Mpdf\Mpdf;

class PDF
{
    private $pdf;
    private $html;

    //============================================================
    public function __construct($formato = 'A4', $orientacao = 'p', $modo = 'utf-8')
    {
        // criar uma instancia da classe Mpdf
        $this->pdf = new Mpdf([
            'format' => $formato,
            'orientation' => $orientacao,
            'mode' => $modo
        ]);
        // iniciar o html
        $this->iniciar_html();
    }

    //============================================================
    public function iniciar_html()
    {
        // coloca o html vazio
        $this->html = '';
    }

    //============================================================
    public function apresentar_pdf()
    {
        // output para o browser ou para arquivo pdf
        $this->pdf->WriteHTML($this->html);
        $this->pdf->Output();
    }

    //============================================================
    public function nova_pagina()
    {
        // acrecentar uma nova página
        $this->html .= '<pagebreak>';
    }

    //============================================================
    public function escrever($mensagem)
    {
        $this->html .= "<p>$mensagem</p>";
    }
}
