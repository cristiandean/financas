<?php


namespace models;

/**
 * Class Contas
 * @package models
 */
class Contas extends Model
{

    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $user;
    /**
     * @var
     */
    private $descricao;
    /**
     * @var
     */
    private $valor;
    /**
     * @var
     */
    private $data_vencimento;
    /**
     * @var
     */
    private $data_referencia;
    /**
     * @var
     */
    private $tipo;
    /**
     * @var
     */
    private $status;
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
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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
    public function getDataVencimento()
    {
        return $this->data_vencimento;
    }

    /**
     * @param mixed $data_vencimento
     */
    public function setDataVencimento($data_vencimento)
    {
        $this->data_vencimento = $data_vencimento;
    }

    /**
     * @return mixed
     */
    public function getDataReferencia()
    {
        return $this->data_referencia;
    }

    /**
     * @param mixed $data_referencia
     */
    public function setDataReferencia($data_referencia)
    {
        $this->data_referencia = $data_referencia;
    }


    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }


    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param $rows
     * @param bool $unique
     * @return array|mixed|null
     */
    public function populate($rows, $unique = false)
    {
        $list = [];
        foreach ($rows as $row) {
            $contas = new Contas();
            $contas->setId($row['id']);
            $contas->setUser((new Users())->get('SELECT * FROM Users WHERE id = :id', ['id'=>$row['user_id']]));
            $contas->setValor($row['valor']);
            $contas->setDataVencimento($row['data_vencimento']);
            $contas->setDataReferencia($row['data_referencia']);
            $contas->setTipo($row['tipo']);
            $contas->setStatus($row['status']);
            array_push($list, $contas);
        }

        if ($unique && $rows[0]!=null)
            return $list[0];
        if (!$unique)
            return $list;
        return null;

    }



}