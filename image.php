<?php


//upload location

class image
{
   
    public function uploadImg($postObj)
	{
	    $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
	    $msgType = "text"; //初始化为文本回复
        $time = time();
	    //$textTpl为消息格式模板
        $textTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
	    <FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<Content><![CDATA[%s]]></Content>
		<FuncFlag>0</FuncFlag>
		</xml>"; 
      
      
      
	     $url = $postObj->PicUrl;
         $path="./img/"; //保存路径 
         if(!file_exists($path))        
         {        
           //检查是否有该文件夹，如果没有就创建，并给予最高权限        
            mkdir("$path", 0700);        
         } 	 
  
         $filename=$path.'sd.png';        
       
         ob_start();        
         readfile($url);        
         $img = ob_get_contents();        
         ob_end_clean();        
         $size = strlen($img);        
       
         $fp2=@fopen($filename, "a");        
         fwrite($fp2,$img);        
         fclose($fp2);  
         
         $contentStr =$filename;
         $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
         echo $resultStr;
	}
		
}

?>