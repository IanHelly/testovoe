<?php

namespace App\Core\Traits;

trait InputValidator {

    private function sanitizeInputData(array $data): array
    {
        $sanitizedData = [];
        foreach ($data as $key => $value) {
            $sanitizedData[$key] = $this->sanitizeInput($value);
        }
        return $sanitizedData;
    }

    public function sanitizeInput($data): string {
        return htmlspecialchars(trim($data));
    }
}
