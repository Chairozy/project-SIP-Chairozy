<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'name',
        'username',
        'email',
        'password',
        'photo',
        'gender',
        'phone',
        'alamat',
        'kebangsaan',
        'tgl_lahir',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->hasMany(Role::class);
    }

    public function memory()
    {
        return $this->hasMany(Memory::class);
    }

    public function allData()
    {
        return DB::table('users')->get();
    }

    public function oneData($id)
    {
        return DB::table('users')->where('id', $id)->first();
    }

    public function addData($data)
    {
        DB::table('users')->insert($data);
    }
    
    public function editData($id, $data)
    {
        DB::table('users')->where('id', $id)->update($data);
    }

    public function deleteData($id)
    {
        DB::table('users')->where('id', $id)->delete();
    }
}
