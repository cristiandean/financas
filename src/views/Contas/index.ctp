<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Cadastro / Alteração de contas</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">


                <form class="form-horizontal form-label-left input_mask" id="form_contas">
                    <input type="hidden" name="id">
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
                                                                       aria-hidden="true"></span> Data Vencimento &nbsp;
                            </div>
                            <input type="text" class="form-control datepicker" required name="data_vencimento"
                                   placeholder="Informe a data de vencimento">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12 has-feedback">
                        <div class="input-group">
                            <div class="input-group-addon">&nbsp;<span class="fa fa-calendar left"
                                                                       aria-hidden="true"></span> Data Referência &nbsp;
                            </div>
                            <input type="text" class="form-control datepicker" required name="data_referencia"
                                   placeholder="Informe a data de referência">
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 has-feedback">
                        <div id="TipoConta" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default tipoLabel-1" data-toggle-class="btn-primary"
                                   data-toggle-passive-class="btn-default">
                                <input type="radio" name="tipo" value="-1" required> &nbsp; Conta a pagar &nbsp;
                            </label>
                            <label class="btn btn-default tipoLabel1" data-toggle-class="btn-primary"
                                   data-toggle-passive-class="btn-default">
                                <input type="radio" name="tipo" value="1" required> Conta a receber
                            </label>
                        </div>
                        <div id="StatusConta" class="btn-group pull-right" data-toggle="buttons">
                            <label class="btn btn-success statusLabel1" data-toggle-class="btn-primary"
                                   data-toggle-passive-class="btn-success">
                                <input type="radio" name="status" value="1" required> &nbsp; Pago
                            </label>
                            <label class="btn btn-warning statusLabel-1" data-toggle-class="btn-primary"
                                   data-toggle-passive-class="btn-danger">
                                <input type="radio" name="status" value="0" required> Aguardando Pagamento
                            </label>
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
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="pull-right"><a href="javascript:void(0)" class="refreshAccounts"><i
                                        class="fa fa-refresh"></i></a>
                        </li>
                    </ul>
                    <div class="input-group pull-right col-md-6">
                        <div class="input-group-addon"><span class="fa fa-calendar left"
                                                             aria-hidden="true"></span>
                            &nbsp;
                        </div>
                        <input type="text" class="form-control daterangepickers" required name="dateSearch"
                               placeholder="Informe a data de pesquisa">
                    </div>
                </h2>
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
                            <th class="column-title">Valor</th>
                            <th class="column-title">Descrição</th>
                            <th class="column-title">Vencimento</th>
                            <th class="column-title">Referência</th>
                            <th class="column-title">Tipo</th>
                            <th class="column-title">Status</th>
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
                        <tfoot>
                        <tr class="headings">
                            <th>
                                Código
                            </th>
                            <th class="column-title">-</th>
                            <th class="column-title">-</th>
                            <th class="column-title">Contas a Pagar</th>
                            <th class="column-title aPagar">R$ 0,00</th>
                            <th class="column-title">Contas a Receber</th>
                            <th class="column-title aReceber">R$ 0,00</th>
                            <th class="column-title no-link last"><span class="nobr"></span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span
                                            class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        var arrayItens = [];
        var dataInicio = '';
        var dataFim = '';
        var aPagar = 0;
        var aReceber = 0;

        $(document).tooltip({selector: '[data-toggle=tooltip]'});


        $('.btnCancel').click(function () {
            resetForm();
        })

        $('.refreshAccounts').click(function () {
            loadAccounts();
        })


        initDateRange = function () {
            "undefined" != typeof $.fn.daterangepicker && (console.log("init_daterangepicker_single_call"), $(".datepicker").daterangepicker({
                singleDatePicker: !0,
                singleClasses: "picker_1",
                format: "DD/MM/YYYY",
                locale: {
                    format: "DD/MM/YYYY"
                }
            }), $(".daterangepickers").daterangepicker({
                singleClasses: "picker_1",
                locale: {
                    format: "DD/MM/YYYY"
                }
            }))
        }

        $('.daterangepickers').on('apply.daterangepicker', function (ev, picker) {
            dataInicio = picker.startDate.format('YYYY-MM-DD');
            dataFim = picker.endDate.format('YYYY-MM-DD');
            loadAccounts();
        });


        $('.maskMoney').maskMoney({
            prefix: 'R$',
            decimal: ',',
            thousands: '.',
            allowZero: true,
            allowNegative: false
        });

        $("#form_contas").submit(function (e) {
            $.ajax({
                type: "POST",
                url: '/Contas/save',
                data: $("#form_contas").serialize(), // serializes the form's elements.
                success: function (data) {
                    if (data.code == '1') {
                        notify(data.message);
                        resetForm();
                        loadAccounts();
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


        loadAccounts = function () {
            $.getJSON('/Contas/getAll&d1=' + dataInicio + '&d2=' + dataFim, function (data) {
                var items = '';
                arrayItens = data.data;
                aPagar = 0;
                aReceber = 0;
                $.each(data.data, function (key, val) {
                    if (val.tipo == '1' && val.status != '1')
                        aPagar = parseFloat(val.valor);
                    else if (val.tipo == '-1' && val.status != '1')
                        aReceber += parseFloat(val.valor);

                    var trClass = (val.tipo == '1' ? 'danger' : 'success');
                    items += '<tr class="even pointer ' + trClass + '">';
                    items += '<td class="a-center ">' + val.id + '</td>';
                    items += '<td class=" ">R$ ' + val.valor.replace('.', ',') + '</td>';
                    items += '<td class=" ">' + val.descricao + '</td>';
                    items += '<td class=" ">' + dateToBR(val.data_vencimento) + '</td>';
                    items += '<td class=" ">' + dateToBR(val.data_referencia) + '</td>';
                    items += '<td class=" ">' + (val.tipo == '1' ? 'Pagar' : 'Receber') + '</td>';
                    items += '<td class=" ">' + (val.status == '1' ? 'Pago' : 'Aguardando Pagamento') + '</td>';
                    items += '<td class="text-center">';
                    items += '<button data-toggle="tooltip" title="Editar" class="btn btn-primary btn-xs editAccount" data-key="' + key + '"><i class="fa fa-pencil"></i></button> ';
                    items += '<button data-toggle="tooltip" title="Apagar" class="btn btn-danger btn-xs removeAccount" data-key="' + key + '"><i class="fa fa-close"></i></button> ';
                    items += '<button data-toggle="tooltip" title="Lançamentos" class="btn btn-info btn-xs checkLancamentos" data-key="' + key + '"><i class="fa fa-list"></i></button> ';
                    items += '</td>';
                    items += '</tr>';
                });


                $('.aPagar').html('R$ ' + aPagar.toFixed(2).replace('.', ','));
                $('.aReceber').html('R$ ' + aReceber.toFixed(2).replace('.', ','));
                $('#tableAccounts tbody tr').remove();
                $('#tableAccounts tbody').append(items)
            });
        }

        resetForm = function () {
            $("#form_contas")[0].reset();
            $("#form_contas label.active").removeClass('active');
            $('input[name="valor"]').attr('disabled', false);
        }

        $(document).on('click', '.checkLancamentos', function () {
            window.location = '/Lancamentos/&conta=' + (arrayItens[$(this).attr('data-key')].id);

        });

        $(document).on('click', '.editAccount', function () {
            var key = $(this).attr('data-key')
            $('input[name="valor"]').attr('disabled', true);
            $('input[name="id"]').val(arrayItens[key].id);
            $('input[name="descricao"]').val(arrayItens[key].descricao);
            $('input[name="valor"]').val('R$' + (arrayItens[key].valor.replace('.', ',')));
            $('input[name="data_vencimento"]').val(dateToBR(arrayItens[key].data_vencimento));
            $('input[name="data_referencia"]').val(dateToBR(arrayItens[key].data_referencia));

            $('label[data-toggle-class]').removeClass('active');
            $('input[name=tipo][value=' + arrayItens[key].tipo + ']').prop('checked', 'checked');
            $('input[name=tipo][value=' + arrayItens[key].tipo + ']').parent().addClass('active');
            $('input[name=status][value=' + arrayItens[key].status + ']').parent().addClass('active');
            $('input[name=status][value=' + arrayItens[key].status + ']').prop('checked', 'checked');
        });

        $(document).on('click', '.removeAccount', function () {
            if (!confirm("Você tem certeza que deseja deletar esta conta?"))
                return false;
            $.ajax({
                type: "POST",
                url: '/Contas/delete',
                data: {id: arrayItens[$(this).attr('data-key')].id}, // serializes the form's elements.
                success: function (data) {
                    if (data.code == '1') {
                        notify(data.message);
                        loadAccounts();
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
        loadAccounts();
    });
</script>