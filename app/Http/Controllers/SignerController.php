<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Elibyy\TCPDF\Facades\TCPDF;
use App\Budget\BudgetFiles;
use \setasign\Fpdi;
use Storage;
use \App\Role\UserRole;

class SignerController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check_user_role:' . UserRole::ROLE_ADMIN);
    }

    /**
     * Siger a PDF file
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function signer(Request $request)
    {
        $user = auth()->user();

        $budgetFile = BudgetFiles::Find($request->id);

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $pdf_path = $storagePath . $budgetFile->url;

        $certificate = 'file://'. realpath('../storage/cert/certificate.crt');
        $private_key = 'file://'. realpath('../storage/cert/out.key');
        $image_signature = realpath('../storage/cert/signature.png');

        //$pdf = new TCPDF();

        $pdf = new \setasign\Fpdi\TcpdfFpdi();

        $pages = $pdf->setSourceFile($pdf_path);
        for ($i=0; $i < $pages; $i++) {
            $pdf->AddPage();
            $page = $pdf->ImportPage( $i+1 );
            $pdf->useTemplate( $page, 0, 0 );
        }

        //$pdf2->AddPage();
        //$pages = $pdf2->setSourceFile( $pdf_path );
        //$page = $pdf2->ImportPage( 1 );
        //$pdf2->useTemplate( $page, 0, 0 );
        //$pdf2->Output();
        //return;

        // set additional information
        $info = array(
        'Name' => $user->name,
        'Location' => '',
        'Reason' => 'Assinatura de certificado',
        'ContactInfo' => $user->email,
        );

        // set document signature
        $pdf->setSignature($certificate, $private_key, '', '', 2, $info);

        // set font
        $pdf->SetFont('helvetica', '', 12);

        //set margin
        $pdf->SetMargins(0,0,0,false);
        $pdf->setCellPaddings(0,0,0,0);
        $pdf->setFooterMargin(0);

        // add a page
        //$pdf->AddPage();

        //$pdf->useTemplate( $page, 0, 0 );

        // print a line of text
        //$text = '<p>Teste de assinatura de certificado</p>';
        //$pdf->writeHTML($text, true, 0, true, 0);

        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // *** set signature appearance ***

        // create content for signature (image and/or text)
        $pdf->Image($image_signature, 180, 261.5, 15, 15, 'PNG');

        // define active area for signature appearance
        $pdf->setSignatureAppearance(180, 261.5, 15, 15);
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // *** set an empty signature appearance ***
        //$pdf::addEmptySignatureAppearance(180, 80, 15, 15);

        // ---------------------------------------------------------

        //Close and output PDF document
        //$pdf->Output('example_052.pdf', 'D');

        $pdf->Output($pdf_path, 'F');

        return response()->file($pdf_path);
    }

}
