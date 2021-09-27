<?php

namespace core\classes;

use Mpdf\Mpdf;

class PDF
{
    private $pdf;
    private $html;

    // Localização do inicio da escrita na página
    private $x;             // left
    private $y;             // top

    // define a área de impressão para um texto
    private $largura;       // width
    private $altura;        // height
    private $alinhamento;   // text-align

    // fonte
    private $cor;           // color
    private $fundo;         //backgroug-color
    private $letra_familia; // font-fanily
    private $letra_tamanho; // font-size
    private $letra_tipo;    // font-wight

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
    public function posicao($x,$y)
    {   
        $this->x = $x;
        $this->y = $y;
    }

    //============================================================
    public function escrever($texto)
    {
        // escreve texto no documento
        $this->html .='<div style="';
        // posicionamento e dimensão
        $this->html .='position:absolute;';
        $this->html .='left: '. $this->x.'px ;' ;
        $this->html .='top: '. $this->y.'px;' ;
        // $this->html .='width'. $this->largura.' px;' ;
        // $this->html .='heiht'. $this->altura.' px;' ;
        // // cores
        // $this->html .='color:'. $this->cor.';' ;
        // $this->html .='backgound-color:'. $this->fundo.';' ;
        // // fonte
        // $this->html .='font-family:'. $this->letra_familia.';' ;
        // $this->html .='font-size:'. $this->letra_tamanho.';' ;
        // $this->html .='font-wight:'. $this->letra_tipo.';' ;
        
        $this->html .='">'. $texto.'</div>';
        
    }
}
