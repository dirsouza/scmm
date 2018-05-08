$(function() {
    /**
    * DataTables
    */
    if (document.getElementById('selectCheckbox') !== null) {
        $('#selectCheckbox').DataTable({
            autoWidth: true,
            responsive: true,
            language: {
                url: "/lib/api/datatables/language/pt-BR.json"
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
                url: "/lib/api/datatables/language/pt-BR.json"
            }
        });
    }

    var table = $('#table').DataTable();
    $('#btn-prodsByCommerce').on('click', function() {
        var data = table.$('td, input').serialize();
        console.log(data);
        alert(data.substr( 0, 120 )+'...');
        return false;
    });

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

    function taskSelect2() {
        $('#product option:selected').prop('selected', false);
        startSelect2();
    }     

    $('#addProduct').on('click', function() {
        var $product = $('#product').val();
        taskSelect2();
        if ($product != "") {
            getProduct($product);
        }
        $('#listProducts').removeClass('hidden');
    });

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
});