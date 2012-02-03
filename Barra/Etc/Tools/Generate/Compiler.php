<?php
/**
 * Gerador de código para CRUD ExtJS + Zend Framework
 * 
 * @author Marcone Costa <blog@barraetc.com.br>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 **/



/**
 * Classe que insere valores das variaveis nos templates
 **/
class Barra_Etc_Tools_Generate_Compiler {
    private static $_varsMap=array();
    public static function addMap($key, $value){
        self::$_varsMap[$key]=$value;
    }
    public static function compile($path){
        $file_handle = fopen($path, "r");
        $body ="";
        if($file_handle){
            while (!feof($file_handle)) {
                $body .= fgets($file_handle);
            }
        }else{
            throw new Exception("Erro ao abrir o arquivo");
        }
               
        foreach (self::$_varsMap as $key => $value) {
             $body  = str_replace("#".$key."#", $value, $body);
        }
        return $body;
    }
    public static function getDefaultDocblock(){
        $docblock = new Zend_CodeGenerator_Php_Docblock(array(
            'shortDescription' => 'Classe gerada automaticamente',
            'longDescription'  => 'Gerada automaticamente pelo script ExtCRUD.',
            'tags'             => array(
                array(
                    'name'        => 'version',
                    'description' => '$Rev:$',
                ),
                array(
                    'name'        => 'license',
                    'description' => 'http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0',
                ),
                array(
                    'name'        => 'author',
                    'description' => 'Marcone Costa <blog@barraetc.com.br>',
                )
            ),
        ));
        return $docblock;
    }
}

?>
