<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avis;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Auth;
use App\Services\GoogleNLPService;
#use Google\Cloud\Language\LanguageClient;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Storage;

class AvisController extends Controller
{
    //
    public function get_all()
    {
        try {
            $avis = Avis::all();
            $formattedAvis = $avis->map(function ($item) {
                return [
                    'id' => $item->id,
                    'user_id' => $item->user_id,
                    'entreprise_ids' => $item->entreprise_ids,
                    'note' => $item->note,
                    'commentaire' => $item->commentaire,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });

            return response()->json([
                'data' => $formattedAvis
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching avis: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while fetching avis.'
            ], 500);
        }
    }

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

    public function exportAllComments()
    {
        $allComments = [];
        $entreprises = Entreprise::all();

        foreach ($entreprises as $entreprise) {
            $avis = Avis::where('entreprise_ids', $entreprise->id_entreprise)->get();
            $comments = $avis->pluck('commentaire')->toArray();
            $notes = $avis->pluck('note')->toArray();
            $allComments[$entreprise->id] = [
                'entreprise' => $entreprise->id_entreprise,
                'commentaire' => $comments,
                'note' => $notes
            ];
        }

        $filename = "all_comments.json";
        file_put_contents(storage_path("app/public/{$filename}"), json_encode($allComments));

        return response()->download(storage_path("app/public/{$filename}"));
    }

    public function analyze(Request $request)
    {
        // Enregistrer les commentaires dans un fichier
        $comments = $request->input('commentaire');
        $filename = 'comments_to_analyze.json';
        Storage::put($filename, json_encode($comments));

        // Appeler le script Python pour analyser les commentaires
        $process = new Process(['python', base_path('../ia_voiceup/analyze_comments.py'), storage_path("app/{$filename}")]);
        $process->run();

        // Vérifier les erreurs
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $result = json_decode($process->getOutput(), true);

        return response()->json($result);
    }






    #
    # SUGGESTION
    #
    public function analyzeAvis($entrepriseId)
    {
        $avis = Avis::where('entreprise_ids', $entrepriseId)->get();
        $feedback = '';

        foreach ($avis as $avi) {
            $feedback .= $avi->commentaire . ' ';
        }

        $suggestions = $this->generateSuggestions($feedback);

        return view('entreprises.analyze', compact('suggestions', 'avis'));
    }



    protected function generateSuggestions($feedback)
    {
        try {
            $response = OpenAI::completions()->create([
                'model' => 'gpt-3.5-turbo-instruct',
                'prompt' => "Analyze the following customer reviews and provide targeted suggestions for improvement. Return the suggestions in HTML format. If there are no relevant suggestions to provide, simply state 'No relevant suggestions'. Each review should be in an <h3> tag and each suggestion in a list <ul>:\n\n" . $feedback,
                'max_tokens' => 150,
            ]);

            return $response->choices[0]->text;
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            \Log::error('OpenAI API error: ' . $e->getMessage());

            // Return an appropriate error message
            //return 'Some error occured; please retry later.';
            return $e->getMessage();
        }
    }
}
