<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use App\Models\MedicalCard;
use App\Models\Parents;
use App\Models\User;
use App\Models\Parental_Link;
use Dompdf\Dompdf;
use Dompdf\Options;

class PDFController extends Controller
{
    public function generatePDF(Request $request)
{
    $data = MedicalCard::find($request->national_number);
    if ($data) {
        $parentalLink = Parental_Link::where('national_number', $request->national_number)->first();
        if ($parentalLink) {
            $parent1Details = User::where('email', $parentalLink->parent_1)->first();
            $parent2Details = User::where('email', $parentalLink->parent_2)->first();
        } else {
            $parent1Details = $parent2Details = null;
        }

        // Chemin vers l'image
        $imagePath = public_path('/images/scout.png');
        $imagePath2 = public_path('/images/pbtpdf.png');

        // Styles CSS pour les images de fond
        $style = '
        <style>
            .background-top {
                background-image: url(' . $imagePath . ');
                background-size: 100px;
                background-position: top left;
                background-repeat: no-repeat;
                width: 100px;
                height: 100px; 
                background-color: #white; /

                
            }
            .background-bottom {
                background-image: url(' . $imagePath2 . ');
                background-size: 100px;
                background-position: center bottom;
                background-repeat: no-repeat;
                width: 100%;
                height: 100px;
                display: flex;
                justify-content: center;
            }
            
        </style>';

        // Génération du contenu HTML
        $html2 = view('animateur/pdf', compact('data', 'parent1Details', 'parent2Details'))->render();
        $html = '<html>
        <head>' . $style . '</head>
        <body>
            <div class="background-top"></div>' . $html2 . '
            <div class="background-bottom"></div>
        </body>
        </html>';

        // Configuration de Dompdf
        $pdf = PDF::loadHtml($html);
        $pdf->setPaper('A4', 'portrait');

        // Rendu du PDF
        $pdf->render();
        
        // Téléchargement du PDF
        $filename = $data->first_name . '_' . $data->last_name . '.pdf';
        return $pdf->download($filename);
    } else {
        return redirect()->route('records')->with('error', 'Aucune donnée trouvée pour préremplir le formulaire.');
    }
}

}
