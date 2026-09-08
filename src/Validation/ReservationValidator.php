<?php

declare(strict_types=1);

namespace App\Validation;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

final class ReservationValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $rules = [
            'salle_id' => v::intVal()->positive(),
            'responsable' => v::stringType()->length(2, 120),
            'email' => v::email(),
            'motif' => v::stringType()->length(5, 255),
            'date_debut' => v::callback([$this, 'estUneDateValide']),
            'date_fin' => v::callback([$this, 'estUneDateValide']),
        ];

        $errors = [];

        foreach ($rules as $field => $rule) {
            try {
                $rule->assert($data[$field] ?? null);
            } catch (NestedValidationException $exception) {
                $errors[$field] = $exception->getMessages()[0] ?? "Le champ {$field} est invalide.";
            }
        }

        if (!empty($errors)) {
            return ValidationResult::failure($errors);
        }

        return ValidationResult::success([
            'salle_id' => (int) $data['salle_id'],
            'responsable' => $data['responsable'],
            'email' => $data['email'],
            'motif' => $data['motif'],
            'date_debut' => $data['date_debut'],
            'date_fin' => $data['date_fin'],
        ]);
    }

    public function estUneDateValide(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        $date = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $value);

        return $date !== false;
    }
}