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
    $('[data-toggle="tooltip"]').tooltip();

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
            url: "/registration/prodsByCommerce/getproduct/" + $product,
            dataType: "json",
            success: function($result) {
                $('#idProductModal').val(('00000'+$result.idproduto).slice(-5));
                $('#productModal').val($result.desnome);
                $('#brandModal').val($result.desmarca);
                
                $('#modalProduct').modal();
            },
            error: function($error) {
                console.log($error);
            }
        });
    }

    $('#addProductModal').on('click', function() {
        $('.panel-body').append('<div class="row"><div class="col-md-2"></div></div>');
    });
});