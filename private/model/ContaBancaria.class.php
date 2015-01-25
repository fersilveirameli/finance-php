<?php
class ContaBancaria extends Conta{

    private $agencia;
    private $conta;
    private $tipoConta;
    private $banco;


    public function getAgencia()
    {
        return $this->agencia;
    }

    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;
    }

    public function getConta()
    {
        return $this->conta;
    }

    public function setConta($conta)
    {
        $this->conta = $conta;
    }

    public function getTipoConta()
    {
        return $this->tipoConta;
    }

    public function setTipoConta($tipoConta)
    {
        $this->tipoConta = $tipoConta;
    }

    public function getBanco()
    {
        return $this->banco;
    }

    public function setBanco($banco)
    {
        $this->banco = $banco;
    }
}
?>