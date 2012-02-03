    /**código gerado automaticamente pelo template put.tpl*/

if(($this->getRequest()->isPut())){
    try{
        $#lowerobjectname#Table = new Data_Model_DbTable_#CamelObjectName#();
        $formData = $this->getRequest()->getParam('rows');
        $formData = json_decode($formData,true);
        $id=$formData['id'];
        unset($formData['id']);
        $#lowerobjectname#Table->update($formData, "id=$id");
        $this->view->msg = "Dados atualizados com sucesso!";
        $row = $#lowerobjectname#Table->fetchRow("id=$id");
        $this->view->rows = $row->toArray();
        $this->view->success=true;

    }  catch (Exception $e){
        $this->view->success=false;
        $this->view->method = $this->getRequest()->getMethod();
        $this->view->msg = "Erro ao atualizar registro<br>".$e->getMessage();
    }
}else{
    $this->view->msg="Método ".$this->getRequest()->getMethod()."<br> Esperado PUT";
}