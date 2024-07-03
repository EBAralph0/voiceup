<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Response;

class ResponseController extends Controller
{
    //
    public function submit(Request $request, $id)
    {
        $request->validate([
            'responses.*' => 'required'
        ]);

        foreach ($request->responses as $question_id => $choix_id) {
            Response::create([
                'questionnaire_id' => $id,
                'question_id' => $question_id,
                'choix_id' => $choix_id,
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('/')->with('success', 'Responses submitted successfully.');
    }
}
