<?php
namespace DoraClient;

class Library
{
    private static $client = null;

    public function __construct($config)
    {
        self::$client = new \DoraRPC\Client($config);
    }


    private function extract_res($result)
    {

        return $result['data']['data']['data'];
    }

    private function setGroup($group)
    {
        $mode = array("type" => 1, "group" => $group);
        self::$client->changeMode($mode);
    }


    public function checkLoginName($loginType,$loginName)
    {
        $this->setGroup("core_group");
        $result = self::$client->singleAPI(
            "checkLoginName",
            array("loginType"=>$loginType,"loginName"=>$loginName),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1);
        return $this->extract_res($result);
    }

    public function checkUserLoginInfo($loginType,$loginName,$passwd)
    {
        $this->setGroup("core_group");

        $result = self::$client->singleAPI(
            "checkUserLoginInfo",
            array("loginType"=>$loginType,"loginName"=>$loginName,"password"=>$passwd),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1);
        return $this->extract_res($result);
    }

    public function getUserById($userId)
    {
        $this->setGroup("core_group");

        $result = self::$client->singleAPI(
            "getUserById",
            array("user_id"=>$userId),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );

        return $this->extract_res($result);

    }

    public function addUser($user)
    {
        $this->setGroup("core_group");

        $result = self::$client->singleAPI(
            "addUser",
            array("user"=>$user),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );

        return $this->extract_res($result);
    }

    public function updateUser($user)
    {
        $this->setGroup("core_group");

        $result = self::$client->singleAPI(
            "updateUser",
            array("user"=>$user),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );

        return $this->extract_res($result);

    }

    public function deleteUser($userId)
    {
        $this->setGroup("core_group");

        $result = self::$client->singleAPI(
            "deleteUser",
            array("user_id"=>$userId),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );
        return $this->extract_res($result);
    }

    public function getUsers($fields="")
    {
        $this->setGroup("core_group");

        $result = self::$client->singleAPI(
            "getUsers",
            array("fields"=>$fields),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );

        return $this->extract_res($result);
    }

    public function getTokenDetail($token)
    {
        $this->setGroup("oauth_group");
        $result = self::$client->singleAPI(
            "getTokenDetail",
            array("token"=>$token),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );

        return $this->extract_res($result);
    }



}
