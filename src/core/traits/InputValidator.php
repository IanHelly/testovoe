<?php

namespace App\Core\Traits;

trait InputValidator {

    protected function sanitizeInputData(array $data): array
    {
        $sanitizedData = [];
        foreach ($data as $key => $value) {
            $sanitizedData[$key] = $this->sanitizeInput($value);
        }
        return $sanitizedData;
    }

    private function sanitizeInput($data): string {
        return htmlspecialchars(trim($data));
    }
}
