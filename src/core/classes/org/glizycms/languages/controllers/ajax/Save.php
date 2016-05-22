<?php
class org_glizycms_languages_controllers_ajax_Save extends org_glizy_mvc_core_CommandAjax
{
    public function execute($data)
    {
// TODO controllo acl
// TODO per motifi di sicurezza forse è meglio non passare il nome del model nella request
// ma avere un controller specifico che estende quello base al quale viene passato il nome del model, come succede per Scaffold

        $proxy = org_glizy_objectFactory::createObject('org.glizycms.languages.models.proxy.LanguagesProxy');
        $result = $proxy->save(json_decode($data));

        $this->directOutput = true;

        if ($result['__id']) {
            return array('set' => $result);
        }
        else {
            return array('errors' => $result);
        }
    }
}