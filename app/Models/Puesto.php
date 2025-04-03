<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    use hasFactory;
    protected $table='puesto';
    protected $primarykey='id_puesto';
    public $incrementing=true;
    protected $keytype='int';
    protected $nombre;
    protected $sueldo;
    protected $fillable=['nombre','sueldo'];
    public $timestamps =false;
    //
}
