namespace App\Services;

use Google\Cloud\Language\LanguageClient;

class GoogleNLPService
{
    protected $language;

    public function __construct()
    {
        $this->language = new LanguageClient([
            'credentials' => base_path(env('GOOGLE_APPLICATION_CREDENTIALS'))
        ]);
    }

    public function analyzeSentiment($text)
    {
        $annotation = $this->language->analyzeSentiment($text);
        $sentiment = $annotation->sentiment();

        return $sentiment;
    }

    public function analyzeEntities($text)
    {
        $annotation = $this->language->analyzeEntities($text);
        $entities = $annotation->entities();

        return $entities;
    }

    public function analyzeSyntax($text)
    {
        $annotation = $this->language->analyzeSyntax($text);
        $tokens = $annotation->tokens();

        return $tokens;
    }
}
