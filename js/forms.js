function test(){alert('test');return true;}
function formhash(form, password) {
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
 
    // Finally submit the form. 
    form.submit();
}
 
function regformhash(form, userlname, password, conf,pn,jabatan,email,uker,lstKC) {
 // Check each field has a value
    if (userlname.value =='' ||
          email.value == ''     || pn.value =='' ||
          password.value == ''  || jabatan.value == '' ||
          conf.value == '' || (uker[1].checked && lstKC.value == 0)) {
 
        alert('Anda harus mengisi semua data. Silahkan coba lagi');
        return false;
    }
    
    // Check Radio button
    var cek = false;
    for(var i=0; i<uker.length; i++) {
        if( uker[i].checked ) {
        	cek = true;        	
        }
    }
    
    if(!cek){
    	alert("Pilih uker kanwil atau kanca. Silahkan coba lagi");
        return false;
    }
    
    // Check unit kerja if kanca radio selected
    if(uker[1].checked && lstKC.value == 0){
    	alert("Pilihan unit kerja harus diisi. Silahkan coba lagi");
        return false;
    }
    
    // Check the pn
    re = /^\w+$/; 
    if(!re.test(form.pn.value)) { 
        alert("PN hanya boleh terdiri dari huruf dan angka. Silahkan coba lagi"); 
        form.pn.focus();
        return false; 
    }
 
    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 6) {
        alert('Password minimal terdiri dari 6 karakter atau lebih.  Silahkan coba lagi');
        form.password.focus();
        return false;
    }
 
    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
 
    /*var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }*/
 
    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Password tidak sama. Silahkan coba lagi');
        form.password.focus();
        return false;
    }
 
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";
 
    // Finally submit the form. 
    form.submit();
    return true;
}

function upduserformhash(form, userlname, password, conf,jabatan,email,uker,lstKC) {
	 // Check each field has a value
	    if (userlname.value =='' ||
	          email.value == ''     || 
	          password.value == ''  || jabatan.value == '' ||
	          conf.value == '' || (uker[1].checked && lstKC.value == 0)) {
	 
	        alert('Anda harus mengisi semua data. Silahkan coba lagi');
	        return false;
	    }
	    
	    // Check Radio button
	    var cek = false;
	    for(var i=0; i<uker.length; i++) {
	        if( uker[i].checked ) {
	        	cek = true;        	
	        }
	    }
	    
	    if(!cek){
	    	alert("Pilih uker kanwil atau kanca. Silahkan coba lagi");
	        return false;
	    }
	    
	    // Check unit kerja if kanca radio selected
	    if(uker[1].checked && lstKC.value == 0){
	    	alert("Pilihan unit kerja harus diisi. Silahkan coba lagi");
	        return false;
	    }
	    
	    // Check the pn
//	    re = /^\w+$/; 
//	    if(!re.test(pn.value)) { 
//	        alert("PN hanya boleh terdiri dari huruf dan angka. Silahkan coba lagi"); 
//	        form.pn.focus();
//	        return false; 
//	    }
	    
	    // Check that the password is sufficiently long (min 6 chars)
	    // The check is duplicated below, but this is included to give more
	    // specific guidance to the user
	    if (password.value.length < 6) {
	        alert('Password minimal terdiri dari 6 karakter atau lebih.  Silahkan coba lagi');
	        form.password.focus();
	        return false;
	    }
	 
	    // At least one number, one lowercase and one uppercase letter 
	    // At least six characters 
	 
	    /*var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
	    if (!re.test(password.value)) {
	        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
	        return false;
	    }*/
	 
	    // Check password and confirmation are the same
	    if (password.value != conf.value) {
	        alert('Password tidak sama. Silahkan coba lagi');
	        form.password.focus();
	        return false;
	    }
	 
	    // Create a new element input, this will be our hashed password field. 
//	    var p = document.createElement("input");
//	 
//	    // Add the new element to our form. 
//	    form.appendChild(p);
//	    p.name = "p";
//	    p.type = "hidden";
//	    p.value = hex_sha512(password.value);
//	 
//	    // Make sure the plaintext password doesn't get sent. 
//	    password.value = "";
//	    conf.value = "";
	 
	    // Finally submit the form. 
	    //form.submit();
	    return true;
	}

