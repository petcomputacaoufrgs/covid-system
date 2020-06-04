function paginar(pagina){
    document.getElementById("hdnPagina").value = pagina;
    document.getElementById("formPesquisa").submit();
}

function limpar(){
    //alert("DDD");
    document.getElementById("hdnPagina").value = 1;
    document.getElementById("item1").value = -1;
    document.getElementById("pesquisaDisabled").disabled = true;
    document.getElementById("formPesquisa").submit();
}