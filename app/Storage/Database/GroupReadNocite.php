<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/24
 * Time: 17:02:36
 */

namespace App\Storage\Database;

use App\Storage\Database;
use App\Generator\Storage\Database\GroupReadNociteTrait;

class GroupReadNocite extends Database
{
    use GroupReadNociteTrait;
    protected $table = 'group_read_nocites';
    //TODO please complete $fields
    protected $fields = [
        'id' => 'id',
        'uid' => 'uid',
        'nocite_id' => 'nociteId',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
    protected  $fillable = [
        'uid',
        'nocite_id'
    ];

}