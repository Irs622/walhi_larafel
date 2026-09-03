<?php

namespace App\Services;

class CsvSanitizer
{
    /**
     * Dangerous formula prefix characters in spreadsheet applications
     * (Excel, Calc, Sheets) that can trigger DDE / Formula Injection.
     */
    private const DANGEROUS_PREFIXES = ['=', '+', '-', '@', "\t", "\r", "\n", '|', '%'];

    /**
     * Sanitize a cell value for safe CSV output by escaping dangerous formula prefixes.
     */
    public static function sanitize(?string $value): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        $firstChar = substr($value, 0, 1);
        if (in_array($firstChar, self::DANGEROUS_PREFIXES, true)) {
            return "'".$value;
        }

        return $value;
    }
}
