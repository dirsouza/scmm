
            </div>
        </div>
        <script src="/public/api/jquery/jquery-3.3.1.min.js"></script>
    </body>
</html>
<script>
$(document).ready(function() {
    $('form').submit(function() {
        $(this).submit(function() {
            return false;
        });
        return true;
    });
});
</script>