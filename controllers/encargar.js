import ClassProduct from '../class/classProduct.js';

class Ventas{

	constructor (){
		this.a_producto=new ClassProduct();
		this.a_btnAgregar=document.getElementById("btnAgregar");
		this.a_formulario=document.getElementById("formulario");
		this.a_listProductos=document.getElementById("products");
		this.a_inpuCantidad=document.getElementById("cantComprar");

		this.a_valoPrevio=0;

	}


	m_accion(p_accion,p_producto){

		switch(p_accion){
			case 'insertVenta':
				c_total.innerHTML=parseInt(this.a_inpuCantidad.value)*parseInt(p_producto.a_precio)+parseInt(c_total.innerHTML);
				$.ajax({
     					url:"../class/classEncargos.php",
        				type:"post",
        				data: 	{accion:p_accion,
        						id_producto:p_producto.a_id,
        						Precio_venta:p_producto.a_precio,
        						Cantidad_disponible:p_producto.a_cantdisponible,
        						nombre:p_producto.a_name,
        						cantidad:this.a_inpuCantidad.value
        					},
        				success: function(html){
                             	formulario.insertAdjacentHTML('beforeend', html);

                          }
                      });
			 break;


			case 'borrarVenta':
				var v_componentes=document.getElementById(p_producto).children;

				$.ajax({
     					url:"../clander.php",
        				type:"post",
        				data: 	{accion:p_accion,
        						fecha_venta:v_componentes[4].value,
        					},
        				success: function(){
							 c_total.innerHTML=parseInt(c_total.innerHTML)-parseInt(v_componentes[0].value)*parseInt(v_componentes[2].value);     					
        					document.getElementById(p_producto).remove();

        				}
                      });
				break;
			case 'update':

				$.ajax({
     					url:"../cl.php",
        				type:"post",
        				data: 	p_producto,
        				success: (html) => {
							 c_total.innerHTML=parseInt(c_total.innerHTML)+p_producto.diferencia*p_producto.Precio_venta; 
							 //formulario.innerHTML=html;    					
        				}
                      });
				break;

	
			case 'veriFecha':
					$.ajax({
     					url:"../class/classEncargos.php",
        				type:"post",
        				data: 	$("#formFecha").serialize(),
        				success: (html) => {
							if (html!=="0")
								$.ajax({
     								url:"encargar.php",
        							type:"post",
        							data: 	{fecha:html},
        						success: (html) => {
									 document.body.innerHTML=html;					
        						}
                      		});
							else
								this.m_alert("No hay ningun evento ese dia","Fecha Incorrecta")	


        				}
                      });
			break;

			default: $.alert('No esta programado','Alert'+p_accion);
		}

	}



	 m_update(p_contenedor){
	 	var v_compHijos=p_contenedor.children;

	 	if (parseInt(v_compHijos[0].value)>parseInt(v_compHijos[0].max) || v_compHijos[0].value<1)
	 		v_compHijos[0].value=this.a_valoPrevio;
	 	else 
	 		this.m_accion('update',{accion:'update',fecha_venta:v_compHijos[4].value,cantidad:v_compHijos[0].value,diferencia:v_compHijos[0].value-this.a_valoPrevio,Precio_venta:parseInt(v_compHijos[2].value)});

	 	console.log(this.a_valoPrevio+"->"+p_contenedor.children[0].value);
	 }


	 setPrevio(p_contenedor) {
  		this.a_valoPrevio=p_contenedor.children[0].value;
	}


	 m_alert(p_msg,p_title) {
	 	$.alert(p_msg,p_title);
	}


	m_AgregarCompra(){
		this.a_producto.m_getProducto(this.a_listProductos);
		var v_cantidad=this.a_inpuCantidad.value;
		if (this.a_inpuCantidad.value>0)
			if (this.a_producto.m_veriProductoAgregado())
				this.m_alterProduct(this.a_producto,v_cantidad);
			else if (this.a_producto.m_hayInventario(v_cantidad))
				this.m_accion('insertVenta',this.a_producto);
			else 
				this.m_alert("La cantidad del inventario no cumple con la demanda <br> cantidad diponible: "+this.a_producto.a_cantdisponible,"No se puede Incrementar")

		else
				this.m_alert("Ingrese una cantidad de producto valido","Datos invalidos");
	
	}



	

	
	m_alterProduct(p_producto,p_cantidad){

		const v_container = document.getElementById(p_producto.a_id);
		const v_inputCantidad = v_container.querySelector("input");
		const v_cantfinal=parseInt(v_inputCantidad.value) + parseInt(p_cantidad);


		if (p_producto.m_hayInventario(v_cantfinal)){
			this.a_valoPrevio=v_inputCantidad.value;
			v_inputCantidad.value=v_cantfinal;
			this.m_update(v_container);
			this.m_alert("Producto "+p_producto.a_name+"<br> actualizado a "+v_cantfinal+" Unidades","Actualizacion de cantidad");
		}
		else
			this.m_alert("No es posble comprar "+v_cantfinal+" Unidades de "+this.a_producto.a_name+"<br> cantidad disponible :"+p_producto.a_cantdisponible,"Advertencia");

	}




}


const v_obj=new Ventas();
window.a_obj=v_obj;

