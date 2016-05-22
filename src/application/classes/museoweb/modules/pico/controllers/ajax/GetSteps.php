<?php
class museoweb_modules_pico_controllers_ajax_GetSteps extends org_glizy_mvc_core_CommandAjax
{
    function execute($from, $to)
    {
        if ($this->user->isLogged())
        {
            $steps = array();

            $availableModules = museoweb_modules_pico_Module::getMappingToModel();
            $modules = org_glizy_Modules::getModules();
            foreach( $modules as $m ) {
                $model = $m->classPath.'.models.Model';
                if (in_array($model, $availableModules)) {
                    $mappingClass = array_search($model, $availableModules);
                    $steps[] = array('action' => 'DeleteIndex', 'params' => array(
                            'mapping' => $mappingClass
                        ));
                }
            }

            // step per aggiorna i dati
            $indexStep = 100;
            $enabledModules = museoweb_modules_pico_Module::getEnabledModules();

            foreach ($enabledModules as $k=>$v) {
                $it = org_glizy_ObjectFactory::createModelIterator($v);
                $it->exec();
                $count = $it->count();
                if ($count) {
                    $part = ceil($count/$indexStep);
                    for ($i=0; $i<$part;$i++) {
                        $steps[] = array('action' => 'CreateIndex', 'params' => array('mapping' => $k, 'model' => $v, 'start' => $i*$indexStep));
                    }
                }
            }
        }
        return $steps;
    }
}