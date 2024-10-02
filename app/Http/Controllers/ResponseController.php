<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Illuminate\Http\Request;
use App\Models\Response;
use App\Models\Suggestion;
use App\Models\Question;
use App\Mail\ThankYouForResponse;
use Illuminate\Support\Facades\Mail;

class ResponseController extends Controller
{
    //
    public function submit(Request $request, $id)
    {
        $request->validate([
            'responses.*' => 'required',
            'suggestion' => 'nullable|string|max:1000'
        ]);

        $questionnaire = Questionnaire::find($id);

        foreach ($request->responses as $question_id => $response) {
            $question = Question::find($question_id);

            if ($question->type === 'onechoice') {
                Response::create([
                    'questionnaire_id' => $id,
                    'question_id' => $question_id,
                    'choix_id' => $response, // Ici le choix_id ne sera pas nul
                    'user_id' => auth()->id(),
                ]);
            } elseif ($question->type === 'multiplechoice') {
                foreach ($response as $choix_id) {
                    Response::create([
                        'questionnaire_id' => $id,
                        'question_id' => $question_id,
                        'choix_id' => $choix_id, // Ici aussi choix_id n'est pas nul
                        'user_id' => auth()->id(),
                    ]);
                }
            } elseif ($question->type === 'textanswer') {
                Response::create([
                    'questionnaire_id' => $id,
                    'question_id' => $question_id,
                    'text_answer' => $response, // Réponse textuelle sans choix_id
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

        $entreprise = $questionnaire->entreprise;

        Mail::to("edracresurek@gmail.com")->send(new ThankYouForResponse(auth()->user(), $questionnaire));

        return redirect()->route('entreprises.list_questionnaire', ['id' => $entreprise->id_entreprise])
            ->with('success', 'Responses and suggestion submitted successfully.');
    }


}
