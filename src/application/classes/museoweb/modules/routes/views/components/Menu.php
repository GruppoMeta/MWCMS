<?php
class museoweb_modules_routes_views_components_Menu extends org_glizy_components_Component
{
    var $_routeGroupId;
    var $_routeThemeId;
    var $_routeId;
    var $_routeGroupAR;
    var $_routeThemeAR;
    var $_routeAR;

    public function process()
    {
        $this->_currentState = __Request::get('state', 'text');
        $this->_routeGroupId = org_glizy_Request::get(museoweb_modules_routes_Module::MW_RouteGroups, 0);
        $this->_routeThemeId = org_glizy_Request::get(museoweb_modules_routes_Module::MW_RouteThemes, 0);
        $this->_routeId = org_glizy_Request::get(museoweb_modules_routes_Module::MW_Routes, 0);

        if ($this->_currentState!='text') {
            $siteMap                = $this->_application->getSiteMap();
            $iteratorRouteGroups    = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.routes.models.Group');
            $iteratorRouteGroups->orderBy('routegroupdetail_title');
            $currentMenu            = $siteMap->getNodeById($this->_application->getPageId());

            foreach ($iteratorRouteGroups as $arRouteGroups) {
                $pageIdRouteGroups = $arRouteGroups->document_id.'_0_0';
                $menuRecord = array();
                $menuRecord['title']        = $arRouteGroups->routegroupdetail_title;
                $menuRecord['description']  = '';
                $menuRecord['id']           = '.'.(900+$arRouteGroups->document_id);
                $menuRecord['pageType']     = $pageIdRouteGroups;
                $menuRecord['isVisible']    = 1;
                $menuRecord['creationDate'] = $arRouteGroups->document_creationDate;
                $menuRecord['modificationDate'] = $arRouteGroups->document_detail_modificationDate;
                $menuRecord['url'] = __Routing::makeURL('museoweb_RoutesGroup', array(museoweb_modules_routes_Module::MW_RouteGroups => $arRouteGroups->document_id));
                $siteMap->addChildMenu($currentMenu, $menuRecord);

                $iteratorRouteThemes = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.routes.models.Theme');
                $iteratorRouteThemes->where('routethemedetail_FK_routegroup_id', $arRouteGroups->document_id, '=' );
                $iteratorRouteThemes->orderBy('routethemedetail_title');
                $currentRouteGroups     = &$siteMap->getNodeById($menuRecord['id']);
                foreach ($iteratorRouteThemes as $arRouteThemes) {
                    $pageIdRouteThemes = $arRouteGroups->document_id.'_'.$arRouteThemes->document_id.'_0';
                    $menuRecord = array();
                    $menuRecord['title']        = $arRouteThemes->routethemedetail_title;
                    $menuRecord['description']  = '';
                    $menuRecord['id']           = '.'.(9000+$arRouteThemes->document_id);
                    $menuRecord['pageType']     = $pageIdRouteThemes;
                    $menuRecord['isVisible']    = 1;
                    $menuRecord['creationDate'] = $arRouteThemes->document_creationDate;
                    $menuRecord['modificationDate'] = $arRouteThemes->document_detail_modificationDate;
                    $menuRecord['url']          = __Routing::makeURL('museoweb_RoutesTheme', array(museoweb_modules_routes_Module::MW_RouteGroups => $arRouteGroups->document_id,
                                                                                                    museoweb_modules_routes_Module::MW_RouteThemes => $arRouteThemes->document_id));
                    $siteMap->addChildMenu($currentRouteGroups, $menuRecord);


                    $iteratorRouteThemes = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.routes.models.Route');
                    $iteratorRouteThemes->where('routedetail_FK_routetheme_id', $arRouteThemes->document_id, '=' );
                    $iteratorRouteThemes->orderBy('routedetail_title');
                    $currentRouteThemes     = &$siteMap->getNodeById($menuRecord['id']);
                    foreach ($iteratorRouteThemes as $arRoutes) {
                        $pageIdRoutes               = $arRouteGroups->document_id.'_'.$arRouteThemes->document_id.'_'.$arRoutes->document_id;
                        $menuRecord                 = array();
                        $menuRecord['title']        = $arRoutes->routedetail_title;
                        $menuRecord['description']  = '';
                        $menuRecord['id']           = '.'.(90000+$arRoutes->document_id);
                        $menuRecord['pageType']     = $pageIdRoutes;
                        $menuRecord['isVisible']    = 1;
                        $menuRecord['creationDate'] = $arRoutes->document_creationDate;
                        $menuRecord['modificationDate'] = $arRoutes->document_detail_modificationDate;
                        $menuRecord['url']          =   __Routing::makeURL('museoweb_Routes', array(museoweb_modules_routes_Module::MW_RouteGroups => $arRouteGroups->document_id,
                                                                                                    museoweb_modules_routes_Module::MW_RouteThemes => $arRouteThemes->document_id,
                                                                                                    museoweb_modules_routes_Module::MW_Routes => $arRoutes->document_id));
                        $siteMap->addChildMenu($currentRouteThemes, $menuRecord);
                    }
                }

            }

            $pageType = (empty($this->_routeGroupId) ? '0' : $this->_routeGroupId).'_'.(empty($this->_routeThemeId) ? '0' : $this->_routeThemeId).'_'.(empty($this->_routeId) ? '0' : $this->_routeId);
            $menu = $siteMap->getMenuByPageType($pageType);
            $this->_application->setPageId($menu->id);

            $evt = array('type' => GLZ_EVT_SITEMAP_UPDATE );
            $this->dispatchEvent($evt);
        }
    }
}