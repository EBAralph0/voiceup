namespace App\Services;

use OpenAI\Client;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'api_key' => env('OPENAI_API_KEY'),
        ]);
    }

    public function generateSuggestions($text)
    {
        $response = $this->client->completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => "Analyze the following customer reviews and provide targeted suggestions for improvement:\n\n" . $text,
            'max_tokens' => 150,
        ]);

        return $response->choices[0]->text;
    }
}
