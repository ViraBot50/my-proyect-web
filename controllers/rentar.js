var v_control;



function m_addUsers() {

            if (sec_rentar.classList.contains("d-none")){
                sec_rentar.classList.remove("d-none");
                sec_add.classList.add("d-none");
            }else{
                sec_rentar.classList.add("d-none");
                sec_add.classList.remove("d-none");
            }

        }



function control(p_accion,id,text){
    switch(p_accion){

    case 'insert_user':
        v_control=$.dialog({
        title: "Cargando",
        columnClass: "medium",
        type:"green",
        content:'<div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="">Loading...</span>' 
        })

         $.ajax({
        url:"../class/classProducts.php?accion="+p_accion,
        type:"post",
        data: $("#form_usuario").serialize(),// {p_accion:cual},
        beforeSend: function(){control.innerHTML='<div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="">Loading...</span>'},
        success: function(html){
                    v_control.close();
                    dinamic_data.innerHTML=html;
                    m_addUsers();
                    form_usuario.reset();
                }
                  });
        break;
    case 'insert_renta':
        $.ajax({
        url:"../class/classProducts.php?accion="+p_accion,
        type:"post",
        data: $("#form_renta").serialize(),// {p_accion:cual},
        beforeSend: function(){alert('<div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="">Loading...</span>')},
        success: function(html){dinamic_data.innerHTML=html;}
                      });

    break;



        default: alert('No existe p_accion');
    }






}
