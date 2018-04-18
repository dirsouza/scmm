<?php
use Dompdf\Dompdf;

ob_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>SCMM</title>
    </head>
    <body>
        TESTE
    </body>
</html>
<?php
$html = ob_get_contents();
ob_end_clean();

$pdf = new Dompdf();
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'Portrait');
$pdf->render();
$pdf->stream('listCommerce.pdf', array(
	'Attachment' => false
));

exit(0);
?>
