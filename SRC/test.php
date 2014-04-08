<?php

			$api=array('appid'=>'wx45763e9f6cffd97c', 'appsecret'=>'16fd288cf346d566352c8cb25d23eab6');
			//$url_get='https://101.226.90.58/cgi-bin/token?grant_type=client_credential&appid='.$api['appid'].'&secret='.$api['appsecret'];
			$url_get='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$api['appid'].'&secret='.$api['appsecret'];
			
			
			//var_dump($url_get); exit;
			//$json=json_decode(curlGet($url_get));
			//$json=file_get_contents($url_get);
			//var_dump($json);
	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url_get);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//禁止直接显示获取的内容 重要
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_SSLVERSION, 3);
			$result = curl_exec($ch);
			var_dump($result);
			
			curl_close($ch);
	 
			

?>