<?php
namespace DoraClient;

class Library
{
    private static $client = null;

    public function __construct($config)
    {
        self::client = new \DoraRPC\Client($config);
    }

    private function coreGroup()
    {
        $mode = array("type" => 1, "group" => "core_group");
        self::client->changeMode($mode);
    }


    public function checkLoginName($lname)
    {
        $this->coreGroup();
        $result = self::client->singleAPI("checkLoginName",array("login_type"=>"email","login_name"=>"ddonng@qq.com"),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1);
        return $result;
    }

}
