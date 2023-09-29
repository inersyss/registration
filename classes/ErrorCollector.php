<?php

namespace Classes;

final class ErrorCollector
{

    public function __construct(
        private array $errors = [],
    ) {
    }

    public function addError(string $message): void
    {
        $this->errors[] = $message;
    }

    public function getFormattedErrors(): array
    {
        $formattedErrors = [];

        foreach ($this->errors as $error) {
            $formattedErrors[] = $error;
        }

        return $formattedErrors;
    }

    public function clearErrors(): void
    {
        $this->errors = [];
    }
}
