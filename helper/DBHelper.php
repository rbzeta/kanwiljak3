<?php


/* function getKancaList($mysqli){
	//get kanca list
	$select_kanca = "SELECT 0 AS branch_id,0 AS branch_mbcode,'-' AS branch_name
										UNION ALL
										SELECT DISTINCT branch_code ,branch_mbcode,branch_mbname AS branch_name FROM m_branch WHERE branch_mbcode = branch_code ORDER BY branch_mbcode ";
	
	$kanca_stmt = $mysqli->prepare($select_kanca);
	
	if ($kanca_stmt) {
	
		$kanca_stmt->execute();
		$kanca_stmt->store_result();
	}
	
	return $kanca_stmt;
} */

function getKancaList($mysqli){
	//get kanca list
	$select_kanca = "SELECT 0 AS branch_id,0 AS branch_mbcode,'-' AS branch_name
					UNION ALL
					SELECT DISTINCT CAST(mainbr AS UNSIGNED) AS branch_id,CAST(mainbr AS UNSIGNED) AS branch_mbcode,mbdesc AS branch_name 
					FROM dwh_branch ORDER BY branch_mbcode ";
	$kanca_stmt = $mysqli->prepare($select_kanca);

	if ($kanca_stmt) {

		$kanca_stmt->execute();
		$kanca_stmt->store_result();
	}

	return $kanca_stmt;
}

function getProviderList($mysqli){
	//get provider list
	$select_provider = "SELECT 0 as provider_id,'-' as provider_desc UNION ALL SELECT edcprovider_id,edcprovider_nama FROM m_edc_provider ";
	$provider_stmt = $mysqli->prepare($select_provider);
	if ($provider_stmt) {
	
		$provider_stmt->execute();
		$provider_stmt->store_result();
	}
	return $provider_stmt;
}

function getMerkList($mysqli){
//get merk list
$select_merk = "SELECT 0 as edcbrand_id,'-' as edcbrand_nama UNION ALL SELECT edcbrand_id,edcbrand_nama FROM m_edc_brand ";
$merk_stmt = $mysqli->prepare($select_merk);
if ($merk_stmt) {

	$merk_stmt->execute();
	$merk_stmt->store_result();
}
	return $merk_stmt;
}

function getJenisUsahaList($mysqli){
	//get jenis usaha list
	$select_kategori = "SELECT 0 as jenisusaha_id,'-' as jenisusaha_desc UNION ALL SELECT jenisusaha_id,jenisusaha_desc FROM m_jenisusaha ";
	$kategori_stmt = $mysqli->prepare($select_kategori);
	if ($kategori_stmt) {
	
		$kategori_stmt->execute();
		$kategori_stmt->store_result();
	}

	return $kategori_stmt;
}


?>