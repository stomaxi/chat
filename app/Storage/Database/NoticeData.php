<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/29
 * Time: 13:58:19
 */

namespace App\Storage\Database;

use App\Storage\Database;
use App\Generator\Storage\Database\NoticeDataTrait;

class NoticeData extends Database
{
    use NoticeDataTrait;
    protected $table = 'notices';
    //TODO please complete $fields
    protected $fields = [
        'id' => 'id',
        'uid' => 'uid',
        'type' => 'type',
        'content' => 'content',
        'is_read' => 'isRead',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
        'deleted_at' => 'deletedAt',
    ];

}