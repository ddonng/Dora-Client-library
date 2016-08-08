<?php
namespace DoraClient;

class Library
{
    private static $client = null;

    public function __construct($config)
    {
        self::$client = new \DoraRPC\Client($config);
    }

    //
    private function extract_sync_res($result)
    {
        return $result['data']['data']['data'];
    }

    private function extract_async_status($result)
    {
        if($result['code']=='0'){
            $code = $result['data']['code'];
            if($code == 100001 )
            {
                return true;
            }
        }
        return false;

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
        return $this->extract_sync_res($result);
    }

    public function checkUserLoginInfo($loginType,$loginName,$passwd)
    {
        $this->setGroup("core_group");

        $result = self::$client->singleAPI(
            "checkUserLoginInfo",
            array("loginType"=>$loginType,"loginName"=>$loginName,"password"=>$passwd),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1);
        return $this->extract_sync_res($result);
    }

    public function getUserById($userId)
    {
        $this->setGroup("core_group");

        $result = self::$client->singleAPI(
            "getUserById",
            array("user_id"=>$userId),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );

        return $this->extract_sync_res($result);

    }

    public function addUser($user)
    {
        $this->setGroup("core_group");

        $result = self::$client->singleAPI(
            "addUser",
            array("user"=>$user),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );

        return $this->extract_sync_res($result);
    }

    public function updateUser($user)
    {
        $this->setGroup("core_group");

        $result = self::$client->singleAPI(
            "updateUser",
            array("user"=>$user),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );

        return $this->extract_sync_res($result);

    }

    public function deleteUser($userId)
    {
        $this->setGroup("core_group");

        $result = self::$client->singleAPI(
            "deleteUser",
            array("user_id"=>$userId),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );
        return $this->extract_sync_res($result);
    }

    public function getUsers($fields="")
    {
        $this->setGroup("core_group");

        $result = self::$client->singleAPI(
            "getUsers",
            array("fields"=>$fields),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );

        return $this->extract_sync_res($result);
    }

    public function getInstitutions()
    {
        $this->setGroup("core_group");
        $result = self::$client->singleAPI(
            "getInstitutions",array(),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );
        return $this->extract_sync_res($result);
    }

    public function getDepartments()
    {
        $this->setGroup("core_group");
        $result = self::$client->singleAPI(
            "getDepartments",array(),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );
        return $this->extract_sync_res($result);
    }

    public function getInstitutionById($institution_id)
    {
        $this->setGroup("core_group");
        $result = self::$client->singleAPI(
            "getInstitutionById",
            array("institution_id"=>$institution_id),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );
        return $this->extract_sync_res($result);
    }

    public function getDepartmentById($department_id)
    {
        $this->setGroup("core_group");
        $result = self::$client->singleAPI(
            "getDepartmentById",
            array("department_id"=>$department_id),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );
        return $this->extract_sync_res($result);
    }

    public function addInstitution($institution_name,$institution_desc="")
    {
        $this->setGroup("core_group");

        $param = array();
        $param['institution_name'] = $institution_name;
        if($institution_desc !=''){
            $param['institution_desc'] = $institution_desc;
        }

        $result = self::$client->singleAPI(
            "addInstitution", $param,
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );
        return $this->extract_sync_res($result);
    }

    public function addDepartment($department_name,$institution_id,$department_desc='')
    {
        $this->setGroup("core_group");
        $param = array();
        $param['department_name'] = $department_name;
        $param['institution_id'] = $institution_id;
        if($department_desc !=''){
            $param['department_desc'] = $department_desc;
        }
        $result = self::$client->singleAPI(
            "addDepartment",$param,
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );
        return $this->extract_sync_res($result);
    }

/*********************** OAuth2 Group ************/

    public function getTokenDetail($token)
    {
        $this->setGroup("oauth_group");
        $result = self::$client->singleAPI(
            "getTokenDetail",
            array("token"=>$token),
            \DoraRPC\DoraConst::SW_MODE_WAITRESULT, 1
        );

        return $this->extract_sync_res($result);
    }


/*********************** Message Group ************/

    public function sendSMS($mobile_phone, $type, $content_keys, $sign="")
    {
        $this->setGroup("msg_group");
        $result = self::$client->singleAPI(
            "sendSMS",
            array(
                "mobile_phone"=>$mobile_phone,
                "type"=>$type,
                "content_keys"=>$content_keys,
                "sign"=>$sign,
            ),
            \DoraRPC\DoraConst::SW_MODE_NORESULT
        );

        return $this->extract_async_status($result);
    }

    /**
     * Array vars:
     * array(
     *     "to" => array('test@ifaxin.com'),
     *     "sub" => array("%user_name%" => Array('123456'))
     * )
     * 此为async
	 */

    public function sendEmail($templateName,$vars = array())
    {
        $this->setGroup("msg_group");

        $result = self::$client->singleAPI(
            "sendEmail",
            array(
                "templateName"=>$templateName,
                "email_vars" =>$vars
            ),
            \DoraRPC\DoraConst::SW_MODE_NORESULT
        );

        return $this->extract_async_status($result);
    }



}
