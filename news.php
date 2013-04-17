<?php


//upload location

class news
{
   
    public function responseNews($postObj)
	{
	    $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
 	    $picTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
			        <ArticleCount>1</ArticleCount>
                    <Articles>
                    <item>
                    <Title><![CDATA[%s]]></Title> 
                    <Description><![CDATA[%s]]></Description>
                    <PicUrl><![CDATA[%s]]></PicUrl>
                    <Url><![CDATA[%s]]></Url>
                    </item>
                    </Articles>
                    <FuncFlag>1</FuncFlag>
				    </xml>";
	   $msgType = "news";
	   $time = time();
	   $title = "#微科普# MOOC是个好东西，但仍需努力";
	   $dspt = "MOOC科普，详情请点击\n";
	   $picurl = "http://mmsns.qpic.cn/mmsns/toelWQyJ4T0aE0d9uoTHUlSvj0kV7awdgfQofZV3Crx1TJvvDRJZ3g/0";
	   $url = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDU0MDcyMQ==&appmsgid=10000006&itemidx=1#wechat_redirect";
	   $resultStr = sprintf($picTpl, $fromUsername, $toUsername, $time, $msgType, $title,$dspt,$picurl,$url);
	   echo $resultStr;
	  
	}
		
}

?>