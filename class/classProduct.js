
export default class ClassProduct{

	constructor (){
		this.a_id=0;
		this.a_name="";
		this.a_cantdisponible=0;
		this.a_precio=0;
	}



	 m_getProducto(p_listProducts) {
		const v_select=p_listProducts.options[p_listProducts.selectedIndex];
		this.a_id=v_select.dataset.id;
		this.a_name=v_select.value;
		this.a_cantdisponible=parseInt(v_select.dataset.cantidadDisponible)
		this.a_precio=parseFloat(v_select.dataset.precioVenta);
	}


	 m_veriProductoAgregado() {
		var v_respuesta=true;
		const v_product=document.getElementById(this.a_id);

		if (v_product ==null)
			v_respuesta=false;


		return v_respuesta;
	}


	 m_hayInventario(p_cantComprar){
		var v_respuesta=true;
		if ( this.a_cantdisponible<p_cantComprar)
			v_respuesta=false;

		return v_respuesta;
	}


}