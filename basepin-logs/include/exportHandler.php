<?php
require_once './config.php'; 
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

if (isset($_GET['ids']) && !empty($_GET['ids'])) {
    $id_array = array_map('intval', explode(',', $_GET['ids']));
    $placeholders = implode(',', array_fill(0, count($id_array), '?'));

    $query = "SELECT 
                ti.control_number, ti.item_key, ti.section, ti.customer, ti.technician_name, 
                ti.date_of_verification, ti.quarter, ti.no, ti.terminal_part_no,  ts.deformation_status, 
                ts.corrosion_status, ts.crack_status, ts.foreign_material_status, 
                ts.alignment_status, ts.total_ok, ts.total_ng, 
                tr.replacement_required, 
                tr.reason_replacement, tr.date_replaced
              FROM terminal_inspections ti
              LEFT JOIN terminal_status ts ON ti.id = ts.inspection_id
              LEFT JOIN terminal_replacement tr ON ti.id = tr.inspection_id
              WHERE ti.id IN ($placeholders)
              ORDER BY ti.control_number ASC";

    $stmt = $conn->prepare($query);
    $types = str_repeat('i', count($id_array));
    $stmt->bind_param($types, ...$id_array);
    $stmt->execute();
    $result = $stmt->get_result();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Grouped Report');


    $sheet->setCellValue('A1', 'TERMINAL INSPECTION COMPREHENSIVE REPORT');
    $sheet->mergeCells('A1:R1'); 
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(20)->getColor()->setRGB('1F4E78');
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getRowDimension('1')->setRowHeight(35);

    $sheet->setCellValue('A2', 'Date Generated: ' . date('F d, Y h:i A'));
    $sheet->mergeCells('A2:R2');
    $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A2')->getFont()->setItalic(true);
    $sheet->getRowDimension('2')->setRowHeight(20);

    $headerStyle = [
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER, 
            'vertical' => Alignment::VERTICAL_CENTER
        ],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
    ];

    $dataCellStyle = [
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER    
        ],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
    ];

    $rowNum = 4; 
    $lastControlNo = null;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            
            if ($row['control_number'] !== $lastControlNo) {
                
                if ($lastControlNo !== null) {
                    $rowNum += 2; 
                }

                $sheet->setCellValue('A' . $rowNum, "CONTROL NO: " . $row['control_number']);
                $sheet->mergeCells("A$rowNum:R$rowNum");
                $sheet->getStyle("A$rowNum")->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
                $sheet->getStyle("A$rowNum")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('203764');
                $sheet->getStyle("A$rowNum")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getRowDimension($rowNum)->setRowHeight(25); 
                $rowNum++;

                $headers = [
                    'no','terminal_part_no','Item Key', 'Section', 'Customer', 'Technician', 'Date Verified', 'Quarter',
                    'Deformation', 'Corrosion', 'Crack', 'Foreign Mat.', 'Alignment', 'OK', 'NG',
                    'Replace?', 'Reason', 'Date Replaced'
                ];
                
                $col = 'A';
                foreach ($headers as $h) {
                    $sheet->setCellValue($col . $rowNum, $h);
                    $sheet->getStyle($col . $rowNum)->applyFromArray($headerStyle);
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                    $col++;
                }
                $sheet->getRowDimension($rowNum)->setRowHeight(22); 
                $rowNum++;
            }

            $colData = 'A';
            $displayData = $row;
            $currentControlNo = $displayData['control_number'];
            unset($displayData['control_number']); 

            $sheet->getRowDimension($rowNum)->setRowHeight(20); 

            foreach ($displayData as $key => $value) {
                $cell = $colData . $rowNum;
                $sheet->setCellValue($cell, $value);
                
                $sheet->getStyle($cell)->applyFromArray($dataCellStyle);
                
                if ($value === 'NG') {
                    $sheet->getStyle($cell)->getFont()->setBold(true)->getColor()->setRGB('FF0000');
                    $sheet->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFEB9C');
                }

                if ($value === 'OK') {
                    $sheet->getStyle($cell)->getFont()->getColor()->setRGB('006100');
                }

                $colData++;
            }

            $lastControlNo = $currentControlNo;
            $rowNum++;
        }
    }

    $filename = "Terminal_Report_" . date('Ymd_His') . ".xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();

} else {
    echo "<script>alert('No Records Selected.'); window.history.back();</script>";
}