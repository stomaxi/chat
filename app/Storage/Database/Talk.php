<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/25
 * Time: 10:41:45
 */

namespace App\Storage\Database;

use App\Storage\Database;
use App\Generator\Storage\Database\TalkTrait;

class Talk extends Database
{
    use TalkTrait;
    protected $table = 'talks';
    //TODO please complete $fields
    protected $fields = [
        'id' => 'id',
        'uid' => 'uid',
        'type' => 'type',
        'content' => 'content',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
        'deleted_at' => 'deletedAt',
    ];
    protected  $fillable = [
        'uid',
        'groups',
        'type',
        'content',
    ];

}