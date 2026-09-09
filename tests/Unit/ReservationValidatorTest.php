<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Validation\ReservationValidator;
use PHPUnit\Framework\TestCase;

final class ReservationValidatorTest extends TestCase
{
    private ReservationValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new ReservationValidator();
    }

    private function donneesValides(array $overrides = []): array
    {
        return array_merge([
            'salle_id' => 1,
            'responsable' => 'Awa Ndiaye',
            'email' => 'awa@universite.sn',
            'motif' => 'Cours de test',
            'date_debut' => '2026-09-10 10:00:00',
            'date_fin' => '2026-09-10 12:00:00',
        ], $overrides);
    }

    public function testDonneesValidesSontAcceptees(): void
    {
        $result = $this->validator->validate($this->donneesValides());

        $this->assertTrue($result->isValid());
    }

    public function testEmailInvalideEstRejete(): void
    {
        $result = $this->validator->validate($this->donneesValides([
            'email' => 'adresse-invalide',
        ]));

        $this->assertFalse($result->isValid());
        $this->assertArrayHasKey('email', $result->errors());
    }

    public function testResponsableVideEstRejete(): void
    {
        $result = $this->validator->validate($this->donneesValides([
            'responsable' => '',
        ]));

        $this->assertFalse($result->isValid());
        $this->assertArrayHasKey('responsable', $result->errors());
    }

    public function testDateIncorrecteEstRejetee(): void
    {
        $result = $this->validator->validate($this->donneesValides([
            'date_debut' => 'pas-une-date',
        ]));

        $this->assertFalse($result->isValid());
        $this->assertArrayHasKey('date_debut', $result->errors());
    }
}