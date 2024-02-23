<div class="container is-fluid mb-6">
	<h1 class="title">Pedidos</h1>
	<h2 class="subtitle">Actualizar pedido</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
		include "./inc/btn_back.php";

		require_once "./php/main.php";

		$id = (isset($_GET['order_id_up'])) ? $_GET['order_id_up'] : 0;
		$id=limpiar_cadena($id);

		//Verificando pedido
    	$check_pedido=conexion();
    	$check_pedido=$check_pedido->query("SELECT * FROM pedido WHERE id='$id'");

        if($check_pedido->rowCount()>0){
        	$datos=$check_pedido->fetch();

			echo '
                        <h2 class="title has-text-centered">Pedido Nº'.$datos['id'].'</h2>';
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/pedido_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" name="pedido_id" value="<?php echo $datos['id']; ?>" required >

		<div class="columns is-centered">
		  	<div class="column is-half">
		    	<div class="select is-rounded is-medium ">
                    <select name="pedido_estado">
                        <option value="" selected="selected" >- Selecciona un Estado -</option>
                        <option value="En proceso">En proceso</option>
                        <option value="Enviado">Enviado</option>
                        <option value="Entregado">Entregado</option>
                    </select>
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
	<?php 
		}else{
			include "./inc/error_alert.php";
		}
		$check_pedido=null;
	?>
</div>