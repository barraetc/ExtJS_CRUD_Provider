<?php
/**
 * Gerador de código para CRUD ExtJS + Zend Framework
 * 
 * @author Marcone Costa <blog@barraetc.com.br>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 **/



/**
 * Cria a classe responsável pela persisttência de dados
 **/
class Barra_Etc_Tools_Generate_JsViews{
    private  $name, $lowerName;

    public function  __construct($name) {
        $this->name = $name;
        $this->lowerName = strtolower($name);

    }
    private function includejs($path)
    {
        $ac = str_replace('.phtml','',substr(strrchr($path, "/"), 1));
        $generator = new Zend_CodeGenerator_Php_File();
        $generator->setBody("include_once '$ac';");
        file_put_contents($path, $generator->generate());
    }
    public function generateStore($path)
    {
    $body = $this->processTemplate('js/store.tpl');
    $jspath = str_replace('.phtml','',$path);
    file_put_contents($jspath, $body);
    $this->includejs($path);
        return $body;
    }


    private function processTemplate($template)
    {
        $path=dirname(__FILE__)."/templates/$template";
        return Barra_Etc_Tools_Generate_Compiler::compile($path);
    }


public function generateModel($path, $fields)
{
    $fields = implode("','", $fields);

    $body = $this->processTemplate('js/model.tpl');
    $jspath = str_replace('.phtml','',$path);
    file_put_contents($jspath, $body);
    $this->includejs($path);
    return $body;
}
public function generateController($path,$module)
{
    $generator = new Zend_CodeGenerator_Php_File();

    $body = $this->processTemplate("js/controller.tpl");
    
    $jspath = str_replace('.phtml','',$path);
    file_put_contents($jspath, $body);
    $this->includejs($path);
    return $body;
}
public function generateList($path,$module,$fields)
{
    $columns = "{header: 'Id.',  dataIndex: 'id',  flex: 0, width: '20'}";

    foreach ($fields as $field){
        $ucfield = ucfirst($field);
        $columns .=",\n\t\t  {header: '$ucfield',  dataIndex: '$field',  flex: 1}";
    }
    $body = $this->processTemplate("js/list.tpl");
    $body  = str_replace("#configColuns#", $columns, $body);

    $jspath = str_replace('.phtml','',$path);
    file_put_contents($jspath, $body);
    $this->includejs($path);
    return $body;
	
}
public function generateEdit($path,$module,$fields)
{
    


    $columns = "";

    foreach ($fields as $field){
        $ucfield = ucfirst($field);
        $columns .="\n\t\t\t{xtype: 'textfield',name : '$field',ref: '$field',fieldLabel: '$ucfield'},";
    }
    $body = $this->processTemplate("js/edit.tpl");
    $body  = str_replace("#configItems#", $columns, $body);

    $jspath = str_replace('.phtml','',$path);
    file_put_contents($jspath, $body);
    $this->includejs($path);
    return $body;

}

}

