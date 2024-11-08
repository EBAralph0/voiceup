<!-- resources/views/partials/question_choices.blade.php -->
@switch($question->type)
    @case('onechoice')
        @foreach($question->choix as $choix)
            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="responses[{{ $question->id }}]" id="choix-{{ $choix->id }}" value="{{ $choix->id }}" required>
                <label class="form-check-label" for="choix-{{ $choix->id }}">
                    {{ $choix->text }}
                </label>
            </div>
        @endforeach
        @break

    @case('multiplechoice')
        @foreach($question->choix as $choix)
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="responses[{{ $question->id }}][]" id="choix-{{ $choix->id }}" value="{{ $choix->id }}">
                <label class="form-check-label" for="choix-{{ $choix->id }}">
                    {{ $choix->text }}
                </label>
            </div>
        @endforeach
        @break

    @case('textanswer')
        <textarea class="form-control" name="responses[{{ $question->id }}]" id="question-{{ $question->id }}" rows="2" required></textarea>
        @break

    @case('numericrange')
        <div class="form-group mt-3">
            <label for="numeric-answer-{{ $question->id }}">Choose a number (0 to {{ $question->max_value }})</label>
            <input type="number" name="responses[{{ $question->id }}]" id="numeric-answer-{{ $question->id }}" class="form-control" min="0" max="{{ $question->max_value }}" required>
        </div>
        @break
@endswitch
