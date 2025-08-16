<?php

namespace App\Validations;

class Validator
{
    protected $errors = [];

    public function validate(array $data, array $rules)
    {
        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? null;
            $this->applyRule($field, $value, $rule);
        }

        return empty($this->errors);
    }

    protected function applyRule($field, $value, $rule)
    {
        if ($rule === 'required' && empty($value)) {
            $this->errors[$field][] = "$field is required.";
        }

        if (strpos($rule, 'string') !== false && !is_string($value)) {
            $this->errors[$field][] = "$field must be a string.";
        }

        if (strpos($rule, 'integer') !== false && !is_int($value)) {
            $this->errors[$field][] = "$field must be an integer.";
        }

        // Add more validation rules as needed
    }

    public function errors()
    {
        return $this->errors;
    }
}