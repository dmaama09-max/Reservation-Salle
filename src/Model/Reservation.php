<?php

declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservation';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $fillable = ['salle_id', 'responsable', 'email', 'motif', 'date_debut', 'date_fin', 'statut'];
    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }
}