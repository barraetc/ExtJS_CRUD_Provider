/*
 * código gerado automaticamente pelo template "js/controller.tpl" 
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 * @author Marcone Costa <blog@barraetc.com.br>
*/

Ext.require('Ext.window.MessageBox');
Ext.define('ExtZF.controller.#moduleName#.#CamelObjectName#', {
    extend: 'Ext.app.Controller',
    stores: ['#CamelObjectName#'], // Store utilizado no gerenciamento do usuário
    models: ['#CamelObjectName#'], // Modelo do usuário
     views: [
    '#moduleName#.#lowerobjectname#.List',
    '#moduleName#.#lowerobjectname#.Edit'
    ],
    refs: [{
                ref:'grid',
                selector:'#moduleName##CamelObjectName#List'
            },{
                ref:'formPanel',
                selector:'#moduleName##CamelObjectName#Edit'
            }
        ],
    init: function() {
        this.control(
        {
            '#moduleName##CamelObjectName#List': {
                itemdblclick: this.editObject
            },
            '#moduleName##CamelObjectName#List button[action=incluir]': {
                click: this.editObject
            },
            '#moduleName##CamelObjectName#List button[action=excluir]': {
                click: this.deleteObject
            },
            '#moduleName##CamelObjectName#Edit button[action=salvar]': {
                click: this.saveObject
            }
        });
    },
    editObject: function(grid, record) {
        var view = Ext.widget('#moduleName##CamelObjectName#Edit');
        view.setTitle('Edição ');
        if(!record.data){
            record = new ExtZF.model.#CamelObjectName#();
            this.get#CamelObjectName#Store().add(record);
            view.setTitle('Cadastro');
        }
      	view.down('form').loadRecord(record);
    },
    deleteObject: function() {
        var grid = this.getGrid(); // recupera lista de usuários
        ids = grid.getSelectionModel().getSelection(); // recupera linha selecionadas
        if(ids.length === 0){
        	Ext.Msg.alert('Atenção', 'Nenhum registro selecionado');
        	return ;
        }
        Ext.Msg.confirm('Confirmação', 'Tem certeza que deseja excluir o(s) registro(s) selecionado(s)?',
		function(opt){
			if(opt === 'no')
				return;
			grid.el.mask('Excluindo registro(s)');
                        store = this.get#CamelObjectName#Store();
                        store.remove(ids);
                        store.sync();
                        grid.el.unmask();
		}, this);
    },
    saveObject: function(button) {
        var me=this;
        var win    = button.up('window'), // recupera um item acima(pai) do button do tipo window
            form   = win.down('form').getForm() // recupera item abaixo(filho) da window do tipo form
        if (form.isValid()) {
            r = form.getRecord();
            form.updateRecord(r);
            r.save({
                success: function(a,b){
                    Ext.log({msg:"Salvo com sucesso!",level:"info"});
                    win.close();
                    me.get#CamelObjectName#Store().load();
                },
                failure:function(a,b){
                    Ext.log({msg:"Erro ao salvar!",level:"error"});
                }
            });
        }
    }
});