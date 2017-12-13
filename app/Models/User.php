<?php

namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
//use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable;
    use CanResetPassword;
    //use EntrustUserTrait;
        
        

    protected $table = 'users';

    protected $fillable = [
    'username', 
    'email', 
    'password',
    'fullname',
    'location',
    'usertype'
    ];

    protected $hidden = [ 
    'password', 
    'remember_token'];

    public function getFullname()
    {

        if($this->fullname)
        {
            return $this->fullname;
        }
        
        return null;

    }

     public function getNameOrUsername()
    {

            return $this->getFullname() ?: $this->username;

    }

  

     public function getRole()
    {

            return $this->usertype;

    }

    public function sendSmsMessage($message, SmsGatewayInterface $smsGateway)
    {
        try
        {
            $smsGateway->sendSms($message, $this->mobilenumber);
        }
        catch(UndeliveredSmsException $ex)
        {
            // Log message not sent in queue
            throw $ex;
        }
    }






}
