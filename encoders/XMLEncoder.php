<?php
    namespace App\Encoders;

    final class XMLEncoder {

        final public static function xmlEncode($name,$mixed) {
            $out='<'.htmlspecialchars($name).'>';
            foreach($mixed as $key=>$val){
                if(!is_array($val))
                    $out.='<'.htmlspecialchars($key).'>'.htmlspecialchars($val).'</'.htmlspecialchars($key).'>';
                else{
                    $out.='<'.htmlspecialchars($key).'>';
                    foreach($val as $key1=>$val1){
                        $out.='<grade>'.htmlspecialchars($val1).'</grade>';
                    }
                    $out.='</'.htmlspecialchars($key).'>';
                }
            }
            $out.='</'.htmlspecialchars($name).'>';
            return $out;
        }
    }