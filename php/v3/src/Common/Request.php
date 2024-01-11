<?php

namespace Dead4w\App\Common;

use Dead4w\App\Exceptions\ValidationInvalidType;

class Request
{

    public function __construct(
        protected array $data
    ) {
        $this->validate();
    }

    /**
     * Validate input data
     * @return void
     */
    public function validate(): void {

    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null) {
        $parts = explode('.', $key);
        $data = $this->data;

        foreach ($parts as $part) {
            if (!is_array($data) || !isset($data[$part])) {
                $data = null;
                break;
            }

            $data = $data[$part] ?? null;
        }

        return $data ?? $default;
    }

    protected function getInteger($key): int {
        $value = $this->get($key);

        if ($value === null) {
            throw new ValidationInvalidType("Value ($key) must be integer");
        }

        if (!is_int($value)) {
            throw new ValidationInvalidType("Value ($key) must be integer");
        }

        if (preg_match('/[^\d]/', $value)) {
            throw new ValidationInvalidType("Value ($key) must be integer");
        }

        try {
            $value = (int) $value;
        } catch (\Throwable $t) {
            throw new ValidationInvalidType("Value ($key) must be integer");
        }

        return $value;
    }

}