<?php
include "satellite.php";
include "location.php";
include "commonsearch.php";
include "news.php";
include "userStatus.php";
include "image.php";
//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();  
$wechatObj->responseMsg();

class wechatCallbackapiTest
{

    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature())
        {
          echo $echoStr;
          //exit;
        }
    }

    public function responseMsg()
    {
	 //get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
        if (!empty($postStr))
        {
                
              	      $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                      $userS =new user();
                      $userS->changeUserStatus($postObj);

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
                      if($postObj->MsgType == "text" && !empty( $keyword ) ) //针对文本信息
                      {

                         if (strpos($keyword,"#提问#") !== false && strlen($keyword)>16 )
                              $contentStr = "thx,we will reply as soon as possible!";
                         elseif (strlen($keyword)==1)
                              $contentStr = $this->responseSimpleCommand($keyword);
						  
                         elseif (strpos($keyword,"#s") !== false && strlen($keyword)>3 )
                         {
                              $cs = new commonsearch();
                              $cs->responseSearch($postObj);
                              exit;
		                 }	  
		                 elseif (strtolower(trim($keyword)) == "news" )
                         {
                               $ns = new news();
		                       $ns->responseNews($postObj);
                         }
                         elseif (strtolower(trim($keyword)) == "sat" )
                         {
                                $sat  = new satelliteSearch();
                                $sat->response($postObj);
                                exit;
                         }
						 elseif (strtolower(trim($keyword)) == "loc" )
                         {
						        $loc = new location();
                                $loc->PositionMap($postObj);
                                exit;
                         }
						 elseif (strtolower(trim($keyword)) == "ms" )
                         {
						        $loc = new location();
                                $loc->MapService($postObj);
                                exit;
                         }
		                 else 
		                 {
                                 $contentStr = "Welcome to RS interest group!\n".
                                  "我们正在开发相关功能，敬请期待\n".
                                  "回复n，查询当前活动参与人数\n".
                                  "回复e，查询近期活动\n".
                                  "回复s，查询联系人信息\n".
                                  "回复t，查询当前可选任务信息\n".
                                  "回复news，查询最近推送的信息\n".
                                  "回复m，查询功能菜单\n".
                                  "回复x，查询项目组所有妹子三围\n";
                	      
			             }
					      
                                        
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
					exit;
           }
	       elseif ($postObj->MsgType == "location")    //针对地理信息
		   {
                   $loc = new location();
                   $loc->responseLatLng($postObj);
                   exit;
           }
           elseif ($postObj->MsgType == "image")
           {
		            $img = new image();
					$img->uploadImg($postObj);
                    exit;
           }
                   

        }
        else 
        {
                echo "";
        	exit;
        }
    }
	
    public function responseSimpleCommand($keyword)
	{
	                if (strtolower($keyword) == "n")
                    {
                       $contentStr = "当前报名人数为27人Θ▽Θ";
                    }
                    elseif (strtolower($keyword) == "e")
                    {
                      $contentStr = "各组即将组织组会，参与人员为该组相关和同学，目前正在联系";
                    }
                    elseif (strtolower($keyword) == "s")
                    {
                       $contentStr = "彭剑威 [pengjw@whu.edu.cn QQ 405962293 博一 973项目组]\n".
                                     "黄 润  [runhuang@whu.edu.cn QQ 849993441 硕一 路网项目组]\n".
                                     "谢曹东 [xcd@whu.edu.cn QQ 674089054 大四，街景项目组]";
                    }
                    elseif (strtolower($keyword) == "t")
                    {
                        $contentStr="1 Osm 的数据（Osm：OpenStreetMap）\n".
	                                "2 地面测量车数据进行建筑物三维建模方向 \n".
	                                "3 众源影像的采集\n".
	                                "4  （众源影像）预处理、超分辨率重建\n".
	                                "5 街景影像的二次开发（移动与桌面平台的各种LBS应用开发）\n".
	                                "6 缺乏纹理区域的三维建模\n".
	                                "7 GPU并行计算\n".
	                                "8 多视角密集匹配，Multi-view Dense Matching\n".
	                                "9 点云和影像结合的三维房屋建模\n".
	                                "10 基于众源数据的人类活动的分析、建模\n"; 
                       
                    }
                    elseif (strtolower($keyword) == "x")
                    {
                       $contentStr = "Don't be stupid..you know that's not gonna happen..";
                    }
                    elseif (strtolower($keyword) == "m")
                    {
                       $contentStr = "*上传地理位置，返回所在地google卫星影像\n\n".
					                 "*回复loc，打开地图点击查询经纬度\n\n".
									 "*回复MS,进入地图服务\n\n".
                                     "*包含格式{#s yourKeyword},实现多平台搜索反馈 e.g: #s PCA\n\n".
                                     "*包含格式{#提问#},我们将保证您的问题三天内得到人工回复";
                    }
					else
                    {
                       $contentStr = "Welcome to RS interest group!\n".
                          "我们正在开发相关功能，敬请期待\n".
                          "回复n，查询当前活动参与人数\n".
                          "回复e，查询近期活动\n".
                          "回复s，查询联系人信息\n".
                          "回复t，查询当前可选任务信息\n".
                          "回复news，查询最近推送的信息\n".
                          "回复m，查询功能菜单\n".
                          "回复x，查询项目组所有妹子三围\n";                 
                    }
					return $contentStr;
	}

	

    private function checkSignature()
    {
            $signature = $_GET["signature"];
            $timestamp = $_GET["timestamp"];
            $nonce = $_GET["nonce"];	

            $token = TOKEN;
            $tmpArr = array($token, $timestamp, $nonce);
            sort($tmpArr);
            $tmpStr = implode( $tmpArr );
            $tmpStr = sha1( $tmpStr );

            if( $tmpStr == $signature ){
                    return true;
            }else{
                    return false;
            }
    }
}

?>