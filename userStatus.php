<?php


//user status changed ----   db--table user

class user
{
   
    public function changeUserStatus($postObj)
	{
	
	   $userID = $postObj->FromUserName;
	   $time = date('Y-m-d H:i:s',time());
	
	   //从平台获取查询要连接的数据库名称
       $dbname = 'qLJDhmshfyEjTiNFGeVg';
 
       //从环境变量里取出数据库连接需要的参数
       $host = getenv('HTTP_BAE_ENV_ADDR_SQL_IP');
       $port = getenv('HTTP_BAE_ENV_ADDR_SQL_PORT');
       $user = getenv('HTTP_BAE_ENV_AK');
       $pwd = getenv('HTTP_BAE_ENV_SK');
 
       //接着调用mysql_connect()连接服务器
       $link = @mysql_connect("{$host}:{$port}",$user,$pwd,true);
       if(!$link) 
	   {
          die("Connect Server Failed: " . mysql_error($link));
       }
       /*连接成功后立即调用mysql_select_db()选中需要连接的数据库*/
       if(!mysql_select_db($dbname,$link)) 
	   {
          die("Select Database Failed: " . mysql_error($link));
       }
       //建立连接完毕
	   $result = mysql_query("SELECT * FROM user WHERE userID = '$userID' ",$link);
	   if($result)//判断结果集是否存在 
	   {                
          if($row = mysql_fetch_array($result))  //存在数据
		  {
		  
            $count= $row['responseNum']+1;
			if ($postObj->MsgType == "location")
			{
			   $lat =  $postObj->Location_X;
		       $lng =  $postObj->Location_Y;
			    mysql_query("UPDATE user SET lastLoginTime = '$time',responseNum='$count',
                           lastLoginLat= '$lat',lastLoginLng= '$lng'  			   
			               WHERE  userID = '$userID' ",$link);
		    }
			else
			{
                mysql_query("UPDATE user SET lastLoginTime = '$time',responseNum='$count' 
			               WHERE  userID = '$userID' ",$link);
			}
             
          }   
          else //没有数据
		  { 
               mysql_query("INSERT INTO user (userID, responseNum,lastLoginTime,serviceName) 
               VALUES ('$userID', 1, '$time','n')"); 
          }
	   }//查询是否正常
	    
       
 
       /*显示关闭连接，非必须*/
       mysql_close($link);
	  
	}
		
		
}

?>