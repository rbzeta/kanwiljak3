<?php
require '../helper/PHPExcel.php';
require '../helper/PHPExcel/Style.php';
require '../helper/PHPExcel/Worksheet.php';
/* require '../helper/exportExcelProcess.php';
require '../helper/functionHelper.php';

sec_session_start();
$report_type = "";

if (isset($_GET['RTYPE'])) {
	$report_type = $_GET['RTYPE'];
}

switch ($report_type) {
	case "atmmaintenance":
		echo $_SESSION['user_id'];
		if (isset($_SESSION['excel_atm_maintenance'])) 
		{
			tesExport2Excel($statement);
		}
		break;
	default:
		;
		break;
} */


function exportReportMaintenanceATM($select_stmt,$ukerName)
{
	
	//STYLE
	$styleArrayBorder = array(
			'borders' => array(
					'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN					)
			),
			'font' => array(
					'bold' => true,
					'name' => 'Tahoma',
					'size' => 10
			),
			'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			)
	);
	
	//SET STYLE SUBDATA
	$styleArrayBorderData = array(
			'font' => array(
					'name' => 'Tahoma',
					'size' => 10
			),
	
	
			'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
	
	);
	
	$styleArrayBorderAllData = array(
			'font' => array(
					'name' => 'Tahoma',
					'size' => 10
			),
			'borders' => array(
					'left' => array(
							'style' => PHPExcel_Style_Border::BORDER_HAIR,
					),
					'right' => array(
							'style' => PHPExcel_Style_Border::BORDER_HAIR,
					)
	
			)
	
	);
	
	$styleArrayjudul = array(
			'font' => array(
					'bold' => true,
					'name' => 'Tahoma',
					'size' => 10
			),
			'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			)
	);
	
	
	$styleArraySubJudul = array(
			'font' => array(
					'bold' => true,
					'name' => 'Tahoma',
					'size' => 10
			),
			'borders' => array(
					'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_HAIR					)
			),
			'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			)
	);
	
	
	$styleArraySumarry = array(
			'font' => array(
					'bold' => true,
					'name' => 'Tahoma',
					'size' => 10
			),
			'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
					'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_HAIR					)
			)
	);
	
	$styleArraySumarryTanggal = array(
			'font' => array(
					'bold' => true,
					'name' => 'Tahoma',
					'size' => 10
			),
			'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
	);
	
	ob_start();

	$fileExcel =  new PHPExcel();

	$fileExcel->getProperties()->setCreator("Portal KW 3");
	$fileExcel->getProperties()->setTitle("Report Maintenance ATM");
	$fileExcel->getProperties()->setSubject("Report Maintenance ATM");
	$fileExcel->getProperties()->setDescription("Laporan maintenance petugas IT ATM");

	
	
	  //magre cell judul
	$fileExcel->setActiveSheetIndex(0)->setCellValue('A1', 'PT.BANK RAKYAT INDONESIA (PERSERO), Tbk')->mergeCells('A1:L1')->getStyle('A1')->applyFromArray($styleArrayjudul);
	$fileExcel->setActiveSheetIndex(0)->setCellValue('A2', "Laporan Maintenance ATM Petugas IT")->mergeCells('A2:L2')->getStyle('A2')->applyFromArray($styleArrayjudul);
	$fileExcel->setActiveSheetIndex(0)->setCellValue('A3',$ukerName)->mergeCells('A3:L3')->getStyle('A3')->applyFromArray($styleArrayjudul);
	$fileExcel->setActiveSheetIndex(0)->setCellValue('A4', "Hari / Tanggal Cetak : ".indonesian_date(date("l")) . date("d-m-Y"))->mergeCells('A4:L4')->getStyle('A4')->applyFromArray($styleArraySumarryTanggal);
	
	
	//STYLE DIMENSION
	$fileExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
	$fileExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
	$fileExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
	$fileExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
	$fileExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
	$fileExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
	$fileExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
	$fileExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
	$fileExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
	$fileExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true);
	$fileExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(60);
	$fileExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setAutoSize(true);
	$fileExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(60);
	$fileExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setAutoSize(true);
	
	//SET STYLE
	$fileExcel->setActiveSheetIndex(0)->getStyle('A6:N6')->applyFromArray($styleArraySubJudul);
	///get fill
	$fileExcel->getActiveSheet(0)->getStyle('A6:N6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$fileExcel->getActiveSheet(0)->getStyle('A6:N6')->getFill()->getStartColor()->setARGB('ffe4ba');
	 
	// Add data FOR JUDUL FIELD
	$fileExcel->setActiveSheetIndex(0)
	->setCellValue('A6', 'NO')
	->setCellValue('B6', 'TANGGAL')
	->setCellValue('C6', 'TID')
	->setCellValue('D6', 'MERK')
	->setCellValue('E6', 'CRO')
	->setCellValue('F6', 'KANCA SPV')
	->setCellValue('G6', 'LOKASI')
	->setCellValue('H6', 'ON/OFF-SITE')
	->setCellValue('I6', 'GARANSI')
	->setCellValue('J6', 'PROBLEM')
	->setCellValue('K6', 'TINDAKAN')
	->setCellValue('L6', 'STATUS')
	->setCellValue('M6', 'KETERANGAN')
	->setCellValue('N6', 'TEAM');

	
	//############################################################
	$counter = 7;
	$rNum = 1;
	if ($select_stmt->num_rows >= 1) {
	
		$select_stmt->bind_result($atm_act_id,
				$atm_act_date,
				$atm_act_loc,
				$atm_act_tid,
				$atm_act_pmaction,
				$atm_act_pmteamkc,
				$atm_act_pmdesc,
				$atm_brand_sname,
				$atm_cro_name,
				$branch_code,
				$atm_act_isonsite,
				$branch_name,
				$branch_mbcode,
				$branch_mbname,
				$problem_name,
				$status_name,
				$status_id,
				$atm_act_isgaransi,
				$user_lname,
				$user_uker);
		while ($select_stmt->fetch()){
			
			 if($counter%2==0)
			{
				$fileExcel->getActiveSheet(0)->getStyle('A'.$counter.':N'.$counter)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$fileExcel->getActiveSheet(0)->getStyle('A'.$counter.':N'.$counter)->getFill()->getStartColor()->setARGB('DADADA');
			
			
			}
			
			//style data
			$fileExcel->setActiveSheetIndex(0)->getStyle('A'.$counter.':H'.$counter.'')->applyFromArray($styleArrayBorderData);
			$fileExcel->setActiveSheetIndex(0)->getStyle('A'.$counter)->applyFromArray($styleArrayBorderAllData);
			$fileExcel->setActiveSheetIndex(0)->getStyle('B'.$counter)->applyFromArray($styleArrayBorderAllData);
			$fileExcel->setActiveSheetIndex(0)->getStyle('C'.$counter)->applyFromArray($styleArrayBorderAllData);
			$fileExcel->setActiveSheetIndex(0)->getStyle('D'.$counter)->applyFromArray($styleArrayBorderAllData);
			$fileExcel->setActiveSheetIndex(0)->getStyle('E'.$counter)->applyFromArray($styleArrayBorderAllData);
			$fileExcel->setActiveSheetIndex(0)->getStyle('F'.$counter)->applyFromArray($styleArrayBorderAllData);
			$fileExcel->setActiveSheetIndex(0)->getStyle('G'.$counter)->applyFromArray($styleArrayBorderAllData);
			$fileExcel->setActiveSheetIndex(0)->getStyle('H'.$counter)->applyFromArray($styleArrayBorderAllData);
			$fileExcel->setActiveSheetIndex(0)->getStyle('I'.$counter)->applyFromArray($styleArrayBorderAllData);
			$fileExcel->setActiveSheetIndex(0)->getStyle('J'.$counter)->applyFromArray($styleArrayBorderAllData);
			$fileExcel->setActiveSheetIndex(0)->getStyle('K'.$counter)->applyFromArray($styleArrayBorderAllData)->getAlignment()->setWrapText(true); 
			$fileExcel->setActiveSheetIndex(0)->getStyle('L'.$counter)->applyFromArray($styleArrayBorderAllData)->getAlignment()->setWrapText(true); 
			$fileExcel->setActiveSheetIndex(0)->getStyle('M'.$counter)->applyFromArray($styleArrayBorderAllData)->getAlignment()->setWrapText(true); 
			$fileExcel->setActiveSheetIndex(0)->getStyle('N'.$counter)->applyFromArray($styleArrayBorderAllData)->getAlignment()->setWrapText(true); 
				 
			if ($atm_act_isonsite == 1) {
				$isOnsite = "Onsite";
			}else $isOnsite = "Offsite";
				
			if ($atm_act_isgaransi == 1) {
				$isGaransi = "Garansi";
			}else $isGaransi = "Non Garansi";
				
			$teamPM = "";
			if (!empty($user_lname)) {
				$teamPM = $user_lname;
				if (!empty($atm_act_pmteamkc)) $teamPM .=','.$atm_act_pmteamkc;
			}
			
			$fileExcel->setActiveSheetIndex(0)->setCellValue('A'.$counter, $rNum)
			->setCellValue('B'.$counter, $atm_act_date)
			->setCellValue('C'.$counter, $atm_act_tid)
			->setCellValue('D'.$counter, $atm_brand_sname)
			->setCellValue('E'.$counter, $atm_cro_name)
			->setCellValue('F'.$counter, $branch_mbname)
			->setCellValue('G'.$counter, $atm_act_loc)
			->setCellValue('H'.$counter, $isOnsite)
			->setCellValue('I'.$counter, $isGaransi)
			->setCellValue('J'.$counter, $problem_name)
			->setCellValue('K'.$counter, $atm_act_pmaction)
			->setCellValue('L'.$counter, $status_name)
			->setCellValue('M'.$counter, $atm_act_pmdesc)
			->setCellValue('N'.$counter, $teamPM);
			
															
			$rNum += 1;
			$counter += 1;
		}
	}
	
	
	
	//###########################################################


	$fileExcel->getActiveSheet()->setTitle('Maintenance ATM');


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$fileExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	//clean the output buffer
	ob_end_clean();



	//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
	//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	//so, we use this header instead.
	//header('Content-type: application/vnd.ms-excel');
	//header('Content-Disposition: attachment;filename="reportmaintainatm.xlsx"');
	//header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($fileExcel, 'Excel2007');
	//$objWriter->save('php://output');
	$objWriter->save('reportmaintainatm.xlsx');
	//$objWriter->save(str_replace(__FILE__,'/path/to/save/tes.xlsx',__FILE__));
	//exit();
}

function indonesian_date ($hari) {
	// $hari = '';
	if($hari=='Sunday'){$hari ="Minggu, ";}
	if($hari=='Monday'){$hari ="Senin, ";}
	if($hari=='Tuesday'){$hari ="Selasa, ";}
	if($hari=='Wednesday'){$hari ="Rabu, ";}
	if($hari=='Thursday'){$hari ="Kamis, ";}
	if($hari=='Friday'){$hari ="Jumat, ";}
	if($hari=='Saturday'){$hari ="Sabtu, ";}
	return $hari;
}
?>