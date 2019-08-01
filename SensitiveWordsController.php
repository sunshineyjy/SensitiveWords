<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SensitiveWordsController extends Controller
{

    /*
     * 2019-6-17
     * param $content 动态的内容敏感词过滤
     * return code 为200给后端存入数据库
     * return code 为400给前端返回给用户动态内容含有敏感词
     * */
    public function seWords(Request $request)
    {
        $content = $request->input('content');
        $fake = file_get_contents("'sensitive.txt'"); // 读取关键字文本信息 这个文本就是敏感词的文本网上都有 最好选择最新最全的
        $content = trim($content); 
        $fuckArr = explode("\n",$fake); 
        $arr= [];
        $arr['code'] = '400';
        $arr['mes'] = 'fail';
        $arr['data'] = '含有敏感词，请重新输入';
        for ($i=0; $i < count($fuckArr) ; $i++){
             $fuckArr[$i] = trim($fuckArr[$i]);
             if ($fuckArr[$i] == "") {
                 continue; //如果关键字为空就跳过本次循环
             }
             if (strpos(trim($fuckArr[$i]),$content) !== false){
//                 return $fuckArr[$i]; //如果匹配到关键字就返回关键字
                 return $arr; //如果匹配到关键字就返回关键字
             }
        }
        $arrUserContent['neirong'] = $content;
        $arr['code'] = '200';
        $arr['mes'] = 'success';
        $arr['data'] = $arrUserContent;
        return json_encode($arr); // 如果没有匹配到关键字就返回 false
    }
}
