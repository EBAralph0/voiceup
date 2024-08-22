<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Choix;
use Illuminate\Support\Facades\Auth;

class ChoixController extends Controller
{
    //
    public function edit($id)
    {
        $choix = Choix::findOrFail($id);
        return view('choix.edit', compact('choix'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string|max:255',
        ]);

        $choix = Choix::findOrFail($id);
        $choix->update($request->all());

        return redirect()->route('questionnaires.detail', $choix->question->questionnaire_id)
                         ->with('success', 'Choice updated successfully');
    }

    public function destroy($id)
    {
        $choix = Choix::findOrFail($id);
        $choix->delete();

        return redirect()->route('questionnaires.detail', $choix->question->questionnaire_id)
                         ->with('success', 'Choice deleted successfully');
    }
}
