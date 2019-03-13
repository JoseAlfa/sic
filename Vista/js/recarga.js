function ajaxFunction() {
  var xmlHttp;
  
  try {
   
    xmlHttp=new XMLHttpRequest();
    return xmlHttp;
  } catch (e) {
    
    try {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      return xmlHttp;
    } catch (e) {
      
	  try {
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        return xmlHttp;
      } catch (e) {
        alert("Tu navegador no soporta AJAX!");
        return false;
      }}}
}
function Enviar(_pagina,capa) {
    /*var ajax;
    ajax = ajaxFunction();
    ajax.open("POST", _pagina, true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    ajax.onreadystatechange = function() {
		if (ajax.readyState==1){
			document.getElementById(capa).innerHTML = " Aguarde por favor...";
			     }
		if (ajax.readyState == 4) {
		   
                document.getElementById(capa).innerHTML=ajax.responseText; 
		     }}
			 
	ajax.send(null);*/
	jQuery(document).ready(function(){jQuery(capa).load(_pagina,jQuery(capa).html(" "));})
} 
function eliminar(id,valor,tabla,campo,archivo)
{
	if(confirm('Esta Apunto de Eliminar a:'+valor+'.\n¿Desea Continuar?'))
	{
		$('#global').load('eliminar.php?id='+id+'&tabla='+tabla+'&campo='+campo+'&archivo='+archivo);
	}
	else
	{
		alert('Usted ha Cancelado Esta Operacion.');
	}

}