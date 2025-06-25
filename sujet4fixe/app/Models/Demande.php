<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    // ✅ Attributs qu'on peut remplir en masse
    protected $fillable = [
        'user_id',
        'document_type_id',
        'statut',
        'commentaire',
    ];

    // ✅ Relation : une demande appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ Relation : une demande appartient à un type de document
    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }
}