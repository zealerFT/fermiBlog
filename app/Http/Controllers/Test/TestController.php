<?php

namespace App\Http\Controllers\Test;

use Log;
use DB;
use App\Jobs\SendEmail;
use App\Http\Controllers\Controller;

class TestController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function first()
    {
        Log::info('this is my first log!');
        echo 'success';
    }

    /**
     * composer require jenssegers/mongodb --ignore-platform-reqs
     * 去掉版本检查
     * @return Array
     */
    public function mongodb()
    {
        DB::connection('mongodb')      //选择使用mongodb
            ->collection('users')           //选择使用users集合
            ->insert([                          //插入数据
                    'name'  =>  'feiteng',
                    'age'   =>   26,
                    'email' => 'ft910310@qq.com'
                ]);
        $res = DB::connection('mongodb')->collection('users')->get()->toArray();   //查询所有数据
        foreach ($res as $key => $value) {
            //echo $value['_id'];
        }
        $user = DB::connection('mongodb')->collection('users')->where('name', 'feiteng')->first();
        debug($user);
    }

    /**
     * 测试docker的计划任务
     * @return Null
     */
    public function testCrontab()
    {
       Log::notice('just test the crontab!');
    }

    /**
     * 测试docker的队列 avslxvemjlcubafg
     * @return Job
     */
    public function testjobs()
    {

    }

    /**
     * 发送邮件 队列
     * @param $receiver string 接收人
     * @param $subject string 主题（邮件标题）
     * @param string $data mix 邮件正文
     * @param null $attach string 附件地址
     * @param $mailType string 邮件类型
     */
    public function emailqueue()
    {
        $aa = DB::connection('mysql')->select('select * from `failed_jobs` order by `id` desc');
        //debug($aa);
        $date = date('Y-m-d');
        $info = DB::connection('mongodb')->collection('users')->where('name', 'feiteng')->first();
        if (!empty($info)) {
            $data = array('view' => 'email.fermi', 'view_data' => array('name' => $info['name']));
            //$url = public_path('images/zoo.jpg');
            $job = new SendEmail($info['email'], '邮件队列测试', $data);
            $this->dispatch($job->onQueue('email'));
            \Log::info("邮件队列创建成功");
        } else {
            \Log::info("邮件队列创建失败：今天没有人过生日！");
        }
    }
}
