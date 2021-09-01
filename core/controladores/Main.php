<?php

namespace core\controladores;

use core\classes\Store;

class Main{
    //============================================================
    public function index(){
        $dados=[
            'titulo'=>APP_NAME." ".APP_VERSION ,
        ];

        Store::Layout([
            'layouts/html_header',
            'header',
            'inicio',
            'footer',
            'layouts/html_footer',
        ], $dados);

    }   
    //============================================================
    public function loja(){
        echo "Loja!!!";
    }   
}