<?php

namespace App\Http\Controllers;
use App\Models\Entreprise;
use App\Models\Questionnaire;
use App\Models\Secteur;
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

    public function showQuestions($questionnaireId, $entrepriseId)
    {
        // Charger le questionnaire de secteur
        $questionnaire = Questionnaire::with('questions.choix')->findOrFail($questionnaireId);

        // Charger l'entreprise
        $entreprise = Entreprise::findOrFail($entrepriseId);

        // Récupérer le questionnaire le plus récent de l'entreprise
        $latestQuestionnaire = Questionnaire::where('entreprise_id', $entreprise->id_entreprise)
                                            ->orderBy('created_at', 'desc')
                                            ->with('questions.choix')
                                            ->first();

        return view('questionnaires.questions', compact('questionnaire', 'entreprise', 'latestQuestionnaire'));
    }
    public function exportExcel($id)
    {
        $questionnaire = Questionnaire::findOrFail($id);
        $fileName = $questionnaire->intitule . '.xlsx'; // Nom dynamique basé sur le titre du questionnaire
        return Excel::download(new QuestionnaireExport($questionnaire->id), $fileName);
    }


    public function storeForSector(Request $request, $id_secteur)
    {
        // Validation des données d’entrée
        $request->validate([
            'intitule' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        // Création du questionnaire lié au secteur
        Questionnaire::create([
            'intitule' => $request->intitule,
            'description' => $request->description,
            'created_by' => Auth::id(),
            'id_secteur' => $id_secteur,
        ]);

        // Rediriger vers la liste des questionnaires du secteur avec un message de succès
        return redirect()->route('secteurs.questionnaires.index', $id_secteur)->with('success', 'Questionnaire created successfully.');
    }

    public function indexBySector($id_secteur)
    {
        // Récupérer le secteur et ses questionnaires
        $secteur = Secteur::with('questionnaires')->findOrFail($id_secteur);

        // Retourner la vue d'index des questionnaires
        return view('secteurs.questionnaires', compact('secteur'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'intitule' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $questionnaire = Questionnaire::findOrFail($id);
        $questionnaire->update([
            'intitule' => $request->intitule,
            'description' => $request->description,
        ]);

        return redirect()->route('secteurs.questionnaires.index', $questionnaire->id_secteur)->with('success', 'Questionnaire updated successfully.');
    }

    // Supprimer un questionnaire
    public function destroy($id)
    {
        $questionnaire = Questionnaire::findOrFail($id);
        $id_secteur = $questionnaire->id_secteur; // Sauvegarder l'ID du secteur pour la redirection
        $questionnaire->delete();

        return redirect()->route('secteurs.questionnaires.index', $id_secteur)->with('success', 'Questionnaire deleted successfully.');
    }

}
