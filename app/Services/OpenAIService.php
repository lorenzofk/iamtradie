
<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;
use Exception;

class OpenAIService
{
    private string $model;
    private int $maxTokens;
    private float $temperature;

    public function __construct()
    {
        $this->model = config('services.openai.model');
        $this->maxTokens = config('services.openai.max_tokens');
        $this->temperature = config('services.openai.temperature');
    }

    /**
     * Generate a quote response based on customer message and user settings
     */
    public function generateQuoteResponse(
        string $clientMessage,
        string $jobType,
        ?string $location = null,
        ?float $calloutFee = null,
        ?float $hourlyRate = null,
        string $responseTone = 'polite',
        ?string $preferredCta = null,
        ?string $tradieFirstName = null
    ): string {
        try {
            $prompt = $this->buildQuotePrompt(
                $clientMessage,
                $jobType,
                $location,
                $calloutFee,
                $hourlyRate,
                $responseTone,
                $preferredCta,
                $tradieFirstName
            );

            $response = OpenAI::chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $this->getSystemPrompt($responseTone, $jobType)],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
            ]);

            return $response->choices[0]->message->content;

        } catch (Exception $e) {
            Log::error('OpenAI quote generation failed', [
                'error' => $e->getMessage(),
                'client_message' => $clientMessage,
                'job_type' => $jobType
            ]);

            return $this->getFallbackResponse($tradieFirstName, $calloutFee, $hourlyRate, $preferredCta);
        }
    }

    /**
     * Improve an existing quote response based on feedback
     */
    public function improveQuoteResponse(string $originalResponse, string $improvements): string
    {
        try {
            $prompt = "Please improve the following quote response based on these suggestions:\n\n";
            $prompt .= "Original Response:\n{$originalResponse}\n\n";
            $prompt .= "Improvements Requested:\n{$improvements}\n\n";
            $prompt .= "Please provide an enhanced version that incorporates the requested improvements while maintaining the professional tradesperson tone and Australian context.";

            $response = OpenAI::chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an expert at refining professional tradesperson communications.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
            ]);

            return $response->choices[0]->message->content;

        } catch (Exception $e) {
            Log::error('OpenAI quote improvement failed', [
                'error' => $e->getMessage(),
                'original_response' => $originalResponse,
                'improvements' => $improvements
            ]);

            return $originalResponse; // Return original if improvement fails
        }
    }

    /**
     * Build the main prompt for quote generation
     */
    private function buildQuotePrompt(
        string $clientMessage,
        string $jobType,
        ?string $location,
        ?float $calloutFee,
        ?float $hourlyRate,
        string $responseTone,
        ?string $preferredCta,
        ?string $tradieFirstName
    ): string {
        $prompt = "Generate a professional quote response for this customer inquiry:\n\n";
        $prompt .= "Customer Message: \"{$clientMessage}\"\n\n";
        $prompt .= "Job Type: {$jobType}\n";
        
        if ($location) {
            $prompt .= "Location: {$location}\n";
        }
        
        if ($calloutFee) {
            $prompt .= "Standard Callout Fee: \${$calloutFee}\n";
        }
        
        if ($hourlyRate) {
            $prompt .= "Hourly Rate: \${$hourlyRate}\n";
        }
        
        if ($tradieFirstName) {
            $prompt .= "Tradesperson Name: {$tradieFirstName}\n";
        }

        $prompt .= "\nResponse Requirements:\n";
        $prompt .= "- Analyze the job complexity from the customer's description\n";
        $prompt .= "- Provide a realistic price estimate with ranges\n";
        $prompt .= "- Include time estimates for completion\n";
        $prompt .= "- Use Australian terminology and pricing conventions\n";
        $prompt .= "- Maintain a {$responseTone} tone\n";
        $prompt .= "- Keep response suitable for SMS (under 1600 characters)\n";
        
        if ($preferredCta) {
            $prompt .= "- Include this call-to-action: \"{$preferredCta}\"\n";
        }

        return $prompt;
    }

    /**
     * Get system prompt based on tone and job type
     */
    private function getSystemPrompt(string $responseTone, string $jobType): string
    {
        $basePrompt = "You are an experienced Australian {$jobType} tradesperson with years of expertise. ";
        $basePrompt .= "You provide accurate, realistic quotes and communicate professionally with customers. ";
        $basePrompt .= "Use Australian terminology, pricing in AUD, and consider local market rates. ";

        switch ($responseTone) {
            case 'casual':
                $basePrompt .= "Use a friendly, conversational tone with some Australian slang. Be approachable and relaxed in your communication style.";
                break;
            case 'professional':
                $basePrompt .= "Use formal business language with technical terminology when appropriate. Maintain a corporate-level professional tone.";
                break;
            case 'polite':
            default:
                $basePrompt .= "Use respectful, courteous language that's professional but warm. Be clear and considerate in your messaging.";
                break;
        }

        return $basePrompt;
    }

    /**
     * Provide fallback response when OpenAI fails
     */
    private function getFallbackResponse(
        ?string $tradieFirstName,
        ?float $calloutFee,
        ?float $hourlyRate,
        ?string $preferredCta
    ): string {
        $response = "G'day! ";
        
        if ($tradieFirstName) {
            $response .= "This is {$tradieFirstName}. ";
        }
        
        $response .= "Thanks for your inquiry. I'd be happy to help with your job. ";
        
        if ($calloutFee) {
            $response .= "My standard callout is \${$calloutFee}. ";
        }
        
        if ($hourlyRate) {
            $response .= "My hourly rate is \${$hourlyRate}. ";
        }
        
        $response .= "I'll need to assess the job to give you an accurate quote. ";
        
        if ($preferredCta) {
            $response .= $preferredCta;
        } else {
            $response .= "Please give me a call to discuss your requirements.";
        }

        return $response;
    }

    /**
     * Analyze job complexity from customer message
     */
    public function analyzeJobComplexity(string $clientMessage, string $jobType): array
    {
        try {
            $prompt = "Analyze this {$jobType} job request and provide a complexity assessment:\n\n";
            $prompt .= "Customer Message: \"{$clientMessage}\"\n\n";
            $prompt .= "Please respond with a JSON object containing:\n";
            $prompt .= "- complexity_level (simple/moderate/complex)\n";
            $prompt .= "- estimated_hours (numeric)\n";
            $prompt .= "- required_skills (array)\n";
            $prompt .= "- material_requirements (array)\n";
            $prompt .= "- safety_considerations (array)";

            $response = OpenAI::chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => "You are an expert {$jobType} tradesperson who analyzes job requirements."],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 300,
                'temperature' => 0.3,
            ]);

            return json_decode($response->choices[0]->message->content, true) ?: [];

        } catch (Exception $e) {
            Log::error('OpenAI job analysis failed', [
                'error' => $e->getMessage(),
                'client_message' => $clientMessage,
                'job_type' => $jobType
            ]);

            return [
                'complexity_level' => 'moderate',
                'estimated_hours' => 2,
                'required_skills' => [],
                'material_requirements' => [],
                'safety_considerations' => []
            ];
        }
    }

    /**
     * Generate SMS-optimized response
     */
    public function generateSmsResponse(
        string $clientMessage,
        string $jobType,
        ?float $calloutFee = null,
        ?float $hourlyRate = null,
        string $responseTone = 'polite',
        ?string $tradieFirstName = null
    ): string {
        $response = $this->generateQuoteResponse(
            $clientMessage,
            $jobType,
            null,
            $calloutFee,
            $hourlyRate,
            $responseTone,
            null,
            $tradieFirstName
        );

        // Ensure SMS character limit compliance
        if (strlen($response) > 1600) {
            $response = substr($response, 0, 1597) . '...';
        }

        return $response;
    }
}
