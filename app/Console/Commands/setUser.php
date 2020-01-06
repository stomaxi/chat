<?php

namespace App\Console\Commands;

use App\Events\UserRegister;
use App\Repositories\GroupchatRepository;
use App\Repositories\MoblieRepository;
use App\Repositories\UserRepository;
use App\Storage\Database\Groupchat;
use App\User;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class setUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setUser
                      {mobile : 用户手机号} 
                      {password : 用户密码}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成根系用户';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = $this->verGroup();
        if ($count > 1){
            $this->info('群已存在，不能使用此命令');
            return false;
        }

        $moblie = $this->argument('mobile');
        $password = $this->argument('password');
        $moblieOBJ = resolve(MoblieRepository::class);
        $ret = $moblieOBJ->regMoblie($moblie);
        if (!$ret){
            $this->info('号码错误，请输入11位中国大陆手机号');
        }else{
            $this->addUser($moblie, $password);
        }
    }
    public function addUser($moblie, $password)
    {
        $userOBJ = resolve(UserRepository::class);
        $exist = $userOBJ->moblieExist($moblie);
        if ($exist){
            $this->info('号码已注册');
            return false;
        }
        $shareCOde = $userOBJ->getRandCode();
        $user_data = array(
            'mobile' => $moblie,
            'password' => Hash::make($password),
            'identity' => 1,
            'parent_id' => 0,
            'initial_id' => 0,
            'shara_code' => $shareCOde,
        );
        $user = $userOBJ->add($user_data);
        $group = $this->addGroup($user->id);
        if ($user && $group){
            event(new UserRegister($user, $group->id));
            $this->info('ok');
        }else{
            $this->info('fail');
        }
    }

    public function addGroup($uid)
    {
        $groupOBJ = resolve(GroupchatRepository::class);
        $data = array(
            'master' => $uid
        );
       return $groupOBJ->add($data);
    }

    public function verGroup()
    {
        $group = new Groupchat();
        $count = $group->count();
        return $count;
    }




}
