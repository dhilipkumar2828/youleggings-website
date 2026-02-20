<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Models\Permission;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermissionGroup extends Model

{

    use HasFactory;

    protected $fillable=['name'];

    public function permissions()

    {

       return $this->hasMany(Permission::class);

    }

}