function regformhash2(form, userlname, password, conf,pn,jabatan,email,uker,lstKC) {

	 // Check each field has a value
	    if (userlname.value =='' ||
	          email.value == ''     || pn.value =='' ||
	          password.value == ''  || jabatan.value == '' ||
	          conf.value == '' || (uker[1].checked && lstKC.value == 0)) {
	 
	        alert('Anda harus mengisi semua data. Silahkan coba lagi');
	        return false;
	    }
	    
	    // Check Radio button
	    var cek = false;
	    for(var i=0; i<uker.length; i++) {
	        if( uker[i].checked ) {
	        	cek = true;        	
	        }
	    }
	    
	    if(!cek){
	    	alert("Pilih uker kanwil atau kanca. Silahkan coba lagi");
	        return false;
	    }
	    
	    // Check unit kerja if kanca radio selected
	    if(uker[1].checked && lstKC.value == 0){
	    	alert("Pilihan unit kerja harus diisi. Silahkan coba lagi");
	        return false;
	    }
	    
	    // Check the pn
	    re = /^\w+$/; 
	    if(!re.test(pn.value)) {
	        alert("PN hanya boleh terdiri dari huruf dan angka. Silahkan coba lagi"); 
	        form.pn.focus();
	        return false; 
	    }
	    
	    // Check that the password is sufficiently long (min 6 chars)
	    // The check is duplicated below, but this is included to give more
	    // specific guidance to the user
	    if (password.value.length < 6) {
	        alert('Password minimal terdiri dari 6 karakter atau lebih.  Silahkan coba lagi');
	        form.password.focus();
	        return false;
	    }
	    
	    // At least one number, one lowercase and one uppercase letter 
	    // At least six characters 
	 
	    /*var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
	    if (!re.test(password.value)) {
	        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
	        return false;
	    }*/
	 
	    // Check password and confirmation are the same
	    if (password.value != conf.value) {
	        alert('Password tidak sama. Silahkan coba lagi');
	        form.password.focus();
	        return false;
	    }
	    
	    // Create a new element input, this will be our hashed password field. 
	    var p = document.createElement("input");
	 
	    // Add the new element to our form. 
	    form.appendChild(p);
	    p.name = "p";
	    p.type = "hidden";
	    p.value = hex_sha512(password.value);
	 
	    // Make sure the plaintext password doesn't get sent. 
	    password.value = "";
	    conf.value = "";
	    form.actionsubmit.value = "submitted";
	    // Finally submit the form. 
	    form.submit();
	    return true;
	}

function updateAtmMaintenanceValidation(form,recordId,atm_act_date,
		atm_act_tid,
		select_merk,
		select_cro,
		select_isonsite,
		select_isgaransi,
		select_kanca,
		atm_act_loc,
		select_problem,
		atm_act_pmaction,
		atm_act_pmdesc,
		select_status,
		select_teamkw,
		atm_act_pmteamkc){

	if(atm_act_date.value == '' || atm_act_tid.value == '' || select_merk.value  == 0 || select_cro.value  == 0 ||
	   select_isonsite.value  == 2 || select_isgaransi.value  == 2 || select_kanca  == 0 ||	atm_act_loc.value == '' ||
		select_problem.value  == 0 || atm_act_pmaction.value.length == '' || select_status.value  == 0 ||
		select_teamkw.value == 0){
		
		alert('Anda harus mengisi semua data. Silahkan coba lagi');
		return false;
	}
	
	return true;
}

function insertAtmMaintenanceValidation(form,atm_act_date,
		atm_act_tid,
		select_merk,
		select_cro,
		select_isonsite,
		select_isgaransi,
		select_kanca,
		atm_act_loc,
		select_problem,
		atm_act_pmaction,
		atm_act_pmdesc,
		select_status,
		select_teamkw,
		atm_act_pmteamkc){

	if(atm_act_date.value == '' || atm_act_tid.value == '' || select_merk.value  == 0 || select_cro.value  == 0 ||
	   select_isonsite.value  == 2 || select_isgaransi.value  == 2 || select_kanca  == 0 ||	atm_act_loc.value == '' ||
		select_problem.value  == 0 || atm_act_pmaction.value.length == '' || select_status.value  == 0 ||
		select_teamkw.value == 0){
		
		alert('Anda harus mengisi semua data. Silahkan coba lagi');
		return false;
	}
	
	return true;
}

