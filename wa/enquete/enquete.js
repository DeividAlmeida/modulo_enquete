function Enquete(id, pag){
    var UrlPainel = $('#Enquete'+id).attr("data-painel");
    $.ajax({
        type: "GET",
        cache: false,
        url: UrlPainel+'wa/enquete/enquete.php?id='+id+'&pag='+pag,
        beforeSend: function (data){
            //$("#SimpleSlideWA"+id).html("<center><br><img src=\""+UrlPainel+"wa/css_js/loading.gif\"><br>Carregando...<br></center>");
        },
        success: function (data) {
            jQuery('#Enquete'+id).html(data);
        },
        error: function (data) {
            setTimeout(function(){ Enquete(id, pag); }, 5000);
        },
    });
}
