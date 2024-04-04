<?php
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, x-requested-with, Authorization');

require_once 'fpdf186/fpdf.php';

class PDF extends FPDF
{
    // Page header
    public function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 10, 'Title', 1, 0, 'C');
        // Line break
        $this->Ln(20);
    }

    // Page footer
    public function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

class Authorization
{
    /**
     * Get header Authorization
     **/
    public function getAuthorizationHeader(){
        $headers = getallheaders();

        if (isset($headers['Authorization'])) {
            return trim($headers["Authorization"]);
        } else {
           return null;
        }
    }

    /**
     * Get access token from header
     **/
    public function getBearerToken() {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers) && preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
        return null;
    }
}

$authorizator = new Authorization();

if ($authorizator->getBearerToken() === '76338a298457ff6a6b5cd46718f607c5') { // login:'testowy', password: 'test123!'
    if (!file_exists('funnyqrcode.pdf')) {
        $val = $_GET['code'] ?? '';
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times','',12);
        $pdf->Image('api.qrserver.png', null, null, 50, 50);
        $pdf->Cell(0, 10, $val, 0, 1);
        $pdf->Output('F', 'funnyqrcode.pdf');
    }

    echo json_encode([
        'message' => ['level' => 'success', 'text' => 'File returned succesfully.'],
        'pdf' => 'http://localhost:8090/funnyqrcode.pdf'
    ]);
} else {
    echo json_encode([
        'message' => ['level' => 'failed', 'text' => 'You do not have permission for this file.'],
        'pdf' => ''
    ]);
}
