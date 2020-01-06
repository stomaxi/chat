<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/23
 * Time: 15:24:57
 */

namespace App\Storage\Database;

use App\Storage\Database;
use App\Generator\Storage\Database\ComplaintTrait;

class Complaint extends Database
{
    use ComplaintTrait;
    protected $table = 'complaints';
    //TODO please complete $fields
    protected $fields = [
        'id' => 'id',
        'complaint_id' => 'complaintId',
        'uid' => 'uid',
        'type' => 'type',
        'order' => 'order',
        'content' => 'content',
        'pic' => 'pic',
        'is_hand' => 'isHand',
        'hand_content' => 'handContent',
        'hand_at' => 'handAt',
        'hand_uid' => 'handUid',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
    protected $fillable = [
        'complaint_id',
        'uid',
        'type',
        'order',
        'content',
        'pic',
    ];

    //挂单对应
    public function transactionOreder(){
        return $this->belongsTo('App\Storage\Database\TransactionOrder','order','order_id');
    }



}