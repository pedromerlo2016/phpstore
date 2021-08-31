<?php

namespace core\controladores;

use core\classes\Functions;

class Main{
    //============================================================
    public function index(){
        $clientes  =  ['Pedro', 'Paulo', 'Ana','João'];
        
        $dados=[
            'titulo'=>'Este é título da minha página',
            'clientes'  =>  ['Pedro', 'Paulo', 'Ana','João']
        ];

        Functions::Layout([
            'layouts/html_header',
            'pagina_inicial',
            'layouts/html_footer',
        ], $dados);

    }   
    //============================================================
    public function loja(){
        echo "Loja!!!";
    }   
}