function insertUkoMaintenanceValidation(form,
		ukermaintenance_date,
		select_kanca,
		ukermaintenance_keterangan,
		ukermaintenance_problem,
		ukermaintenance_tindaklanjut,
		select_status,
		ukermaintenance_pic
		){

	if(ukermaintenance_date.value == '' || ukermaintenance_keterangan.value == '' || select_kanca.value  == 0 || 
			select_status.value  == 0 || ukermaintenance_problem.value == '' || ukermaintenance_tindaklanjut.value == '' || 
			ukermaintenance_pic.value == ''){
		
		alert('Anda harus mengisi semua data. Silahkan coba lagi');
		return false;
	}
	
	return true;
}

function insertAtmSparepartValidation(form,select_merk,
		select_part,
		atmpart_sn,
		atmpart_source_tid,
		atmpart_dest_tid,
		atmpart_keterangan,
		select_statuspart){

	if(select_merk.value  == 0 || select_statuspart.value  == 0 || select_part.value  == 0 || atmpart_sn.value == '' ){
		
		alert('Anda harus mengisi semua data. Silahkan coba lagi');
		return false;
	}
	
	return true;
}

function updateAtmSparepartValidation(form,recordId,select_merk,
		select_part,
		atmpart_sn,
		atmpart_source_tid,
		atmpart_dest_tid,
		atmpart_keterangan,
		select_statuspart){

	if(select_merk.value  == 0 || select_statuspart.value  == 0 || select_part.value  == 0 || atmpart_sn.value == '' ){
		
		alert('Anda harus mengisi semua data. Silahkan coba lagi');
		return false;
	}
	
	return true;
}

function updateAtmProblemValidation(form,recordId,atmnop_tid,
		atmnop_brand,
		atmnop_vendor,
		atmnop_lokasi,
		atmnop_area,
		atmnop_pengelola,
		atmnop_petugas,
		atmnop_keterangan){

	/*if(select_merk.value  == 0 || select_statuspart.value  == 0 || select_part.value  == 0 || atmpart_sn.value == '' ){
		
		alert('Anda harus mengisi semua data. Silahkan coba lagi');
		return false;
	}*/
	
	return true;
}

function updateUkoMaintenanceValidation(form,recordId,
		ukermaintenance_date,
		select_kanca,
		ukermaintenance_keterangan,
		ukermaintenance_problem,
		ukermaintenance_tindaklanjut,
		select_status,
		ukermaintenance_pic
		){
	
	if(ukermaintenance_date.value == '' || ukermaintenance_keterangan.value == '' || select_kanca.value  == 0 || 
			select_status.value  == 0 || ukermaintenance_problem.value == '' || ukermaintenance_tindaklanjut.value == '' || 
			ukermaintenance_pic.value == ''){
		
		alert('Anda harus mengisi semua data. Silahkan coba lagi');
		return false;
	}
	
	return true;
}

function insertMasterMonbinValidation(form,
		tsimonbin_start_date,
		tsimonbin_end_date,
		select_kanca,
		tsimonbin_pic
		){
	
	if(tsimonbin_start_date.value == '' || tsimonbin_end_date.value == '' || select_kanca.value  == 0 || 
			tsimonbin_pic.value == '' ){
		
		alert('Anda harus mengisi semua data. Silahkan coba lagi');
		return false;
	}
	
	return true;
}

function updateAtmMasterValidation(form,recordId,select_kanca,
		masteratm_branch_code,
		masteratm_tid,
		select_tipeatm,
		masteratm_lokasi,
		select_isonsite,
		select_cro,
		select_isgaransi,
		select_merk){

	if(select_kanca.value  == 0 || masteratm_branch_code.value == '' || masteratm_tid.value == '' || select_tipeatm.value  == 0 ||
			masteratm_lokasi.value == '' || select_isonsite.value  == 2 || select_cro.value  == 0 || select_isgaransi.value  == 2 ||
			select_merk.value  == 0 ){
		
		alert('Anda harus mengisi semua data. Silahkan coba lagi');
		return false;
	}
	
	return true;
}

