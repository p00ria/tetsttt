<?php

define('API_KEY','204374776:AAGHFw2g4x2VmTOTPPdX2Wfmext7KI803uc');
//----######------
function makereq($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
//##############=--API_REQ
function apiRequest($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }
  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }
  foreach ($parameters as $key => &$val) {
    // encoding to JSON array parameters, for example reply_markup
    if (!is_numeric($val) && !is_string($val)) {
      $val = json_encode($val);
    }
  }
  $url = "https://api.telegram.org/bot".API_KEY."/".$method.'?'.http_build_query($parameters);
  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);
  return exec_curl_request($handle);
}
//----######------
//---------
$update = json_decode(file_get_contents('php://input'));
$banall = file_get_contents("https://codesupport.ir/pv/data/banall.txt");
var_dump($update);
//=========
$chat_id = $update->message->chat->id;
$message_id = $update->message->message_id;
$from_id = $update->message->from->id;
$name = $update->message->from->first_name;
$username = $update->message->from->username;
$textmessage = isset($update->message->text)?$update->message->text:'';
$txtmsg = $update->message->text;
$reply = $update->message->reply_to_message->forward_from->id;
$admin = 195651268;
$cht = file_get_contents("cht");
$dat = file_get_contents("http://api.codesupport.ir/td/?td=date");
$tm = file_get_contents("http://api.codesupport.ir/td/?td=time");
$stickerid = $update->message->reply_to_message->sticker->file_id;
$step = file_get_contents("data/".$from_id."/step.txt");
$userhelp = file_get_contents("userhelp");
$canreq = file_get_contents("canreq");
$time = file_get_contents("https://api.codesupport.ir/td/?td=time");
$date = file_get_contents("https://api.codesupport.ir/td?td=date");
$inchat = file_get_contents("inchat");

//-------
function SendMessage($ChatId, $TextMsg)
{
 makereq('sendMessage',[
'chat_id'=>$ChatId,
'text'=>$TextMsg,
'parse_mode'=>"MarkDown"
]);
}
function SendSticker($ChatId, $sticker_ID)
{
 makereq('sendSticker',[
'chat_id'=>$ChatId,
'sticker'=>$sticker_ID
]);
}
function Forward($KojaShe,$AzKoja,$KodomMSG)
{
makereq('ForwardMessage',[
'chat_id'=>$KojaShe,
'from_chat_id'=>$AzKoja,
'message_id'=>$KodomMSG
]);
}
function save($filename,$TXTdata)
	{
	$myfile = fopen($filename, "w") or die("Unable to open file!");
	fwrite($myfile, "$TXTdata");
	fclose($myfile);
	}
//===========
$inch = file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@PvCreators&user_id=".$from_id);
	if (strpos($banall , "$from_id") !== false  ) {
  SendMessage($chat_id,"*You Are GloballyBanned From Server.??
You Can't Use This Bot...??*
??????????
`?????? ??? ?? ??? ???? ????? ??? ???.??
??? ????????? ?? ???? ??????? ????...??`");
 }
elseif (strpos($banall , "$from_id") !== false  ) {
  SendMessage($chat_id,"");
 }

	elseif (strpos($inch , '"status":"left"') !== false ) {
SendMessage($chat_id,"???? ??????? ?? ???? ??? ?? ????? ?? ??? ????.
@PvCreators");
}
elseif (strpos($banall , "$from_id") !== false  ) {
  SendMessage($chat_id,"");
 }
       $txxt = file_get_contents('member.txt');
$pmembersid= explode("\n",$txxt);
  if (!in_array($chat_id,$pmembersid)) {
    $aaddd = file_get_contents('member.txt');
    $aaddd .= $chat_id."
";
      file_put_contents('member.txt',$aaddd);
}
    $txxtt = file_get_contents('ids');
$pmembersidd= explode("\n",$txxtt);
  if (!in_array(@$username,$pmembersidd)) {
    $aadddd = file_get_contents('ids');
    $aadddd .= @$username."
";
      file_put_contents('ids',$aadddd);
}
	elseif (strpos($inch , '"status":"left"') !== false ) {
SendMessage($chat_id,"???? ??????? ?? ???? ??? ?? ????? ?? ??? ????.
@PvCreators");
}
elseif (strpos($banall , "$from_id") !== false  ) {
  SendMessage($chat_id,"");
 }
elseif(isset($update->callback_query)){
    $callbackMessage = '';
    var_dump(makereq('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>$callbackMessage
    ]));
    $chat_id = $update->callback_query->message->chat->id;
    
    $message_id = $update->callback_query->message->message_id;
    $data = $update->callback_query->data;
    if (strpos($data, "del") !== false ) {
    $botun = str_replace("del ","",$data);
    unlink("bots/".$botun."/index.php");
    save("data/$chat_id/bots.txt","");
    save("data/$chat_id/tedad.txt","0");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"???? ??? ?? ?????? ??? ?? !",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"?? ????? ?? ????????",'url'=>"https://telegram.me/PvCreators"]
                    ]
                ]
            ])
        ])
    );
 }

 else {
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"???",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"?? ????? ?? ????????",'url'=>"https://telegram.me/PvCreators"]
                    ]
                ]
            ])
        ])
    );
 }
}

