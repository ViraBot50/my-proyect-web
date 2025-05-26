var control
var a_table='rol';
var a_consulta='SELECT * from rol';


function adminUD(p_accion,id,text){
	switch(p_accion){
    case 'edit':
    case 'new': control=$.dialog({
    title: (id==null?'Nuevo ':'Editando ')+a_table,
    columnClass: "xlarge",
    type:"green",
    content: 'url:../class/classAdminUD.php?table='+a_table+'&accion='+p_accion+'&Id='+id+"&query="+a_consulta})
     break;


     case 'inseUpdate': 
        $.ajax({
     	url:"../class/classAdminUD.php?table="+a_table+"&query="+a_consulta,
        type:"post",
        data: $("#formulario").serialize(),// {p_accion:cual},
        //beforeSend: function(){control.innerHTML='<div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="">Loading...</span></div><div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">Loading...</span></div>'},
        success: function(html){
                             vista.innerHTML=html;
                             control.close();
                          }
                      })
     break;

      case 'delete':$.confirm({
    title: 'Desea borrar',
    content: 'El registro: '+id+') '+text,
    type: "blue",
    buttons: {
        confirm: function () {
            $.ajax({
        url:"../class/classAdminUD.php?table="+a_table+"&query="+a_consulta,
        type:"post",
        data: {Id:id,accion:p_accion},
        success: function(html){
                             vista.innerHTML=html;
                          }
                      });
        },
        cancel: function () {
           // $.alert('Canceled!');
            },
        }
    }); break;





      default: alert('No existe p_accion');
	}
}
