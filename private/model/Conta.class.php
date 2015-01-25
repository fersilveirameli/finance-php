<?php
abstract class Conta{

    private $id;
    private $nome;
    private $instancia;
    private $limite;
    private $saldo;

    function getId () {
        return $this->id;
    }

    function setId ($id) {
        $this->id = $id;
    }


    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getInstancia()
    {
        return $this->instancia;
    }

    public function setInstancia($instancia)
    {
        $this->instancia = $instancia;
    }
    
    public function getLimite()
    {
        return $this->limite;
    }
    
    public function setLimite($limite)
    {
        $this->limite = $limite;
    }
    
    public function getSaldo()
    {
        return $this->saldo;
    }
    
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;
    }
}
?>