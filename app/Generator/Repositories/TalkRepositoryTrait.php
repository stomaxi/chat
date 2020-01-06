<?php
/**
* Created by PhpStorm.
* User: apple GeneratorCommand
* Date: 2019/09/25
* Time: 10:41:45
*/

namespace App\Generator\Repositories;

use App\Storage\Storage;
trait TalkRepositoryTrait
{
    public function __construct(\App\Storage\Database\Talk $persistence)
    {
        parent::__construct($persistence);
    }

    public function store(array $newData)
    {
        //todo  wirete new data login
        $model = $this->storage();
        $model->uid  =  $newData['uid'];
        $model->type  =  $newData['type'];
        $model->content  =  $newData['content'];
        $model->groups  =  $newData['groups'];
        return $this->save($model);
    }
    public function update(Storage $oldModel, array $updateData)
    {
        //todo  wirete update  data login
        if(isset($updateData['uid']))
        $oldModel->uid  =  $updateData['uid'];
        if(isset($updateData['type']))
        $oldModel->type  =  $updateData['type'];
        if(isset($updateData['content']))
        $oldModel->content  =  $updateData['content'];
            return $this->save($oldModel);
    }

}