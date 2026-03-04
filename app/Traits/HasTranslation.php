<?php

namespace App\Traits;

trait HasTranslation
{
    /**
     * Get the translated value for a given attribute.
     * If locale is 'en' and an English version exists, return it.
     * Otherwise, return the original (Indonesian) value.
     */
    public function translated(string $attribute): mixed
    {
        if (app()->getLocale() === 'en') {
            $enAttribute = $attribute . '_en';
            $enValue = $this->{$enAttribute};
            if (!empty($enValue) && $enValue !== '[]') {
                return $enValue;
            }
        }

        return $this->{$attribute};
    }

    /**
     * Magic accessor: $model->translated_title, $model->translated_description, etc.
     */
    public function __get($key)
    {
        if (str_starts_with($key, 'translated_')) {
            $attribute = substr($key, strlen('translated_'));
            return $this->translated($attribute);
        }

        return parent::__get($key);
    }

    /**
     * Safely decode JSON that may be double-encoded.
     * Shared utility for models that store JSON arrays.
     */
    public static function safeJsonArray(mixed $value): array
    {
        if (is_array($value)) return $value;
        if (!is_string($value) || $value === '') return [];

        $decoded = json_decode($value, true);
        if (is_array($decoded)) return $decoded;

        // Handle double-encoded: json string containing json string
        if (is_string($decoded)) {
            $second = json_decode($decoded, true);
            return is_array($second) ? $second : [];
        }

        return [];
    }
}