function updateAtmMasterValidation(form,recordId,select_kanca,
		masteratm_branch_code,
		masteratm_tid,
		select_tipeatm,
		masteratm_lokasi,
		select_isonsite,
		select_cro,
		select_isgaransi,
		select_merk){

	if(select_kanca.value  == 0 || masteratm_branch_code.value == '' || masteratm_tid.value == '' || select_tipeatm.value  == 0 ||
			masteratm_lokasi.value == '' || select_isonsite.value  == 2 || select_cro.value  == 0 || select_isgaransi.value  == 2 ||
			select_merk.value  == 0 ){
		
		alert('Anda harus mengisi semua data. Silahkan coba lagi');
		return false;
	}
	
	return true;
}

function updateStockMikrotikValidation(form,recordId,stockmikrotik_mikrotiksn,
		stockmikrotik_modemsn,
		stockmikrotik_simno,
		select_provider,
		select_status,
		stockmikrotik_lokasi,
		stockmikrotik_startdt,
		stockmikrotik_enddt,
		stockmikrotik_pic,
		stockmikrotik_ippool){
	
	if(select_provider.value  == 0 || stockmikrotik_mikrotiksn.value == '' || stockmikrotik_modemsn.value == '' || select_status.value  == 0 ||
			stockmikrotik_simno.value == '' || stockmikrotik_lokasi.value  == '' || stockmikrotik_startdt.value  == ''
				 || stockmikrotik_enddt.value  == '' || stockmikrotik_pic.value  == '' || stockmikrotik_ippool.value  == ''){
		
		alert('Anda harus mengisi semua data. Silahkan coba lagi');
		return false;
	}
	
	return true;
}

function insertStockMikrotikValidation(form,stockmikrotik_mikrotiksn,
		stockmikrotik_modemsn,
		stockmikrotik_simno,
		select_provider,
		select_status,
		stockmikrotik_lokasi,
		stockmikrotik_startdt,
		stockmikrotik_enddt,
		stockmikrotik_pic,
		stockmikrotik_ippool){
	
	if(select_provider.value  == 0 || stockmikrotik_mikrotiksn.value == '' || stockmikrotik_modemsn.value == '' || select_status.value  == 0 ||
			stockmikrotik_simno.value == '' || stockmikrotik_lokasi.value  == '' || stockmikrotik_startdt.value  == ''
				 || stockmikrotik_enddt.value  == '' || stockmikrotik_pic.value  == '' || stockmikrotik_ippool.value  == ''){
		
		alert('Anda harus mengisi semua data. Silahkan coba lagi');
		return false;
	}
	
	return true;
}

function insertJadwalATMValidation(form,
		atmjadwal_date,
		atmjadwal_tid,
		select_kanca,
		atmjadwal_pic,
		atmjadwal_keterangan)
{
	
	if(atmjadwal_date.value  == '' || atmjadwal_tid.value == '' || select_kanca.value == 0 || atmjadwal_pic.value  == '' ||
			atmjadwal_keterangan.value == ''){
		
		alert('Anda harus mengisi semua data. Silahkan coba lagi');
		return false;
	}
	
	return true;
}

function insertAtmMasterValidation(form,select_kanca,
		masteratm_branch_code,
		masteratm_tid,
		select_tipeatm,
		masteratm_lokasi,
		select_isonsite,
		select_cro,
		select_isgaransi,
		select_merk){

	if(select_kanca.value  == 0 || masteratm_branch_code.value == '' || masteratm_tid.value == '' || select_tipeatm.value  == 0 ||
			masteratm_lokasi.value == '' || select_isonsite.value  == 2 || select_cro.value  == 0 || select_isgaransi.value  == 2 ||
			select_merk.value  == 0 ){
		
		alert('Anda harus mengisi semua data. Silahkan coba lagi');
		return false;
	}
	
	return true;
}

