<?php
require '../helper/PHPExcel.php';


function tesExport2Excel($statement)
{
	ob_start();
	
	$fileExcel =  new PHPExcel();

	$fileExcel->getProperties()->setCreator("Portal KW 3");
	$fileExcel->getProperties()->setTitle("Report Maintenance ATM");
	$fileExcel->getProperties()->setSubject("Report Maintenance ATM");
	$fileExcel->getProperties()->setDescription("Laporan maintenance petugas IT ATM");

	// Add data FOR JUDUL FIELD
	$fileExcel->setActiveSheetIndex(0)
	->setCellValue('A5', 'NO')
	->setCellValue('B5', 'KATEGORI')
	->setCellValue('C5', 'JENIS')
	->setCellValue('D5', 'MERK')
	->setCellValue('E5', 'TYPE HADIAH')
	->setCellValue('F5', 'TAHUN PEMBUATAN')
	->setCellValue('G5', 'KONDISI PEMBUATAN')

	->setCellValue('H5', 'HARGA SATUAN')
	->setCellValue('I5', 'JUMLAH')
	->setCellValue('J5', 'POTONGAN HARGA')
	->setCellValue('K5', 'TOTAL HARGA');




	$fileExcel->getActiveSheet()->setTitle('DAFTAR HADIAH');


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$fileExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	//clean the output buffer
	ob_end_clean();



	//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
	//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	//so, we use this header instead.
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="reportmaintainatm.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($fileExcel, 'Excel2007');
	$objWriter->save('php://output');
	//$objWriter->save(str_replace(__FILE__,'/path/to/save/tes.xlsx',__FILE__));
	exit();
}
?>