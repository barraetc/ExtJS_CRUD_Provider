    /**código gerado automaticamente pelo template init.tpl*/

$swContext = $this->_helper->contextSwitch();
$swContext->setAutoJsonSerialization(true);
$swContext->addContext('js', array('suffix' => 'js'))
                ->addActionContext('Store', array( 'js'))
                ->addActionContext('Model', array('js'))
                ->initContext('js');
$this->_helper->layout()->disableLayout();
        