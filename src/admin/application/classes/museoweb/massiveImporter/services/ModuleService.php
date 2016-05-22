<?php
// TODO: sostituire con org_glizycms_helpers_Modules
class museoweb_massiveImporter_services_ModuleService extends GlizyObject
{
    public function getFields($pageId)
    {
        $editForm = $this->getEditForm($pageId);

        $fields = array();

        for ($i = 0; $i < count($editForm->childComponents); $i++)
        {
            $c = $editForm->childComponents[$i];
            $id = $c->getAttribute('id');

            if ( ( is_subclass_of($c, 'org_glizy_components_HtmlFormElement') || is_a($c, 'org_glizy_components_Fieldset') ) && substr($id, 0, 2) != '__' ) {
                $fields[$id] = $c;
            }
        }

        return $fields;
    }

    public function getModelPath($pageId)
    {
        $editForm = $this->getEditForm($pageId);

        for ($i = 0; $i < count($editForm->childComponents); $i++)
        {
            $c = $editForm->childComponents[$i];
            $id = $c->getAttribute('id');

            if ($id == '__model') {
                return $c->getAttribute('value');
            }
        }

        return null;
    }

    protected function getEditForm($pageId)
    {
        $application = org_glizy_ObjectValues::get('org.glizy', 'application');

        $originalRootComponent = $application->getRootComponent();

        $siteMap = $application->getSiteMap();
        $siteMapNode = $siteMap->getNodeById($pageId);
        $pageType = $siteMapNode->getAttribute('pageType');

        $path = org_glizy_Paths::get('APPLICATION_PAGETYPE');
        $templatePath = org_glizycms_Glizycms::getSiteTemplatePath();
        $options = array(
            'skipImport' => true,
            'pathTemplate' => $templatePath,
            'mode' => 'edit'
        );

        $pageTypeObj = &org_glizy_ObjectFactory::createPage($application, $pageType, $path, $options);

        $rootComponent = $application->getRootComponent();
        $rootComponent->init();
        $application->_rootComponent = &$originalRootComponent;

        __Request::set('action', 'edit');
        $rootComponent->process();

        return $rootComponent->getComponentById('editForm');
    }
}