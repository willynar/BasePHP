<?php
class ViewsController
{
	private $master;
	private $doizer;
	function __CONSTRUCT()
	{
		$this->master =  MasterModel();
		$this->doizer = new DoizerController;
	}
	function main()
	{
		require_once "views/modules/index.php";
	}
	function users()
	{
		$direccion = $this->master->api("objetoUsuarios");
		$json = file_get_contents($direccion);
		$arrayDatos = json_decode($json, true);

		if (isset($_SESSION['USER']['ROL']) && $_SESSION['USER']['ROL'] == 1) {
			$dataUsers = $this->master->procedure->PRByAll("sp_consultar_usuarios", array(1, 0));
			// $dataGroups = $this->master->procedure->PRByAll("sp_consultar_grupos", array(1, 0, 0));
			require_once "views/include/scope.header.php";
			require_once "views/modules/admin/user/user.php";
			require_once "views/include/scope.footer.php";
		} else {
			session_destroy();
			header("Location: inicio");
		}
	}
	function profileAdmin()
	{
		// if (isset($_SESSION['USER']['ROL']) && $_SESSION['USER']['ROL'] == 1) {
		if (isset($_SESSION['USER']['ROL'])) {
			$data = $this->master->procedure->PRByAll("sp_consultar_usuarios", array(2, $_SESSION['USER']['ID']));
			$_SESSION['USER_UPDATE'] = $_SESSION['USER']['ID'];
			require_once "views/include/scope.header.php";
			require_once "views/modules/admin/profile.php";
			require_once "views/include/scope.footer.php";
		} else {
			session_destroy();
			header("Location: inicio");
		}
		// }
	}
	function viewUpdateUser()
	{
		if (isset($_SESSION['USER']['ROL']) && $_SESSION['USER']['ROL'] == 1) {
			$data = $this->master->procedure->PRByAll("sp_consultar_usuarios", array(2, $_GET['data']));
			$_SESSION['USER_UPDATE'] = $_GET['data'];
			require_once "views/include/scope.header.php";
			require_once "views/modules/admin/user/update.php";
			require_once "views/include/scope.footer.php";
		} else {
			session_destroy();
			header("Location: inicio");
		}
	}
}
