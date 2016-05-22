<?php
class org_glizycms_contents_models_proxy_ModuleContentProxy extends GlizyObject
{
    public function loadContent($recordId, $model)
    {
        $document = org_glizy_objectFactory::createModel($model);
        $document->load($recordId);
        $values = $document->getValuesAsArray();

        if (__Config::get('ACL_MODULES')) {
            // caricamento permessi editing e visualizzazione record
            $ar = org_glizy_objectFactory::createModel('org.glizycms.contents.models.DocumentACL');
            $ar->load($recordId);

            $values['__aclEdit'] = $this->getPermissionName($ar->__aclEdit);
            $values['__aclView'] = $this->getPermissionName($ar->__aclView);
        }

        return $values;
    }

    private function getPermissionName($permissions)
    {
		$names = array();
		$permissions = explode(',', $permissions);
		$ar = org_glizy_ObjectFactory::createModel('org.glizycms.roleManager.models.Role');
		foreach ($permissions as $v) {
			if ($ar->load($v)) {
				$names[] = array (
                    'id' => $ar->role_id,
                    'text' => $ar->role_name
                );
			}
		}

		return $names;
	}

    public function saveContent($data, $publish=true)
    {
        $recordId = $data->__id;
        $model = $data->__model;

        $document = org_glizy_objectFactory::createModel($model);
        $document->load($recordId);

        if (property_exists($data, 'title')) {
            $document->title = $data->title;
        }

        if (property_exists($data, 'url')) {
            $document->url = $data->url;
        }

        $document->fulltext = org_glizycms_core_helpers_Fulltext::make($data, $document, true);

        try {
            if ($publish) {
                $id = $document->publish();
            } else {
                // $document->{org_glizy_dataAccessDoctrine_ActiveRecordDocument::DOCUMENT_DETAIL_STATUS} = 'DRAFT';
                // $id = $document->save();
                $id = $document->save(null, false, 'PUBLISHED');
            }

            if (__Config::get('ACL_MODULES')) {
                // gestione acl record
                $ar = org_glizy_objectFactory::createModel('org.glizycms.contents.models.DocumentACL');
                $ar->load($id);
                $ar->__aclEdit = $data->__aclEdit;
                $ar->__aclView = $data->__aclView;
                $ar->save();
            }
        }
        catch (org_glizy_validators_ValidationException $e) {
            return $e->getErrors();
        }

        return array('__id' => $id);
    }

    public function delete($recordId, $model='')
    {
        if (__Config::get('ACL_MODULES')) {
            // cancella i permessi di editing e visualizzazione record
            // TODO gestire le relazioni in ActiveRecordDocument cosicché questo codice venga automaticamente gestito
            // dal delete sul document
            $ar = org_glizy_objectFactory::createModel('org.glizycms.contents.models.DocumentACL');
            $ar->load($recordId);
            $ar->__aclEdit = array();
            $ar->__aclView = array();
            $ar->save();
        }

        // cancella il document;
        $document = org_glizy_objectFactory::createModel(!$model ? 'org.glizycms.core.models.Content' : $model);
        $document->delete($recordId);
    }

    public function toggleVisibility($recordId, $model='')
    {
        $document = org_glizy_objectFactory::createModel(!$model ? 'org.glizycms.core.models.Content' : $model);
        $document->load($recordId);
        $document->setVisible($document->isVisible() ? 0 : 1);
        $document->save();
    }
}