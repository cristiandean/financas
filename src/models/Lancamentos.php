<?php


namespace models;

class Lancamentos extends Model
{

    private $id;
    private $conta;
    private $tipo_lancamento;
    private $descricao;
    private $valor;
    private $data;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $conta
     */
    public function setConta($conta)
    {
        $this->conta = $conta;
    }

    /**
     * @return mixed
     */
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * @return mixed
     */
    public function getTipoLancamento()
    {
        return $this->tipo_lancamento;
    }

    /**
     * @param mixed $tipo_lancamento
     */
    public function setTipoLancamento($tipo_lancamento)
    {
        $this->tipo_lancamento = $tipo_lancamento;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }


    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @param $rows
     * @param bool $unique
     * @return array|mixed|null
     */
    public function populate($rows, $unique = false)
    {
        return null;
    }



}