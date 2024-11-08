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
        $questionnaire = Questionnaire::with(['questions.choix.responses', 'questions.responses'])->findOrFail($id);
        $data = [];
        $frequencyData = [];
        $overallFrequencyData = [];

        foreach ($questionnaire->questions as $question) {
            $questionData = [];
            $responsesCount = 0;
            $questionFrequency = [];
            $dates = [];

            // Normaliser les dates pour chaque choix
            foreach ($question->choix as $choix) {
                foreach ($choix->responses as $response) {
                    $date = Carbon::parse($response->created_at)->format('Y-m-d');
                    $dates[$date] = 0;
                }
            }

            if ($question->type === 'onechoice' || $question->type === 'multiplechoice') {
                foreach ($question->choix as $choix) {
                    $count = $choix->responses->count();
                    $responsesCount += $count;

                    $questionData[] = [
                        'choix' => $choix->text,
                        'count' => $count,
                    ];

                    $choixFrequency = $dates;
                    foreach ($choix->responses as $response) {
                        $date = Carbon::parse($response->created_at)->format('Y-m-d');
                        $choixFrequency[$date]++;
                    }
                    $questionFrequency[$choix->text] = $choixFrequency;

                    foreach ($choixFrequency as $date => $count) {
                        if (!isset($overallFrequencyData[$date])) {
                            $overallFrequencyData[$date] = 0;
                        }
                        $overallFrequencyData[$date] += $count;
                    }
                }
            } elseif ($question->type === 'textanswer') {
                $textResponses = $question->responses->whereNotNull('text_answer')->pluck('text_answer');
                $responsesCount = $textResponses->count();
                $questionData = [
                    'responses' => $textResponses->toArray(),
                ];
            } elseif ($question->type === 'numericrange') {
                $numericResponses = $question->responses->whereNotNull('numeric_answer')->pluck('numeric_answer');
                $responsesCount = $numericResponses->count();
                $questionData = [
                    'responses' => $numericResponses->toArray(),
                ];
            }

            ksort($questionFrequency);
            $frequencyData[$question->id] = $questionFrequency;

            $data[] = [
                'id' => $question->id,
                'question' => $question->text,
                'type' => $question->type,
                'data' => $questionData,
                'responses_count' => $responsesCount,
            ];
        }

        ksort($overallFrequencyData);

        return view('dashboards.questionnaire', compact('questionnaire', 'data', 'frequencyData', 'overallFrequencyData'));
    }


}




