<?php
/*

@nameMethod:validateSecurityPassword(string)
@description:valida que una cadena de texto sea mayor a 8 caracteres,menor a 25, no tenga espacios, una letra miniscula,una mayuscula y un caracter numerico, en caso de cumplir con estos requisitos  invoca la funcion passwordEncrypt para restornar el hash de contraseña

@nameMethod:passwordEncrypt(string)
@description:encriptar contraseñas con hash

@nameMethod:validateImage(array,string)
@description:validateImage($_FILES,$folder) este metodo valida  el peso,extencion y tipo de imagen, retorna un string en caso de error  o un array en cuya posicion 0 contiene  true y en la 1 el nombre del archivo con su extencion y guarda el archivo en su respectiva carpeta

@nameMethod: validateDate(string,string,string)
@description:validateDate($fecha(Y-m-d),$acction) recibe 3 parametros (2 opcionales) el primero es la fecha a validar si la fecha esta en formato correcto retorna true, si se le agrega el segudo parametro con el valor 'past' retorna true si la fecha actual es igual o menor a la ingresada , si  se le agrega con el valor 'difference' retorna la diferencia  de dias entre la fecha actual y la ingresada si se agrega con el valor 'compare' y un tercer parametro en formate(Y-m-d) validara las dos fechas y retornara la diferencia  en dias de la primera fecha con la segunda

@nameMethod: DateInRange(string,string)
@description:validateDate(fecha_inicio,fecha_final) calcula las fechas   y rotorna la fechas en aumento  de un dia hasta llegar a la fecha limite

 @nameMethod: onlyNumbers(string)
@description:validateDate($dato)valida si en una cadena hay solo numeros si es asi retorna true si no false

@nameMethod: onlyNumbersDelete(string)
@description:validateDate($dato)valida si en una cadena hay solo numeros si es asi retorna true si no retorna un  int  eliminado los otros caracteres

@nameMethod: validateDate(string,string,string)
@description:validateDate("year/month/day")valida si la fecha esta en un formato valido, retorna true en caso de que sea valida
@description:validateDate("year/month/day","past")valida si la fecha ya paso, retorna true si la fecha ya paso
@description:validateDate("year/month/day","difference")retorna un int con la diferencia que hay entre la fecha actual y la ingresada
@description:validateDate("year/month/day","compare","year/month/day"9:38 p. m. 2/02/2018)retorna un int con la diferencia que hay entre la primer fecha y la segunda


@nameMethod: deleteSpaces(string)
@description:deleteSpaces($dato)valida si existen espacios en blaco en una cadena retorna true si no tiene espacios y false si tiene

*/
class DoizerController
{
	//CONTRASEÑAS
	//Validar seguridad de la contraseña
	function validateSecurityPassword($password)
	{
		if (strlen($password) < 8) {
			$error_clave = "La clave debe tener al menos 8 caracteres";
			return $error_clave;
		}
		if (strlen($password) > 25) {
			$error_clave = "La clave no puede tener más de 25 caracteres";
			return $error_clave;
		}
		if (!preg_match('`[a-z]`', $password)) {
			$error_clave = "La clave debe tener al menos una letra minúscula";
			return $error_clave;
		}
		if (!preg_match('`[A-Z]`', $password)) {
			$error_clave = "La clave debe tener al menos una letra mayúscula";
			return $error_clave;
		}
		if (!preg_match('`[0-9]`', $password)) {
			$error_clave = "La clave debe tener al menos un caracter numérico";
			return $error_clave;
		}
		$pattern = '/[\'\/~`\!\%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\\\]/';
		if (preg_match($pattern, $password)) {
			return 'la clave no debe tener caracteres especiales';
		}
		$caracteres = strlen($password);
		$i = 0;
		while ($caracteres > $i) {
			if (ctype_space($password[$i]) == true) {
				return "La clave no debe tener espacios en blaco";
			}
			$i++;
		}
		$result = array(true, $this->passwordEncrypt($password));
		return $result;
	}
	//encriptar contraseña
	function passwordEncrypt($password)
	{
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
		return $password_hash;
	}

