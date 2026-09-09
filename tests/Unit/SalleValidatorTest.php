<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Validation\SalleValidator;
use PHPUnit\Framework\TestCase;

final class SalleValidatorTest extends TestCase
{
    private SalleValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new SalleValidator();
    }

    public function testDonneesValidesSontAcceptees(): void
    {
        $result = $this->validator->validate([
            'nom' => 'Salle B12',
            'batiment' => 'Bâtiment B',
            'capacite' => 40,
            'type' => 'cours',
            'active' => true,
        ]);

        $this->assertTrue($result->isValid());
    }

    public function testCapaciteNegativeEstRejetee(): void
    {
        $result = $this->validator->validate([
            'nom' => 'Salle B12',
            'batiment' => 'Bâtiment B',
            'capacite' => -5,
            'type' => 'cours',
            'active' => true,
        ]);

        $this->assertFalse($result->isValid());
        $this->assertArrayHasKey('capacite', $result->errors());
    }

    public function testTypeInconnuEstRejete(): void
    {
        $result = $this->validator->validate([
            'nom' => 'Salle B12',
            'batiment' => 'Bâtiment B',
            'capacite' => 40,
            'type' => 'piscine',
            'active' => true,
        ]);

        $this->assertFalse($result->isValid());
        $this->assertArrayHasKey('type', $result->errors());
    }
}