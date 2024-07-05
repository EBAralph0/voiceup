<?php

namespace App\Http\Controllers;
use App\Models\Questionnaire;
use App\Models\Response;
use App\Models\Question;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function show($id)
    {
        $questionnaire = Questionnaire::with('questions.choix.responses')->findOrFail($id);
        $data = [];
        $frequencyData = [];

        foreach ($questionnaire->questions as $question) {
            $questionData = [];
            foreach ($question->choix as $choix) {
                $questionData[] = [
                    'choix' => $choix->text,
                    'count' => $choix->responses->count(),
                ];

                // Collect frequency data for histogram
                foreach ($choix->responses as $response) {
                    $date = Carbon::parse($response->created_at)->format('Y-m-d');
                    if (!isset($frequencyData[$date])) {
                        $frequencyData[$date] = 0;
                    }
                    $frequencyData[$date]++;
                }
            }
            $data[] = [
                'question' => $question->text,
                'data' => $questionData,
            ];
        }

        ksort($frequencyData);
        return view('dashboards.questionnaire', compact('questionnaire', 'data', 'frequencyData'));
    }
}
