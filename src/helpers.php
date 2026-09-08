<?php

declare(strict_types=1);

if (!function_exists('echapper')) {
    function echapper(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}