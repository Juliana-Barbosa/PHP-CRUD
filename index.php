<?php

require './App/DB/Database.php';
//require './App/Enitity/Pessoa.php';


$banco = new Database("usuario");


$users = $banco->select();


echo '<br>';
print_r($users);

// for($i=0; $i < count($users); $i++){
//     echo '<br>';
//     echo $users[$i]['id_usuario']. ' ' . $users[$i]['nome'];
// }

// $del_user = $banco->delete('id_usuario = 8');

// if($del_user){
//     echo '<script> alert ("DELETADO COM SUCESSO") </script>';
// }
// else{
//     echo '<script> alert("ERRO") </script>';
// }

$user_atualizar = $banco->select_by_id('id_usuario = 4');


echo '<br>';
print_r($user_atualizar);

$user_atualizar['nome'] = "NOVO NOME";
$user_atualizar['email'] = "juju@gmail.com";
$user_atualizar['cpf'] = "987654321";

echo '<br>';
echo '<pre>';
print_r($user_atualizar);
echo '</pre>';

$result = $banco->update('id_usuario = ' .$user_atualizar['id_usuario'], $user_atualizar);

















//$pes = new Pessoa();
//echo '<br>';

// mostrar o tipo da variável
//print_r($pes);
//$pes->nome = "Ju";
//$pes->estado_civil = "Namorando";
//$pes->idade = 18;
//echo '<br>';

// mostrar o que tem    
//var_dump($pes);




?>