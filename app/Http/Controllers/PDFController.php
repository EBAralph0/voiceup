<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questionnaire;
// use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use PDF;

class PDFController extends Controller
{
    public function generatePDF(Request $request, $id)
    {
        try {
            $questionnaire = Questionnaire::findOrFail($id);

            // Vérifier que 'charts' contient bien des images
            $charts = $request->input('charts', []);
            if (empty($charts)) {
                return response()->json(['error' => 'No chart images provided'], 400);
            }

            $data = $this->getQuestionnaireData($id);

            // Ajouter les images base64 des graphiques aux questions
            foreach ($data as $index => &$questionData) {
                $questionData['bar_chart'] = $charts[$index * 3] ?? null;
                $questionData['doughnut_chart'] = $charts[$index * 3 + 1] ?? null;
                $questionData['pie_chart'] = $charts[$index * 3 + 2] ?? null;
            }

            $pdf = PDF::loadView('pdf_template', [
                'questionnaire' => $questionnaire,
                'data' => $data,
            ])->setPaper('a4', 'portrait');

            return $pdf->download('questionnaire_report.pdf');

        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate PDF'], 500);
        }
    }

    protected function getQuestionnaireData($id)
    {
        $questionnaire = Questionnaire::with('questions.choix')->findOrFail($id);
        $data = [];

        foreach ($questionnaire->questions as $question) {
            $questionData = [
                'id' => $question->id,
                'question' => $question->text,
                'data' => [],
            ];

            foreach ($question->choix as $choix) {
                $questionData['data'][] = [
                    'choix' => $choix->intitule,
                    'count' => $choix->responses()->count(),
                ];
            }
            $data[] = $questionData;
        }
        return $data;
    }
}

