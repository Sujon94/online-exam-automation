<?php


namespace App\Helpers;


use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Mpdf\HTMLParserMode;
use Mpdf\MpdfException;

class Mpdf extends \Mpdf\Mpdf
{
    /**
     * @throws MpdfException
     */
    public function __construct(array $config = ['format' => 'A4-L', 'orientation' => 'L'], $container = null)
    {
        parent::__construct($config, $container);
    }

    public function storeReport($base64File, $mimeType, $fileName, $viewPath, $data)
    {
        $time = Carbon::now();
        $footer = "<div style='text-align: right;'>Printed at: " . $time->toDateTimeString() . "<span></span></div>";

        try {
            ob_end_flush();
            $this->useSubstitutions = false;
            $this->simpleTables = true;
            $this->curlAllowUnsafeSslRequests = true;
            $this->showImageErrors = true;
            $this->SetDefaultBodyCSS('background-image', "url(data:" . $mimeType . ";base64, " . $base64File . ")");
            $this->SetDefaultBodyCSS('background-image-resize', 6);
            $html = View::make($viewPath)->with(compact('data'))->render();
            $this->WriteHTML($html);
            //$this->Output($fileName, 'F');
            Storage::disk('public')->put($fileName, $this->Output('', 'S'));
            return ['success' => true, 'filename' => 'cert_preview.pdf'];
        } catch (MpdfException $e) {
            dd($e->getMessage());
        }
    }

    public function generateReport($base64File, $mimeType, $fileName, $viewPath, $data)
    {
        $time = Carbon::now();
        $footer = "<div style='text-align: right;'>Printed at: " . $time->toDateTimeString() . "<span></span></div>";

        try {
            //$data->cert_image = public_path("/backend/assets/images/cert/cert.jpg");
            ob_end_flush();
            //$mpdf = new mPDF();
            $this->useSubstitutions = false;
            $this->simpleTables = true;
            $this->curlAllowUnsafeSslRequests = true;
            $this->showImageErrors = true;
            //$mpdf->Image($imagePath, 500, 500, 210, 297, 'jpeg', '', true, false);
            //$this->AddPage('L');
            /*$this->SetHTMLFooter('
<table width="100%" style="font-size: 12px;">
    <tr>
        <td width="33%">Printed at:{DATE j M Y h:i:s A}</td>
        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
        <td width="33%" style="text-align: right;">Developed By: .</td>
    </tr>
</table>');*/
            $this->SetDefaultBodyCSS('background-image', "url(data:" . $mimeType . ";base64, " . $base64File . ")");
            $this->SetDefaultBodyCSS('background-image-resize', 6);
            //$this->WriteHTML(public_path('/backend/assets/css/bootstrap.min.css'),HTMLParserMode::HEADER_CSS);
            $html = View::make($viewPath)->with(compact('data'))->render();
            $this->WriteHTML($html);

            $this->Output($fileName, 'I');
        } catch (MpdfException $e) {
            dd($e->getMessage());
        }
    }
}
