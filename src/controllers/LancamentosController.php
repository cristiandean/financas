<?php

/**
 * Created by PhpStorm.
 * User: cristiandean
 * Date: 19/07/17
 * Time: 21:32
 */

namespace controllers;


use models\Contas;
use models\Lancamentos;

class LancamentosController extends Controller
{

    public function init()
    {
    }

    public function index()
    {
        setConfig('title_page', 'Lançamentos');
    }


    public function save()
    {
        if ($this->request->getData('id') == null)
            $this->insert();
        else
            $this->update();
    }

    private function insert()
    {
        $validate = $this->validate();
        if ($validate !== true) {
            $output = ['message' => $validate, 'code' => -1];
            $this->renderJson($output);
        }
        $save = $this->getModel()->save(
            'INSERT INTO Lancamentos (descricao, conta_id, valor, data, tipo_lancamento) VALUES (:descricao, :conta_id, :valor, :data, :tipo_lancamento)',
            [
                'descricao' => $this->getModel()->getDescricao(),
                'conta_id' => $this->getModel()->getConta()->getId(),
                'valor' => $this->getModel()->getValor(),
                'data' => $this->getModel()->getData()->format('Y-m-d'),
                'tipo_lancamento' => $this->getModel()->getTipoLancamento()]);

        if ($save)
            $output = ['message' => 'Lançamento inserido com sucesso!', 'code' => 1];
        else
            $output = ['message' => 'Não foi possível completar sua solicitação!', 'code' => -1];

        $this->renderJson($output);
    }

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

    public function delete()
    {
        $validate = $this->validateExclusion();
        if ($validate !== true) {
            $output = ['message' => $validate, 'code' => -1];
            $this->renderJson($output);
        }
        $delete = $this->getModel()->save(
            'DELETE FROM Lancamentos WHERE id = :id',
            ['id' => $this->request->getData('id')]);

        if ($delete)
            $output = ['message' => 'Lançamento removido com sucesso!', 'code' => 1];
        else
            $output = ['message' => 'Não foi possível completar sua solicitação!', 'code' => -1];

        $this->renderJson($output);
    }

    public function getAll()
    {
        $output = ['message' => 'Não foi possível completar sua solicitação!', 'code' => -1];
        if (!isset($_GET['idConta']))
            $this->renderJson($output);

        $contaId = $_GET['idConta'];

        try {
            $data = $this->getModel()->query('SELECT * FROM Lancamentos WHERE conta_id=:conta_id',
                ['conta_id' => $contaId],
                false);

            $saldo = $this->getModel()->query('SELECT valor, descricao FROM Contas WHERE id=:id',
                ['id' => $contaId],
                false, true);

            $output = ['data' => $data, 'saldo' => $saldo['valor'],  'descricao' => $saldo['descricao'], 'code' => 1];

        } catch (\Exception $exception) {
            $output = ['message' => 'Não foi possível completar sua solicitação!', 'code' => -1];
        }

        $this->renderJson($output);
    }


    function validate()
    {
        $conta = new Contas();
        $conta = $conta->get('SELECT * FROM Contas WHERE id = :id ', ['id' => (int)$this->request->getData('conta_id')]);
        $this->getModel()->setId($this->request->getData('id'));
        $this->getModel()->setDescricao($this->request->getData('descricao'));
        $this->getModel()->setValor(moneyToFloat($this->request->getData('valor')));
        $this->getModel()->setData(\DateTime::createFromFormat('d/m/Y', $this->request->getData('data')));
        $this->getModel()->setTipoLancamento($this->request->getData('tipo_lancamento'));
        $this->getModel()->setConta($conta);

        if ($this->getModel()->getId() == null) {

            if ($this->getModel()->getDescricao() == null || trim($this->getModel()->getDescricao() == ''))
                return 'Informe a descrição para continuar';

            if ($this->getModel()->getTipoLancamento() == null || $this->getModel()->getTipoLancamento() == '')
                return 'Informe o tipo de lançamento para continuar';

            if ($this->getModel()->getValor() == null || $this->getModel()->getValor() == '')
                return 'Informe o valor para continuar';
            else if (($this->getModel()->getValor() * $this->getModel()->getTipoLancamento()) + $conta->getValor() > 881.9)
                return 'O valor do lançamento deixa a conta com o valor superior a R$ 881,90';
            else if (($this->getModel()->getValor() * $this->getModel()->getTipoLancamento()) + $conta->getValor() < 0)
                return 'A conta não pode ficar negativa!';

            if ($this->getModel()->getData() == null || $this->getModel()->getData() == '')
                return 'Informe a data para continuar';
        }
        return true;
    }

    function validateExclusion()
    {
        $lancamentos = new Lancamentos();
        $count = $lancamentos->query('SELECT count(id) AS count FROM lancamentos WHERE conta_id=:id', ['id' => $this->request->getData('id')], false);
        if ($count[0]['count'] != 0)
            return 'Remova os lançamentos da conta para deletá-la';
        return true;
    }

}