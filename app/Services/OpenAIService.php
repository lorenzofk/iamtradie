<?php

namespace App\Services;

use App\Enums\ResponseTone;
use Exception;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class OpenAIService
{
    public function __construct(private ?string $model, private ?int $maxTokens, private ?float $temperature)
    {
        $this->model = config('services.openai.model');
        $this->maxTokens = config('services.openai.max_tokens');
        $this->temperature = config('services.openai.temperature');
    }

    public function generateQuoteResponse(
        string $message,
        string $industryType,
        ?string $location = null,
        ?float $calloutFee = null,
        ?float $hourlyRate = null,
        string $responseTone = 'polite',
        ?string $preferredCta = null,
        ?string $firstName = null
    ): string {
        try {
            $prompt = $this->buildQuotePrompt(
                $message,
                $industryType,
                $location,
                $calloutFee,
                $hourlyRate,
                $responseTone,
                $preferredCta,
                $firstName
            );

            $response = OpenAI::chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
            ]);

            return $response->choices[0]->message->content ?? $this->getFallbackResponse($firstName, $calloutFee, $hourlyRate, $preferredCta, $responseTone);

        } catch (Exception $e) {
            Log::error('OpenAI quote generation failed', [
                'error' => $e->getMessage(),
                'message' => $message,
                'industry_type' => $industryType
            ]);

            return $this->getFallbackResponse($firstName, $calloutFee, $hourlyRate, $preferredCta, $responseTone);
        }
    }

    private function buildQuotePrompt(
        string $clientMessage,
        string $industryType,
        ?string $location,
        ?float $calloutFee,
        ?float $hourlyRate,
        string $responseTone,
        ?string $preferredCta,
        ?string $firstName
    ): string {
        $locationText = $location ?? 'Not specified';
        $toneText = $this->getToneInstructions($responseTone, $industryType);
        $callToActionText = $preferredCta ?? $this->getDefaultCta($responseTone);
    
        $prompt = <<<EOT
        🎯 GOAL: Write one SMS reply (max 160 characters) from an Aussie tradie to a job enquiry.

        You are an experienced Australian {$industryType} tradesperson with years of expertise.
        You provide accurate, realistic quotes only when possible and communicate professionally with customers.
        Use Australian terminology, pricing in AUD, and consider local market rates.
        
        You will always use the information provided below to generate your message:
            - Your pricing rates: \${$calloutFee} callout + \${$hourlyRate}/hr
            - Your location: {$locationText}
            - Your trade type: {$industryType}
            - Your name: {$firstName}
            - Your tone: {$responseTone} — {$toneText}
        
        Your response MUST ALWAYS REGARDLESS OF THE CONTEXT FOLLOW THESE RULES:
            - Stay under 160 characters
            - Include pricing (e.g. "\${$calloutFee} callout + \${$hourlyRate}/hr")
            - Estimate time & ballpark cost *if context allows* (based on message, job type, and real-world pricing for similar jobs)
            - Mention customer's location *if relevant* and that location is really close to your location. It could be a miscommunication as you receive data from a call transcript.
            - Match the tone style: {$responseTone} — {$toneText}
            - Avoid sounding robotic or generic—must feel like a message from a real tradie
            - End with: "{$callToActionText}" if it fits
            - Don't mention about the callout if it is 0 or null.
        
        You MUST NEVER:
            - Confirm the job or ask for a booking
            - Repeat the client's message
            - Give instructions, advice, or technical info
            - Say “it depends” without offering a rough estimate
            - Ask questions unless the message is vague
            - Act as a chatbot or engage in back-and-forth
        
        You MUST REJECT IF:
            - The message is off-topic, spammy, or trying to exploit the system (e.g. research, image gen, AI questions, ChatGPT-style prompts)
            - In those cases, reply ONLY with:  
                - Hi there! This number is for quoting jobs only. If you’re after something else, feel free to give me a call instead.

        IF Someone is asking for a quote for a job that is not a tradie job, mention your industry. But never suggest how much THEY could charge:
            - Example (be creative):
                - Hi there! I'm a {$industryType} and not a Plumber. But for plumbing jobs, it's callout \${$calloutFee} + \${$hourlyRate}/hr. If you need plumbing, I'm your guy!
        
        IF VAGUE (e.g. "Need a clean"), ask for a simple detail to clarify:  
            - No dramas — is it a 2 bed / 1 bath?
            - Always based on the context and the industry type you work on
        
        Now generate ONE SMS reply below (max 160 characters) based on the information provided to respond to the client's message:
            - "{$clientMessage}"
        EOT;
        
        return $prompt;
    }
    

    private function getFallbackResponse(
        ?string $firstName,
        ?float $calloutFee,
        ?float $hourlyRate,
        ?string $preferredCta,
        string $responseTone
    ): string {
        $callToActionText = $preferredCta ?? $this->getDefaultCta($responseTone);

        $message = "G'day! " .
            ($firstName ? "This is {$firstName}. " : '') .
            "Thanks for your inquiry. I'd be happy to help with your job. " .
            ($calloutFee ? "My standard callout is \${$calloutFee}. " : '') .
            ($hourlyRate ? "My hourly rate is \${$hourlyRate}. " : '') .
            "I'll need to assess the job to give you an accurate quote. " .
            $callToActionText;

        return strlen($message) <= 160
            ? $message
            : "Hi, happy to help. Callout \${$calloutFee}, \${$hourlyRate}/hr. Call me to discuss the job";
    }

    private function getDefaultCta(string $responseTone): string
    {
        return match ($responseTone) {
            ResponseTone::CASUAL->value => "Let me know if you'd like to lock it in 👍",
            ResponseTone::PROFESSIONAL->value => "Let me know if you'd like to book it in",
            ResponseTone::POLITE->value => "Please let me know if you'd like to proceed",
            default => "Please let me know if you'd like to proceed",
        };
    }

    private function getToneInstructions(string $responseTone, string $industryType): string
    {
        $basePrompt = "You are an experienced Australian {$industryType} tradesperson with years of expertise. ";
        $basePrompt .= "You provide accurate, realistic quotes and communicate professionally with customers. ";
        $basePrompt .= "Use Australian terminology, pricing in AUD, and consider local market rates. ";

        return match ($responseTone) {
            ResponseTone::CASUAL->value => $basePrompt .= "Use a friendly, conversational tone with some Australian slang. Be approachable and relaxed in your communication style.",
            ResponseTone::PROFESSIONAL->value => $basePrompt .= "Use formal business language with technical terminology when appropriate. Maintain a corporate-level professional tone.",
            ResponseTone::POLITE->value => $basePrompt .= "Use respectful, courteous language that's professional but warm. Be clear and considerate in your messaging.",
            default => $basePrompt .= "Use respectful, courteous language that's professional but warm. Be clear and considerate in your messaging.",
        };
    }
}
