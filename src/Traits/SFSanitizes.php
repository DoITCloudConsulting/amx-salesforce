<?php

namespace Amx\Salesforce\Traits;

trait SFSanitizes
{
    /**
     * Sanitizes a single value.
     *
     * @param mixed $value
     * @return string
     */
    public function sanitizeValue(mixed $value): string
    {
        return str_replace(["'", '"', ";", "--"], "", trim((string)$value));
    }

    /**
     * Sanitizes an array and converts it into a safe list for IN/NOT IN in SOQL.
     *
     * @param array|string $values
     * @return string
     */
    public function sanitizeArray(array|string $values): string
    {
        if (!is_array($values)) {
            $values = explode(',', trim($values, "()"));
        }

        $sanitized = array_map([$this, 'sanitizeValue'], $values);
        return "( '" . implode("','", $sanitized) . "' )";
    }
}