elseif ($textmessage == '?? ?????') {
save("data/$from_id/step.txt","none");
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"?? ???? ???? ???????\n?????? ????",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"?? ???? ????"],['text'=>"?????? ??? ??"]
                ],
                [
                   ['text'=>"?? ??? ????"],['text'=>"??????? ??"]
                ],
                [
                   ['text'=>"?? ??????"],['text'=>"?? ??????"],['text'=>"?????? ????"]
                ],
		[
		['text'=>"??????? ????"],['text'=>"?? ????? ???"]
		]
                ],
            	'resize_keyboard'=>true
       		])
    		]));
    		}
elseif ($step == 'delete') {
$botun = $txtmsg ;
if (file_exists("bots/".$botun."/index.php")) {

$src = file_get_contents("bots/".$botun."/index.php");

if (strpos($src , $from_id) !== false ) {
save("data/$from_id/step.txt","none");
unlink("bots/".$botun."/index.php");
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"?? ???? ??? ?? ?????? ??? ??? ??? 
?? ???? ???? ?????? ??",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"?? ???? ????"],['text'=>"?? ?????"]
                ]
                
            	],
            	'resize_keyboard'=>true
       		])
    		]));
}
else {
SendMessage($chat_id,"???!
??? ??? ?????? ??? ???? ?? ??? ???? ! ");
}
}
else {
SendMessage($chat_id,"???? ???.");
}
}
elseif ($step == 'create bot') {
$token = $textmessage ;

			$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));
			//==================
			function objectToArrays( $object ) {
				if( !is_object( $object ) && !is_array( $object ) )
				{
				return $object;
				}
				if( is_object( $object ) )
				{
				$object = get_object_vars( $object );
				}
			return array_map( "objectToArrays", $object );
			}

	$resultb = objectToArrays($userbot);
	$un = $resultb["result"]["username"];
	$ok = $resultb["ok"];
		if($ok != 1) {
			//Token Not True
			SendMessage($chat_id,"???? ?? ?????!");
		}
		else
		{
		SendMessage($chat_id,"?? ??? ???? ???? ...");
		if (file_exists("bots/$un/index.php")) {
		$source = file_get_contents("bot/index.php");
		$source = str_replace("[*BOTTOKEN*]",$token,$source);
		$source = str_replace("**admin**",$from_id,$source);
		save("bots/$un/index.php",$source);
		$textinstall = "???? ???? ???? ??? ?? ?????? ?? ???? ????????? ?? ???? /start ?? ????? ??????";
		  file_get_contents("http://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=$textinstall");
		$txxt = file_get_contents('data/bots.txt');
$pmembersid= explode("\n",$txxt);
  if (!in_array($un,$pmembersid)) {
    $aaddd = file_get_contents('data/bots.txt');
    $aaddd .= $un."
";
      file_put_contents('data/bots.txt',$aaddd);
}
		
		save("bots/$un/token.txt",$token);
		save("bots/$un/admin.txt",$from_id);
		
		file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=https://codesupport.ir/pv/bots/$un/index.php");

var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"?? ???? ?? ?????? ????????? ????
[???? ???? ?? ???? ??? ???? ???? ??](https://telegram.me/$un)",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"?? ???? ????"],['text'=>"?? ?????"]
                ]
                
            	],
            	'resize_keyboard'=>true
       		])
    		]));
		}
		else {
		save("data/$from_id/tedad.txt","0");
		save("data/$from_id/step.txt","none");
		save("data/$from_id/bots.txt","$un");
		
		mkdir("bots/$un");
		mkdir("bots/$un/data");
		mkdir("bots/$un/data/btn");
		mkdir("bots/$un/data/words");
		mkdir("bots/$un/data/profile");
		mkdir("bots/$un/data/setting");
		
		save("bots/$un/token.txt",$token);
		save("bots/$un/admin.txt",$from_id);
		
		save("bots/$un/data/blocklist.txt","");
		save("bots/$un/data/last_word.txt","");
		save("bots/$un/data/pmsend_txt.txt","Message Sent!");
		save("bots/$un/data/start_txt.txt","Hello World!");
		save("bots/$un/data/bottype.txt","free");
		save("bots/$un/data/forward_id.txt","");
		save("bots/$un/data/users.txt","$from_id\n");
		mkdir("bots/$un/data/$from_id");
		save("bots/$un/data/$from_id/type.txt","admin");
		save("bots/$un/data/$from_id/step.txt","none");
		
		save("bots/$un/data/btn/btn1_name","");
		save("bots/$un/data/btn/btn2_name","");
		save("bots/$un/data/btn/btn3_name","");
		save("bots/$un/data/btn/btn4_name","");
		
		save("bots/$un/data/btn/btn1_post","");
		save("bots/$un/data/btn/btn2_post","");
		save("bots/$un/data/btn/btn3_post","");
		save("bots/$un/data/btn/btn4_post","");
	    $myfile2 = fopen("data/bots.txt", "a") or die("Unable to open file!"); 
        fwrite($myfile2, "$un\n");
        fclose($myfile2);
		save("bots/$un/data/setting/sticker.txt","?");
		save("bots/$un/data/setting/video.txt","?");
		save("bots/$un/data/setting/voice.txt","?");
		save("bots/$un/data/setting/file.txt","?");
		save("bots/$un/data/setting/photo.txt","?");
		save("bots/$un/data/setting/music.txt","?");
		save("bots/$un/data/setting/forward.txt","?");
		save("bots/$un/data/setting/joingp.txt","?");
		
		$source = file_get_contents("bot/index.php");
		$source = str_replace("[*BOTTOKEN*]",$token,$source);
		$source = str_replace("**admin**",$from_id,$source);
		save("bots/$un/index.php",$source);	
		$textinstalls = "???? ?? ?????? ?? ???? ???? ???? ???? ?? ???? /start ?? ????? ??????";
		 file_get_contents("http://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=$textinstalls");
		file_get_contents("http://api.telegram.org/bot$token/setwebhook?url=https://codesupport.ir/pv/bots/$un/index.php");

var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"???? ?? ?????? ?? ???? ???? ???? ???? ???? 
[???? ???? ?? ???? ??? ???? ???? ??](https://telegram.me/$un)",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"?? ???? ????"],['text'=>"?? ?????"]
                ]
                
            	],
            	'resize_keyboard'=>true
       		])
    		]));
		}
}
}

