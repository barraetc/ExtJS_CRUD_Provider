<?php
/**
 * Gerador de código para CRUD ExtJS + Zend Framework
 * 
 * @author Marcone Costa <blog@barraetc.com.br>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 **/


/**
 * Cria a classe responsável pela persisttência de dados
 *
 **/
class Barra_Etc_Tools_Generate_SharedController {
    private  $name, $lowerName;

    public function  __construct($name) {
        $this->name = $name;
        $this->lowerName = strtolower($name);

    }
    public function init($path)
    {
        $generator = Zend_CodeGenerator_Php_File::fromReflectedFileName($path);
        $classe=$generator->getClass();
        $classe->setDocblock(Barra_Etc_Tools_Generate_Compiler::getDefaultDocblock());
        $classe->getMethod('init')->setBody($this->processTemplate('shared/init.tpl'));
        $generator->setClass($classe);
        file_put_contents($path, $generator->generate());
    }
    private function processTemplate($template)
    {
        $path=dirname(__FILE__)."/templates/$template";
        return Barra_Etc_Tools_Generate_Compiler::compile($path);
    }

}

