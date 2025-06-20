<?php

declare(strict_types=1);

namespace App\Enums;

enum SmsClassification: string
{
    case CLEAN = 'clean';
    case SPAM = 'spam';
    case SCAM = 'scam';
    case MARKETING = 'marketing';
    case OFFENSIVE = 'offensive';
    case NON_JOB_RELATED = 'non_job_related';

    public function isBlocked(): bool
    {
        return $this !== self::CLEAN;
    }

    public function isClean(): bool
    {
        return $this === self::CLEAN;
    }
}