elseif (strpos($textmessage , "/ungb") !== false && $chat_id == $admin) {
$result = str_replace("/ungb","",$textmessage);
$blist = str_replace($result,"",$ban);
save("data/banall.txt",$blist);
SendMessage($chat_id,"$result *unBlocked!*");
SendMessage($result,"*You Are UnGloballyBanned From Server.??
You can re-use of the Robots??*
??????????
`??????? ??? ?? ??? ???? ??? ??.??
???????? ???? ?? ???? ??????? ????...??`");
}
elseif (strpos($textmessage, "/setvip") !== false) {
$botun = str_replace("/setvip ","",$textmessage);
SendMessage($chat_id,"$textmessage");
$src = file_get_contents("bots/$botun/index.php");
$nsrc = str_replace("free","gold",$src);
save("bots/$botun/index.php",$nsrc);
SendMessage($chat_id,"Updated!");
}
elseif (strpos($textmessage , "/toall") !== false ) {
if ($from_id == $admin) {
$text = str_replace("/toall","",$textmessage);
$fp = fopen( "data/users.txt", 'r');
exit;
}
else {
SendMessage($chat_id,"You Are Not Admin");
}
}
elseif($textmessage == '?????? ??? ??')
{
$botname = file_get_contents("data/$from_id/bots.txt");
if ($botname == "") {
SendMessage($chat_id,"??? ???? ??? ????? ?????? ??? !");
return;
}
 	var_dump(makereq('sendMessage',[
	'chat_id'=>$update->message->chat->id,
	'text'=>"???? ???? ??? ??? : ",
	'parse_mode'=>'MarkDown',
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[
	['text'=>"?? @".$botname,'url'=>"https://telegram.me/".$botname]
	]
	]
	])
	]));
}
elseif($textmessage == '/bots' || $textmessage == '?? ???? ??')
if ($from_id == $admin) {
$number = count(scandir("bots"))-1;
SendMessage($chat_id,"?? ???? ??? ????? ??? : ".$number."");
}
else {
SendMessage($chat_id,"You Are Not Admin");
}
elseif ($textmessage == '/howbot') {
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"????? ???? ???? ?? ??? ???
[??????](https://telegram.me/PvCreators/7)
",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'resize_keyboard'=>true
       		])
    		]));
}
	elseif ($textmessage == '??????' && $from_id == $admin) {
	$usercount = -1;
	$fp = fopen( "data/users.txt", 'r');
	while( !feof( $fp)) {
    		fgets( $fp);
    		$usercount ++;
	}
	fclose( $fp);
	SendMessage($chat_id,"`????? ????`: `".$usercount."`");
	}
		elseif ($textmessage == '?????? ??? ????' && $from_id == $admin) {
	$botcount = -1;
	$fp = fopen( "data/bots.txt", 'r');
	while( !feof( $fp)) {
    		fgets( $fp);
    		$botcount ++;
	}
	fclose( $fp);
	SendMessage($chat_id,"`?????? ??? ????`: `".$botcount."`");
	}
