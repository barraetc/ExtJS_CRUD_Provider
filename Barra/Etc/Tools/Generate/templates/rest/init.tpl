    /**código gerado automaticamente pelo template init.tpl*/

$swContext = $this->_helper->contextSwitch();
$swContext->setAutoJsonSerialization(true);
$swContext->addActionContext('index', array('json', 'xml'))
                ->addActionContext('put', array( 'json', 'xml'))
                ->addActionContext('post', array('json', 'xml'))
                ->addActionContext('get', array('json', 'xml'))
                ->addActionContext('delete', array( 'json', 'xml'))
                ->initContext('json');
$this->_helper->layout()->disableLayout();
        