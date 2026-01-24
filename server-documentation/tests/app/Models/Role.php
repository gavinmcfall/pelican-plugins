<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Role extends Model
{
    protected $fillable = ['name'];

    public const ROOT_ADMIN = 'root_admin';

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public static function factory()
    {
        return \Starter\ServerDocumentation\Database\Factories\RoleFactory::new();
    }
}