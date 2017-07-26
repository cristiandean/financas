<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Cadastro / Alteração de Lancamentos</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">


                <form class="form-horizontal form-label-left input_mask" id="form_lancamentos">
                    <input type="hidden" name="id">
                    <input type="hidden" name="conta_id" value="<?= $_GET['conta'] ?>">
                    <div class="col-md-6 col-sm-6 col-xs-12 has-feedback">
                        <div class="input-group">
                            <div class="input-group-addon">&nbsp;<span class="fa fa-pencil-square-o left"
                                                                       aria-hidden="true"></span> Descrição &nbsp;
                            </div>
                            <input type="text" class="form-control" placeholder="Informe a descição da conta"
                                   name="descricao" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12 has-feedback">
                        <div class="input-group">
                            <div class="input-group-addon">&nbsp;<span class="fa fa-money left"
                                                                       aria-hidden="true"></span> Valor &nbsp;
                            </div>
                            <input type="text" class="form-control maskMoney" name="valor" required
                                   placeholder="Informe o valor da conta">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 has-feedback">
                        <div class="input-group">
                            <div class="input-group-addon">&nbsp;<span class="fa fa-calendar left"
                                                                       aria-hidden="true"></span> Data &nbsp;
                            </div>
                            <input type="text" class="form-control datepicker" required name="data"
                                   placeholder="Informe a data do lançamento">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-6 has-feedback">
                        <div id="TipoConta" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default tipoLabel-1" data-toggle-class="btn-primary"
                                   data-toggle-passive-class="btn-default">
                                <input type="radio" name="tipo_lancamento" value="1" required> &nbsp;<i
                                        class="fa fa-plus"></i> Acréscimo&nbsp;
                            </label>
                            <label class="btn btn-default tipoLabel1" data-toggle-class="btn-primary"
                                   data-toggle-passive-class="btn-default">
                                <input type="radio" name="tipo_lancamento" value="-1" required> <i
                                        class="fa fa-minus"></i> Desconto
                            </label>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6 col-sm-6 col-xs-12 has-feedback">
                        <div class="input-group">
                            <div class="input-group-addon">&nbsp;<span class="fa fa-check-circle left"
                                                                       aria-hidden="true"></span>Descrição
                                &nbsp;
                            </div>
                            <input type="text" class="form-control" value="" disabled required name="descricaoConta"
                                   id="descricaoConta"
                                   placeholder="Informe a data do lançamento">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 has-feedback">
                        <div class="input-group">
                            <div class="input-group-addon">&nbsp;<span class="fa fa-check-circle left"
                                                                       aria-hidden="true"></span> Saldo da Conta
                                &nbsp;
                            </div>
                            <input type="text" class="form-control" value="R$ 0,00" disabled required name="saldo"
                                   id="saldoConta"
                                   placeholder="Informe a data do lançamento">
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group" style="margin-top: 10px">
                        <div class="col-xs-12 text-center">
                            <button type="submit" class="btn btn-success">Salvar</button>
                            <button class="btn btn-danger btnCancel">Cancelar</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    Listagem de contas
                </h2>
                <ul class="nav navbar-right panel_toolbox pull-right">
                    <li class="pull-right"><a href="javascript:void(0)" class="refreshAccounts"><i
                                    class="fa fa-refresh"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action" id="tableAccounts">
                        <thead>
                        <tr class="headings">
                            <th>
                                Código
                            </th>
                            <th class="column-title">Descrição</th>
                            <th class="column-title">Valor</th>
                            <th class="column-title">Tipo</th>
                            <th class="column-title">Data</th>
                            <th class="column-title no-link last"><span class="nobr">Ações</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span
                                            class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                        </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        var arrayItens = [];
        idLancamento = <?=$_GET['conta']?>;

        $(document).tooltip({selector: '[data-toggle=tooltip]'});


        $('.btnCancel').click(function () {
            resetForm();
            loadLancamentos();
        })

        $('.refreshAccounts').click(function () {
            loadLancamentos();
        })

        initDateRange = function () {
            "undefined" != typeof $.fn.daterangepicker && (console.log("init_daterangepicker_single_call"), $(".datepicker").daterangepicker({
                singleDatePicker: !0,
                singleClasses: "picker_1",
                format: "DD/MM/YYYY",
                locale: {
                    format: "DD/MM/YYYY"
                }
            }));
        }


        $('.maskMoney').maskMoney({
            prefix: 'R$',
            decimal: ',',
            thousands: '.',
            allowZero: true,
            allowNegative: false
        });

        $("#form_lancamentos").submit(function (e) {
            $.ajax({
                type: "POST",
                url: '/Lancamentos/save',
                data: $("#form_lancamentos").serialize(), // serializes the form's elements.
                success: function (data) {
                    if (data.code == '1') {
                        notify(data.message);
                        resetForm();
                        loadLancamentos();
                    } else if (typeof data.message != "undefined")
                        notify(data.message, 'Erro', 'error');
                    else
                        notify('Não foi possível completar sua solicitação, tente novamente mais tarde', 'Erro', 'error');
                },
                error: function () {
                    notify('Não foi possível completar sua solicitação, tente novamente mais tarde', 'Erro', 'error');
                }
            });

            e.preventDefault(); // avoid to execute the actual submit of the form.
        });

        notify = function (message, title='Sucesso', type='success') {
            new PNotify({
                title: title,
                text: message,
                type: type,
                styling: 'bootstrap3'
            });
        }


        dateToBR = function (date) {
            date = date.split('-');
            return date[2] + '/' + date[1] + '/' + date[0];
        }


        loadLancamentos = function () {
            $.getJSON('/Lancamentos/getAll&idConta=' + idLancamento, function (data) {
                var items = '';
                arrayItens = data.data;
                $('#saldoConta').val('R$ ' + data.saldo.replace('.', ','));
                $('#descricaoConta').val(data.descricao);
                $.each(data.data, function (key, val) {
                    var trClass = (val.tipo_lancamento == '1' ? 'danger' : 'success');
                    items += '<tr class="even pointer ' + trClass + '">';
                    items += '<td class="a-center ">' + val.id + '</td>';
                    items += '<td class=" ">' + val.descricao + '</td>';
                    items += '<td class=" ">R$ ' + (val.tipo_lancamento * val.valor).toFixed(2).replace('.', ',') + '</td>';
                    items += '<td class=" ">' + (val.tipo_lancamento == '1' ? 'Aditivo' : 'Desconto') + '</td>';
                    items += '<td class=" ">' + dateToBR(val.data) + '</td>';
                    items += '<td class="text-center">';
                    items += '<button data-toggle="tooltip" title="Apagar" class="btn btn-danger btn-xs removeLancamento" data-key="' + key + '"><i class="fa fa-close"></i></button> ';
                    items += '</td>';
                    items += '</tr>';
                });

                $('#tableAccounts tbody tr').remove();
                $('#tableAccounts tbody').append(items)
            });
        }

        resetForm = function () {
            $("#form_lancamentos")[0].reset();
            $("#form_lancamentos label.active").removeClass('active');
            $('input[name="valor"]').attr('disabled', false);
        }

        $(document).on('click', '.removeLancamento', function () {
            if (!confirm("Você tem certeza que deseja deletar este lançamento?"))
                return false;
            $.ajax({
                type: "POST",
                url: '/Lancamentos/delete',
                data: {id: arrayItens[$(this).attr('data-key')].id}, // serializes the form's elements.
                success: function (data) {
                    if (data.code == '1') {
                        notify(data.message);
                        loadLancamentos();
                        resetForm();
                    } else if (typeof data.message != "undefined")
                        notify(data.message, 'Erro', 'error');
                    else
                        notify('Não foi possível completar sua solicitação, tente novamente mais tarde', 'Erro', 'error');
                },
                error: function () {
                    notify('Não foi possível completar sua solicitação, tente novamente mais tarde', 'Erro', 'error');
                }
            });

        });
        initDateRange();
        loadLancamentos();
    });
</script>