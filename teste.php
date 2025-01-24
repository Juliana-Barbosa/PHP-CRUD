<?php

require './App/DB/Database.php';

$banco = new Database("usuario");

$nome = "Juliana"; // recebend os dados do form e armazenando em um var php

$dados_user = array(
    "nome"=>"gui",
    "email"=>"gui@gmail",
    "cpf"=>"123456",
    "senha"=>"321",
    "id_perfil"=>10
);

$resultado = $banco->insert($dados_user);

if($resultado){
    echo "Cadastrado com sucesso";
}
else{
    echo "Erro ao cadastrar";
}

echo '<br>';

// CONDICIONAL TERNARIO
// $valor = (CONDIÇÃO) ? 'VERDADE' : 'OUTRO TEXTO';

// $valor = (10 < 5) ? 'é verdadeira a comparação' : 'CONDIÇÃO FALSA';




// echo $valor . "<br>";


// $usuarios = $banco->select('id_usuario = 1');

// foreach ($usuarios as $user){
//     echo $user['nome'] . "<br>";
// }