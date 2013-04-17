<?php


//common search

class commonsearch
{
   
   public function responseSearch($postObj)
	{
	    $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
		$rawStr = $postObj->Content;
		$start = strpos($rawStr,"#s")+2;
        $kw =  substr($rawStr,$start,strlen($rawStr)-$start);
		$kw = strtolower(trim($kw));
		$kw = urlencode($kw);
 	    $picTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
			        <ArticleCount>4</ArticleCount>
                    <Articles>
                    <item>                                        
                    <Title><![CDATA[%s]]></Title> 
                    <Description><![CDATA[%s]]></Description>
                    <PicUrl><![CDATA[%s]]></PicUrl>
                    <Url><![CDATA[%s]]></Url>
                    </item>
					<item>
                    <Title><![CDATA[%s]]></Title> 
                    <Description><![CDATA[%s]]></Description>
                    <PicUrl><![CDATA[%s]]></PicUrl>
                    <Url><![CDATA[%s]]></Url>
                    </item>
					<item>
                    <Title><![CDATA[%s]]></Title> 
                    <Description><![CDATA[%s]]></Description>
                    <PicUrl><![CDATA[%s]]></PicUrl>
                    <Url><![CDATA[%s]]></Url>
                    </item>
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
	   $title1 = "Search Results from Wiki"; $title2= "from wolfram_alpha"; $title3= "from guokr"; $title4= "from zhihu";
       $dspt1 = "results in wiki"; $dspt2 = "results in WA"; $dspt3 = "results in guokr"; $dspt4 = "results in zhihu";  
	   
	   $u1 = "http://en.wikipedia.org/wiki/".$kw;
	   $u2 = "http://www.wolframalpha.com/input/?i=".$kw;
	   $u3 = "http://www.guokr.com/search/all/?wd=".$kw;
	   $u4 = "http://www.zhihu.com/search?q=".$kw;
	   
	   $pu1 = "http://e.hiphotos.baidu.com/album/s%3D255%3Bq%3D90/sign=6251ecf44bed2e73f8e98129b23ad0b6/e4dde71190ef76c6f3c4f85b9c16fdfaaf5167af.jpg";
	   $pu2 = "http://a.hiphotos.baidu.com/album/whcrop%3D389%2C70%3Bq%3D90/sign=7cdf07edcaef76093c5ecfdd41ad9eff/9358d109b3de9c82a173faff6d81800a19d843af.jpg";
	   $pu3 = "http://b.hiphotos.baidu.com/album/whcrop%3D170%2C61%3Bq%3D90/sign=a251b141a08b87d65017fd5d68781509/bf096b63f6246b601d7eb104eaf81a4c510fa249.jpg";
	   $pu4 = "http://g.hiphotos.baidu.com/album/s%3D299%3Bq%3D90/sign=ff2a7cd0f703738dda4a0b2b8a20c16c/8c1001e93901213ffe254dac55e736d12f2e95af.jpg";
	   
	   $resultStr = sprintf($picTpl, $fromUsername, $toUsername, $time, $msgType, $title1,$dspt1,$pu1,$u1,
	                             $title2,$dspt2,$pu2,$u2,
                                    $title3,$dspt3,$pu3,$u3,					
                                          $title4,$dspt4,$pu4,$u4 );
	   echo $resultStr;
	   
	}
    
		
}

?>