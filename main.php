<?php
error_reporting(0);

include_once 'FarsiToFingilish.php';
$farsiCharacterToEnglish_obj = new FarsiToFingilish();
$strList =[
    "سلام",
    "رضا حسینی",
    "فاطمه پروش",
    "ستار قهرمانی",
    "آنیتا فیروززاده",
    "محمد سلیمی",
    "مریم امیری",
    "مهدی حیدری",
    "مریم بوستانی",
    "ابوالفضل نوروزی",
    "ریحانه رضائی",
];

foreach ($strList as $name) {
    echo $name.'---'.$farsiCharacterToEnglish_obj->convertor($name).'<br>';
}
