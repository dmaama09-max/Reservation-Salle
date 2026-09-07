<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return function (Capsule $capsule): void {
    $schema = $capsule->schema();

    if (!$schema->hasTable('salle')) {
        $schema->create('salle', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->string('batiment', 100);
            $table->unsignedInteger('capacite');
            $table->enum('type', ['cours', 'informatique', 'laboratoire', 'amphitheatre', 'reunion']);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    
};