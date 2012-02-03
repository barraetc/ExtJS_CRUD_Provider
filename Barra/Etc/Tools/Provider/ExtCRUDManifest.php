<?php
/**
 * Gerador de código para CRUD ExtJS + Zend Framework
 * 
 * @author Marcone Costa <blog@barraetc.com.br>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 **/

class Barra_Etc_Tools_Provider_ExtCRUDManifest implements Zend_Tool_Framework_Manifest_ProviderManifestable
{
    /**
     * Returns the list of all available providers
     *
     * @return array
     */
    public function getProviders()
    {
        return array(
                new Barra_Etc_Tools_Provider_ExtCRUDProvider()
        );
    }
} 
