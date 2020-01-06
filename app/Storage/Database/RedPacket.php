<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/26
 * Time: 11:15:07
 */

namespace App\Storage\Database;

use App\Storage\Database;
use App\Generator\Storage\Database\RedPacketTrait;

class RedPacket extends Database
{
    use RedPacketTrait;
    protected $table = 'red_packets';
    //TODO please complete $fields
    protected $fields = [
        'id' => 'id',
        'app_id' => 'appID',
        'service' => 'service',
        'url' => 'url',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
        'deleted_at' => 'deletedAt',
    ];

}