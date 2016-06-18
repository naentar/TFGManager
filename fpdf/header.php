<?php
		   class PDF extends FPDF {
			// Cabecera de p�gina
			function Header()
			{
				// Logo
				$this->Image('logo.png',10,8);
				// Salto de l�nea
				$this->Ln(20);
			}

			// Pie de p�gina
			function Footer()
			{
				// Posici�n: a 1,5 cm del final
				$this->SetY(-15);
				// Arial italic 8
				$this->SetFont('Arial','I',8);
				// N�mero de p�gina
				$this->Cell(0,10,$this->PageNo().'/{nb}',0,0,'C');
			}
			}
?>