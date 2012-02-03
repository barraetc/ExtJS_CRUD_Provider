    /**código gerado automaticamente pelo template post.tpl*/

if($this->getRequest()->isPost()){
    try{

        $#lowerobjectname#Table = new Data_Model_DbTable_#CamelObjectName#();
        $formData = $this->getRequest()->getPost('rows');
        $formData = json_decode($formData,true);
        unset($formData['id']);
        foreach ($formData as $key => $value) {
            if($value=='')
               unset($formData[$key]);
        }
        $id = $#lowerobjectname#Table->insert($formData);
        $this->view->msg="Dados inseridos com sucesso!";

        $row = $#lowerobjectname#Table->fetchRow("id=$id");
        $this->view->rows = $row->toArray();
        $this->view->success=true;
        $this->view->metodo = $this->getRequest()->getMethod();

    }  catch (Exception $e){
        $this->view->success = false;
        $this->view->method  = $this->getRequest()->getMethod();
        $this->view->msg     = "Erro ao atualizar/inserir registro<br>" .$e->getMessage();
    }
}else{
    $this->view->msg="Método ".$this->getRequest()->getMethod()."<br>Esperado POST";
}