	//ARCHIVOS
	public function ValidateImage($image, $folder)
	{
		if (isset($image['file']) && $image['file']['error'] == 0) {
			$allowed = array('JPG' => 'image/jpg', 'PNG' => 'image/png', 'jpg' => 'image/jpg', 'png' => 'image/png', 'gif' => 'image/gif', 'jpeg' => 'image/jpeg');
			$filetype = $image['file']['type'];
			$filesize = $image['file']['size'];
			$extention = pathinfo($image['file']['name']);
			$extention = "." . $extention['extension'];
			$rand = rand(10000, 999999) * rand(10000, 999999);
			$tmp_name = md5($rand . $image['file']['name']);
			$filename = $tmp_name . $extention;
			$extention = pathinfo($filename, PATHINFO_EXTENSION);
			if (!array_key_exists($extention, $allowed)) {
				return "Error: Seleccione un formato valido(jpg,png,gif) ";
			}
			$maxsize = 2 * 1024 * 1024;
			if ($filesize > $maxsize) {
				return "Error: el tamaño del archivo debe ser menor o igual a 2 mb";
			}
			if (in_array($filetype, $allowed)) {
				if (file_exists($folder . $filename)) {
					return "El archivo ya existe";
				} else {
					$result = array(true, $filename);
					move_uploaded_file($_FILES['file']['tmp_name'], $folder . $result[1]);
					return $result;
				}
			} else {
				return "Error: No se ha reconocido la imagen";
			}
		} else {
			return "Ha ocurrido un error  con la imagen ";
		}
	}

