<?php

require_once 'Connection.php';
require_once 'InstanciaDAO.class.php';
require_once 'BancoDAO.class.php';
require_once __ROOT__.'/private/model/Conta.class.php';
require_once __ROOT__.'/private/model/ContaBancaria.class.php';
require_once __ROOT__.'/private/model/ContaCartaoCredito.class.php';

class ContaDAO{

    private $conn;

    function __construct(){
        $this->conn = new Connection();
    }

    public function get($id){
        $this->conn->open();
        $query = "SELECT c.id, c.nome, c.instancia, cb.agencia, cb.conta, c.limite, c.saldo, cb.tipo_conta, cb.banco, cc.dia_vencimento, cc.conta_bancaria
        FROM conta c
        left join conta_bancaria cb on cb.id = c.id
        left join conta_cartao_credito cc on cc.id = c.id
        WHERE c.id = $id ";

        $result = pg_query($query);
        if (!$result) {
            echo "Um erro ocorreu na consulta.\n";
            exit;
        }

        $conta = null;
        $row = pg_fetch_array($result);

        $instanciaDAO = new InstanciaDAO();
        $bancoDAO = new BancoDAO();
        
        if($row['agencia']){

            $conta = new ContaBancaria();
            $conta->setId($row['id']);
            $conta->setBanco($bancoDAO->get($row['banco']));
            $conta->setConta($row['conta']);
            $conta->setAgencia($row['agencia']);
            //$conta->setInstancia($instanciaDAO->get($row['instancia']));
            $conta->setLimite($row['limite']);
            $conta->setNome($row['nome']);
            $conta->setSaldo($row['saldo']);
            $conta->setTipoConta($row['tipo_conta']);

        }else{

            $conta = new ContaCartaoCredito();
            $conta->setId($row['id']);
            $conta->setNome($row['nome']);
            // $conta->setInstancia($instanciaDAO->get($row['instancia']));
            $conta->setContaBancaria(null);
            $conta->setDiaVencimento($row['dia_vencimento']);           
            $conta->setLimite($row['limite']);
            $conta->setSaldo($row['saldo']);

        }

        $this->conn->close();
        return $conta;
    }

    public function getList(){
        $this->conn->open();
        $query = "SELECT c.id, c.nome, c.instancia, cb.agencia, cb.conta, c.limite, c.saldo, cb.tipo_conta, cb.banco, cc.dia_vencimento, cc.conta_bancaria
        FROM conta c
        left join conta_bancaria cb on cb.id = c.id
        left join conta_cartao_credito cc on cc.id = c.id ";

        $result = pg_query($query);
        if (!$result) {
            echo "Um erro ocorreu na consulta.\n";
            exit;
        }
        
        $instanciaDAO = new InstanciaDAO();
        $bancoDAO = new BancoDAO();

        $list = array();
        while ($row = pg_fetch_array($result)) {

           
            $conta = null;

            if($row['agencia']){

                $conta = new ContaBancaria();
                $conta->setId($row['id']);
                $conta->setBanco($bancoDAO->get($row['banco']));
                $conta->setConta($row['conta']);
              //  $conta->setInstancia($instanciaDAO->get($row['instancia']));
                $conta->setLimite($row['limite']);
                $conta->setNome($row['nome']);
                $conta->setSaldo($row['saldo']);
                $conta->setTipoConta($row['tipo_conta']);

            }else{

                $conta = new ContaCartaoCredito();
                $conta->setId($row['id']);
                $conta->setContaBancaria(null);
                $conta->setDiaVencimento($row['dia_vencimento']);
               // $conta->setInstancia($instanciaDAO->get($row['instancia']));
                $conta->setNome($row['nome']);
                $conta->setLimite($row['limite']);
                $conta->setSaldo($row['saldo']);

            }
            $list[] = $conta;
             
        }
        $this->conn->close();

        return $list;

    }




}
?>