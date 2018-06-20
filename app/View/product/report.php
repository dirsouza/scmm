<?php
use Dompdf\Dompdf;
use Dompdf\Options;

ob_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title><?= $_SESSION['system']['abrev'] ?> - Produtos</title>
        <link rel="shortcut icon" href="<?= PATH_DIR ?>/public/img/logo-mini.png">
        <style>
            @page { margin: 100px 25px; }

            header {
                position: fixed;
                top: -60px;
                left: 0;
                right: 0;
                font: 20px Arial, Sans-serif;
                border: 2px solid #000;
                border-radius: 3px;
                width: 100%;
                height: 50px;
                text-align: center;
                line-height: 40px;
                font-weight: bold;
            }

            footer {
                position: fixed;
                bottom: -100px;
                left: 0;
                right: 0;
                font: 10px Arial, Sans-serif;
                border-top: 1px solid #000;
                width: 100%;
                height: 50px;
                padding: 0 3px 0 3px;
            }
            
            .logo-left {
                float: left;
                margin: 10px;
                width: 50px;
            }

            .logo-right {
                font-size: 12px;
                font-weight: none;
                float: right;
                margin-top: -15px;
                width: 50px;
            }

            .footer-left {
                float: left;
                width: 50%;
                text-align: left;
            }

            .footer-right {
                float: right;
                width: 50%;
                text-align: right;
            }
            
            .table {
                font-size: 15px;
                margin-top: 10px;
                border-collapse: collapse;
                border: 1px solid #000;
                width: 100%;
                color: #fff;
                table-layout: fixed;
            }
            .table th {
                font-size: 16px;
                height: 20px;
                border: 1px solid #000;
                text-align: center;
                vertical-align: middle;
                background: #2980b9;
            }
            .table td {
                overflow: hidden;
                white-space: nowrap;
                height: 15px;
                border: 1px solid #000;
                vertical-align: middle;
                background: #fff;
                color: #000;
                padding: 3px;
            }

            .text-center {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <header class="content">
            <img class="logo-left" src="<?= PATH_DIR ?>/public/img/logo-pdf.jpg">
            Relatório de Produtos
            <div class="logo-right">Página</div>
        </header>
        <footer>
            <div class="footer-left"><?= $_SESSION['system']['name'] ?></div>
            <div class="footer-right">Versão <?= $_SESSION['system']['version'] ?></div>
        </footer>
        <main>
            <table class="table">
                <thead>
                    <tr>
                        <th width="10%">Código</th>
                        <th width="50%">Nome</th>
                        <th width="40%">Marca</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (is_array($products) && count($products) > 0): ?>
                    <?php foreach ($products as $value): ?>
                    <tr>
                        <td class="text-center"><?= str_pad($value['idproduto'], 5, 0, STR_PAD_LEFT)?></td>
                        <td><?=$value['desnome']?></td>
                        <td><?=$value['desmarca']?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </main>
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
$pdf->setPaper('A4', 'portrait');
$pdf->render();
$font = $pdf->getFontMetrics()->get_font("Sans-serif");
$page = "{PAGE_NUM}";
$canvas = $pdf->get_canvas();
$canvas->page_text(545, 53, $page, $font, 10, array(0,0,0));
$pdf->stream('listProduct.pdf', array(
    'Attachment' => false
));

exit(0);
?>
