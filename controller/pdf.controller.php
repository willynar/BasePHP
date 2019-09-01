<?php
require_once "controller/doizer.controller.php";
require_once 'views/assets/lib/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

class PdfController
{
	private $master;
	private $doizer;
	private $dompdf;
	function __CONSTRUCT()
	{
		$this->master = new MasterModel;
		$this->doizer = new DoizerController;
		$this->dompdf = new Dompdf();
	}
	function main()
	{
		$tipoOperacion = $_SESSION['tipoOperacion'];
		$onrientacion = $_SESSION['orientacion'];
		if ($tipoOperacion == 'session') {		
			$datos = $_SESSION['html'];
		} 
		if($tipoOperacion == 'obget') {
			$quitarString = (int)$_SESSION['quitarString'];

			switch ($_SESSION['direccion']) {
				case 'general':
					$direccion = 'admin/projects/deatailReport.php';
					break;
				case 'proyecto':
					$direccion = 'admin/projects/formatoReporte.php';
					break;

				default:
					# code...
					break;
			}

			///para no usar session
			ob_start();
			require_once  'views/modules/'.$direccion.'';
			$html = ob_get_clean();

			if ($quitarString == 0) {
				$datos =  $html;
			} else {
				$datos = substr($html, $quitarString);
			}
		}


		//contenido del pdf
		$content = '<html>';
		$content .= '<head>';
		$content .= '<link type="text/css" rel="stylesheet" href="views/assets/css/pdf.css"/>';
		// $content .= ''.$_SESSION['script'].'';
		$content .= '</head><body>';
		$content .= '<div class="container">' . $datos . '</div>';


		$content .= '</body></html>';
		//crear el pdf		
		$this->dompdf->loadHtml($content);
		$this->dompdf->setPaper('A4', $onrientacion); // (Opcional) Configurar papel y orientación (landscape)=horizontal/(portrait)vertical
		$this->dompdf->render(); // Generar el PDF desde contenido HTML
		$this->dompdf->output(); // Obtener el PDF generado
		$this->dompdf->stream("Reporte-"); // Enviar el PDF generado al navegador

	}
}
