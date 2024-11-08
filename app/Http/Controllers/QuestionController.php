<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entreprise;
use App\Models\Questionnaire;
use App\Models\Question;
use App\Models\Choix;
use Illuminate\Support\Facades\Auth;


class QuestionController extends Controller
{
    //
    public function create($questionnaire_id)
    {
        $questionnaire = Questionnaire::findOrFail($questionnaire_id);
        return view('questions.create', compact('questionnaire'));
    }

    public function store(Request $request, $questionnaire_id)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'type' => 'required|in:onechoice,multiplechoice,textanswer,numericrange', // Validation du type
            'max_value' => 'nullable|integer|min:1', // Validation de max_value
        ]);

        $question = new Question();
        $question->text = $request->text;
        $question->type = $request->type; // Stockage du type de question
        $question->questionnaire_id = $questionnaire_id;

        if ($request->type === 'numericrange') {
            $question->max_value = $request->max_value;
        }

        $question->save();

        return redirect()->route('questionnaires.detail', $questionnaire_id)->with('success', 'Question added successfully.');
    }

    public function storeg(Request $request, $questionnaire_id)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'type' => 'required|in:onechoice,multiplechoice,textanswer,numericrange',
            'max_value' => 'required_if:type,numericrange|integer|min:1', // Max seulement pour le type numérique
        ]);

        $question = new Question();
        $question->text = $request->text;
        $question->type = $request->type;
        $question->questionnaire_id = $questionnaire_id;
        $question->is_general = true;

        // Enregistrer la limite maximale pour les questions numériques
        if ($request->type === 'numericrange') {
            $question->max_value = $request->max_value;
        }

        $question->save();

        return redirect()->route('secteurs.detail', $questionnaire_id)->with('success', 'General question added successfully.');
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);
        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'type' => 'required|in:onechoice,multiplechoice,textanswer,numericrange', // Validation du type
        ]);

        $question = Question::findOrFail($id);
        $question->text = $request->text;
        $question->type = $request->type; // Mise à jour du type de question
        $question->save();

        return redirect()->route('questionnaires.detail', $question->questionnaire_id)->with('success', 'Question updated successfully.');
    }

    public function updateg(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'type' => 'required|in:onechoice,multiplechoice,textanswer,numericrange', // Validation du type
        ]);

        $question = Question::findOrFail($id);
        $question->text = $request->text;
        $question->type = $request->type; // Mise à jour du type de question
        $question->save();

        return redirect()->route('secteurs.detail', $question->questionnaire_id)->with('success', 'General question updated successfully.');
    }

    public function createChoix($question_id)
    {
        $question = Question::findOrFail($question_id);
        return view('choix.create', compact('question'));
    }

    public function storeChoix(Request $request, $question_id)
    {
        $request->validate([
            'text' => 'required|string|max:255',
        ]);

        $choix = new Choix();
        $choix->text = $request->text;
        $choix->question_id = $question_id;
        $choix->save();

        $question = Question::findOrFail($question_id);
        $questionnaire_id = $question->questionnaire_id;

        return redirect()->route('questionnaires.detail', $questionnaire_id)->with('success', 'Choice added successfully.');
    }

    public function storeChoixg(Request $request, $question_id)
    {
        $request->validate([
            'text' => 'required|string|max:255',
        ]);

        $choix = new Choix();
        $choix->text = $request->text;
        $choix->question_id = $question_id;
        $choix->save();

        $question = Question::findOrFail($question_id);
        $questionnaire_id = $question->questionnaire_id;

        return redirect()->route('secteurs.detail', $questionnaire_id)->with('success', 'Choice added successfully.');
    }

}
