<?php

class Validator
{
    private array $rules = [];
    private array $errors = [];
    private ?UserRepository $userRepository = null;

    public function __construct(?UserRepository $userRepository = null)
    {
        $this->userRepository = $userRepository;
    }
    
    public function addRule(string $field, string $rule, $value = null, ...$params): self
    {
        $this->rules[$field][] = ['rule' => $rule, 'value' => $value, 'params' => $params];
        return $this;
    }
    
    public function required(string $field, $value): self
    {
        return $this->addRule($field, 'required', $value);
    }
    
    public function email(string $field, $value): self
    {
        return $this->addRule($field, 'email', $value);
    }
    
    public function phone(string $field, $value): self
    {
        return $this->addRule($field, 'phone', $value);
    }
    
    public function cni(string $field, $value): self
    {
        return $this->addRule($field, 'cni', $value);
    }

    public function unique(string $field, $value, string $repositoryMethod, string $errorMessageKey): self
    {
        return $this->addRule($field, 'unique', $value, $repositoryMethod, $errorMessageKey);
    }

    public function min(string $field, $value, float $min): self
    {
        return $this->addRule($field, 'min', $value, $min);
    }
    
    public function validate(): bool
    {
        foreach ($this->rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule) {
                $this->validateRule($field, $rule['rule'], $rule['value'], $rule['params']);
            }
        }
        
        return empty($this->errors);
    }
    
    private function validateRule(string $field, string $rule, $value, array $params): void
    {
        $method = "validate" . ucfirst($rule);
        
        if (method_exists($this, $method)) {
            // Passer les paramètres supplémentaires à la méthode de validation
            call_user_func_array([$this, $method], array_merge([$field, $value], $params));
        }
    }
    
    private function validateRequired(string $field, $value): void
    {
        if (empty($value) && $value !== 0 && $value !== '0') { // Ajout de la vérification pour 0
            $this->errors[$field] = Translator::get('validation.required', ['field' => $field]);
        }
    }
    
    private function validateEmail(string $field, $value): void
    {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = Translator::get('validation.email', ['field' => $field]);
        }
    }
    
    private function validatePhone(string $field, $value): void
    {
        if (!empty($value) && !preg_match('/^(77|78|70|76|75)[0-9]{7}$/', $value)) {
            $this->errors[$field] = Translator::get('validation.phone');
        }
    }
    
    private function validateCni(string $field, $value): void
    {
        if (!empty($value) && !preg_match('/^[0-9]{13}$/', $value)) {
            $this->errors[$field] = Translator::get('validation.cni');
        }
    }

    private function validateUnique(string $field, $value, string $repositoryMethod, string $errorMessageKey): void
    {
        if ($this->userRepository && method_exists($this->userRepository, $repositoryMethod)) {
            if ($this->userRepository->$repositoryMethod($value)) {
                $this->errors[$field] = Translator::get($errorMessageKey, ['field' => $field]);
            }
        } else {
            error_log("Validator: Unique rule failed - UserRepository or method '{$repositoryMethod}' not available.");
        }
    }

    private function validateMin(string $field, $value, float $min): void
    {
        if (!empty($value) && $value < $min) {
            $this->errors[$field] = Translator::get('validation.min', ['field' => $field, 'min' => $min]);
        }
    }
    
    public function getErrors(): array
    {
        return $this->errors;
    }
}
