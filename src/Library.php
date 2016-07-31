<?php
namespace DoraClient;

class Library
{
    private static $client = null;

    public function __construct($config)
    {
        $this->client = new \DoraRPC\Client($config);
    }

    private function coreGroup()
    {
        $mode = array("type" => 1, "group" => "core_group");
        $this->client->changeMode($mode);
    }


    public function checkLoginName($lname)
    {
        $this->coreGroup();
        $result = $this->client->singleAPI("checkLoginName",array("login_type"=>"email","login_name"=>"ddonng@qq.com"),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1);
        return $result;
    }

}
