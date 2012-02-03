<?php
/**
 * Gerador de código para CRUD ExtJS + Zend Framework
 * 
 * @author Marcone Costa <blog@barraetc.com.br>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 **/


require_once 'Zend/Tool/Project/Provider/Abstract.php';
require_once 'Zend/Tool/Project/Provider/Exception.php';
require_once 'Barra/Etc/Tools/Generate/RestController.php';
require_once 'Barra/Etc/Tools/Generate/SharedController.php';
require_once 'Barra/Etc/Tools/Generate/GUIController.php';
require_once 'Barra/Etc/Tools/Generate/JsViews.php';
require_once 'Barra/Etc/Tools/Generate/Compiler.php';

class Barra_Etc_Tools_Provider_ExtCRUDProvider extends Zend_Tool_Project_Provider_Abstract
{
    /**
     * Nome da classe/controller
     * @var String
     */
    public $_name;
    /**
     * Nome da tabela no DB
     * @var String
     */
    public $_actualTableName;
    /**
     * Nome do módulo
     * @var string
     */
    public $_module;
    /**
     * Campos da persistência
     * @var array
     */
    public $_fields;
    
    public static function hasResource(Zend_Tool_Project_Profile $profile, $crudName, $moduleName = null)
    {
        
        if (!is_string($crudName)) {
            throw new Zend_Tool_Project_Provider_Exception('Nome inválido.');
        }

        $controllersDirectory = self::_getControllersDirectoryResource($profile, $moduleName);
        return (($controllersDirectory->search(array('controllerFile' => array('controllerName' => $crudName)))) instanceof Zend_Tool_Project_Profile_Resource);
    }

        /**
     * _getControllersDirectoryResource()
     *
     * @param Zend_Tool_Project_Profile $profile
     * @param string $moduleName
     * @return Zend_Tool_Project_Profile_Resource
     */
    protected static function _getControllersDirectoryResource(Zend_Tool_Project_Profile $profile, $moduleName = null)
    {
        $profileSearchParams = array();

        if ($moduleName != null && is_string($moduleName)) {
            $profileSearchParams = array('modulesDirectory', 'moduleDirectory' => array('moduleName' => $moduleName));
        }

        $profileSearchParams[] = 'controllersDirectory';

        return $profile->search($profileSearchParams);
    }
    /**
     *
     * @param string $name
     * @param string $actualTableName
     * @param string $fields
     * @param string $module
     * @return type 
     */
    public function create($name, $actualTableName, $fields=null, $module=null)
    {
        
        $this->_actualTableName=$actualTableName;
        $this->_module = $module;
        $this->_fields = explode(",", $fields);
        Barra_Etc_Tools_Generate_Compiler::addMap('moduleName', $this->_module);
        Barra_Etc_Tools_Generate_Compiler::addMap('fieldsList', implode("','", $this->_fields));
        

        $this->_loadProfile(self::NO_PROFILE_THROW_EXCEPTION);
        if (!is_string($name)) {
            throw new Zend_Tool_Project_Provider_Exception('Nome inválido.');
        }

        // Check that there is not a dash or underscore, return if doesnt match regex
        if (preg_match('#[_-]#', $name)) {
            throw new Zend_Tool_Project_Provider_Exception('Name should be camel cased.');
        }

        $originalName = $name;
        $name = ucfirst($name);
        $this->_name = $name;
        Barra_Etc_Tools_Generate_Compiler::addMap('lowerobjectname', strtolower($this->_name));
        Barra_Etc_Tools_Generate_Compiler::addMap('CamelObjectName', $this->_name);
        if ($actualTableName == '') {
            throw new Zend_Tool_Project_Provider_Exception('You must provide both the DbTable name as well as the actual db table\'s name.');
        }

        if (self::hasResource($this->_loadedProfile, $name, $module)) {
            throw new Zend_Tool_Project_Provider_Exception('This project already has a DbTable named ' . $name);
        }

        // get request/response object
        $request = $this->_registry->getRequest();
        $response = $this->_registry->getResponse();

        // alert the user about inline converted names
        $tense = (($request->isPretend()) ? 'would be' : 'is');

        if ($name !== $originalName) {
            $response->appendContent(
                'Note: The canonical model name that ' . $tense
                    . ' used with other providers is "' . $name . '";'
                    . ' not "' . $originalName . '" as supplied',
                array('color' => array('yellow'))
                );
        }

        try {
            $this->createPersistence();
            $this->createShare();
            $this->createGUI();
        } catch (Exception $e) {
            $response = $this->_registry->getResponse();
            $response->setException($e);
            return;
        }


    }
   
