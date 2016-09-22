$body = $("body");

$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});

$(document).ready(function(){
    function loading_show(){
        $('#loading').html("<img src='images/loading.gif'/>").fadeIn('fast');
    }
    function loading_hide(){
        $('#loading').fadeOut('fast');
    }                
    function loadData(page){
        loading_show();                    
        $.ajax
        ({
            type: "POST",
            url: "load_data_stok_edc_kanwil.php",
            //data: "page="+page,
            data: {page : page,logged : 'in'},
            success: function(msg)
            {
                $("#tabeldata").ajaxComplete(function(event, request, settings)
                {
                    loading_hide();
                    $("#tabeldata").html(msg);
                });
            }
        });
    }
    
    loadData(1,'','');  // For first time page load default results

    function loadData(page,txtSearch,selectSearch){
        loading_show();                    
        $.ajax
        ({
            type: "POST",
            url: "load_data_stok_edc_kanwil.php",
            //data: "page="+page,
            data: {page : page,logged : 'in', txtsearch : txtSearch, selectSearch :selectSearch},
            success: function(msg)
            {
                $("#tabeldata").ajaxComplete(function(event, request, settings)
                {
                    loading_hide();
                    $("#tabeldata").html(msg);
                });
            }
        });
    }
    
    $('#tabeldata .pagination li.active').live('click',function(){
        var page = $(this).attr('p');
        var txtSearch = $('#txtSearch').val();
        var selectSearch = $('#selectSearch').val();
        
        loadData(page,txtSearch,selectSearch);
        
    });           
    $('#go_btn').live('click',function(){
        var page = parseInt($('.goto').val());
        var no_of_pages = parseInt($('.total').attr('a'));
        var txtSearch = $('#txtSearch').val();
        var selectSearch = $('#selectSearch').val();
        if(page != 0 && page <= no_of_pages){
        	loadData(page,txtSearch,selectSearch);
        }else{
            alert('Enter a PAGE between 1 and '+no_of_pages);
            $('.goto').val("").focus();
            return false;
        }
        
    });

    $('#btnCari').live('click',function(){
        var txtSearch = $('#txtSearch').val();
        var selectSearch = $('#selectSearch').val();
        loadData(1,txtSearch,selectSearch);
    });
});
