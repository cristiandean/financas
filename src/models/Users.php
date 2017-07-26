<?php


namespace models;

/**
 * Class Users
 * @package models
 */
class Users extends Model
{

    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $nome;
    /**
     * @var
     */
    private $username;
    /**
     * @var
     */
    private $password;

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
            $user = new Users();
            $user->setId($row['id']);
            $user->setNome($row['nome']);
            $user->setUsername($row['username']);
            $user->setPassword($row['password']);
            array_push($list, $user);
        }

        if ($unique && isset($rows[0]))
            return $list[0];
        if (!$unique)
            return $list;
        return null;

    }

}