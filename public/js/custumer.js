$(function() {
    /**
    * DataTables
    */
    if (document.getElementById('selectCheckbox') !== null) {
        $('#selectCheckbox').DataTable({
            autoWidth: true,
            responsive: true,
            language: {
                url: "/public/api/datatables/language/pt-BR.json"
            },
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
            order: [[1, 'asc']]
        });
    } else {
        $('#table').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                url: "/public/api/datatables/language/pt-BR.json"
            }
        });
    }

    /**
    * Tootip
    */
   tooltip();
    function tooltip() {
        $('[data-toggle="tooltip"]').tooltip();
    }

    /**
     * Input Mask
     */
    $('#cep').mask(
        '00000-000', 
        {
            placeholder: "_____-___",
            clearIfNotMatch: true,
            reverse: true
        }
    );
    $('#priceModel').mask(
        '#.##0,00',
        {
            placeholder: "0,00",
            reverse: true
        }
    );

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
        $('#product option:selected').prop('selected', false);
        startSelect2();
    }     

    /**
     * Pega o Value do select id="product"
     */
    $('#addProduct').on('click', function() {
        var $product = $('#product').val();
        taskSelect2();
        if ($product != "") {
            getProduct($product);
        }
        $('#listProducts').removeClass('hidden');
    });

    /**
     * Consulta via AJAX se o Value passado no parâmetro
     * $product existe no banco de dados e o retorna no modal
     * @param {$product}  
     */
    function getProduct($product) {
        $.ajax({
            type: "GET",
            url: "/admin/prodsByCommerce/getproduct/" + $product,
            dataType: "json",
            success: function($result) {
                $('#idProductModal').val(('00000'+$result.idproduto).slice(-5));
                $('#productModal').val($result.desnome);
                $('#brandModal').val($result.desmarca);
                
                $('#modalProduct').modal('show');
            },
            error: function($error) {
                console.log($error);
            }
        });
    }

    $('#addProductModal').on('click', function() {
        $('#productsInsert').append('<div class="row">' +
                                    '<div class="col-md-2">' +
                                       ' <div class="form-group">' +
                                            '<input type="text" name="idProduct[]" class="form-control text-center" value="' + $('#idProductModal').val() + '" readonly>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="col-md-4">' +
                                        '<div class="form-group">' +
                                            '<input type="text" class="form-control" value="' + $('#productModal').val() + '" readonly>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="col-md-3">' +
                                        '<div class="form-group">' +
                                            '<input type="text" class="form-control" value="' + $('#brandModal').val() + '" readonly>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="col-md-2">' +
                                        '<div class="input-group">' +
                                            '<span class="input-group-addon">R$</span>' +
                                            '<input type="text" id="priceModel[]" class="form-control" value="' + $('#priceModel').val() + '" readonly>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="col-md-1" style="transform: translate(0, 0);">' +
                                        '<div class="btn-group" role="group">' +
                                            '<button class="btn btn-danger btnRemove" data-toggle="tooltip" data-placement="top" title="Excluir"><i class="fa fa-trash"></i></button>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>');
        $('#modalProduct').modal('hide');
    });
 
    $('#productsInsert').on('click', '.btnRemove', function (e) {
        $(this).closest('.row').remove();
    });
});