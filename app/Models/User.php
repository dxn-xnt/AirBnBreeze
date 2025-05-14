<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_fname',
        'user_lname',
        'user_password',
        'user_email',
        'user_contact_number',
        'user_profile',
        'user_is_host',
        'user_date_created',
    ];


    public $timestamps = false;
    protected $hidden = [
        'user_pass',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->user_password;
    }
}
