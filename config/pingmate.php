<?php

declare(strict_types=1);

return [
    'chat_prevention_time_minutes' => env('PINGMATE_CHAT_PREVENTION_MINUTES', 5),

    'enable_sms_content_filter' => env('PINGMATE_ENABLE_SMS_CONTENT_FILTER', true),
    'enable_ai_sms_classification' => env('PINGMATE_ENABLE_AI_SMS_CLASSIFICATION', true),

    'ai_sms_classification_model' => env('PINGMATE_AI_SMS_CLASSIFICATION_MODEL', 'gpt-4o-mini'),

    'ai_sms_classification_prompt_instructions' => env(
        'PINGMATE_AI_SMS_CLASSIFICATION_PROMPT_INSTRUCTIONS',
        'Classify the following SMS message for an Australian tradie business. Determine if it is a legitimate job inquiry or should be filtered out. Respond with JSON: {"classification": "clean"|"spam"|"scam"|"marketing"|"offensive"|"non_job_related", "reason": "brief reason"}. Only classify as "clean" if it appears to be a genuine request for tradesperson services (plumbing, electrical, cleaning, handyman, etc.). Consider Australian context and terminology.'
    ),

    'enable_voicemail_transcription_filter' => env('PINGMATE_ENABLE_VOICEMAIL_TRANSCRIPTION_FILTER', true),

    'enable_ai_voicemail_classification' => env('PINGMATE_ENABLE_AI_VOICEMAIL_CLASSIFICATION', true),

    'ai_voicemail_classification_prompt_instructions' => env(
        'PINGMATE_AI_VOICEMAIL_CLASSIFICATION_PROMPT_INSTRUCTIONS',
        'Classify the following voicemail transcription for an Australian tradie business. Note: transcription quality may be poor due to automated speech-to-text. Determine if it appears to be a legitimate job inquiry or should be filtered out. Respond with JSON: {"classification": "clean"|"spam"|"scam"|"marketing"|"offensive"|"non_job_related", "reason": "brief reason"}. Be more lenient due to transcription errors - only classify as spam/scam if clearly obvious. Consider Australian context and terminology.'
    ),

    'sms_filter_keywords' => [
        'nigerian prince',
        'free money',
        'loan offer',
        'sex',
        'nude',
        'fuck',
        'shit',
        'crypto investment',
        'win prize',
        'unclaimed funds',
        'lottery winner',
        'urgent transfer',
        'inheritance',
        'beneficiary',
        'atm card',
        'centrelink payment',
        'tax refund',
        'ato refund',
        'medicare refund',
        'australia post',
        'auspost delivery',
        'toll payment',
        'bitcoin',
        'cryptocurrency',
        'forex',
        'trading platform',
        'investment opportunity',
        'guaranteed returns',
        'make money fast',
        'escort',
        'massage parlour',
        'adult services',
        'webcam',
        'click here',
        'verify account',
        'suspended account',
        'update payment',
        'security alert',
        'confirm identity',
        'congratulations you have won',
        'limited time offer',
        'act now',
        'call immediately',
        'urgent response required',
        'winner',
        'marketing services',
        'seo services',
        'website design',
        'digital marketing',
        'social media management',
        'lead generation',
    ],
];