elseif ($textmessage == '?? ??????') {
var_dump(makereq('sendMessage',[
          'chat_id'=>$update->message->chat->id,
          'text'=>"$name 
???? ???? ????? ???? ???? ?? ???? ???? ?????? ?? ???? ???? ?????
-------------------------------------------------------------------------------------------------------------------
?????? ????? 1= ?????? ???????? ?? ?? ???? ??????? ??? ????? ????? ??????? ???? ?????? ???? ?? ?????? ?????? ????? ?????? ? ?? ?????? ??? ???? ???? ?????? ????!

?????? ????? 2=  ?? ?? ???? ? ??????? ???? ??? ??? ????? ?????? ? ?? ??? ??????? ???????,??? ????? ????? ?? ??????.

?????? ????? 3=  ???? ???? ?? ????? ??? ????????? ? ????????? ???? ??? ???????? ???? ??? ? ??? ????? ????? ???? ? ???? ??????? ???? ???? ??? ????? ????? ??.

?????? ????? 4= ??????? ?????? ????-???-????-??? ??? ????? ?? ???? ?????? ?????? ???? ?????? ? ???? ??????? ??? ???? ???????? ?????.

?????? ????? 5= ???? ??? ????? ??? ??? ??? ??? ????? ? ??? ??? ????????? ?? ? ??? ???? ???? ???? ???? ??? ???? ?????? ????? ????? ??!

?????? ????? 6= ????? ???? ????? ???? ? ?? ??????? ???? ????? ??????.

?????? ????? 7= ???? ?????? ???? ??? ??? ???? ? ??? ????? ? ?? ????? ???? ? ???? ??? ???? ????? ????? ????? ??.

?????? ????? 8= ??? ??????? ??? ???? ??? ?? ???? ?? spam ??? ?? ???? ??? ???? ????? ???? ????? ????? ?????? ???/?????? ??? VIP ???? ?? ??????? ??????.

?????? ????? 9= ??? ??????? ??? ??? ?? ???? ?? ???? ???? ?? ???? ??????? ??? ??????? ???? ????? VIP ???? ??? ?????? VIP ?? ????? ???? ???? ???? ????? 8 ???? ????? ??.

?????? ????? 10= ?? ??? ????? ????? ??? ??? ?? ?????? ????
http://internet.ir/law.html",
    'parse_mode'=>'MarkDown',
          'reply_markup'=>json_encode([
              'resize_keyboard'=>true
           ])
        ]));
}
elseif ($textmessage == '???? ??????'&& $from_id == $admin) {
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"???? ?????
??? ????? ???? ?? ?? ?????? ????? ???? ?????? ?? ????? ??? ??????? ????
*/gb USERID*",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'resize_keyboard'=>true
       		])
    		]));
}
elseif ($textmessage == '?? ????? ???') {
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"???? ???? ????
??? ????? ????? ????? ?? ?? ?????? ??????? ?????? ?? ????? ??? ??????? ????
*/feedback PM*",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'resize_keyboard'=>true
       		])
    		]));
}
elseif ($textmessage == '??????? ????') {
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"???? ???? ????
??? ????? ????? ?? ????? ???? ?????? ?? ????? ??? ??????? ????
*/report BOTID*
?? ??? ????? ????? ???? ???? ???? ?? ??? ???? ?? ???? ???:
`/report BotId `",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'resize_keyboard'=>true
       		])
    		]));
}
elseif ($textmessage == '?????????? ??') {
var_dump(makereq('sendMessage',[
          'chat_id'=>$update->message->chat->id,
          'text'=>"???? ?????
??? ????? ???? ?? ?? ?????? ??? ????? ???? ?????? ?? ????? ??? ??????? ????
*/ungb USERID*",
    'parse_mode'=>'MarkDown',
          'reply_markup'=>json_encode([
              'resize_keyboard'=>true
           ])
        ]));
}
	elseif ($step== 'Forward To All' && $type == 'admin') {
		SendMessage($chat_id,"????? ??? ?? ??? `??????` ??? ?????? .");
		save($from_id."/step.txt","none");
		$fp = fopen( "data/users.txt", 'r');
		while( !feof( $fp)) {
 			$users = fgets( $fp);
		Forward($users,$chat_id,$message_id);
		}
		SendMessage($chat_id,"???? ??? ?? ??? ??????? `??????` ?? .");
		
	}
	elseif (strpos($textmessage , "/fwdtoall") !== false  || $textmessage == "?? ?????? ??????") {
		if ($from_id == $admin) {
			save($from_id."/step.txt","Forward To All");
				var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"???? ?? ???????? ???? ??????? ???? ?????? ??? ?? ????? ???? :",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'?? ????? ?? ???? ????']
                ]
				]
       		])
    		]));
		}
		else {
			SendMessage($chat_id,"You Are Not Admin");
		}
	}
		elseif ($textmessage == '??????? ???? ????? ???????' && $from_id == $admin) {
	save(data/$from_id."/step.txt","Set idtab");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"???? ???? ????? ?? ?? \n@\n???? ???? ????:\n@PvCreators",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'?? ?????']
                ]
				]
       		])
    		]));
	}
	elseif ($step == 'Set idtab' && $from_id == $admin) {
	
	save(data/$from_id."/step.txt","none");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"???? ?????? ????? ????!",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                 [
                    ['text'=>"??????"],['text'=>"???? ??????"]
                ],
                [
                    ['text'=>"?????? ??????"],['text'=>"?? ???? ??"]
                ],
                [
                    ['text'=>"?????????? ??"],['text'=>"?? ?????? ??????"]
                ],
				[
				['text'=>"??????? ???? ??? ???????"],['text'=>"??????? ???? ????? ???????"]
				],
        [
            ['text'=>"?? ?????"]
        ]
            ]
       		])
    		]));
    		save("idkanal.txt","$textmessage");
	}
		elseif ($textmessage == '??????? ???? ??? ???????' && $from_id == $admin) {
	save(data/$from_id."/step.txt","Set idt");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"?????? ??? ?? ???? ????\n??? ??? ???? ???? ???? ? ?? ??????? ??\nCopyPostLink\n???? ??? ???? ?????:\n
			https://t.me/PvCreators/7\n?? ????? ???? ??? 7 ???",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'?? ?????']
                ]
            	]
       		])
    		]));
	}
	elseif ($step== 'Set idt' && $from_id == $admin) {
	
	save(data/$from_id."/step.txt","none");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"???? ?????? ????? ????!",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                 [
                    ['text'=>"??????"],['text'=>"???? ??????"]
                ],
                [
                    ['text'=>"?????? ??????"],['text'=>"?? ???? ??"]
                ],
                [
                    ['text'=>"?????????? ??"],['text'=>"?? ?????? ??????"]
                ],
				[
				['text'=>"??????? ???? ??? ???????"],['text'=>"??????? ???? ????? ???????"]
				],
        [
            ['text'=>"?? ?????"]
        ]
            ]
       		])
    		]));
    		save("adad.txt","$textmessage");
	}
