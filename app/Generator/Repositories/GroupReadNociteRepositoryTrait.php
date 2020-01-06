<?php
/**
* Created by PhpStorm.
* User: apple GeneratorCommand
* Date: 2019/09/24
* Time: 17:02:36
*/

namespace App\Generator\Repositories;

use App\Storage\Storage;
trait GroupReadNociteRepositoryTrait
{
    public function __construct(\App\Storage\Database\GroupReadNocite $persistence)
    {
        parent::__construct($persistence);
    }

    public function store(array $newData)
    {
        //todo  wirete new data login
        $model = $this->storage();
        $model->uid  =  $newData['uid'];
        $model->nociteId  =  $newData['nociteId'];
        return $this->save($model);
    }
    public function update(Storage $oldModel, array $updateData)
    {
        //todo  wirete update  data login
        return false;
    }

}