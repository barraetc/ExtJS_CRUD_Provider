/*
 * código gerado automaticamente pelo template store.tpl 
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 * @author Marcone Costa <blog@barraetc.com.br>
*/

Ext.define('ExtZF.model.#CamelObjectName#', {
            extend         : 'Ext.data.Model',
            fields         : ['id','#fieldsList#'],
            proxy          : {
    	    simpleSortMode : true, 
            type           : 'rest',
            url            :   'data/#lowerobjectname#',
            reader         : {
                              type    : 'json',
                              root    : 'rows',
                              successProperty: 'success'
                            },
            writer         : {
                                root     : 'rows',
                                type     : 'json',
                                encode   : true 
                                }
            }
});