	function validateVideo($archivo, $path)
	{
		$archivo =  $_FILES["archivo1"];
		$folder = $path;
		$allowed = array('mp4' => 'video/mp4', 'mp4' => 'application/mp4');
		$filetype = $archivo['type'];
		$filesize = $archivo['size'];
		$extention = pathinfo($archivo['name']);
		$extention = "." . $extention['extension'];
		$rand = rand(10000, 999999) * rand(10000, 999999);
		$tmp_name = md5($rand . $archivo['name']);
		$filename = $tmp_name . $extention;
		$extention = pathinfo($filename, PATHINFO_EXTENSION);
		if (!array_key_exists($extention, $allowed)) {
			echo  json_encode("Error: Seleccione un formato valido(mp4) ");
			return;
		}
		$maxsize = 60000000;
		if ($filesize > $maxsize) {
			return "Error: el tamaño del archivo debe ser menor o igual a 60 MB";
			return;
		}
		if (file_exists($folder . $filename)) {
			return "El archivo ya existe";
		} else {
			$result = array(true, $filename);
			move_uploaded_file($archivo['tmp_name'], $folder . $result[1]);
			return $result;
		}
	}
	function validateNoticia($archivo, $path)
	{
		$archivo =  $_FILES["archivo1"];
		$folder = $path;
		$allowed = array('JPG' => 'image/jpg', 'PNG' => 'image/png', 'jpg' => 'image/jpg', 'png' => 'image/png', 'gif' => 'image/gif', 'jpeg' => 'image/jpeg');
		$filetype = $archivo['type'];
		$filesize = $archivo['size'];
		$extention = pathinfo($archivo['name']);
		$extention = "." . $extention['extension'];
		$rand = rand(10000, 999999) * rand(10000, 999999);
		$tmp_name = md5($rand . $archivo['name']);
		$filename = $tmp_name . $extention;
		$extention = pathinfo($filename, PATHINFO_EXTENSION);
		if (!array_key_exists($extention, $allowed)) {
			echo  json_encode("Error: Seleccione un formato valido(jpg,png) ");
			return;
		}
		$maxsize = 60000000;
		if ($filesize > $maxsize) {
			return "Error: el tamaño del archivo debe ser menor o igual a 60 MB";
			return;
		}
		if (file_exists($folder . $filename)) {
			return "El archivo ya existe";
		} else {
			$result = array(true, $filename);
			move_uploaded_file($archivo['tmp_name'], $folder . $result[1]);
			return $result;
		}
	}
	//FECHAS
	function validarFecha($Lafecha)
	{
		$valores = explode('/', $Lafecha);
		$dsd = count($valores);
		if (count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])) {
			return true;
		}
		return false;
	}

	function validateDate($date, $acction = 'no', $date2 = '0000-00-00')
	{
		$valores = explode('-', $date);
		if (count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])) {
			if ($acction == 'past') {
				$date = $valores[1] . "/" . ($valores[2]) . "/" . $valores[0];
				$current_date = new DateTime(date('Y/m/d'));
				$date_born = new DateTime($date);
				$interval = $current_date->diff($date_born);
				$interval = $interval->format('%R%a');
				$interval = intval($interval);
				return $interval;
			}
			if ($acction == 'difference') {
				$date = $valores[1] . "/" . ($valores[2]) . "/" . $valores[0];
				$current_date = new DateTime(date('Y/m/d'));
				$date_born = new DateTime($date);
				$interval = $current_date->diff($date_born);
				$interval = $interval->format('%R%a dias');
				return $interval;
			}
			if ($acction == 'compare') {
				$valores2 = explode('/', $date2);
				if (count($valores2) == 3 && checkdate($valores2[1], $valores2[2], $valores2[0])) {
					$date1 = new DateTime($date);
					$date2 = new DateTime($date2);
					$interval = $date1->diff($date2);
					$interval = $interval->format('%R%a dias');
					return $interval;
				}
			}
			return true;
		} else {
			return "fecha no valida";
		}
	}
	//RETORNAR FECHAS EN UN RANGO
	public function DateInRange($date1, $date2)
	{
		$date_begin = new DateTime($date1);
		$date_end = new DateTime($date2);
		$date_end = $date_end->modify('+1 day');
		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($date_begin, $interval, $date_end);
		foreach ($daterange as $date) {
			$result[] = $date->format("Y-m-d");;
		}
		return $result;
	}
	//NUMEROS

	public function onlyNumbers($number)
	{
		if (filter_var($number, FILTER_VALIDATE_INT)) {
			return true;
		} else {
			return false;
		}
	}

	public function onlyNumbersDelete($number)
	{
		return  filter_var($number, FILTER_SANITIZE_NUMBER_INT);
	}
	//TEXTO
	function validateSpacesBlank($txt)
	{
		$caracteres = strlen($txt);
		$i = 0;
		while ($caracteres > $i) {
			if (ctype_space($txt[$i]) == true) {
				return true;
			}
			$i++;
		}
		return false;
	}
	function specialCharater($string)
	{
		$pattern = '/[\'\/~`\!\%\^&\*\(\)\+=\{\}\[\]\|;:"\<\>,\\\]/';
		if (preg_match($pattern, $string)) {
			return false;
		} else {
			return true;
		}
	}
	function deleteSpaces($string)
	{
		$caracteres = strlen($string);
		$i = 0;
		while ($caracteres > $i) {
			if (ctype_space($string[$i]) == true) {
				return false;
			} else {
				$result = true;
			}
			$i++;
		}
		return $result;
	}

	function validateEmail($mail)
	{
		if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)) {
			return true;
		} else {
			return false;
		}
	}
	function validarEmailNew($email)
	{

		// Remove all illegal characters from email
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);

		// Validate e-mail
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			return true;
			// echo("$email is a valid email address");
		} else {
			return false;

			// echo("$email is not a valid email address");
		}
	}
	//ERRORES EN CONSULTAS
	function knowError($code)
	{
		switch ($code) {
			case '1146':
				return 'La tabla no existe en la base de datos';
				break;
			case '1136':
				return 'La cantidad de datos enviados no coinciden';
				break;
			case '1062':
				return 'El dato ya esta resgistrado en el sistema';
				break;
			case '1451':
				return 'No se puede eliminar debido a que esta relacionado con otros registros';
				break;
			case '1054':
				return 'El nombre de la columan no existe en la tabla';
				break;
			case '1452':
				return 'No se puede modificar debido a que  existen otros registros relacionados con este';
				break;
			case 'HY093':
				return 'los parametos a modificar no coinciden';
				break;
			case '1062':
				return 'El dato ya existe resgistrado en el sistema';
				break;
			default:
				'ocurrio un error';
				break;
		}
	}
	function randAlphanum($length)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomAlpha = '';
		for ($i = 0; $i < $length; $i++) {
			$randomAlpha .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomAlpha;
	}
	function ContarCampos($campo, $cantidad)
	{
		if (count($campo) > $cantidad) {
			return false;
		} else {
			return true;
		}
	}
}
