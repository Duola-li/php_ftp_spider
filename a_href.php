<?php
	//header("Content-Type:text/html;charset=UTF-8");
	header("Content-Type:text/html;charset=GBK");
	$ip_file = "main.html";
	//$myfile = fopen($ip_file, "r");
	$lines = file($ip_file);//返回数组，键值对，0=》第一行，。。。
	//print_r($lines);

	$result = array();
	//$regular = "/\<a\s((.|\n)*\s)?href=((\"|\')?)\S*\3(\s|>)/i";//
	//$regular = "/<a\s((.|\n)*\s)?href=(?<cut>(\"|\')?)\S*\k<cut>(\s|>)/i";
	//$regular = "/(?<=\<a\s((.|\n)*\s)?)href/i";//php零宽断言不支持*？等循环的东西。
	$regular = "/(?<=\<a\shref=)(?<cut>(\"|\')?)\S*\k<cut>(?=>|\s)/i";//这个就简单了，默认href是第一个属性
	//$regular = "/(?<=\<a\shref=)((\"|\')?)\S*\1(?=>|\s)/i";//这个就简单了，默认href是第一个属性
	foreach ($lines as $line_num => $line) {
		//echo "Line # <b>{$line_num}</b>:".htmlspecialchars($line)."<br />\n";
		$temp = array();
		preg_match_all($regular, $line, $temp);
		$result = array_merge($result, $temp[0]);
		//print_r($temp[0]);
	}
	// print_r($result);
	foreach ($result as $num => $url) {
		echo $num.":".$url."<br />";
	}
?>
