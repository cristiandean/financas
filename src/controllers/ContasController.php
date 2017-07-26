<?php

/**
 * Created by PhpStorm.
 * User: cristiandean
 * Date: 19/07/17
 * Time: 21:32
 */

namespace controllers;


use models\Lancamentos;

/**
 * Class ContasController
 * @package controllers
 */
class ContasController extends Controller
{

    /**
     *
     */
    public function init()
    {
    }


    /**
     *
     */
    public function home()
    {

    }

    /**
     *
     */
    public function index()
    {
        setConfig('title_page', 'Contas');
        /**
         * Geração de contas aleatórias
         */
        /*
       for ($i = 1; $i < 90; $i++) {
            $rand = rand(20, 40);
            for ($j = 0; $j < $rand; $j++) {
                $save = $this->getModel()->save(
                    'INSERT INTO Contas (user_id, descricao, valor, data_vencimento, data_referencia, tipo, status) VALUES (:user_id, :descricao, :valor, :data_vencimento, :data_referencia, :tipo, :status)',
                    ['user_id' => 1,
                        'descricao' => 'Conta gerada: '.$rand,
                        'valor' => rand(25, 880).'.'.rand(0, 99),
                        'data_vencimento' => date('Y-m-d', strtotime("+" . $i . " days", strtotime('2017-06-15'))),
                        'data_referencia' => date('Y-m-d', strtotime("+" . $i . " days", strtotime('2017-06-15'))),
                        'tipo' => rand(0, 1) == 1 ? 1 : -1,
                        'status' => rand(0, 1)]);
            }
        }
        */

    }


    /**
     *
     */
    public function save()
    {
        if ($this->request->getData('id') == null)
            $this->insert();
        else
            $this->update();
    }

    /**
     *
     */
    private function insert()
    {
        $validate = $this->validate();
        if ($validate !== true) {
            $output = ['message' => $validate, 'code' => -1];
            $this->renderJson($output);
        }
        $save = $this->getModel()->save(
            'INSERT INTO Contas (user_id, descricao, valor, data_vencimento, data_referencia, tipo, status) VALUES (:user_id, :descricao, :valor, :data_vencimento, :data_referencia, :tipo, :status)',
            ['user_id' => $this->request->getComponent('Auth')->getUser()->getId(),
                'descricao' => $this->getModel()->getDescricao(),
                'valor' => $this->getModel()->getValor(),
                'data_vencimento' => $this->getModel()->getDataVencimento()->format('Y-m-d'),
                'data_referencia' => $this->getModel()->getDataReferencia()->format('Y-m-d'),
                'tipo' => $this->getModel()->getTipo(),
                'status' => $this->getModel()->getStatus()]);

        if ($save)
            $output = ['message' => 'Conta inserida com sucesso!', 'code' => 1];
        else
            $output = ['message' => 'Não foi possível completar sua solicitação!', 'code' => -1];

        $this->renderJson($output);
    }

    /**
     *
     */
    private function update()
    {
        $validate = $this->validate();
        if ($validate !== true) {
            $output = ['message' => $validate, 'code' => -1];
            $this->renderJson($output);
        }

        $save = $this->getModel()->save(
            'UPDATE Contas SET descricao=:descricao, valor=:valor, data_vencimento=:data_vencimento, data_referencia=:data_referencia, tipo=:tipo, status=:status WHERE id=:id',
            ['id' => $this->getModel()->getId(),
                'descricao' => $this->getModel()->getDescricao(),
                'valor' => $this->getModel()->getValor(),
                'data_vencimento' => $this->getModel()->getDataVencimento()->format('Y-m-d'),
                'data_referencia' => $this->getModel()->getDataReferencia()->format('Y-m-d'),
                'tipo' => $this->getModel()->getTipo(),
                'status' => $this->getModel()->getStatus()]);

        if ($save)
            $output = ['message' => 'Conta atualizada com sucesso!', 'code' => 1];
        else
            $output = ['message' => 'Não foi possível completar sua solicitação!', 'code' => -1];

        $this->renderJson($output);
    }

    /**
     *
     */
    public function delete()
    {
        $validate = $this->validateExclusion();
        if ($validate !== true) {
            $output = ['message' => $validate, 'code' => -1];
            $this->renderJson($output);
        }
        $delete = $this->getModel()->save(
            'DELETE FROM Contas WHERE id = :id',
            ['id' => $this->request->getData('id')]);

        if ($delete)
            $output = ['message' => 'Conta removida com sucesso!', 'code' => 1];
        else
            $output = ['message' => 'Não foi possível completar sua solicitação!', 'code' => -1];

        $this->renderJson($output);
    }

