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
            $stmt->execute($binds);
            return $stmt;
        }
        catch(PDOException $err){
            die("Conection Failed". $err->getMessage());
        }
    }

    public function insert($values){
        // quebrar o array associativo que veio como parametro
        $fields = array_keys($values);

        $binds = array_pad([],count($fields),'?');

        $query = 'INSERT INTO ' .$this->table . '('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

        $res = $this->execute($query,array_values($values));

        if ($res){
            return true;
        }else{
            return false;
        }
    }

    public function select($where =  null,$order = null, $limit = null, $fields = '*'){

        $where = strlen($where) ? 'WHERE ' .$where : '';
        $order = strlen($order) ? 'ORDER BY ' .$order : '';
        $limit = strlen($limit) ? 'LIMIT ' .$limit : '';

        $query = 'SELECT' .$fields. ' FROM ' .$this->table. ' ' . $where. ' ' .$order . ' '.$limit;

        return $this->execute($query);
    }

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

        $del = $del->rowCount();
        if($del == 1){
            return true;
        }else{
            return false;
        }
    }

}

?>