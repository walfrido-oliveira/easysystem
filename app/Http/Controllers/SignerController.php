<?php

namespace App\Http\Controllers;

use Storage;
//use Elibyy\TCPDF\Facades\TCPDF;
use setasign\Fpdi;
use App\Budget\Budget;
use App\Role\UserRole;
use App\User\UserHasClient;
use App\Budget\BudgetFiles;
use Illuminate\Http\Request;
use App\User;

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

        $budget = $budgetFile->budget;

        $users = UserHasClient::where('client_id', $budget->client_id)->get();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $pdf_path = $storagePath . $budgetFile->url;

        $certificate = 'file://' . realpath(config('app.certificate.CRT'));
        $private_key = 'file://' . realpath(config('app.certificate.KEY'));
        $image_signature = realpath(config('app.certificate.IMAGE'));

        //$pdf = new TCPDF();

        $pdf = new \setasign\Fpdi\TcpdfFpdi();

        $pages = $pdf->setSourceFile($pdf_path);
        for ($i=0; $i < $pages; $i++) {
            $pdf->AddPage();
            $page = $pdf->ImportPage( $i+1 );
            $pdf->useTemplate( $page, 0, 0 );
        }

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

        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // *** set signature appearance ***

        // create content for signature (image and/or text)
        $pdf->Image($image_signature, 180, 261.5, 15, 15, 'PNG');

        // define active area for signature appearance
        $pdf->setSignatureAppearance(180, 261.5, 15, 15);
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        $pdf->Output($pdf_path, 'F');

        $budgetFile->signed = true;
        $budgetFile->save();

        User::sendSignedFileEmails($users, $budget, $budgetFile->name);

        return response()->file($pdf_path);
    }

}
