<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF;

class SignerController extends Controller
{


    /**
     * Siger a PDF file
     *
     * @param  $pdf_path
     */
    public function signer(Request $request)
    {
        //dd($request->pdf_path);

        $pdf_path = $request->pdf_path;

        $certificate = 'file://'. realpath('../storage/cert/certificate.crt');
        $private_key = 'file://'. realpath('../storage/cert/out.key');
        $image_signature = realpath('../storage/cert/signature.png');
        //$pdf_path = realpath('../storage/files/teste.pdf');


        $pdf = new TCPDF();

        // set additional information
        $info = array(
        'Name' => 'Name of PDF',
        'Location' => '',
        'Reason' => 'Proof of author',
        'ContactInfo' => 'info@example.co.za',
        );

        // set document signature
        $pdf::setSignature($certificate, $private_key, '', '', 2, $info);

        // set font
        $pdf::SetFont('helvetica', '', 12);

        //set margin
        $pdf::SetMargins(0,0,0,false);
        $pdf::setCellPaddings(0,0,0,0);
        $pdf::setFooterMargin(0);

        // add a page
        $pdf::AddPage();

        // print a line of text
        $text = '<p>Teste de assinatura de certificado</p>';
        $pdf::writeHTML($text, true, 0, true, 0);

        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // *** set signature appearance ***

        // create content for signature (image and/or text)
        $pdf::Image($image_signature, 180, 261.5, 15, 15, 'PNG');

        // define active area for signature appearance
        $pdf::setSignatureAppearance(180, 261.5, 15, 15);
        //dd($pdf::getMargins())  ;
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // *** set an empty signature appearance ***
        //$pdf::addEmptySignatureAppearance(180, 80, 15, 15);

        // ---------------------------------------------------------

        //Close and output PDF document
        //$pdf->Output('example_052.pdf', 'D');

        $pdf::Output($pdf_path, 'D');

        //return response()->stream($pdf::Output());
    }

}
