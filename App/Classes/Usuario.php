<?php

require './App/DB/Database.php';

class Usuario {
    // declaração dos atributos da classe:
    public string $nome;
    public string $email;
    public string $cpf;
    public string $senha;
    public int $id_perfil;

    // função para cadastrar um novo usuário no banco:
    public function cadastrar() {
        // conecta com o banco de dados na tabela "usuario"
        $db = new Database('usuario');

        $db->insert([
            'nome' => $this->nome,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'senha' => $this->senha,
            'id_perfil' => $this->id_perfil,
        ]);

        return true;
    }

    public function buscar() {
        // pega os dados do banco e retorna como uma lista de objetos "Usuario":
        return (new Database('usuario'))->select()->fetchAll(PDO::FETCH_CLASS, self::class);
    }
}

$user = new Usuario();
$user->nome = "gui";
$user->email = "gui@gmail.com";
$user->cpf = "12394534526";
$user->senha = "54321";
$user->id_perfil = 10;

echo '<pre>';
print_r($user); // mostra os atributos do objeto de forma legível
echo '</pre>';

$usuarios = $user->buscar();

foreach ($usuarios as $usuario) {
    echo '<br>';
    echo $usuario->nome . ' ' . $usuario->email . ' ' . $usuario->cpf;
}
