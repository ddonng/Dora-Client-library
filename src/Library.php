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
        // return $result;
        return $result['data']['data']['data'];
    }

    private function extract_async_status($result)
    {
        // return $result;
        if($result['code']=='0'){
            //异常错误
// Warning: swoole_client::recv(): recv() failed. Error: Resource temporarily unavailable [11] in /var/www/html/vendor/xcl3721/dora-rpc/src/Client.php on line 515
// array(3) { ["code"]=> int(0) ["msg"]=> string(2) "OK" ["data"]=> array(1) { ["97666928f23cd82301051df4e58e2c3f"]=> array(3) { ["code"]=> int(100009) ["msg"]=> string(27) "the recive wrong or timeout" ["data"]=> array(0) { } } } }
            if(!isset($result['data']['code']))
            {
                var_export($result['data']);
            }else{
                $code = $result['data']['code'];
                if($code == 100001 )
                {
                    return true;
                }
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

    public function async_htmltopdf($type,$url,$fileName='')
    {
        $this->setGroup("pdf_group");
        if($fileName == '')
            $fileName = time().\Phalcon\Text::random(\Phalcon\Text::RANDOM_NUMERIC,4);
        $category = date("Y")."/".date("m");
        $result = self::$client->singleAPI(
            "async_htmltopdf",
            array(
                "url"=>$url,
                "type"=>$type,
                "category"=>$category,  //not need slash /
                "fileName"=>$fileName
            ),
            \DoraRPC\DoraConst::SW_MODE_NORESULT
        );

        $stat = $this->extract_async_status($result);
        if($stat){
            //发送成功，返回uri
            $uri = $type . "/pdf/" . $category . "/" . $fileName;
            return $uri;
        }else{
            return false;
        }
    }

    public function async_htmltoimage($type,$url,$fileName='')
    {
        $this->setGroup("pdf_group");
        if($fileName == '')
            $fileName = time().\Phalcon\Text::random(\Phalcon\Text::RANDOM_NUMERIC,4);

        $category = date("Y")."/".date("m");
        $result = self::$client->singleAPI(
            "async_htmltoimage",
            array(
                "url"=>$url,
                "type"=>$type,
                "category"=>$category,  //not need slash /
                "fileName"=>$fileName
            ),
            \DoraRPC\DoraConst::SW_MODE_NORESULT
        );

        $stat = $this->extract_async_status($result);
        if($stat){
            //发送成功，返回uri
            $uri = $type . "/image/" . $category . "/" . $fileName;
            return $uri;
        }else{
            return false;
        }


    }

    /**
 	 * 同步方式的文档转换,文档会转换后直接存放与源文件同目录
 	 * @param extension 文档的拓展名，doc或docx
	 */
     public function async_doctopdf($extension,$relativePath,$fileName)
     {
         $this->setGroup("pdf_group");
         $result = self::$client->singleAPI(
             "async_doctopdf",
             array(
                 "extension"=>$extension,
                 'relativePath'=>$relativePath,
                 'fileName'=>$fileName
             ),
             \DoraRPC\DoraConst::SW_MODE_NORESULT
         );

         return $this->extract_async_status($result);

     }

     public function sync_doctopdf($extension,$relativePath,$fileName)
     {
         $this->setGroup("pdf_group");
         $result = self::$client->singleAPI(
             "sync_doctopdf",
             array(
                 "extension"=>$extension,
                 'relativePath'=>$relativePath,
                 'fileName'=>$fileName
             ),
             \DoraRPC\DoraConst::SW_MODE_WAITRESULT
         );

         return $this->extract_sync_res($result);

     }

}
