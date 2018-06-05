$(function() {
    var rowData = [];

    /**
     * Evita multiplos click
     */
    $('form').submit(function() {
        $(this).submit(function() {
            return false;
        });
        return true;
    });

    /**
     * DataTables
     */
    if (document.getElementById('selectCheckbox') !== null) {
        var table = $('#selectCheckbox').DataTable({
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
            order: [
                [1, 'asc']
            ]
        });

        table.on('select', function(e, dt, type, index) {
            console.log(index);
            rowData.push(JSON.stringify(table.rows(index).data().toArray()));
        }).on('deselect', function(e, dt, type, index) {
            rowData.splice($.inArray(JSON.stringify(table.rows(index).data().toArray()), rowData), 1);
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
        '00000-000', {
            placeholder: "_____-___",
            clearIfNotMatch: true,
            reverse: true
        }
    );

    var SPMaskBehavior = function(val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };
    $('#telefone').mask(SPMaskBehavior, spOptions);

    $('#cpf').mask(
        '000.000.000-00', {
            placeholder: "___.___.___-__",
            clearIfNotMatch: true,
            reverse: true
        }
    );

    $('#btnHref').on('click', function() {
        window.location.reload();
    });

    $('.btnAltPass').on('click', function() {
        $('#frmModal').attr("action", "/admin/users/admins/altPass/" + $(this).attr('data-user-id'));
        $('.modal-title').empty();
        $('.modal-title').append('<i class="glyphicon glyphicon-shopping-cart"> </i> SCMM - Alterar Senha do Usuário: <b><u><i>' + $(this).attr('data-user-name') + '</i></u></b>');
        $('#modalPass').modal('show');
    });

    $('#modalPass').on('shown.bs.modal', function() {
        $('input[name="oldPass"]').focus();
    });

    $('#genaratePDF').on('click', function() {
        if (rowData.length > 0) {
            $.post('/client/search', { rowData }).done(function(result) {
                loadModal(result);
            });
        } else {
            loadModal("Nenhum item foi selecionado.");
        }
    });

    function loadModal($msg) {
        var dialog = bootbox.dialog({
            size: 'small',
            title: '<i class="glyphicon glyphicon-shopping-cart"> </i> SCMM',
            message: '<p><i class="fa fa-spin fa-spinner"></i> Loading...</p>'
        });

        dialog.init(function() {
            setTimeout(function() {
                dialog.find('.bootbox-body').html($msg);
            }, 900);
        });
    }
});