<?php
//define your token
//写入微信公众号设置的TOKEN值
define("TOKEN", "jcai12321jcai");
//实例化对象
$wechatObj = new wechatCallbackapiTest();
//①验证成功后,注释验证valid(),
$wechatObj->valid();
//②开启自动回复功能
//$wechatObj->responseMsg();

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }
    public function responseMsg()
    {
		//get post data, May be due to the different environments
		//接收用户通过微信客户端发来的XML格式数据
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
				//防止XML外部实体注入，最好的办法是自己来检查XML的有效性
                libxml_disable_entity_loader(true);
				//通过simplexml对XML数据进行XML解析
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
				//发来者:手机端,FromUserName发送方帐号（一个OpenID）
                $fromUsername = $postObj->FromUserName;
				//接收者:微信公众平台
                $toUsername = $postObj->ToUserName;
                //发来的信息类型
                $msgType = trim($postObj->MsgType);
				//发来的关键词:trim()—去除字符串首尾处的空白字符（或者其他字符） 
                $keyword = trim($postObj->Content);
                //发来的地理位置信息
                $location = $postObj->Label;
                //接收的经纬度
                //$latitude = round($latitude,2);//纬度,保留2小数
                $latitude = sprintf('%.2f',$postObj->Location_X);//纬度,保留2小数
                $longitude = sprintf('%.2f',$postObj->Location_Y);//经度
				//时间戳
                //var_dump($postObj);
				//菜单点击时接收event，eventkey,--消息msgType类型为event
				$event = $postObj->Event;//事件类型，CLICK,关注时subscribe
				$eventKey = $postObj->EventKey;//事件KEY值，与自定义菜单接口中KEY值对应
                $time = time();
				//公众号回应用户的文本回复模板,
                //1，文本消息
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
                //2，图文消息
                $newsTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <ArticleCount>%s</ArticleCount>
                            %s
                            </xml>";
	/*****************可以用switch语句选择$msgType类型****************/
				if($msgType == "text"){
					if(!empty( $keyword )){
                        $pcKeyword = array('PC','pc','图文','?','？','211','211拼车','拼车');
                        if(in_array($keyword,$pcKeyword)){
                            //回复类型
                            $msgType = "news";
                            $count = 4;
                            $str = "<Articles>";
                            $str .= "<item>
                                        <Title><![CDATA[* 回梅州就上梅州211拼车 *]]></Title>
                                        <Description><![CDATA[一起回梅州]]></Description>
                                        <PicUrl><![CDATA[http://pc.mz211.com/PinChe/Public/Home/images/wxHead.jpg]]></PicUrl>
                                        <Url><![CDATA[http://pc.mz211.com]]></Url>
                                    </item>";
                            $str .= "<item>
                                        <Title><![CDATA[ 车主找乘客 ]]></Title>
                                        <Description><![CDATA[我要找车主！]]></Description>
                                        <PicUrl><![CDATA[]]></PicUrl>
                                        <Url><![CDATA[http://pc.mz211.com/Index/index.html]]></Url>
                                    </item>";
                            $str .= "<item>
                                        <Title><![CDATA[ 乘客找顺风车 ]]></Title>
                                        <Description><![CDATA[我要找乘客！]]></Description>
                                        <PicUrl><![CDATA[]]></PicUrl>
                                        <Url><![CDATA[http://pc.mz211.com/Index/indexp.html]]></Url>
                                    </item>";
                           $str .= "<item>
                                        <Title><![CDATA[ 登录入口 ]]></Title>
                                        <Description><![CDATA[我要找乘客！]]></Description>
                                        <PicUrl><![CDATA[]]></PicUrl>
                                        <Url><![CDATA[http://pc.mz211.com/Login/login.html]]></Url>
                                    </item>";
                            $str .= "</Articles>";
                            $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType, $count, $str);
                            echo $resultStr;
                        }else if($keyword == 1 || $keyword == '帮助'){
                            $msgType = "text";
                            $contentStr = "/激动".' 点击进入梅州211拼车网 '."\n\n".'<a href="http://pc.mz211.com/Login/login.html"> 登录入口 </a>'."\n\n".'<a href="http://pc.mz211.com/Register/register.html"> 注册入口 </a>'."\n\n".'<a href="http://pc.mz211.com/"> 寻找车主 </a>'."\n\n".'<a href="http://pc.mz211.com/Index/indexp.html"> 寻找乘客 </a>'."\n\n".'<a href="http://pc.mz211.com/Index/person.html"> 个人中心 </a>';
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;
                        }else if($keyword == 2){
                            $msgType = "text";
                            $contentStr = '<a href="http://pc.mz211.com/Login/login.html"> 登录入口 </a>';
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;
                        }else if($keyword == 3){
                            $msgType = "text";
                            $contentStr = '<a href="http://pc.mz211.com/Register/register.html"> 注册入口 </a>';
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;
                        }else if($keyword == 4){
                            $msgType = "text";
                            $contentStr = '<a href="http://pc.mz211.com/"> 寻找车主 </a>';
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;
                        }else if($keyword == 5){
                            $msgType = "text";
                            $contentStr = '<a href="http://pc.mz211.com/Index/indexp.html"> 寻找乘客 </a>';
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;
                        }else if($keyword == 6){
                            $msgType = "text";
                            $contentStr = '<a href="http://pc.mz211.com/Index/person.html"> 进入个人中心 </a>';
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;
                        }else{
                            /*
                            //接入图灵机器人
                            $msgType = "text";
                            //请求地址
                            $url = "http://www.tuling123.com/openapi/api?key=c06733cf8c8bf79091f6f6a3b6d0bb73&info={$keyword}";
                            //模拟http中的get请求
                            $str = file_get_contents($url);
                            //格式化json为对象或数组
                            $json = json_decode($str);
                            //取出内容
                            $contentStr = '$ : '.$json->text;
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;
                             */
                            $msgType = "text";
                            $contentStr = "/咖啡 ".'回复以下数字获取帮助:'."\n".' 1 :帮助列表'."\n".' 2 :登录入口'."\n".' 3 :注册入口'."\n".' 4 :寻找车主'."\n".' 5 :寻找乘客'."\n".' 6 :个人中心'."\n/:ok".'或回复 : '."\n".'?,帮助,拼车,211拼车...';
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;
                        }
					}else{
						echo "";
					}
				}else if($msgType == "image"){
						$msgType = "text";
						$contentStr = "你发送的是:图片";
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						echo $resultStr;
				}else if($msgType == "voice"){
						$msgType = "text";//返回类型
						$contentStr = "你发送的是:语音";
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						echo $resultStr;					
				}else if($msgType == "video" || $msgType == "shortvideo"){
						$msgType = "text";//返回类型
						$contentStr = "你发送的是:视频";
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						echo $resultStr;					
				}else if($msgType == "location"){
                    $msgType = "text";//返回类型
                    $contentStr = '你的位置是：'.$location."\n".'经度：'.$longitude."\n".'纬度：'.$latitude;
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;		
				}else if($msgType == "event"){
					if($event == 'subscribe'){
						//用户关注公众号
                            $msgType = "news";
                            $count = 4;
                            $str = "<Articles>";
                            $str .= "<item>
                                        <Title><![CDATA[欢迎关注梅州211拼车官方微信平台，点击注册发布拼车信息！]]></Title>
                                        <Description><![CDATA[一起回梅州]]></Description>
                                        <PicUrl><![CDATA[http://pc.mz211.com/PinChe/Public/Home/images/wxHead.jpg]]></PicUrl>
                                        <Url><![CDATA[http://pc.mz211.com/Register/register.html]]></Url>
                                    </item>";
                            $str .= "<item>
                                        <Title><![CDATA[ 车主找乘客 ]]></Title>
                                        <Description><![CDATA[我要找车主！]]></Description>
                                        <PicUrl><![CDATA[]]></PicUrl>
                                        <Url><![CDATA[http://pc.mz211.com/Index/index.html]]></Url>
                                    </item>";
                            $str .= "<item>
                                        <Title><![CDATA[ 乘客找顺风车 ]]></Title>
                                        <Description><![CDATA[我要找乘客！]]></Description>
                                        <PicUrl><![CDATA[]]></PicUrl>
                                        <Url><![CDATA[http://pc.mz211.com/Index/indexp.html]]></Url>
                                    </item>";
                           $str .= "<item>
                                        <Title><![CDATA[ 登录入口 ]]></Title>
                                        <Description><![CDATA[登录入口！]]></Description>
                                        <PicUrl><![CDATA[]]></PicUrl>
                                        <Url><![CDATA[http://pc.mz211.com/Login/login.html]]></Url>
                                    </item>";
                            $str .= "</Articles>";
                            $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType, $count, $str);
                            echo $resultStr;
					}else if($event == 'unsubscribe'){
						//取消关注公众号，做帐号的解绑
						echo '';
						exit();
					}else if($event == 'CLICK'){//CLICK需大写
						if($eventKey == 'gethelp'){//判断点击了那个键
                            $msgType = "news";
                            $count = 4;
                            $str = "<Articles>";
                            $str .= "<item>
                                        <Title><![CDATA[* 回梅州就上梅州211拼车 *]]></Title>
                                        <Description><![CDATA[一起回梅州]]></Description>
                                        <PicUrl><![CDATA[http://pc.mz211.com/PinChe/Public/Home/images/wxHead.jpg]]></PicUrl>
                                        <Url><![CDATA[http://pc.mz211.com]]></Url>
                                    </item>";
                            $str .= "<item>
                                        <Title><![CDATA[ 车主找乘客 ]]></Title>
                                        <Description><![CDATA[我要找车主！]]></Description>
                                        <PicUrl><![CDATA[]]></PicUrl>
                                        <Url><![CDATA[http://pc.mz211.com/Index/index.html]]></Url>
                                    </item>";
                            $str .= "<item>
                                        <Title><![CDATA[ 乘客找顺风车 ]]></Title>
                                        <Description><![CDATA[我要找乘客！]]></Description>
                                        <PicUrl><![CDATA[]]></PicUrl>
                                        <Url><![CDATA[http://pc.mz211.com/Index/indexp.html]]></Url>
                                    </item>";
                           $str .= "<item>
                                        <Title><![CDATA[ 登录入口 ]]></Title>
                                        <Description><![CDATA[我要找乘客！]]></Description>
                                        <PicUrl><![CDATA[]]></PicUrl>
                                        <Url><![CDATA[http://pc.mz211.com/Login/login.html]]></Url>
                                    </item>";
                            $str .= "</Articles>";
                            $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType, $count, $str);
                            echo $resultStr;
						}
					}
                    		
				}
                //echo sprintf($textTpl, $fromUsername, $toUsername, $time, 'text', 'location Error!');
        }else{
			//出错了
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")){
            throw new Exception('TOKEN is not defined!');
        }
        //接收签名
        $signature = $_GET["signature"];
		//接收时间戳
        $timestamp = $_GET["timestamp"];
		//接收随机数
        $nonce = $_GET["nonce"];        		
		$token = TOKEN;
		//把3个变量组成数组
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		//通过字典法排序
		sort($tmpArr, SORT_STRING);
		//排序后把数组组成字符串
		$tmpStr = implode( $tmpArr );
		//通过哈希算法加密
		$tmpStr = sha1( $tmpStr );
		//把加密后的值与接收的签名比对判断是否正确
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}
?>