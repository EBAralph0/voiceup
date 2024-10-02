<?php

namespace App\Exports;

use App\Models\Questionnaire;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionnaireExport implements FromArray, WithHeadings
{
    protected $questionnaireId;

    public function __construct($questionnaireId)
    {
        $this->questionnaireId = $questionnaireId;
    }

    public function headings(): array
    {
        return [
            'Question',
            'Choice',
            'Response Count',
        ];
    }

    public function array(): array
    {
        $questionnaire = Questionnaire::with('questions.choix.responses')->find($this->questionnaireId);
        $exportData = [];

        foreach ($questionnaire->questions as $question) {
            foreach ($question->choix as $choix) {
                $exportData[] = [
                    'question' => $question->text,
                    'choice' => $choix->text,
                    'response_count' => $choix->responses->count(),
                ];
            }
        }

        return $exportData;
    }
}
