<?php


//upload location

class location
{

       public  $picTpl = "<xml>
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
					
       public   $msgType = "news";
   
    public function responseLatLng($postObj)
	{
	   $fromUsername = $postObj->FromUserName;
       $toUsername = $postObj->ToUserName;
	   $lat =  $postObj->Location_X;
	   $lng =  $postObj->Location_Y;
 	

	   $time = time();
	   $title = "Google Satellite Map";
	   $dspt = "google satellite map of your location!\n".
	           "栅格影像在遥感科学中是一种非常重要的数据\n".
			   "大多以规则格网作为基本形式，而GoogleMap以多级影像金字塔拼接的方式构成最终的产品";
	   $picurl = "http://maps.googleapis.com/maps/api/staticmap?center=".$lat.",".$lng."&zoom=14&size=400x400&maptype=satellite&sensor=false";
	   $url = "http://en.wikipedia.org/wiki/Google_map";
	   $resultStr = sprintf($this->picTpl, $fromUsername, $toUsername, $time, $this->msgType, $title,$dspt,$picurl,$url);
	   echo $resultStr;
	   
	}
	
	public function PositionMap($postObj)
	{
	   $fromUsername = $postObj->FromUserName;
       $toUsername = $postObj->ToUserName;
	   $time = time();
	   
	   $title = "Get the geographic coordinate";
	   $dspt = "Click on the map!\n".
	           "and you'll get the latitude & longitude of this point";
	   $picurl = "http://b.hiphotos.baidu.com/album/whcrop=355,117;q=90/sign=107d9b52203fb80e0c84379559a1121d/a71ea8d3fd1f4134869e921d241f95cad1c85e23.jpg";
	   $url = "http://rsinfopush.duapp.com/position.html";
	   $resultStr = sprintf($this->picTpl, $fromUsername, $toUsername, $time, $this->msgType, $title,$dspt,$picurl,$url);
	   echo $resultStr;
	   
	}
	
	public function MapService($postObj)
	{
	   $fromUsername = $postObj->FromUserName;
       $toUsername = $postObj->ToUserName;
	   $time = time();
	   
	   $title = "Map Service For Your Daily Life";
	   $dspt = "now the time is: ".date('Y-m-d H:i:s',$time)."\n".
	           "click the marker on the map & get more info\n".
			   "have a good day";
	   $picurl = "http://g.hiphotos.baidu.com/album/whcrop%3D270%2C102%3Bq%3D90/sign=dd72c683f603918fd7846b883e4d1ba5/c75c10385343fbf20c443740b17eca8065388f6d.jpg";
	   $url = "http://rsinfopush.duapp.com/BMap.html";
	   $resultStr = sprintf($this->picTpl, $fromUsername, $toUsername, $time, $this->msgType, $title,$dspt,$picurl,$url);
	   echo $resultStr;
	   
	}
    
		
}

?>