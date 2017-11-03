<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table='users';

    protected $fillable = [
        'name', 'email', 'password','avatar','confirmation_token'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $data =[
          'url'=>url('password/reset',$token)
        ];
        $template =new SendCloudTemplate('zhihu_pass_reset',$data);
        Mail::raw($template,function($message){
            $message->from('xarial@193.com','yuling');
            $message->to($this->email);
        });
    }
}
