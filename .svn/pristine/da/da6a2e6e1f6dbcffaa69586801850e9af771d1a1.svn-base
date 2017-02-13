<?php
	// 无线级分类
	 function layer($cate,$id=0){//一棵树形成一个数组
            $arr=array();
            foreach($cate as $v){
                    if($v['mpid'] == $id){
						$v['cate'] = layer($cate,$v['id']);
						if(empty($v['cate'])) {
							array_pop($v);
						}
						$arr[] = $v;
                    }
            }
            return $arr;
    }
	// 生成卡密字符串
	function getRandChar($length){
		$str = null;
		$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
		$max = strlen($strPol)-1;
		for($i=0;$i<$length;$i++){
			$str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
		}
		return $str;
	}
?>