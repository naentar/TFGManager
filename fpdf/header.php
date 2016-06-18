<?php
		   class PDF extends FPDF {
			// Cabecera de página
			function Header()
			{
				// Logo
				$this->Image('logo.png',10,8);
				// Salto de línea
				$this->Ln(20);
			}

			// Pie de página
			function Footer()
			{
				// Posición: a 1,5 cm del final
				$this->SetY(-15);
				// Arial italic 8
				$this->SetFont('Arial','I',8);
				// Número de página
				$this->Cell(0,10,$this->PageNo().'/{nb}',0,0,'C');
			}
			}
?>