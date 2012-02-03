    /**código gerado automaticamente pelo template init.tpl*/

$swContext = $this->_helper->contextSwitch();
$swContext->setAutoJsonSerialization(true);
$swContext->addContext('js', array('suffix' => 'js'))
                ->addActionContext('Controller', array( 'js'))
                ->addActionContext('List', array( 'js'))
                ->addActionContext('Edit', array('js'))
                ->initContext('js');
$this->_helper->layout()->disableLayout();