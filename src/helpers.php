<?php

declare(strict_types=1);

if (!function_exists('echapper')) {
    function echapper(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}


function flash(string $type, string $message): void
{
    $_SESSION['flash'][$type] = $message;
}


function recupererFlash(string $type): ?string
{
    $message = $_SESSION['flash'][$type] ?? null;
    unset($_SESSION['flash'][$type]);

    return $message;
}