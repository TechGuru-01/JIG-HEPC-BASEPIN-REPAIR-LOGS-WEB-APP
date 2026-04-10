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
                ti.control_number, ti.item_key, ti.section, ti.customer, 
                ti.technician_name, ti.date_of_verification, ti.quarter, 
                ts.id as status_row_id, ts.row_no, 
                ts.terminal_part_no as inspect_part_no, ts.deformation_status, 
                ts.corrosion_status, ts.crack_status, ts.foreign_material_status, 
                ts.alignment_status,
                tr.id as replacement_row_id, tr.replacement_terminal_replace_no as replace_part_no, 
                tr.replacement_required, tr.reason_replacement, tr.date_replaced,
                tr.replacement_technician
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

    $data_grouped = [];
    while ($row = $result->fetch_assoc()) {
        $ctrl = $row['control_number'];
        if (!isset($data_grouped[$ctrl])) {
            $data_grouped[$ctrl] = ['info' => $row, 'inspections' => [], 'replacements' => []];
        }

        if (!empty($row['status_row_id']) && !isset($data_grouped[$ctrl]['inspections'][$row['status_row_id']])) {
            $data_grouped[$ctrl]['inspections'][$row['status_row_id']] = $row;
        }

        if (!empty($row['replacement_row_id']) && strtoupper($row['replacement_required'] ?? '') !== 'NO' && !isset($data_grouped[$ctrl]['replacements'][$row['replacement_row_id']])) {
            $data_grouped[$ctrl]['replacements'][$row['replacement_row_id']] = $row;
        }
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Terminal Detailed Report');

    $navyBlue = '1F3864';
    $sectionHeaderStyle = [
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']]]
    ];
    $borderStyle = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'BFBFBF']]]];

    $sheet->setCellValue('A1', 'TERMINAL INSPECTION & REPLACEMENT DETAILED REPORT');
    $sheet->mergeCells('A1:J1');
    $sheet->getStyle('A1:J1')->getFont()->setBold(true)->setSize(16)->getColor()->setRGB('FFFFFF');
    $sheet->getStyle('A1:J1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($navyBlue);
    $sheet->getRowDimension('1')->setRowHeight(35);

    $rowNum = 3;

    foreach ($data_grouped as $ctrlNo => $data) {
        // Main Header per Control Number
        $sheet->setCellValue('A' . $rowNum, " CONTROL NO: " . $ctrlNo . " | CUSTOMER: " . $data['info']['customer']);
        $sheet->mergeCells("A$rowNum:J$rowNum");
        $sheet->getStyle("A$rowNum:J$rowNum")->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A$rowNum:J$rowNum")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('203764');
        $rowNum++;

        // Nilagay ko dito yung Item Key boy para kitang-kita agad
        $sheet->setCellValue('A' . $rowNum, " ITEM KEY: " . $data['info']['item_key'] . " | SECTION: " . $data['info']['section'] . " | DATE: " . $data['info']['date_of_verification']);
        $sheet->mergeCells("A$rowNum:J$rowNum");
        $sheet->getStyle("A$rowNum:J$rowNum")->getFont()->setItalic(true)->setBold(true);
        $rowNum += 2;

        // --- SECTION I: INSPECTION ---
        $sheet->setCellValue('A' . $rowNum, "I. INSPECTION DETAILS");
        $sheet->getStyle('A' . $rowNum)->getFont()->setBold(true)->setSize(12);
        $rowNum++;

        $inspectHeaders = ['Row No', 'Terminal Part No', 'Deformation', 'Corrosion', 'Crack', 'Foreign Mat.', 'Alignment', 'Verified By'];
        $col = 'A';
        foreach ($inspectHeaders as $h) {
            $cell = ($col == 'H') ? 'J' . $rowNum : $col . $rowNum; 
            $sheet->setCellValue($cell, $h);
            $sheet->getStyle($cell)->applyFromArray($sectionHeaderStyle);
            if($col == 'H') { $sheet->mergeCells("H$rowNum:J$rowNum"); }
            $col++;
            if($col == 'I') break; 
        }
        $rowNum++;

        $totalGroupOK = 0;
        $totalGroupNG = 0;

        foreach ($data['inspections'] as $ins) {
            $statuses = [
                $ins['deformation_status'], $ins['corrosion_status'], $ins['crack_status'], 
                $ins['foreign_material_status'], $ins['alignment_status']
            ];

           $isNG = false;
            foreach ($statuses as $status) {

                if (strtoupper(trim($status ?? '')) === 'NG') {
                    $isNG = true;
                    break; 
                }
            }

            if ($isNG) { $totalGroupNG++; } else { $totalGroupOK++; }

            $sheet->setCellValue('A'.$rowNum, $ins['row_no']);
            $sheet->setCellValue('B'.$rowNum, $ins['inspect_part_no']);
            $sheet->setCellValue('C'.$rowNum, strtoupper($ins['deformation_status']));
            $sheet->setCellValue('D'.$rowNum, strtoupper($ins['corrosion_status']));
            $sheet->setCellValue('E'.$rowNum, strtoupper($ins['crack_status']));
            $sheet->setCellValue('F'.$rowNum, strtoupper($ins['foreign_material_status']));
            $sheet->setCellValue('G'.$rowNum, strtoupper($ins['alignment_status']));
            $sheet->setCellValue('J'.$rowNum, $ins['technician_name']);
            $sheet->mergeCells("H$rowNum:J$rowNum");

            $sheet->getStyle("A$rowNum:J$rowNum")->applyFromArray($borderStyle);
            $sheet->getStyle("A$rowNum:J$rowNum")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            if ($rowNum % 2 == 0) $sheet->getStyle("A$rowNum:J$rowNum")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F9F9F9');

            $rowNum++;
        }

        $rowNum += 2;

        // --- SECTION II: REPLACEMENT ---
        $sheet->setCellValue('A' . $rowNum, "II. REPLACEMENT DETAILS");
        $sheet->getStyle('A' . $rowNum)->getFont()->setBold(true)->setSize(12);
        $rowNum++;

        $replaceHeaders = ['Replacement Terminal No', 'Status', 'Replacement Tech', 'Reason', 'Date Replaced'];
        $col = 'A';
        foreach ($replaceHeaders as $h) {
            $sheet->setCellValue($col . $rowNum, $h);
            $sheet->getStyle($col . $rowNum)->applyFromArray($sectionHeaderStyle);
            $col++;
        }
        $rowNum++;

        if (empty($data['replacements'])) {
            $sheet->setCellValue('A'.$rowNum, "No replacements recorded.");
            $sheet->mergeCells("A$rowNum:E$rowNum");
            $sheet->getStyle("A$rowNum:E$rowNum")->applyFromArray($borderStyle);
            $rowNum++;
        } else {
            foreach ($data['replacements'] as $rep) {
                $sheet->setCellValue('A'.$rowNum, $rep['replace_part_no']);
                $sheet->setCellValue('B'.$rowNum, strtoupper($rep['replacement_required']));
                $sheet->setCellValue('C'.$rowNum, $rep['replacement_technician']);
                $sheet->setCellValue('D'.$rowNum, $rep['reason_replacement']);
                $sheet->setCellValue('E'.$rowNum, $rep['date_replaced']);
                $sheet->getStyle("A$rowNum:E$rowNum")->applyFromArray($borderStyle);
                $sheet->getStyle("A$rowNum:E$rowNum")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $rowNum++;
            }
        }

        // --- SUMMARY ---
        $rowNum++;
        $summaryStart = $rowNum;

        $sheet->setCellValue('H' . $rowNum, "Total Passed (OK):");
        $sheet->setCellValue('J' . $rowNum, $totalGroupOK);
        $sheet->getStyle('J'.$rowNum)->getFont()->getColor()->setRGB('008000');
         $rowNum++;
        
        $sheet->setCellValue('H' . $rowNum, "Total Failed (NG):");
        $sheet->setCellValue('J' . $rowNum, $totalGroupNG);
        $sheet->getStyle('J'.$rowNum)->getFont()->getColor()->setRGB('C00000');
        $rowNum += 2;
        
        $sheet->setCellValue('H' . $rowNum, "Total Units Inspected:");
        $sheet->setCellValue('J' . $rowNum, count($data['inspections']));
         $rowNum++;
        
        $sheet->setCellValue('H' . $rowNum, "Total Units Replaced:");
        $sheet->setCellValue('J' . $rowNum, count($data['replacements']));
        
        $sheet->getStyle("H$summaryStart:J$rowNum")->getFont()->setBold(true);
        $sheet->getStyle("J$summaryStart:J$rowNum")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $rowNum += 3; 
    }

    foreach (range('A', 'J') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $filename = "Terminal_Report_Final_" . date('Ymd_His') . ".xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
}