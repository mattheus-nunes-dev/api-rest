<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unidade extends Model
{
    use HasFactory;

    protected $table = 'unidade';

    protected $primaryKey = 'unid_id';

    protected $fillable = [
        'unid_id',
        'unid_nome',
        'unid_sigla',
    ];
}