elseif ($textmessage == '/panel'&& $from_id == $admin) {
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"?? ??? ?????? ???? ??? ????? ?????\n??? ?? ???? ???? ?????? ????",
  'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
                [
                    ['text'=>"??????"],['text'=>"???? ??????"]
                ],
                [
                    ['text'=>"?????? ??????"],['text'=>"?? ???? ??"]
                ],
                [
                    ['text'=>"?????????? ??"],['text'=>"?? ?????? ??????"]
                ],
				[
				['text'=>"??????? ???? ??? ???????"],['text'=>"??????? ???? ????? ???????"]
				],
        [
            ['text'=>"?? ?????"]
        ]
            ]
        ])
    ]));
}
elseif (strpos($textmessage, "/gb") !== false && $chat_id == $admin) {
$ban = str_replace("/gb ","",$textmessage);
save("data/$from_id/step.txt","none");
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"*User* _".$ban."_ *Globally Banned*\n????:$tm\n?????:$dat",
		'parse_mode'=>'MarkDown'
    		]));
			var_dump(makereq('sendMessage',[
        	'chat_id'=>$ban,
        	'text'=>"*You Are Globally Banned!*",
		'parse_mode'=>'MarkDown'
    		]));

$myfile2 = fopen("data/banall.txt", "a") or die("Unable to open file!");	
fwrite($myfile2, "$ban\n");
fclose($myfile2);

}
elseif ($textmessage == '/creator') {
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"???????? ??:
 @pvVigeo - @MrMetti
????? ??: @PvCreators
*PvCreators!*",
	'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [
                    ['text'=>"??????",'url'=>"https://telegram.me/pvVigeo"],
                    ['text'=>"??????",'url'=>"https://telegram.me/MrMetti"],
                    ['text'=>"\n????? ????",'url'=>"https://telegram.me/PvCreators"]
                ]
            ]
        ])
    ]));
}
elseif($textmessage == '????' && $from_id == $admin){
save("data/$from_id/step.txt","jpm");
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"`?? ?? ??? ?? ????? ????`",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
              [
                ['text'=>"?? ?????"]
              ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
}
elseif ($step == 'jpm'){
save("data/$from_id/step.txt","jpmm");
$jpm = $textmessage ;
save("cht","$jpm");
SendMessage($admin,"
$jpm");
}
elseif ($step == 'jpmm'){
$jpmm = $textmessage ;
SendMessage($cht,"`????? ?? ?????` :
$jpmm");
SendMessage($admin,"
????? ??
`??? ????` :
 $jpmm");
}
elseif ($textmessage == '??????? ??') {
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"???? ?? ????? ?? ??? ?????? ????? ????",
	'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [
                    ['text'=>"???? ??",'url'=>"https://telegram.me/PvCreators"]
                ]
            ]
        ])
    ]));
}
	elseif (strpos($inch , '"status":"left"') !== false ) {
SendMessage($chat_id,"???? ??????? ?? ???? ??? ?? ????? ?? ??? ????.
@PvCreators");
}
elseif (strpos($banall , "$from_id") !== false  ) {
  SendMessage($chat_id,"");
 }

elseif($textmessage == '/start')
{

if (!file_exists("data/$from_id/step.txt")) {
mkdir("data/$from_id");
save("data/$from_id/step.txt","none");
save("data/$from_id/tedad.txt","0");
save("data/$from_id/bots.txt","");
$myfile2 = fopen("data/users.txt", "a") or die("Unable to open file!");	
fwrite($myfile2, "$from_id\n");
fclose($myfile2);
}

var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"???? *$name* ??????
?? ???? ???? ??????? ??? ????????
??? ?????? ????? ?? ????? ???????? ???? ????? ?????? ? ??? ?????? ?? ?? ????? ??? ??????
???? ?????? ???? `?? ???? ????` ?? ???????
?????? ???????? ???? ? ???? ????? ????? ??? ?? ??? ?? ??? ?????? ?????? ?????????
@PvCreatorsBot",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"?? ???? ????"],['text'=>"?????? ??? ??"]
                ],
                [
                   ['text'=>"?? ??? ????"],['text'=>"??????? ??"]
                ],
                [
                   ['text'=>"?? ??????"],['text'=>"?? ??????"],['text'=>"?????? ????"]
                ],
		[
		['text'=>"??????? ????"],['text'=>"?? ????? ???"]
		]
                ],
            	'resize_keyboard'=>true
       		])
    		]));
			Forward($chat_id,"@PvCreators",7);
    		}
				elseif (strpos($inch , '"status":"left"') !== false ) {
SendMessage($chat_id,"???? ??????? ?? ???? ??? ?? ????? ?? ??? ????.
@PvCreators");
}
elseif (strpos($banall , "$from_id") !== false  ) {
  SendMessage($chat_id,"");
 }
	elseif ($textmessage == '?????? ????') {
	$usercount = -1;
	$botscount = -1;
	
	$fp = fopen( "data/users.txt", 'r');
	$fps = fopen( "data/bots.txt", 'r');
	$number = count(scandir("bots"))-1;
	while( !feof( $fp)) {
    		fgets( $fp);
    		$usercount ++;
	}
		while( !feof( $fps)) {
    		fgets( $fps);
    		$botscount ++;
	}
	fclose( $fp);
	fclose( $fps);
	SendMessage($chat_id,"???? *$name* ????!?? ???? ???? ?? ???? (`$tm`) ? ????? (`$dat`) ?? ??? ??? ????????

?????? ??? ????? ???:*".$number."*
???????? ??? ????: *".$botscount."*
??`????? ????`:*".$usercount."*
`#PvCreators`
	");
	}
		elseif (strpos($inch , '"status":"left"') !== false ) {
SendMessage($chat_id,"???? ??????? ?? ???? ??? ?? ????? ?? ??? ????.
@PvCreators");
}
elseif (strpos($banall , "$from_id") !== false  ) {
  SendMessage($chat_id,"");
 }
elseif ($textmessage == '?? ??????') {
var_dump(makereq('sendMessage',[
          'chat_id'=>$update->message->chat->id,
          'text'=>"$name ???? ???? ???? ???? ?????
???? ???????? ??? ??????? ????? ?????? ?? ???? ????? ??????!??
?????? ???? ?? ?? ?????? ???? ???? ?????? ????? ? ??? ???? ?? ??? ????? ????? ???? ??? ???? ?? ????? ??????? ??? ???!??
???? ??? ?????? ?? ?????? ????? ?? ????????? ?? ?? ?????? ?????? ??????
?? ???? ???? ??? ???????? ???? ????? ?????? ? ?????? ?? ??? ? ?? ??? ?? ?????? ?????? ????? ???????
?????? ???????? ???? ????? ?? ??? ?????? ?? ??? ??? ?????? ????\nhttps://telegram.me/PvCreators/7",
    'parse_mode'=>'MarkDown',
          'reply_markup'=>json_encode([
              'resize_keyboard'=>true
           ])
        ]));
}
elseif ($textmessage == '?????? ??????') {
save("data/$from_id/step.txt","send to all");
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"??? ??? :",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"?? ?????"]
                ],
                
            	],
            	'resize_keyboard'=>true
       		])
    		]));
}
elseif ($step == 'send to all') {
  save("data/$from_id/step.txt","none");
  var_dump(makereq('sendMessage',[
          'chat_id'=>$update->message->chat->id,
          'text'=>"????? ?????!",
    'parse_mode'=>'MarkDown',
          'reply_markup'=>json_encode([
              'keyboard'=>[
                [
                   ['text'=>"?? ?????"]
                ]
              ],
              'resize_keyboard'=>false
           ])
        ]));
      $all_member = fopen( "data/users.txt", 'r');
    while( !feof( $all_member)) {
       $user = fgets( $all_member);
      var_dump(makereq('sendMessage',[
          'chat_id'=>$user,
          'text'=>$txtmsg,
    'parse_mode'=>'html'
        ]));
    }
    }
		
