<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Company extends Model
{    
    use HasFactory;


    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
    ];


    public function cars()
    {
        return $this->hasMany('App\Car');
    }
    public function driver()
    {
        return $this->hasMany('App\Driver');
    }
    public function users()
    {
        return $this->hasMany('App\Users');
    }
}
