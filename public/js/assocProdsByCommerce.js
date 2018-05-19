$(function () {

    $('#report').on('click', function() {
        var $form = '<div class="modal-header"><h4 class="modal-title"><i class="glyphicon glyphicon-shopping-cart"> </i> SCMM - Relatórios</h4></div>' +
            '<div class="modal-body">' +
            '<div id="rowButtons" class="row" style="padding-bottom: 15px">' +
            '<div class="col-md-12 text-center">'+
            '<div class="col-md-4"><button type="button" class="btn btn-block btn-primary btnReport">Por Comércio</button></div>' +
            '<div class="col-md-4"><button type="button" class="btn btn-block btn-success btnReport">Por Produto</button></div>' +
            '<div class="col-md-4"><a href="/admin/prodsByCommerce/reportAll" id="btnHref" class="btn btn-block btn-info" target="_blank">Geral</a></div>' +
            '</div>' +
            '</div>' +
            '<div id="rowSelect" class="row hidden">' +
            '<div class="form-horizontal"><div class="form-group"><label class="col-md-3 control-label">Selecione:</label>' +
            '<div class="col-md-8"><select id="selectOption" class="form-control select2"><option></option></select></div></div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-md-12" style="padding: 0 67px 0 172px"><button type="button" data-url-type="#" class="btn btn-block btn-primary btnViewReport">Geral Relatório</button></div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="modal-footer">' +
            '<button type="button" class="btn btn-warning btnCancel">Cancelar</button>' +
            '</div>';
        
        $('#modalIndexProduct .modal-content').append($form);
        $('#modalIndexProduct').modal('show');
    });

    $('#modalIndexProduct').on('click', ".btnReport", function (e) {
        $('#rowSelect').removeClass('hidden');
        var $bntName = $(this).text();
        if (typeof $bntName != 'undefined' && $bntName == 'Por Comércio') {
            getCommerces();
            startSelect2();
        } else {
            getProducts();
            startSelect2();
        }
    });

    $('#modalIndexProduct').on('click', ".btnViewReport", function (e) {
        var $type = $(this).attr('data-url-type');
        var $id = $('#selectOption').val();
        if ($id != null && typeof $type != 'undefined' && $type == 'commerces') {
            window.open('/admin/prodsByCommerce/reportCommerces/' + $id, '_blank');
            hiddenModal();
            window.location.reload();
        } else if ($id != null && typeof $type != 'undefined') {
            window.open('/admin/prodsByCommerce/reportProducts/' + $id, '_blank');
            hiddenModal();
            window.location.reload();
        }
    });

    $('#modalIndexProduct').on('click', '#btnHref', function () {
        hiddenModal();
        window.location.reload();
    });

    $('#listProdsByCommerce').on('click', '.updateProduct', function () {
        var $form = '<div class="modal-header"><h4 class="modal-title" id="gridSystemModalLabel"><i class="glyphicon glyphicon-shopping-cart"> </i> SCMM - Atualizar Produto</h4></div>' +
            '<form action="/admin/prodsByCommerce/update/' + $(this).attr('data-product-id') + '" method="POST">' +
            '<div class="modal-body">' +
            '<div class="form-horizontal">' +
            '<div class="form-group"><label class="col-md-2 control-label">Código:</label><div class="col-md-9"><input type="text" id="idProductModal" class="form-control" readonly></div></div>' +
            '<div class="form-group"><label class="col-md-2 control-label">Comércio:</label><div class="col-md-9"><input type="text" id="commerceModal" class="form-control" readonly></div></div>' +
            '<div class="form-group"><label class="col-md-2 control-label">Produto:</label><div class="col-md-9"><input type="text" id="productModal" class="form-control" readonly></div></div>' +
            '<div class="form-group"><label class="col-md-2 control-label">Marca:</label><div class="col-md-9"><input type="text" id="brandModal" class="form-control" readonly></div></div>' +
            '<div class="form-group"><label class="col-md-2 control-label">Preço:</label><div class="col-md-9"><div class="input-group"><span class="input-group-addon">R$</span><input type="text" name="desPreco" id="priceModel" class="form-control"></div></div></div>' +
            '</div>' +
            '</div>' +
            '<div class="modal-footer"><button type="submit" class="btn btn-primary btnUpdate" data-product-id="' + $(this).attr('data-product-id') + '">Atualizar</button><button type="button" class="btn btn-warning btnCancel">Cancelar</button></div>' +
            '</form>';

        $('#modalIndexProduct .modal-content').append($form);
        getProdsByCommerce($(this).attr('data-product-id'));
        $('#priceModel').val($(this).attr('data-product-preco'));
        $('#modalIndexProduct').modal('show');
        enabledMoney();
    });

    $('#modalIndexProduct').on('click', '.btnCancel', function () {
        hiddenModal();
    });

    function hiddenModal() {
        $('#modalIndexProduct').modal('hide');
        $('#modalIndexProduct .modal-content').empty();
    }

    $('#listProdsByCommerce').on('click', '.deleteProduct', function () {
        var $form = '<div class="modal-header"><h4 class="modal-title" id="gridSystemModalLabel"><i class="glyphicon glyphicon-shopping-cart"> </i> SCMM - Selecione uma opção</h4></div>' +
            '<div class="modal-body"><div class="form-group text-center"><div class="row" style="margin-bottom: 5px"><div class="col-md-12">'+
            '<a href="/admin/prodsByCommerce/delete/' + $(this).attr('data-product-id') + '" onclick="return confirm(' + '\'Deseja excluir esse Produto?\'' + ')"  class="btn btn-lg btn-block btn-info">Excluir o produto ' + ('00000' + $(this).attr('data-product-id')).slice(-5) + " - " + $(this).attr('data-product-name') + '</a></div></div><div class="row"><div class="col-md-12">' +
            '<a href="/admin/prodsByCommerce/deleteAll/' + $(this).attr('data-product-id') + '" onclick="return confirm('+'\'Deseja excluir todos os Produtos vinculados ao Comércio?\''+')" class="btn btn-xs btn-block btn-danger">Excluir todos os produtos associados ao Comércio ' + $(this).attr('data-commerce-name') + '</a></div></div></div></div>' +
            '<div class="modal-footer"><button type="button" class="btn btn-warning btnCancel">Cancelar</button></div>';

            $('#modalIndexProduct .modal-content').append($form);
            $('#modalIndexProduct').modal('show');
    });

    $('#modalIndexProduct').on('shown.bs.modal', function () {
        $('#priceModel').focus();
    });

    function enabledMoney() {
        $('#priceModel').mask(
            '#.##0,00', {
                placeholder: "0,00",
                reverse: true
            }
        );
    }

    /**
     * Select2
     */
    startSelect2();
    function startSelect2() {
        $('.select2').select2({
            theme: "bootstrap",
            placeholder: "Selecione...",
            allowClear: true,
            language: "pt-BR",
            width: "100%"
        });
    }

    /**
     * Limpa seleção do select id="product"
     * e reinicia a API select2
     */
    function taskSelect2() {
        $('#product').val(null).trigger('change');
    }

    function enableItemSelect($id) {
        $('#product option[value="' + $id + '"]').prop('disabled', false);
        taskSelect2();
        startSelect2();
    }

    function desabledItemSelect() {
        $('#product option:selected').prop('disabled', true);
        taskSelect2();
        startSelect2();
    }

    function enableListProds() {
        $('#listProducts').removeClass('hidden');
    }

    function disabledListProds() {
        if ($('#productsInsert input').length == 0) {
            $('#listProducts').addClass('hidden');
        }
    }

    /**
     * Pega o Value do select id="product"
     */
    $('#addProduct').on('click', function () {
        var $product = $('#product').val();
        if ($product != "" && typeof $product != 'object') {
            clearModal();
            getProduct($product);
            $('#modalProduct').modal('show');
            enabledMoney();
            enableListProds();
        }
    });

    $('#addProductModal').on('click', function () {
        $('#productsInsert').append('<div class="row">' +
            '<div class="col-md-2"><div class="form-group"><input type="text" name="idProduto[]" class="form-control text-center" value="' + $('#idProductModal').val() + '" readonly></div></div>' +
            '<div class="col-md-4"><div class="form-group"><input type="text" class="form-control" value="' + $('#productModal').val() + '" readonly></div></div>' +
            '<div class="col-md-3"><div class="form-group"><input type="text" class="form-control" value="' + $('#brandModal').val() + '" readonly></div></div>' +
            '<div class="col-md-2"><div class="input-group"><span class="input-group-addon">R$</span><input type="text" name="desPreco[]" class="form-control" value="' + $('#priceModel').val() + '" readonly required></div></div>' +
            '<div class="col-md-1" style="transform: translate(0, 0);"><div class="btn-group" role="group"><button class="btn btn-danger btnRemove" data-select-id="' + parseInt($('#idProductModal').val()) + '" data-toggle="tooltip" data-placement="top" title="Excluir"><i class="fa fa-trash"></i></button></div></div>' +
            '</div>');
        $('#modalProduct').modal('hide');
        desabledItemSelect();
        enableListProds();
    });

    $('#cancelProductModal').on('click', function () {
        disabledListProds();
    });

    $('#productsInsert').on('click', '.btnRemove', function (e) {
        $(this).closest('.row').remove();
        disabledListProds();
        enableItemSelect($(this).attr('data-select-id'));
    });

    $('#modalProduct').on('shown.bs.modal', function () {
        $('#priceModel').focus();
    });

    function clearModal() {
        $('#priceModel').val("");
    }

    $('#idComercio').on('change', function () {
        $('#product').empty();
        var $idComerce = $(this).val();
        var $addOption = null;
        $.ajax({
            type: "GET",
            url: "/admin/prodsByCommerce/getproductdiff/" + $idComerce,
            dataType: "json",
            success: function ($result) {
                if ($result != null) {
                    $.each($result, function (i, item) {
                        if ($addOption === null) {
                            $addOption = '<option value=' + item.idproduto + '>' + item.desnome + ' - ' + item.desmarca + '</option>';
                        } else {
                            $addOption += '<option value=' + item.idproduto + '>' + item.desnome + ' - ' + item.desmarca + '</option>';
                        }
                    });
                    $('#product').append($addOption);
                }
            },
            error: function ($error) {
                console.log($error);
            }
        });
    });

    /**
     * Consulta via AJAX se o Value passado no parâmetro
     * $product existe no banco de dados e o retorna no modal
     * @param {$product}  
     */
    function getProduct($idproduct) {
        $.ajax({
            type: "GET",
            url: "/admin/product/getproduct/" + $idproduct,
            dataType: "json",
            success: function ($result) {
                $('#idProductModal').val(('00000' + $result[0].idproduto).slice(-5));
                $('#productModal').val($result[0].desnome);
                $('#brandModal').val($result[0].desmarca);
            },
            error: function ($error) {
                console.log($error);
            }
        });
    }

    function getProdsByCommerce($idProdsByCommerce) {
        $.ajax({
            type: "GET",
            url: "/admin/prodsByCommerce/getprodsbycommerce/" + $idProdsByCommerce,
            dataType: "json",
            success: function ($result) {
                $('#idProductModal').val(('00000' + $result[0].idProdutoComercio).slice(-5));
                $('#commerceModal').val($result[0].desComercio);
                $('#productModal').val($result[0].desProduto);
                $('#brandModal').val($result[0].desmarca);
            },
            error: function ($error) {
                console.log($error);
            }
        });
    }

    function getCommerces() {
        $('#selectOption').empty();
        var $addOption = null;
        $.ajax({
            type: "GET",
            url: '/admin/commerce/getcommerces',
            dataType: "json",
            success: function ($result) {
                if ($result != null) {
                    $.each($result, function (i, item) {
                        if ($addOption === null) {
                            $addOption = '<option value=' + item.idcomercio + '>' + item.desnome + '</option>';
                        } else {
                            $addOption += '<option value=' + item.idcomercio + '>' + item.desnome + '</option>';
                        }
                    });
                    $('#selectOption').append($addOption);
                    $('.btnViewReport').attr('data-url-type', 'commerces');
                }
            },
            error: function ($error) {
                console.log($error);
            }
        });
    }

    function getProducts() {
        $('#selectOption').empty();
        var $addOption = null;
        $.ajax({
            type: "GET",
            url: '/admin/product/getproducts',
            dataType: "json",
            success: function($result) {
                if ($result != null) {
                    $.each($result, function (i, item) {
                        if ($addOption === null) {
                            $addOption = '<option value=' + item.idproduto + '>' + item.desnome + ' - ' + item.desmarca + '</option>';
                        } else {
                            $addOption += '<option value=' + item.idproduto + '>' + item.desnome + ' - ' + item.desmarca + '</option>';
                        }
                    });
                    $('#selectOption').append($addOption);
                    $('.btnViewReport').attr('data-url-type', 'products');
                }
            },
            error: function($error) {
                console.log($error);
            }
        });
    }
});