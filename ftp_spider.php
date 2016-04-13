<?php
	
	set_time_limit(0);

	// $con = ftp_connect("192.168.56.11");
	// $login = ftp_login($con, "duola", "duola123");
	$con = ftp_connect("ftp3.ouc.edu.cn");
	$login = ftp_login($con, "Anonymous", "");
	$myfile=fopen("result.txt","w");

	$queue = array("/"); 	//存放目录的队列

	while(!empty($queue)){	//还有未遍历目录
		$list_now = array_shift($queue);//本次处理目录
		// if(!ftp_chdir($con, $list_now)){//文件目录不存在，数字开头后加空格的奇葩命名文件
		// 	fwrite($myfile, $list_now."\r\n");
		// 	continue;//跳过本次循环
		// }
		ftp_chdir($con, $list_now);
		$filelist = ftp_rawlist($con, $list_now);

		$name = preg_replace("/.+:*\\d+\\s/", "", $filelist[2]);
		if(count($filelist) == 3 && ftp_size($con, $name) != -1){
			//只有一个电影,目录名字即为电影名
			fwrite($myfile, $list_now."\r\n");	
		}else{
			foreach($filelist as $file)
		    {
		        $filename = preg_replace("/.+:*\\d+\\s/", "", $file);
		       	if(ftp_size($con, $filename) == -1){
		       		//是目录
		       		if($filename != "." && $filename != ".."){
		       			array_push($queue, $list_now."/".$filename);
		       			//echo "<br>\ndocument：".$list_now."/".$filename;
		       		}
		       	}
				else{
		       		fwrite($myfile, $list_now."/".$filename."\r\n");
		       	}
		    }
		}

	}
	fclose($myfile);
	ftp_close($con);

?>