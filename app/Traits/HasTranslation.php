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
}
