
            
            </div>
            <!-- /#page-wrapper -->
            <footer class="footer">
                <div class="container">
                    <p class="text-muted left"><?= $_SESSION['system']['name'] ?></p>
                    <p class="text-muted right hidden-xs">Versão <?= $_SESSION['system']['version'] ?></p>
                </div>
            </footer>
        </div>
        <!-- /#wrapper -->
        <!-- Notify -->
        <?php if(isset($_SESSION['notify']) && !empty($_SESSION['notify'])): ?>
        <script>
            var $typeNotify = "<?= $_SESSION['notify']['type'] ?>";
            var $msgNotify = "<?= $_SESSION['notify']['msg'] ?>";
        </script>
            <?php unset($_SESSION['notify']) ?>
        <?php else: ?>
        <script>
            var $typeNotify = null;
            var $msgNotify = null;
        </script>
        <?php endif; ?>
        <!-- /Notify -->

        <script src="/public/api/jquery/jquery-3.3.1.min.js"></script>
        <script src="/public/api/bootstrap/js/bootstrap.min.js"></script>
        <script src="/public/api/metismenu/metisMenu.min.js"></script>
        <script src="/public/api/datatables/js/jquery.dataTables.min.js"></script>
        <script src="/public/api/datatables/js/dataTables.bootstrap.min.js"></script>
        <script src="/public/api/datatables/extensions/responsive/js/dataTables.responsive.min.js"></script>
        <script src="/public/api/datatables/extensions/responsive/js/responsive.bootstrap.min.js"></script>
        <script src="/public/api/datatables/extensions/selected/js/dataTables.select.min.js"></script>
        <script src="/public/api/jquery-mask/jquery.mask.min.js"></script>
        <script src="/public/api/select2/js/select2.min.js"></script>
        <script src="/public/api/select2/js/i18n/pt-BR.js"></script>
        <script src="/public/api/bootbox/bootbox.min.js"></script>
        <script src="/public/api/toastr/toastr.min.js"></script>
        <script src="/public/js/scmm.js"></script>
        <script src="/public/js/custumer.js"></script>
        <script src="/public/js/buscarCep.js"></script>
        <script src="/public/js/assocProdsByCommerce.js"></script>
    </body>
</html>