$(function() {
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

    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
        onKeyPress: function (val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };
    $('#desTelefone').mask(SPMaskBehavior, spOptions);

    $('#btnHref').on('click', function() {
        window.location.reload();
    });

    notify($typeNotify, $msgNotify);
    function notify($type, $msg) {
        if ($type != null && $msg != null) {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            
            switch ($type) {
                case 'success':
                    toastr.success($msg);
                    break;
                case 'warning':
                    toastr.warning($msg);
                    break;
                case 'error':
                    toastr.error($msg);
                    break;
            }
        }
    }

    $('.btnAltPass').on('click', function() {
        $('#frmModal').attr("action", "/admin/users/admin/altPass/" + $(this).attr('data-user-id'));
        $('#modalPass').modal('show');
    });

    $('#modalPass').on('shown.bs.modal', function () {
        $('input[name="oldPass"]').focus();
    });
});