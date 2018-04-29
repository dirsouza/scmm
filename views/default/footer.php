
            
            </div>
            <!-- /#page-wrapper -->
            <footer class="footer">
                <div class="container">
                    <p class="text-muted left"><?= $_SESSION['system']['name'] ?></p>
                    <p class="text-muted right">Versão <?= $_SESSION['system']['version'] ?></p>
                </div>
            </footer>
        </div>
        <!-- /#wrapper -->

        <script src="/scmm/lib/api/jquery/jquery-3.3.1.min.js"></script>
        <script src="/scmm/lib/api/bootstrap/js/bootstrap.min.js"></script>
        <script src="/scmm/lib/api/metismenu/metisMenu.min.js"></script>
        <script src="/scmm/lib/style/js/scmm.js"></script>
        <script src="/scmm/lib/api/datatables/js/jquery.dataTables.min.js"></script>
        <script src="/scmm/lib/api/datatables/js/dataTables.bootstrap.min.js"></script>
        <script src="/scmm/lib/api/datatables/extensions/responsive/js/dataTables.responsive.min.js"></script>
        <script src="/scmm/lib/api/datatables/extensions/responsive/js/responsive.bootstrap.min.js"></script>
        <script src="/scmm/lib/api/datatables/extensions/selected/js/dataTables.select.min.js"></script>

        <script>
            $(document).ready(function() {
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
                        order: [[1,'asc']]
                    });
                } else {
                    $('.table').DataTable({
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
            });
        </script>
    </body>
</html>