<?php
$_dompdf_show_warnings = true;
$_dompdf_warnings = [];

use Dompdf\Dompdf;
use Dompdf\Options;

ob_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>SCMM</title>
        <style>
            .content {
                font:20px Arial, Sans-serif;
                border: 1px solid #000;
                border-radius: 3px;
                width: 100%;
                height: 50px;
                text-align: center;
                line-height: 40px;
                font-weight: bold;
            }
            
            .logo-left {
                float: left;
                margin: 10px;
                width: 50px;
            }
            
            .table {
                font-size: 15px;
                margin-top: 10px;
                border: 1px solid #000;
                border-radius: 2px;
                width: 100%;
                background: #2980b9;
                color: #fff;
            }
            .table th {
                height: 20px;
                text-align: center;
                vertical-align: middle;
            }
            .table td {
                height: 15px;
                text-align: left;
                vertical-align: middle;
                background: #fff;
                color: #000;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <img class="logo-left" src="C:/xampp/htdocs/scmm/src/img/logo-pdf.jpg">
            Relatório de Comércios
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">Código</th>
                    <th>Nome</th>
                    <th>Rua</th>
                    <th>Bairro</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>00001</td>
                    <td>Casa da Carne</td>
                    <td>Rua Izaurina Braga</td>
                    <td>Compensa</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
<?php
$html = ob_get_contents();
ob_end_clean();

$options = new Options();
$options->set('defaultFont', 'Courier');
$options->set('isRemoteEnabled', true);
$options->set('debugKeepTemp', true);
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);

$pdf = new Dompdf($options);
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'Portrait');
$pdf->render();
$pdf->stream('listCommerce.pdf', array(
    'Attachment' => false
));

exit(0);
?>