<?php

class Database{
    private $conn;
    private string $local = 'localhost';
    private string $db = 'passcontrol';
    private string $user = 'root';
    private string $password = '';
    private $table;
    // recebe a tabela como parâmetro e faz a conexão automaticamente:
    function __construct($table = null){
        $this->table = $table;
        $this->conecta();
    }

    private function conecta(){
        try{ // configura a conexão usando PDO:
            $this->conn = new PDO("mysql:host=".$this->local.";dbname=$this->db",$this->user,$this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            echo "Conectado com sucesso!";
        }
        catch(PDOException $err){ // caso ocorra um erro, o sistema para e exibe a mensagem:
            die("Conection Failed ". $err->getMessage());
        }
    }
    // consulta no banco de dados
    public function execute($query,$binds = []){
        // echo $query;
        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute($binds);  // executa a consulta com os parâmetros
            return $stmt;
        }
        catch(PDOException $err){
            die("Conection Failed". $err->getMessage());
        }
    }

    public function insert($values){
        // quebrar o array associativo que veio como parametro
        $fields = array_keys($values);
        // cria uma lista de "?" para serem usados como placeholders("espaços reservados" para valores que serão adicionados)
        $binds = array_pad([],count($fields),'?');
         // monta a consulta SQL para inserir os dados na tabela
        $query = 'INSERT INTO ' .$this->table . '('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

        $res = $this->execute($query,array_values($values));

        if ($res){
            return true;
        }else{
            return false;
        }
    }
    // seleciona dados da tabela atual:
    public function select($where =  null,$order = null, $limit = null, $fields = '*'){

        $where = strlen($where) ? 'WHERE ' .$where : '';
        $order = strlen($order) ? 'ORDER BY ' .$order : '';
        $limit = strlen($limit) ? 'LIMIT ' .$limit : '';
        // monta a query de seleção
        $query = 'SELECT' .$fields. ' FROM ' .$this->table. ' ' . $where. ' ' .$order . ' '.$limit;

        return $this->execute($query);
    }
    // seleciona um único registro da tabela pelo ID:
    public function select_by_id($where =  null,$order = null, $limit = null, $fields = '*'){

        $where = strlen($where) ? 'WHERE ' .$where : '';
        $order = strlen($order) ? 'ORDER BY ' .$order : '';
        $limit = strlen($limit) ? 'LIMIT ' .$limit : '';

        $query = 'SELECT' .$fields. ' FROM ' .$this->table. ' ' . $where. ' ' .$order . ' '.$limit;

        return $this->execute($query)->fetch(PDO::FETCH_ASSOC);
    }


    public function update($where,$values){
        // extraindo as chaves, colunas
        $fields = array_keys($values);
        // montar a query
        $query = 'UPDATE ' .$this->table. ' SET ' .implode('=?,',$fields). '=? WHERE ' .$where;

        $res = $this->execute($query,array_values($values));
        return $res;
    }

    public function delete($where){
        // echo 'chegou no where: ' . $where; 
        // montar a query
        $query = 'DELETE FROM ' .$this->table.' WHERE ' .$where;

        $del = $this->execute($query);

        $del = $del->rowCount();  // conta quantas linhas foram afetadas:
        if($del == 1){  // retorna true se exatamente um registro foi excluído:
            return true;
        }else{
            return false;
        }
    }

}

?>