<?php

namespace App\Core;

class Validator
{
    protected $errors = [];

    public function validate(
        array $data = [],
        array $rules = []
    ) {
        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? null;
            $this->applyRule($field, $value, $rule);
        }
    }

    protected function applyRule($field, $value, $rule)
    {
        if ($rule === 'required' && empty($value)) {
            $this->errors[$field][] = "$field is required.";
        }

        if (strpos($rule, 'string') !== false && !is_string($value)) {
            $this->errors[$field][] = "$field must be a string.";
        }

        if (strpos($rule, 'email') !== false && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "$field must be a valid email address.";
        }

        if (strpos($rule, 'positive_number') !== false && (!is_numeric($value) || $value <= 0)) {
            $this->errors[$field][] = "$field must be a positive number.";
        }
    }

    public function passes()
    {
        return empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }
}