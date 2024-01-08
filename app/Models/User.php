<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function getUsers($id){
        $users = DB::table('users')
                ->where('id', '!=',$id)
                ->get();
        return $users;
    }

    public static function getName($userIDArr){
        $jsEnc = json_decode($userIDArr);
        $toObj = (array)$jsEnc;
        $stringNames = '';
        for ($i=0; $i < count($toObj); $i++) { 
            $users = DB::table('users')->where('id',$toObj[$i])->get();
            $jsdecode = json_decode($users);
            $finalData = (array)$jsdecode;
            if(count($toObj) > 1){
                $stringNames .= $finalData[0]->name;
                $stringNames .= ', ';
            }
            else if(count($toObj) === 1){
                $stringNames = $finalData[0]->name;
            }
        }
        return $stringNames;
    }

}