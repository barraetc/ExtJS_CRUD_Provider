        /**código gerado automaticamente pelo template get.tpl*/
        $#lowerobjectname#Table = new Data_Model_DbTable_#CamelObjectName#();
        try{
            $#lowerobjectname# = $#lowerobjectname#Table->fetchRow('id='.$this->_getParam('id'));
            $this->_helper->viewRenderer->setNoRender(true);
            $this->view->rows= $#lowerobjectname#->toArray();
            $this->view->total = count($rows);
         }catch (Exception $e){
            $this->view->success=false;
            $this->view->msg = 'Erro abrir o registro<br>'. $e->getMessage();
        }
