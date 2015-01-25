<?php
class ContaCartaoCredito extends Conta{

    private $diaVencimento;
    private $contaBancaria;





    public function getDiaVencimento()
    {
        return $this->diaVencimento;
    }

    public function setDiaVencimento($diaVencimento)
    {
        $this->diaVencimento = $diaVencimento;
    }





    public function getContaBancaria()
    {
        return $this->contaBancaria;
    }

    public function setContaBancaria($contaBancaria)
    {
        $this->contaBancaria = $contaBancaria;
    }
}
?>