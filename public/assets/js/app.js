/* app.js */
// ============================================================
function adicionar_carrinho(id_produto) {
    $interval=3000;
    axios.defaults.withCredentials = true;
    axios.get('?a=adicionar_carrinho&id_produto=' + id_produto)
        .then(function (response) {
            var total_produtos = response.data;
            document.getElementById('carrinho').innerText = total_produtos;
            document.getElementById('msg').innerText="Item incluido no carrinho";
            
            setTimeout(() => {
                document.getElementById('msg').innerText="";
            }, $interval);
            
        });
    
}

// ============================================================
function limpar_carrinho(){
    var e = document.getElementById('confirma_limpar_carrinho');
    e.style.display="inline";
}

// ============================================================
function limpar_carrinho_off(){
    var e = document.getElementById('confirma_limpar_carrinho');
    e.style.display="none";
}

// ============================================================
function usar_residencai_alternativa(){
    // mostar ou esconder o espaço da residência alternativa
    var e  =  document.getElementById('check_residencia_alternatida');
    var espaco = document.getElementById('residencia_alternativa');
    if(e.checked==true){
        // mostra o espaço da residência alternativa
        espaco.style.display="block";
    }else{
        // esconde o espaço da residência alternativa
        espaco.style.display="none";
    }
}

// ============================================================
function residencia_alternativa(){
    // buscar os dados dos inputs
    // enviar por url via post para um médoto do controlador
    // metodo controlador recebe os dados e coloca na sessão
    axios(
        {
            method:'post',
            url:'?a=residencia_alternativa',
            data: {
                text_residencia:document.getElementById('text_residencia_alternativa').value,
                text_cidade:document.getElementById('text_cidade_alternativa').value,
                text_email:document.getElementById('text_email_alternativa').value,
                text_telefone:document.getElementById('text_telefone_alternativa').value,
            }
        }
    );
}