<?php
	//Creamos una clase temporal
	class Vario
	{
		private $_comida = array();
		private $_num = 0;

		//creamos el array de comidas
		public function setArrayComida( $comidas )
		{
			$this->_comida[$this->_num] = $comidas;

			$this->_num++;

			return $this->_comida;
		}

		public function crearInsert( $usuarios_id )
		{
			$sql = "INSERT INTO comidas( nombre, usuarios_id ) VALUES ";
			$lim = sizeof( $this->_comida );
			for ($i=0; $i < $lim; $i++) { 
				if ( $lim - 1 == $i ) {
					$sql .= "('" . $this->_comida[$i] . "', " . $usuarios_id . ");";
				} else {
					$sql .= "('" . $this->_comida[$i] . "', " . $usuarios_id . "), ";
				}
			}

			return $sql;

		}

	}


	if ($_POST) {

		
		//conexion a la mysql
		$conexion = mysql_connect("localhost", "prueba", "prueba");
		//usar la tabla consulta_select
		mysql_select_db("consulta_select", $conexion);

		$nombre = (isset($_POST["nombre"])) ? trim( $_POST["nombre"] ) : '' ;
		$comida1 = (isset($_POST["comida1"])) ? trim( $_POST["comida1"] ) : '' ;
		$comida2 = (isset($_POST["comida2"] )) ? trim( $_POST["comida2"] ) : '' ;
		$comida3 = (isset($_POST["comida2"] )) ? trim( $_POST["comida3"] ) : '' ;
		$comida4 = (isset($_POST["comida2"] )) ? trim( $_POST["comida4"] ) : '' ;
		$comida5 = (isset($_POST["comida2"] )) ? trim( $_POST["comida5"] ) : '' ;

		$nombre = mysql_real_escape_string($nombre);
		$comida1 = mysql_real_escape_string($comida1);
		$comida2 = mysql_real_escape_string($comida2);
		$comida3 = mysql_real_escape_string($comida3);
		$comida4 = mysql_real_escape_string($comida4);
		$comida5 = mysql_real_escape_string($comida5);

		$sql = sprintf( "INSERT INTO usuarios(nombre) VALUES ('%s')", $nombre );

		$result = mysql_query($sql);
		$usuarios_id = mysql_insert_id();

		$varios = new Vario;

		//creamos el array de comida
		$varios->setArrayComida($comida1);
		$varios->setArrayComida($comida2);
		$varios->setArrayComida($comida3);
		$varios->setArrayComida($comida4);
		$varios->setArrayComida($comida5);

		$sql = $varios->crearInsert( $usuarios_id );

		$result = mysql_query($sql);

		$sql = sprintf( "INSERT INTO comidas(nombre, usuarios_id) VALUES ('%1\$s', '%3\$d'), ('%2\$s', '%3\$d')", $comida1, $comida2, $usuarios_id );


		$result = mysql_query($sql);


		$sql = sprintf( "SELECT * FROM usuarios, comidas WHERE usuarios.id = comidas.usuarios_id AND usuarios.id = '%d'", $usuarios_id );

		$result = mysql_query($sql, $conexion);

		while ( $row =@ mysql_fetch_assoc($result)  ) {
			$usuario[] = $row;
		}


		$resultado = "-Se ha creado un nuevo usuario-";

	}else {
		$resultado = "-No se entro adecuadamente-";
	}

?>
<html>
<head>
	<title></title>
</head>
<body>
	<h1><?php echo $resultado; ?></h1>
	<p>
		<?php 
			var_dump($usuario);
		?>
	</p>
</body>
</html>