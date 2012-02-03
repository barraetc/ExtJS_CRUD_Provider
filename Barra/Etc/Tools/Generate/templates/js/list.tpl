/*
 * código gerado automaticamente pelo template js/list.tpl 
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 * @author Marcone Costa <blog@barraetc.com.br>
*/

Ext.define('ExtZF.view.#moduleName#.#lowerobjectname#.List' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.#moduleName##CamelObjectName#List', 
    store: '#CamelObjectName#',
    title : 'Lista',
    selModel: {mode: 'MULTI'}, 
    
    tbar :[{
    	text: 'Incluir',
        iconCls: 'icon-new',
    	action: 'incluir'
    },{
    	text: 'Excluir',
        iconCls: 'icon-delete',
    	action: 'excluir'
    }],
	columns: [
                  #configColuns#
                 ],
    dockedItems: [{
        xtype: 'pagingtoolbar',
        store: '#CamelObjectName#',
        dock: 'bottom',
        displayInfo: true
    }]
});