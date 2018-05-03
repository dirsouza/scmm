$(function() {
    /**
    * DataTables
    */
    if (document.getElementById('selectCheckbox') !== null) {
        $('#selectCheckbox').DataTable({
            autoWidth: true,
            responsive: true,
            language: {
                url: "../../../scmm/lib/api/datatables/language/pt-BR.json"
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
                url: "../../../scmm/lib/api/datatables/language/pt-BR.json"
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

    /**
     * Select2
     */
    $('.select2').select2({
        theme: "bootstrap",
        placeholder: "Selecione...",
        allowClear: true,
        language: "pt-BR",
        width: "resolve"
    });
});