<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Password;
use App\Notifications\WelcomeUser;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'roles', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'roles' => 'array',
    ];

    /**
     * @param string $role
     * @return $this
    */
    public function addRole(string $role)
    {
        $roles = $this->getRoles();
        $roles[] = $role;

        $roles = array_unique($roles);
        $this->setRoles($roles);
        return $this;
    }

    /**
     * @param string $role
     * @return $this
    */
    public function removeRole(string $role)
    {
        $roles = $this->getRoles();
        //dd($roles);
        //dd($roles[$role]);
        unset($roles[array_search($role,$roles)]);

        $roles = array_unique($roles);
        $this->setRoles($roles);
        return $this;
    }

    /**
     * @param array $roles
     * @return $this
    */
    public function setRoles(array $roles)
    {
        $this->setAttribute('roles', $roles);
        return $this;
    }

    /**
     * @param $role
     * @return mixed
    */
    public function hasRole($role)
    {
        return in_array($role, $this->getRoles());
    }

    /**
     * @param $roles
     * @return mixed
    */
    public function hasRoles($roles)
    {
        $currentRoles = $this->getRoles();
        foreach($roles as $role) {
            if ( ! in_array($role, $currentRoles )) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return array
    */
    public function getRoles()
    {
        $roles = $this->getAttribute('roles');

        if (is_null($roles)) {
            $roles = [];
        }

        return $roles;
    }

    /**
     * Generate a password radom
     *
     * @return string
    */
    public static function generatePassword()
    {
      return bcrypt(str_random(35));
    }

     /**
     * Send welcome email
     *
     */
    public static function sendWelcomeEmail($user)
    {
        $token = Password::getRepository()->create($user);

        $user->notify(new WelcomeUser($token));
    }

  }
