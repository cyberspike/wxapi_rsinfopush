<?php


//search satellite info


class satelliteSearch
{

    public function response($postObj)
	{
	    $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
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
		$contentStr="";		
		$xml = simplexml_load_file("satelliteList.xml");
        foreach ($xml->children() as $node)
        {
		   $id = "";  $name = "";
		   foreach ($node->children() as $subnode)
		   {
		       if ($subnode->getName() == "id")
			      $id = $subnode;
			   if ($subnode->getName() == "name")
			      $name = $subnode;
		   }
		   $contentStr = $contentStr."回复编号".$id.","."查看".$name."参数\n";
        }		
					
			                                        
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        echo $resultStr;
		
	}
    
		
}

?>