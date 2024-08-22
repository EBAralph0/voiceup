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
    //
    public function generatePDF(Request $request, $id)
    {
        try {
            $questionnaire = Questionnaire::findOrFail($id);
            // $charts est un tableau contenant les images base64
            $charts = $request->input('charts');
            $data = $this->getQuestionnaireData($id);

            // Ajouter les images de graphiques dans $data
            foreach ($data as $index => $questionData) {
                $data[$index]['bar_chart'] = $charts[$index * 3] ?? null; // bar_chart image
                $data[$index]['doughnut_chart'] = $charts[$index * 3 + 1] ?? null; // doughnut_chart image
                $data[$index]['pie_chart'] = $charts[$index * 3 + 2] ?? null; // pie_chart image
            }

            $pdf = PDF::loadView('pdf_template', [
                'questionnaire' => $questionnaire,
                'data' => $data,
            ]);

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
