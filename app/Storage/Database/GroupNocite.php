<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/24
 * Time: 14:14:43
 */

namespace App\Storage\Database;

use App\Storage\Database;
use App\Generator\Storage\Database\GroupNociteTrait;

class GroupNocite extends Database
{
    use GroupNociteTrait;
    protected $table = 'group_nocites';
    //TODO please complete $fields
    protected $fields = [
        'id' => 'id',
        'group_id' => 'group_id',
        'uid' => 'uid',
        'content' => 'content',
        'read_num' => 'readNum',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
    protected $fillable = [
        'group_id',
        'uid',
        'content',
        'read_num',
    ];

    public function user()
    {
        return $this->belongsTo('App\Storage\Database\User','uid','id');
    }

    public function groupReadNocite(){
        return $this->hasMany('App\Storage\Database\GroupReadNocite','nocite_id','id');
    }

}