    /**
     *
     */
    public function getAll()
    {
        try {
            $dataInicio = (new \DateTime())->format('Y-m-d');
            $dataFim = (new \DateTime())->format('Y-m-d');

            if (isset($_GET['d1']) && $_GET['d1'] != '')
                $dataInicio = $_GET['d1'];
            if (isset($_GET['d2']) && $_GET['d2'] != '')
                $dataFim = $_GET['d2'];
            $data = $this->getModel()->query('SELECT * FROM Contas WHERE (data_referencia>=DATE(:data_inicio) AND data_referencia<=DATE(:data_fim)) OR (data_vencimento>=DATE(:data_inicio) AND data_vencimento<=DATE(:data_fim))',
                ['data_inicio' => $dataInicio, 'data_fim' => $dataFim],
                false);
            $output = ['data' => $data, 'code' => 1];

        } catch (\Exception $exception) {
            $output = ['message' => 'Não foi possível completar sua solicitação!', 'code' => -1];
        }

        $this->renderJson($output);
    }


    /**
     *
     */
    public function relatorioMensal()
    {
        try {
            $dataInicio = date('Y-m-d');
            $dataFim = date('Y-m-d', strtotime("+1 month", strtotime($dataInicio)));
            if (isset($_GET['d1']) && $_GET['d1'] != '')
                $dataInicio = $_GET['d1'];
            if (isset($_GET['d2']) && $_GET['d2'] != '')
                $dataFim = $_GET['d2'];
            $dataMonth = $this->getModel()->query('SELECT data_vencimento ,SUM(valor) AS saldo, tipo FROM Contas WHERE (data_vencimento>=DATE(:data_inicio) AND data_vencimento<=DATE(:data_fim)) GROUP BY data_referencia, tipo',
                ['data_inicio' => $dataInicio, 'data_fim' => $dataFim],
                false);

            $dataPeriod = $this->getModel()->query('SELECT max(valor) AS max, min(valor) AS min, tipo FROM Contas  WHERE (data_vencimento>=DATE(:data_inicio) AND data_vencimento<=DATE(:data_fim)) GROUP BY tipo',
                ['data_inicio' => $dataInicio, 'data_fim' => $dataFim],
                false);

            $output = ['dataMonth' => $dataMonth, 'dataPeriod' => $dataPeriod, 'code' => 1];

        } catch (\Exception $exception) {
            $output = ['message' => 'Não foi possível completar sua solicitação!', 'code' => -1];
        }

        $this->renderJson($output);
    }


    /**
     * @return bool|string
     */
    private function validate()
    {
        $this->getModel()->setId($this->request->getData('id'));
        $this->getModel()->setDescricao($this->request->getData('descricao'));
        $this->getModel()->setValor(moneyToFloat($this->request->getData('valor')));
        $this->getModel()->setDataVencimento(\DateTime::createFromFormat('d/m/Y', $this->request->getData('data_vencimento')));
        $this->getModel()->setDataReferencia(\DateTime::createFromFormat('d/m/Y', $this->request->getData('data_referencia')));
        $this->getModel()->setTipo($this->request->getData('tipo'));
        $this->getModel()->setStatus($this->request->getData('status'));

        if ($this->getModel()->getId() == null) {
            $this->getModel()->setUser($this->request->getComponent('Auth')->getUser());

            if ($this->getModel()->getDescricao() == null || trim($this->getModel()->getDescricao() == ''))
                return 'Informe a descrição para continuar';

            if ($this->getModel()->getValor() == null || $this->getModel()->getValor() == '')
                return 'Informe o valor para continuar';
            else if ($this->getModel()->getValor() > 881.9)
                return 'O valor não deve ser superior a R$ 881,90';

            if ($this->getModel()->getDataVencimento() == null || $this->getModel()->getDataVencimento() == '')
                return 'Informe a data de vencimento para continuar';

            if ($this->getModel()->getDataReferencia() == null || $this->getModel()->getDataReferencia() == '')
                return 'Informe a data de referencia para continuar';

            if ($this->getModel()->getTipo() == null || $this->getModel()->getTipo() == '')
                return 'Informe o tipo de conta para continuar';

            if ($this->getModel()->getStatus() == null || $this->getModel()->getStatus() == '')
                return 'Informe o status da conta para continuar';

        }
        return true;
    }

    /**
     * @return bool|string
     */
    private function validateExclusion()
    {
        $lancamentos = new Lancamentos();
        $count = $lancamentos->query('SELECT count(id) AS count FROM lancamentos WHERE conta_id=:id', ['id' => $this->request->getData('id')], false);
        if ($count[0]['count'] != 0)
            return 'Remova os lançamentos da conta antes de executar esta ação!';
        return true;
    }

}