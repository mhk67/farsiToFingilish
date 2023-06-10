<?php

class FarsiToFingilish
{
    var $persian_chars = ['آ', 'ا', 'ب', 'پ', 'ت', 'ث', 'ج', 'چ', 'ح', 'خ', 'د', 'ذ', 'ر', 'ز', 'ژ'
        , 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ع', 'غ', 'ف', 'ق', 'ک', 'گ', 'ل', 'م', 'ن'
        , 'و', 'ه', 'ی', 'ئ'];
    var $persian_kasre_chars = ['', 'ط', 'م', 'ی', 'د', 'ن'];

    var $english_chars_ = ['a', 'a', 'b', 'p', 't', 's', 'j', 'ch', 'h', 'kh', 'd', 'z', 'r', 'z', 'zh', 's', 'sh'
        , 's', 'z', 't', 'z', 'a', 'gh', 'f', 'gh', 'k', 'g', 'l', 'm', 'n', 'v', 'h', 'y', 'e'];

    var $english_chars = ['a', 'a', 'b', 'p', 't', 's', 'j', 'ch', 'h', 'kh', 'd', 'z', 'r', 'z', 'zh', 's', 'sh'
        , 's', 'z', 't', 'z', 'a', 'gh', 'f', 'gh', 'k', 'g', 'l', 'm', 'n', 'v', 'h', 'y', 'e'];

    function __construct()
    {
    }

    function convertor($persian_string)
    {
        $persian_string = array_filter(explode(' ', $persian_string));
        $ret = '';
        foreach ($persian_string as $str) {
            $first = str_replace($this->persian_chars, $this->english_chars_, mb_substr($str, 0, 1));
            $start_i = 1;
            if ($char = $this->two_letter_check(mb_substr($str, 0, 1), mb_substr($str, 1, 1))) {
                $first = $char;
                $start_i = 2;
            } elseif ($char = $this->next_letter_check(mb_substr($str, 1, 1))) {
                $first .= $char;
                $start_i = 2;
            } else {
                $char = $this->first_letter_check(mb_substr($str, 0, 1), mb_substr($str, 1, 1));
                $first = $char;
            }

            $mid = '';
            for ($i = $start_i; $i < mb_strlen($str) - 1; $i++) {
                if ($char = $this->two_letter_check(mb_substr($str, $i, 1), mb_substr($str, $i + 1, 1))) {
                    $mid .= $char;
                    $i++;
                    continue;
                }

                $mid .= str_replace($this->persian_chars, $this->english_chars, mb_substr($str, $i, 1));
                if ($char = $this->next_letter_check(mb_substr($str, $i + 1, 1))) {
                    $mid .= $char;
                    $i++;
                    continue;
                }

                if(mb_substr($str, $i+1, 1)!='ا'){
                    if (array_search(mb_substr($str, $i, 1), $this->persian_kasre_chars, true)) {
                        $mid .= 'e';
                    }
                }
            }
            $last = str_replace($this->persian_chars, $this->english_chars_, mb_substr($str, -1, 1));
            $last = $this->last_letter_check($mid, $last);

//            if (mb_substr($mid, -1, 1) == 'i') {
//                $en = $first . $mid;
//            } else {
//                $en = $first . $mid . $last;
//            }
            $en = $first . $mid . $last;
            $ret .= "$en ";
        }
        return $ret;
    }

    private function two_letter_check($char, $next_char)
    {
        $twoCharList = ['مر' => 'mar', 'یم' => 'yam','حم'=>'ham'];
        return $twoCharList[$char . $next_char];
    }

    private function next_letter_check($next_char)
    {
        $charList = ['ی' => 'i', 'و' => 'o'];
        return $charList[$next_char];
    }

    private function first_letter_check($letter, $next_letter)
    {
        $list=['مح'=>'mo','مج'=>'mo','مه'=>'ma','مژ'=>'mo','سه'=>'so','اک'=>'a'
        ,'گل'=>'go','حس'=>'ho','ام'=>'a','اب'=>'a','رض'=>'re','جو'=>'ja'];
        if ($list[$letter.$next_letter]){
            return $list[$letter.$next_letter];
        }

        if ($letter == 'ا') {
            return 'e';
        }
        if ($letter == 'ع') {
            return str_replace($this->persian_chars, $this->english_chars, $letter);
        }
        if ($next_letter == 'ا') {
            return str_replace($this->persian_chars, $this->english_chars, $letter);
        }

        return str_replace($this->persian_chars, $this->english_chars, $letter) . 'a';
    }

    private function last_letter_check($string, $last_letter)
    {
        $last_string_letter=mb_substr($string, -1, 1);

        if ($last_string_letter == 'i' && $last_letter=='y'){
            return '';
        }
        if ($last_string_letter != $last_letter){
            return $last_letter;
        }
        return '';
    }
}