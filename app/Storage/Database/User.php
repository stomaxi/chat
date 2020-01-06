<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/17
 * Time: 14:42:02
 */

namespace App\Storage\Database;
use App\Storage\Storage;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Generator\Storage\Database\UserTrait;
use Illuminate\Notifications\Notifiable;
use Fruits\Apple\Auth\Passwords\CanResetPassword;
use Fruits\Apple\Channels\NotificationFor;

class User extends Authenticatable implements Storage
{
    use UserTrait,Notifiable,NotificationFor,CanResetPassword;
    protected $table = 'users';
    public $apiToken;
    protected $dateFormat = 'U';
    //TODO please complete $fields
    protected $fields = [
        'id' => 'id',
        'name' => 'name',
        'mobile' => 'mobile',
        'password' => 'password',
        'pic' => 'pic',
        'identity' => 'identity',
        'grade' => 'grade',
        'fraction' => 'fraction',
        'remember_token' => 'rememberToken',
        'status' => 'status',
        'shara_code' => 'sharaCode',
        'parent_id' => 'parentId',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
    protected $fillable = ['mobile', 'password', 'identity', 'parent_id', 'initial_id', 'shara_code','level'];
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function persist($data = [])
    {

        return $this->save();
    }

    public function retrieve($id, $columns = array('*'))
    {

        return  $this->findOrFail($id);
    }
    public function getFieldName($propertyName)
    {

        return $this->fieldNameMap[$propertyName] ?? $propertyName;
    }
/*    public function toArray()
    {

        $ret = [];
        foreach ($this->fields as $dbField => $classProperty) {

            $ret[$classProperty] = $this->{$dbField};
        }

        return $ret;
    }*/


    public function red_packets()
    {
        return $this->hasOne('App\Storage\Database\RedPacket','app_id','id');
    }

    public function account()
    {
        return $this->hasOne('App\Storage\Database\Account','uid','id');
    }
    public function getGroup()
    {
        return $this->hasOne('App\Storage\Database\Groupchat','id','groupchat');
    }

    public function userInfo()
    {
        return $this->hasOne('App\Storage\Database\UserInfo','uid','id');

    }

    public function getUids(array $ids)
    {
        return $this->whereIn('id',$ids)->get();
    }

}