<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class QRCodeController extends BaseController
{
    private $uploadPath = WRITEPATH . 'uploads/qrcode/';

    public function __construct()
    {
        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }
    }

    // ✅ Generate QR Code untuk Job tertentu
    public function job($id_job)
    {
        $url = base_url("https://example.com/job/123" . $id_job);
        $filePath = $this->uploadPath . "job_" . $id_job . ".png";

        if (file_exists($filePath)) {
            return $this->response->download($filePath, null);
        }

        $result = Builder::builder()         // Versi 6.x menggunakan builder()
            ->writer(new PngWriter())
            ->data($url)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->build();

        $result->saveToFile($filePath);

        return $this->response->download($filePath, null);
    }

    // ✅ Generate QR Code untuk halaman utama ERP
    public function xmlkarir()
    {
        $url = base_url();
        $filePath = $this->uploadPath . "xmlkarir.png";

        if (file_exists($filePath)) {
            return $this->response->download($filePath, null);
        }

        $result = Builder::builder()
            ->writer(new PngWriter())
            ->data($url)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->build();

        $result->saveToFile($filePath);

        return $this->response->download($filePath, null);
    }
}
