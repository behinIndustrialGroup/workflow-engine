<?php

namespace BehinUserRoles\Models;

use BehinInit\App\Http\Controllers\AccessController;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'name',
        'email',
        'password',
        'level',
        'display_name',
        'showInReport',
        'role_id',
        'reset_code',
        'pm_username', 'pm_user_password', 'pm_user_access_token', 'pm_user_access_token_exp_date',
        'ext_num',
        'valid_ip'
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

    public function canManageBinshopsBlogPosts()
    {
        // Enter the logic needed for your app.
        // Maybe you can just hardcode in a user id that you
        //   know is always an admin ID?

        if (       $this->id === 10
           ){

           // return true so this user CAN edit/post/delete
           // blog posts (and post any HTML/JS)

           return true;
        }

        // otherwise return false, so they have no access
        // to the admin panel (but can still view posts)

        return false;
    }

    function access($method_name) {
        return (new AccessController($method_name))->check();
    }

    function role(){
        return Role::find($this->role_id);
    }

    function departments(){
        return UserDepartment::where('user_id', $this->id)->get();
    }

}
