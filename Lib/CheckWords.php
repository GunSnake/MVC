<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/8/9
 * Time: 15:46
 */

namespace Lib;


class CheckWords
{
    private $words;//传入单词
    private $near_words;//单词库
    private $want_word;//期望单词

    public function __construct($words)
    {
        $this->words = $words;
        $this->near_words = ['apple','orange','pear','banana'];
    }

    public function getNearWords(){
        if (is_array($this->near_words)){
            $len = 255;
            foreach ($this->near_words as $v){
                $real_len = levenshtein($this->words, $v);//两个单词之间的编辑距离（增、删、替换等）
                if (0 === $real_len) {
                    $this->want_word = $this->words;
                    $len = 0;
                    break;
                }elseif(-1 === $real_len){
                    $this->want_word = $this->words;
                    break;
                }elseif ($real_len<$len){
                    $this->want_word = $v;
                    $len = $real_len;
                }
            }
            if ($len === 0){
                return '已找到<span style="color:blue;">'.$this->want_word.'</span>';
            }else{
                return '你是不是想找：<span style="color:blue;">'.$this->want_word.'</span>';
            }
        }else{
            return $this->words;
        }
    }
}