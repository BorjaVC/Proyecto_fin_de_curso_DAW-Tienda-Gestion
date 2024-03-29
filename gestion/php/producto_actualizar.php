<?php
	require_once "main.php";

	//Almacenar id 
    $id=limpiar_cadena($_POST['producto_id']);


    // Verificar producto 
	$check_producto=conexion();
	$check_producto=$check_producto->query("SELECT * FROM producto WHERE producto_id='$id'");

    if($check_producto->rowCount()<=0){
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El producto no existe en el sistema
            </div>
        ';
        exit();
    }else{
    	$datos=$check_producto->fetch();
    }
    $check_producto=null;


    // Almacenar datos 
    $nombre=limpiar_cadena($_POST['producto_nombre']);
    $categoria=limpiar_cadena($_POST['producto_categoria']);
    $talla=limpiar_cadena($_POST['producto_talla']);
    $color=limpiar_cadena($_POST['producto_color']);
	$precio=limpiar_cadena($_POST['producto_precio']);
	$cantidad=limpiar_cadena($_POST['producto_cantidad']);
    $descripcion=limpiar_cadena($_POST['producto_descripcion']);


	//Verificando campos obligatorios 
    if($nombre=="" || $categoria=="" ||  $talla=="" || $color==""   || $precio=="" || $cantidad=="" /*|| $descripcion==""*/){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    //Verificando integridad de los datos

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,50}",$talla)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La TALLA no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,50}",$color)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El COLOR no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[0-9.]{1,25}",$precio)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El PRECIO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[0-9]{1,25}",$cantidad)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La CANTIDAD no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    // Verificar nombre 
    if($nombre!=$datos['producto_nombre']){
	    $check_nombre=conexion();
	    $check_nombre=$check_nombre->query("SELECT producto_nombre FROM producto WHERE producto_nombre='$nombre'");
	    if($check_nombre->rowCount()>0){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
	            </div>
	        ';
	        exit();
	    }
	    $check_nombre=null;
    }


    // Verificar categoria
    if($categoria!=$datos['categoria_id']){
	    $check_categoria=conexion();
	    $check_categoria=$check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria'");
	    if($check_categoria->rowCount()<=0){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                La categoría seleccionada no existe
	            </div>
	        ';
	        exit();
	    }
	    $check_categoria=null;
    }


    // Actualizando datos/
    $actualizar_producto=conexion();
    $actualizar_producto=$actualizar_producto->prepare("UPDATE producto SET producto_nombre=:nombre,categoria_id=:categoria,producto_talla=:talla,producto_color=:color,producto_precio=:precio,producto_cantidad=:cantidad,producto_descripcion=:descripcion WHERE producto_id=:id");

    $marcadores=[
        ":nombre"=>$nombre,
        ":categoria"=>$categoria,
        ":talla"=>$talla,
        ":color"=>$color,
        ":precio"=>$precio,
        ":cantidad"=>$cantidad,
        ":descripcion"=>$descripcion,
        ":id"=>$id
    ];


    if($actualizar_producto->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡PRODUCTO ACTUALIZADO!</strong><br>
                El producto se actualizo con exito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar el producto, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_producto=null;