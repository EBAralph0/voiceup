<?php

namespace App\Http\Controllers;
use App\Models\Entreprise;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\QuestionnaireExport;
use Maatwebsite\Excel\Facades\Excel;


class QuestionnaireController extends Controller
{
    //
    public function create($entreprise_id)
    {
        $entreprise = Entreprise::findOrFail($id);
        return view('questionnaires.create', compact('entreprise_id','entreprise'));
    }

    public function store(Request $request, $entreprise_id)
    {
        $request->validate([
            'intitule' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $questionnaire = new Questionnaire();
        $questionnaire->intitule = $request->intitule;
        $questionnaire->description = $request->description;
        $questionnaire->created_by = Auth::id();
        $questionnaire->entreprise_id = $entreprise_id;
        $questionnaire->save();

        return redirect()->route('entreprises.detail', $entreprise_id)->with('success', 'Questionnaire créé avec succès.');
    }

    public function detail($id)
    {
        $questionnaire = Questionnaire::with(['questions.choix'])->findOrFail($id);
        return view('questionnaires.detail', compact('questionnaire'));
    }

    public function showQuestions($id)
    {
        $questionnaire = Questionnaire::with('questions.choix')->findOrFail($id);
        return view('questionnaires.questions', compact('questionnaire'));
    }

    public function exportExcel($id)
    {
        $questionnaire = Questionnaire::findOrFail($id);
        $fileName = $questionnaire->intitule . '.xlsx'; // Nom dynamique basé sur le titre du questionnaire
        return Excel::download(new QuestionnaireExport($questionnaire->id), $fileName);
    }

}
