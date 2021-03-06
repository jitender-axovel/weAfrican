<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class Helper extends Model
{
    public static function slug($name, $id = null) {
        
            $name = trim($name);
            
            $table = array(

                'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',

                'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',

                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',

                'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',

                'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',

                'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',

                'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y','þ'=>'b', 'ÿ'=>'y',

                'Ŕ'=>'R', 'ŕ'=>'r', '/' => '', ' ' => '-', '.' => '', '"' => '', ',' => '', "'" => '', ':' => '',
                ';' => '', '<' => '', '>' => '', '?' => ''

            );

            $name = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $name);

            $name = strtolower(strtr($name, $table));

            if ($id) {
                $name .= '-' . $id;
            }

            return $name;

    }

    public static function removeImages($path, $file) {
        File::delete($path.$file,$path.'/thumbnails/small/'.$file,$path.'/thumbnails/medium/'.$file,$path.'/thumbnails/large/'.$file);
    }
}
