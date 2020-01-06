<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/24
 * Time: 10:29:27
 */

namespace App\Storage\Database;

use App\Storage\Database;
use App\Generator\Storage\Database\GroupchatTrait;

class Groupchat extends Database
{
    use GroupchatTrait;
    protected $table = 'groupchats';
    //TODO please complete $fields
    protected $fields = [
        'id' => 'id',
        'master' => 'master',
        'name' => 'name',
        'status' => 'status',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
    protected $fillable = ['master'];


}