    /*
     * TODO inplementar uma função que gere apenas os códigos do model store e modulo REST
     */
    public function nogui()
    {
        echo "chamou o nogui";
    }
    /**
     * Cria persistências 
     * @return type 
     */
    public function createPersistence()
    {
        $response = $this->_registry->getResponse();
        $dbtable = new Zend_Tool_Project_Provider_DbTable();
        $controllerprovider = new Zend_Tool_Project_Provider_Controller();
        try
        {
            $dbtable->initialize();
            $dbtable->_registry = $this->_registry;
            
            //Sempre cria a persistência no módulo "data"
            $dbtable->create($this->_name, $this->_actualTableName, 'data', true);

            // CRIA O CONTROLLER DO MÓDULO data
            $controllerResource = Zend_Tool_Project_Provider_Controller::createResource($this->_loadedProfile, $this->_name,'data');
            $response->appendContent('Creating a controller at ' . $controllerResource->getContext()->getPath());
            $controllerResource->create();
            $response->appendContent('Creating REST actions method in controller ' . $this->_name);
            //CRIA AS ACTIONS DO REST
            $actionResource = Zend_Tool_Project_Provider_Action::createResource($this->_loadedProfile, 'index', $this->_name, 'data');
            $actionResource->create();
            $actionResource = Zend_Tool_Project_Provider_Action::createResource($this->_loadedProfile, 'get', $this->_name,  'data');
            $actionResource->create();
            $actionResource = Zend_Tool_Project_Provider_Action::createResource($this->_loadedProfile, 'put', $this->_name, 'data');
            $actionResource->create();
            $actionResource = Zend_Tool_Project_Provider_Action::createResource($this->_loadedProfile, 'post', $this->_name, 'data');
            $actionResource->create();
            $actionResource = Zend_Tool_Project_Provider_Action::createResource($this->_loadedProfile, 'delete', $this->_name, 'data');
            $actionResource->create();
            // CONFIGURA O REST
            $restController = new Barra_Etc_Tools_Generate_RestController($this->_name);
            $restController->init($controllerResource->getContext()->getPath());

        }  catch (Exception $e){
            $response = $this->_registry->getResponse();
            $response->setException($e);
            return;
        }
    }
    /**
     * Cria o controller e views responsáveis por gerar os javascritps com model e store
     * @return type 
     */
    public function createShare(){
        $response = $this->_registry->getResponse();

        $controllerprovider = new Zend_Tool_Project_Provider_Controller();
        $jsview = new Barra_Etc_Tools_Generate_JsViews($this->_name);
        try
        {
            // CRIA O CONTROLLER DO MÓDULO share
            $controllerResource = Zend_Tool_Project_Provider_Controller::createResource($this->_loadedProfile, $this->_name,'shared');
            $response->appendContent('Creating a controller at ' . $controllerResource->getContext()->getPath());
            $controllerResource->create();
            $response->appendContent('Creating actions method in controller ' . $this->_name);
            //Cria o store
            $actionResource = Zend_Tool_Project_Provider_Action::createResource($this->_loadedProfile,'store', $this->_name,'shared');
            $actionResource->create();

            $viewResource = Zend_Tool_Project_Provider_View::createResource($this->_loadedProfile,'store.js', $this->_name, 'shared');

            $response->appendContent(
                'Creating a view script for the ' . $this->_name . ' action method at ' . $viewResource->getContext()->getPath()
                );
            $viewResource->create();
            $jsview->generateStore($viewResource->getContext()->getPath());
            $this->_storeProfile();

            // Cria o model
            $actionResource = Zend_Tool_Project_Provider_Action::createResource(
                                                                                $this->_loadedProfile,
                                                                                'model', $this->_name,
                                                                                'shared');
            $actionResource->create();
            $viewResource = Zend_Tool_Project_Provider_View::createResource($this->_loadedProfile,'model.js', $this->_name, 'shared');

            $response->appendContent(
                'Creating a view script for the ' . $this->_name . ' action method at ' . $viewResource->getContext()->getPath()
                );
            $viewResource->create();
            $jsview->generateModel($viewResource->getContext()->getPath(),$this->_fields);
            $this->_storeProfile();

            $shared = new Barra_Etc_Tools_Generate_SharedController($this->_name);
            $shared->init($controllerResource->getContext()->getPath());



            

        }  catch (Exception $e){
            $response = $this->_registry->getResponse();
            $response->setException($e);
            return;
        }

    }
    /*
     * Cria o controller e as views responsáveis pela apresentação e edição dos dados
     */
    public function createGUI() {
        $response = $this->_registry->getResponse();

        $controllerprovider = new Zend_Tool_Project_Provider_Controller();
        $jsview = new Barra_Etc_Tools_Generate_JsViews($this->_name);
        try
        {
            // CRIA O CONTROLLER NO MÓDULO ESPECIFICADO
            $controllerResource = Zend_Tool_Project_Provider_Controller::createResource($this->_loadedProfile, $this->_name,$this->_module);
            $response->appendContent('Creating a controller at ' . $controllerResource->getContext()->getPath());
            $controllerResource->create();
            $response->appendContent('Creating actions method in controller ' . $this->_name);
            //CRIA AS ACTIONS
            $response->appendContent(
                'Creating view scripts for the ' . $this->_name . ' action method'
                );
            $actionResource = Zend_Tool_Project_Provider_Action::createResource($this->_loadedProfile,
                                                                                'controller', $this->_name,
                                                                                $this->_module);
            $actionResource->create();

            $viewResource = Zend_Tool_Project_Provider_View::createResource($this->_loadedProfile,
                                                                            'controller.js', $this->_name,
                                                                            $this->_module);
            $viewResource->create();
            $jsview->generateController($viewResource->getContext()->getPath(), $this->_module);
            $this->_storeProfile();

            // CRIA O ACTION list
            $actionResource = Zend_Tool_Project_Provider_Action::createResource($this->_loadedProfile,
                                                                                'list', $this->_name,
                                                                                $this->_module);
            $actionResource->create();
            $viewResource = Zend_Tool_Project_Provider_View::createResource($this->_loadedProfile,
                                                                            'list.js', $this->_name,
                                                                            $this->_module);
            $viewResource->create();
            $jsview->generateList($viewResource->getContext()->getPath(),$this->_module,$this->_fields);
            $this->_storeProfile();

             // CRIA O ACTION edit
            $actionResource = Zend_Tool_Project_Provider_Action::createResource($this->_loadedProfile,
                                                                                'edit', $this->_name,
                                                                                $this->_module);
            $actionResource->create();
            $viewResource = Zend_Tool_Project_Provider_View::createResource($this->_loadedProfile,
                                                                            'edit.js', $this->_name,
                                                                            $this->_module);
            $viewResource->create();
            $jsview->generateEdit($viewResource->getContext()->getPath(),$this->_module,$this->_fields);
            $this->_storeProfile();


            $gui = new My_Tool_Generate_GUIController($this->_name);
            $gui->init($controllerResource->getContext()->getPath());





        }  catch (Exception $e){
            $response = $this->_registry->getResponse();
            $response->setException($e);
            return;
        }
    }

}