elseif (strpos($textmessage, "/feedback") !== false) {
$feed = str_replace("/feedback ","",$textmessage);
save("data/$from_id/step.txt","none");
var_dump(makereq('sendMessage',[
          'chat_id'=>$admin,
          'text'=>"<b>Name:</b> $name\n<b>UserName:</b> @$username\n<b>ID:</b> $from_id<b>\nText Msg:</b>\n$feed",
    'parse_mode'=>'html'
        ]));
var_dump(makereq('sendMessage',[
          'chat_id'=>$update->message->chat->id,
          'text'=>"?? ???????? ????? ??.",
    'parse_mode'=>'MarkDown'
        ]));
}
	elseif (strpos($inch , '"status":"left"') !== false ) {
SendMessage($chat_id,"???? ??????? ?? ???? ??? ?? ????? ?? ??? ????.
@PvCreators");
}
elseif (strpos($banall , "$from_id") !== false  ) {
  SendMessage($chat_id,"");
 }
elseif (strpos($textmessage, "/report") !== false) {
$feed = str_replace("/report","",$textmessage);
save("data/$from_id/step.txt","none");
var_dump(makereq('sendMessage',[
          'chat_id'=>$admin,
          'text'=>"<b>Name:</b> $name\n<b>UserName:</b> @$username\n<b>ID:</b> $from_id<b>\nText Msg:</b>\n$feed",
    'parse_mode'=>'html'
        ]));
var_dump(makereq('sendMessage',[
          'chat_id'=>$update->message->chat->id,
          'text'=>"?? ???????? ????? ??.",
    'parse_mode'=>'MarkDown'
        ]));
}
elseif ($textmessage == '?? ??? ????') {
if (file_exists("data/$from_id/step.txt")) {

}
$botname = file_get_contents("data/$from_id/bots.txt");
if ($botname == "") {
SendMessage($chat_id,"??? ???? ??? ????? ?????? ??? !");

}
else {
//save("data/$from_id/step.txt","delete");


 	var_dump(makereq('sendMessage',[
	'chat_id'=>$update->message->chat->id,
	'text'=>"??? ?? ???? ??? ??? ?? ?????? ???? : ",
	'parse_mode'=>'MarkDown',
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[
	['text'=>"?? @".$botname,'callback_data'=>"del ".$botname]
	]
	]
	])
	]));
}
}

elseif ($textmessage == '/update' && $from_id == $admin) {
SendMessage($chat_id,"??? ????");	
$all_member = fopen( "data/bots.txt", 'r');
    while( !feof( $all_member)) {
       $user = fgets( $all_member);
      $user = str_replace("\n",'',$user);
	  $user = str_replace(" ",'',$user);
	  $token = file_get_contents("bots/$user/token.txt");
	  $admin = file_get_contents("bots/$user/admin.txt");
	  $source = file_get_contents("bot/index.php");
		$source = str_replace("[*BOTTOKEN*]",$token,$source);
		$source = str_replace("**admin**",$admin,$source);
		save("bots/$user/index.php",$source);	
    }
	SendMessage($chat_id,"??? ???? ?? ????? ??");
}

elseif ($textmessage == '?? ???? ????') {

$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 2) {
SendMessage($chat_id,"????? ???? ??? ????? ??? ??? ???? ??? !
??? ???? ?? ???? ?? ??? ???? ! $tedad");
return;
}
save("data/$from_id/step.txt","create bot");
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"???? ?? ???? ???? : ",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"?? ?????"]
                ]
                
            	],
            	'resize_keyboard'=>true
       		])
    		]));
}

else
{
SendMessage($chat_id,"");
}

?>