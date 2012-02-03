        /**código gerado automaticamente */
        $#lowerobjectname#Table = new Data_Model_DbTable_#CamelObjectName#();
        $rows = $#lowerobjectname#Table->fetchAll(null, 'id');
        $this->_helper->viewRenderer->setNoRender(true);
        $this->view->rows= $rows->toArray();
        $this->view->total = count($rows);

