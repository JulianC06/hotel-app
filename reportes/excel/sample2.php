<?php
    require '../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    
    use PhpOffice\PhpSpreadsheet\IOFactory;

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Hello World !');

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    /*header('Content-Disposition: attachment;filename="Reporte_Empresas.xlsx"');
    */

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    
?>