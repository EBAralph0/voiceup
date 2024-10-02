<?php

namespace App\Http\Controllers;
use App\Models\Questionnaire;
use App\Models\Response;
use App\Models\Question;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function show($id)
    {
        // Charger le questionnaire avec les questions, choix et réponses associées
        $questionnaire = Questionnaire::with(['questions.choix.responses', 'questions.responses'])->findOrFail($id);
        $data = [];
        $frequencyData = [];

        foreach ($questionnaire->questions as $question) {
            $questionData = [];
            $responsesCount = 0; // Compteur global des réponses

            // Gestion des questions de type "onechoice" ou "multiplechoice"
            if ($question->type === 'onechoice' || $question->type === 'multiplechoice') {
                foreach ($question->choix as $choix) {
                    $count = $choix->responses->count();
                    $responsesCount += $count;

                    $questionData[] = [
                        'choix' => $choix->text,
                        'count' => $count,
                    ];

                    // Collecte des données de fréquence pour l'histogramme
                    foreach ($choix->responses as $response) {
                        $date = Carbon::parse($response->created_at)->format('Y-m-d');
                        if (!isset($frequencyData[$date])) {
                            $frequencyData[$date] = 0;
                        }
                        $frequencyData[$date]++;
                    }
                }
            } elseif ($question->type === 'textanswer') {
                // Récupérer les réponses textuelles
                $textResponses = $question->responses->whereNotNull('text_answer')->pluck('text_answer');
                $responsesCount = $textResponses->count();

                // Ajouter les réponses textuelles pour affichage dans une table
                $questionData = [
                    'responses' => $textResponses->toArray(),
                ];
            }

            // Stocker les données de la question avec son type
            $data[] = [
                'id' => $question->id,
                'question' => $question->text,
                'type' => $question->type, // Ajouter le type pour le traitement conditionnel dans la vue
                'data' => $questionData, // Ajouter les données, y compris les réponses textuelles
                'responses_count' => $responsesCount,
            ];
        }

        ksort($frequencyData);


        return view('dashboards.questionnaire', compact('questionnaire', 'data', 'frequencyData'));
    }
}




