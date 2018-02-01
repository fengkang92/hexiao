<?php
/**
    * 导出数据为excel表格
    *@param $data    一个二维数组,结构如同从数据库查出来的数组
    *@param $title   excel的第一行标题,一个数组,如果为空则没有标题
    *@param $filename 下载的文件名
    *@examlpe 
    $stu = M ('User');
    $arr = $stu -> select();
    exportexcel($arr,array('id','账户','密码','昵称'),'文件名!');
    */
    function exportexcel($data=array(),$title=array(),$filename='report'){
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");  
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=iconv("UTF-8", "GB2312",$v);
            }
            $title= implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data)){
            foreach($data as $key=>$val){
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key]=implode("\t", $data[$key]);
                
            }
            echo implode("\n",$data);
        }
    }

    function curls($url,$data=array()) {

        //echo $url;die;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);  

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    

        curl_setopt($ch, CURLOPT_HEADER, false);                            
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, false); 

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        //dump($data);
        //dump($url);die;

        $ret = curl_exec($ch);

        $data = json_decode($ret, true);

        curl_close($ch);
        return $data;
    }
    //php curl封装函数
    function sendRequest($url,$https=true,$method='get',$data=''){
        //1.初始化curl
        $ch = curl_init($url);
        //2.根据实际请求需求进行参数封装
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        //如果是https请求
        if($https == true){
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        }
        //请求方式
        if($method === "post"){
            curl_setopt($ch,CURLOPT_POST,true);
            curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($data));
        }
        //3.发送
        $data = curl_exec($ch);
//        print_r($data);die();
        //4.关闭
        curl_close($ch);
        $data = json_decode($data,true);
        return $data;
    }