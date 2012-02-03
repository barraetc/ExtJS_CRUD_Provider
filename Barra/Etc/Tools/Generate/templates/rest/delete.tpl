    /**código gerado automaticamente pelo template delete.tpl*/

if($this->getRequest()->isDelete()){
    try{
        $#lowerobjectname#Table = new Data_Model_DbTable_#CamelObjectName#();
        $id = $this->_getParam('id');
        $#lowerobjectname#Table->delete('id='.$id);
        $this->view->success=true;
        $this->view->msg="Dados apagados com sucesso!";
    }  catch (Exception $e){
        $this->view->success=false;
        $this->view->msg = "Erro ao apagar o registro<br>".$e->getTraceAsString();
    }
}else{
    $this->view->parametros = $this->_getAllParams();
}