$(function() {
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
});