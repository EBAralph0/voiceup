<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
</head>
<body>
    <div style="text-align: center;">
        <img src="{{ asset('images/voiceup.png') }}" alt="VoiceUp Logo" style="width: 100px; height: 100px;">
        <h1>Thank you for your response, {{ $user->name }}!</h1>
        <p>We appreciate your feedback on the "{{ $questionnaire->intitule }}" questionnaire.</p>

        <p>If you'd like to review more questionnaires or learn more, feel free to return to the platform using the link below:</p>

        <a href="{{ $platformUrl }}" style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none;">Return to VoiceUp</a>

        <p>Thanks again for your participation!</p>
    </div>
</body>
</html>
