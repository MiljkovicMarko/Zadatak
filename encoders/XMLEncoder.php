<?php
    namespace App\Encoders;

    final class XMLEncoder {

        final public static function xmlEncode($name,$mixed) {
            $out='<'.$name.'>';
            foreach($mixed as $key=>$val){
                if(!is_array($val))
                    $out.='<'.strval($key).'>'.strval($val).'</'.strval($key).'>';
                else{
                    $out.='<'.strval($key).'>';
                    foreach($val as $key1=>$val1){
                        $out.='<grade>'.strval($val1).'</grade>';
                    }
                    $out.='</'.strval($key).'>';
                }
            }
            $out.='</'.$name.'>';
            return $out;
        }
    }