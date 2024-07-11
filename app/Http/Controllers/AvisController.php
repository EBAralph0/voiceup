<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avis;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    //
    public function create($entreprise_id)
    {
        $entreprise = Entreprise::findOrFail($entreprise_id);
        return view('avis.create', compact('entreprise'));
    }

    public function store(Request $request, string $entreprise_id)
    {
        $request->validate([
            'note' => 'required|numeric|min:0|max:5',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        Avis::create([
            'user_id' => Auth::id(),
            'entreprise_ids' => $entreprise_id,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return redirect()->route('entreprises.list_questionnaire', $entreprise_id)->with('success', 'Avis ajouté avec succès.');
    }
}
