<?php

class Pessoa{

    public string $nome;
    public string $estado_civil;
    public int $idade;

    public function hello(){
        echo 'Hello ' . $this->nome;
    }

    public function getIdade(){
        return $this->idade;
    }
}

?>