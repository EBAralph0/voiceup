<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Illuminate\Http\Request;
use App\Models\Response;
use App\Models\Suggestion;
use App\Models\Entreprise;
use App\Models\Question;
use App\Mail\ThankYouForResponse;
use Illuminate\Support\Facades\Mail;

class ResponseController extends Controller
{
    //
    public function submit(Request $request, $id, $entrepriseId)
    {
        $request->validate([
            'responses.*' => 'required',
            'suggestion' => 'nullable|string|max:1000'
        ]);

        $questionnaire = Questionnaire::findOrFail($id);

        foreach ($request->responses as $question_id => $response) {
            $question = Question::findOrFail($question_id);

            if ($question->type === 'onechoice') {
                Response::create([
                    'questionnaire_id' => $id,
                    'question_id' => $question_id,
                    'choix_id' => $response,
                    'user_id' => auth()->id(),
                ]);
            } elseif ($question->type === 'multiplechoice') {
                foreach ($response as $choix_id) {
                    Response::create([
                        'questionnaire_id' => $id,
                        'question_id' => $question_id,
                        'choix_id' => $choix_id,
                        'user_id' => auth()->id(),
                    ]);
                }
            } elseif ($question->type === 'textanswer') {
                Response::create([
                    'questionnaire_id' => $id,
                    'question_id' => $question_id,
                    'text_answer' => $response,
                    'user_id' => auth()->id(),
                ]);
            }elseif ($question->type === 'numericrange') {
                $numericAnswer = max(0, min($response, $question->max_value)); // Ajustement dans les limites
                Response::create([
                    'questionnaire_id' => $id,
                    'question_id' => $question_id,
                    'numeric_answer' => $numericAnswer,
                    'user_id' => auth()->id(),
                ]);
            }
        }

        if ($request->filled('suggestion')) {
            Suggestion::create([
                'id_user' => auth()->id(),
                'id_questionnaire' => $id,
                'text' => $request->suggestion,
            ]);
        }

        // Obtenir l'entreprise via l'ID passé en paramètre
        $entreprise = Entreprise::findOrFail($entrepriseId);

        // Envoi de l'e-mail de remerciement
        Mail::to("edracresurek@gmail.com")->send(new ThankYouForResponse(auth()->user(), $questionnaire));

        // Redirection vers la page des questionnaires de l'entreprise
        return redirect()->route('entreprises.list_questionnaire', ['id' => $entreprise->id_entreprise])
            ->with('success', 'Responses and suggestion submitted successfully.');
    }

}
