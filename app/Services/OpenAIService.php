<?php

declare(strict_types=1);

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

    /**
     * This method generates a quote response for a given message.
     */
    public function generateQuoteResponse(
        string $message,
        string $industryType,
        ?string $location = null,
        ?float $calloutFee = null,
        ?float $hourlyRate = null,
        string $responseTone = 'polite',
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
                $firstName
            );

            $response = OpenAI::chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
            ]);

            return $response->choices[0]->message->content ?? $this->getFallbackResponse($firstName, $calloutFee, $hourlyRate, $responseTone);

        } catch (Exception $e) {
            Log::error('OpenAI quote generation failed', [
                'error' => $e->getMessage(),
                'message' => $message,
                'industry_type' => $industryType,
            ]);

            return $this->getFallbackResponse($firstName, $calloutFee, $hourlyRate, $responseTone);
        }
    }

    /**
     * This method generates a voicemail summary for the user.
     */
    public function generateVoicemailSummaryForUser(
        string $transcription,
        string $industryType,
        ?float $calloutFee = null,
        ?float $hourlyRate = null,
        ?string $userFirstName = null
    ): string {
        try {
            $prompt = $this->buildVoicemailSummaryPrompt(
                $transcription,
                $industryType,
                $calloutFee,
                $hourlyRate,
                $userFirstName
            );

            $response = OpenAI::chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 100,
                'temperature' => 0.2,
            ]);

            return $response->choices[0]->message->content ?? 'Unable to generate summary.';

        } catch (Exception $e) {
            Log::error('OpenAI voicemail summary generation failed', [
                'error' => $e->getMessage(),
                'transcription' => $transcription,
                'industry_type' => $industryType,
            ]);

            return 'Error generating summary for voicemail. Please check logs.';
        }
    }

    /**
     * This method builds the prompt for the quote response.
     */
    private function buildQuotePrompt(
        string $clientMessage,
        string $industryType,
        ?string $location,
        ?float $calloutFee,
        ?float $hourlyRate,
        string $responseTone,
        ?string $firstName
    ): string {
        $locationText = $location ?? 'Not specified but always in Australia';
        $toneText = $this->getToneInstructions($responseTone, $industryType);
        $callToActionText = $this->getDefaultCta($responseTone);

        $prompt = <<<EOT
        🎯 GOAL: Write one SMS reply (max 160 characters) from an Aussie tradie to a job enquiry.

        You are an experienced Australian {$industryType} tradesperson named {$firstName} with years of expertise.
        You provide accurate, realistic quotes only when possible and communicate professionally with customers.
        Use Australian terminology, pricing in AUD, and consider local market rates.
        
        You will always use the information provided below to generate your message:
            - Your pricing rates: \${$calloutFee} callout + \${$hourlyRate}/hr
            - Your location: {$locationText}
            - Your specific trade: {$industryType}
            - Your name: {$firstName}
            - Your tone: {$responseTone} — {$toneText}
        
        Your response MUST ALWAYS REGARDLESS OF THE CONTEXT FOLLOW THESE RULES:
            - Stay under 160 characters
            - Match the tone style: {$responseTone} — {$toneText}
            - Avoid sounding robotic or generic—must feel like a message from a real tradie
            - End with: "{$callToActionText}" if it fits (unless explicitly overruled by a rejection rule below)
            - Don't mention about the callout if it is 0 or null.
        
        You MUST NEVER:
            - Confirm the job or ask for a booking
            - Repeat the client's message
            - Give instructions, advice, or technical info unless specifically asked for details to clarify a vague request for YOUR trade.
            - Say "it depends" without offering a rough estimate *if quoting is appropriate*.
            - Ask questions unless the message is vague *and for your trade*.
            - Act as a chatbot or engage in back-and-forth.
            - **Quote or estimate for services not directly related to your specific trade ({$industryType}).**
            - **Offer services or advice outside of your specified trade.**

        **CRITICAL HIERARCHY OF RESPONSES - FOLLOW STRICTLY:**

        1.  **IF The message is OFF-TOPIC, SPAMMY, or attempts to EXPLOIT the system (e.g., research, image generation, AI questions, non-job related inquiries, or is clearly a scam):**
            * Reply ONLY with this exact message (no other text, no CTA):
                Hey mate! This number is for quoting jobs only. If you're after something else, feel free to give me a call instead.

        2.  **ELSE IF The message is a LEGITIMATE JOB INQUIRY BUT IS CLEARLY OUTSIDE OF YOUR SPECIFIC TRADE ({$industryType}) (e.g., a plumber receives a 'bond cleaning' request):**
            * Do NOT provide any quotes or estimates for *your* services in this response.
            * Politely state your trade type and that you cannot assist with *that specific type of job*.
            * Maintain the {$responseTone} tone.
            * End with a polite closing, possibly without the CTA if it doesn't fit the context of declining.
            * **Example Response for a Plumber receiving a cleaning request:**
                G'day! I'm {$firstName}, a plumber. I specialise in plumbing jobs and can't help with cleaning. No worries!

        3.  **ELSE IF The message is a LEGITIMATE JOB INQUIRY AND IS WITHIN YOUR SPECIFIC TRADE ({$industryType}):**
            * **IF VAGUE** (e.g., "Need a clean" for a Cleaner, or "Fix my tap" for a Plumber), ask for a simple detail to clarify:
                * Always base the question on the context and your industry type.
                * Example (Plumber): "No worries — is it a leaky tap or a blocked drain?"
                * Example (Cleaner): "No worries — is it a 2 bed / 1 bath?"
            * **ELSE (IF CLEAR enough to estimate):**
                * Include pricing (e.g., "\${$calloutFee} callout + \${$hourlyRate}/hr").
                * Estimate time & ballpark cost (based on message, job type, and real-world pricing for similar jobs).
                * Mention customer's location *if relevant* and if it's close to your service area. Acknowledge if it's from a call transcript (e.g., "From your voicemail, sounds like you're in [location]").
                * End with: "{$callToActionText}".

        Now generate ONE SMS reply below (max 160 characters) based on the information provided to respond to the client's message:
            - "{$clientMessage}"
        EOT;

        return $prompt;
    }

    /**
     * This method builds the prompt for voicemail summary generation.
     */
    private function buildVoicemailSummaryPrompt(
        string $transcription,
        string $industryType,
        ?float $calloutFee,
        ?float $hourlyRate,
        ?string $userFirstName
    ): string {
        $calloutText = $calloutFee ? "{$calloutFee} callout" : '';
        $hourlyText = $hourlyRate ? "{$hourlyRate}/hr" : '';

        $pricingText = '';
        if ($calloutFee && $hourlyRate) {
            $pricingText = "Your standard pricing is {$calloutText} and {$hourlyText}";
        } elseif ($calloutFee) {
            $pricingText = "Your callout fee is ${$calloutFee}";
        } elseif ($hourlyRate) {
            $pricingText = "Your hourly rate is ${$hourlyRate}/hr";
        }

        $prompt = <<<EOT
        You are an intelligent assistant for an Australian tradie. Your task is to summarize a voicemail transcription into a structured, concise SMS for the tradie. The summary must be short, typically under 160 characters, and fit the specified format. Do not include the caller's phone number as it will be added by the application code separately.

        **CONTEXT FOR YOU (THE AI):**
        - You are summarizing for a {$industryType} tradie.
        - Your name is {$userFirstName} (if provided).
        - You operate in Australia. The current location is Peregian Springs, Queensland.
        - {$pricingText} (only include if provided). If only one is provided, state that (e.g., "hourly rate is \$X/hr").

        **INSTRUCTIONS:**
        1.  Extract the core job request or inquiry from the transcription. Be specific and brief.
        2.  Infer urgency: "ASAP", "This week", "Next month", "No rush", or "Not specified".
        3.  Infer the customer's location if explicitly mentioned in the transcription. Otherwise, state "Not specified".
        4.  Estimate job value: If the voicemail clearly describes a typical job for a {$industryType} and provides enough detail, give a rough **Australian Dollar** range estimate based on typical job durations for your trade and the provided callout/hourly rates. For example, a "leaky tap" for a plumber might be 1-2 hours of work plus callout. If it's too vague or complex for a reasonable estimate, state "Needs inspection" or "Cannot estimate".
        5.  Do NOT add any conversational filler, greetings, or sign-offs. Just the structured summary.
        6.  Ensure the total output for the summary content is as short as possible while retaining key information, ideally under 160 characters.

        **DESIRED OUTPUT FORMAT (STRICTLY ADHERE TO THIS - NO EXTRA TEXT):**
        💬 [Concise Job Description]
        💰 Est. Value: [e.g., \$320–\$450 or Needs inspection]
        ⚡ Urgency: [e.g., ASAP / This week / Not specified]
        📍 Location: [e.g., Peregian Springs / Not specified]

        **VOICEMAIL TRANSCRIPTION TO SUMMARIZE:**
        "{$transcription}"
        EOT;

        return $prompt;
    }

    /**
     * This method returns the fallback response for a given response tone.
     */
    private function getFallbackResponse(?string $firstName, ?float $calloutFee, ?float $hourlyRate, string $tone): string
    {
        $callToActionText = $this->getDefaultCta($tone);

        $message = "G'day! ".
            ($firstName ? "This is {$firstName}. " : '').
            "Thanks for your inquiry. I'd be happy to help with your job. ".
            ($calloutFee ? "My standard callout is \${$calloutFee}. " : '').
            ($hourlyRate ? "My hourly rate is \${$hourlyRate}. " : '').
            "I'll need to assess the job to give you an accurate quote. ".
            $callToActionText;

        $shortMessage = "Hi, happy to help. Callout \${$calloutFee}, \${$hourlyRate}/hr. Call me to discuss the job";

        return mb_strlen($message) <= 160 ? $message : $shortMessage;
    }

    /**
     * This method returns the default call to action for a given response tone.
     */
    private function getDefaultCta(string $responseTone): string
    {
        return match ($responseTone) {
            ResponseTone::CASUAL->value => "Let me know if you'd like to lock it in 👍",
            ResponseTone::PROFESSIONAL->value => "Let me know if you'd like to book it in",
            ResponseTone::POLITE->value => "Please let me know if you'd like to proceed",
            default => "Please let me know if you'd like to proceed",
        };
    }

    /**
     * This method returns the tone instructions for a given response tone and industry type.
     */
    private function getToneInstructions(string $responseTone, string $industryType): string
    {
        $basePrompt = "You are an experienced Australian {$industryType} tradesperson with years of expertise. ";
        $basePrompt .= 'You provide accurate, realistic quotes and communicate professionally with customers. ';
        $basePrompt .= 'Use Australian terminology, pricing in AUD, and consider local market rates. ';

        return match ($responseTone) {
            ResponseTone::CASUAL->value => $basePrompt .= 'Use a friendly, conversational tone with some Australian slang. Be approachable and relaxed in your communication style.',
            ResponseTone::PROFESSIONAL->value => $basePrompt .= 'Use formal business language with technical terminology when appropriate. Maintain a corporate-level professional tone.',
            ResponseTone::POLITE->value => $basePrompt .= "Use respectful, courteous language that's professional but warm. Be clear and considerate in your messaging.",
            default => $basePrompt .= "Use respectful, courteous language that's professional but warm. Be clear and considerate in your messaging.",
        };
    }
}
