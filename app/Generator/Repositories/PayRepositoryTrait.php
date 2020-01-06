<?php
/**
* Created by PhpStorm.
* User: apple GeneratorCommand
* Date: 2019/09/18
* Time: 14:45:12
*/

namespace App\Generator\Repositories;

use App\Storage\Storage;
trait PayRepositoryTrait
{
    public function __construct(\App\Storage\Database\Pay $persistence)
    {
        parent::__construct($persistence);
    }

    public function store(array $newData)
    {
        //todo  wirete new data login
        $model = $this->storage();
        $model->uid  =  $newData['uid'];
        $model->payId  =  $newData['payId'];
        $model->name  =  $newData['name'];
        $model->account  =  $newData['account'];
        $model->payPic  =  $newData['payPic'];
        $model->other  =  $newData['other'];
        return $this->save($model);
    }
    public function update(Storage $oldModel, array $updateData)
    {
        //todo  wirete update  data login
        if(isset($updateData['uid']))
        $oldModel->uid  =  $updateData['uid'];
        if(isset($updateData['payId']))
        $oldModel->payId  =  $updateData['payId'];
        if(isset($updateData['name']))
        $oldModel->name  =  $updateData['name'];
        if(isset($updateData['account']))
        $oldModel->account  =  $updateData['account'];
        if(isset($updateData['payPic']))
        $oldModel->payPic  =  $updateData['payPic'];
        if(isset($updateData['other']))
        $oldModel->other  =  $updateData['other'];
            return $this->save($oldModel);
    }

}