<?php

require_once '../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<p style="color:green; text-decoration: underline">Hello world!</p>');
$mpdf->Output();