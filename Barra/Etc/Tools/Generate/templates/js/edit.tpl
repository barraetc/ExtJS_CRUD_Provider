/*
 * código gerado automaticamente pelo template js/list.tpl 
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 * @author Marcone Costa <blog@barraetc.com.br>
*/

Ext.define('ExtZF.view.#moduleName#.#lowerobjectname#.Edit', {
    extend: 'Ext.window.Window',
    alias : 'widget.#moduleName##CamelObjectName#Edit', 
    title : 'Edição',
    layout: 'fit',
    autoShow: true, 
    initComponent: function() {
    	// Itens da janela
        this.items = [{
            xtype: 'form',
            items: [#configItems#
            ]}
        ];

        this.buttons = [{
            text: 'Salvar',
            iconCls: 'icon-save',
            action: 'salvar'
        },
        {
            text: 'Cancelar',
            iconCls: 'icon-cancel',
            scope: this,
            handler: this.close
        }];

        this.callParent(arguments);
    }
});