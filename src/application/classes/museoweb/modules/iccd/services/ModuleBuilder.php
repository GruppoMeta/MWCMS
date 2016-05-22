<?php
class museoweb_modules_iccd_services_ModuleBuilder extends GlizyObject
{
    public function createModule($moduleName, $elements, $htmlElements, $fieldsAttributes)
    {
        $moduleNameSuffix = lcfirst(preg_replace('/\W+/', '', $moduleName));

        $classPath = $moduleNameSuffix;
        $classPathUnderscore = str_replace('.', '_', $classPath);

        $moduleVO = new org_glizy_ModuleVO();
        $moduleVO->id = $classPathUnderscore;
        $moduleVO->name = $classPath.'.views.FrontEnd';
        $moduleVO->description = ''; // TODO
        $moduleVO->version = '1.0.0';
        $moduleVO->pageType = $classPath.'.views.FrontEnd';
        $moduleVO->classPath = $classPath;
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        //$moduleVO->siteMapAdmin = '<glz:Page pageType="'.$classPath.'.views.Admin" id="'.$moduleVO->id.'" value="{i18n:'.$moduleVO->pageType.'}" icon="icon-circle-blank" adm:acl="*" />';

        $moduleVO->siteMapAdmin =<<<EOD

<glz:Page id="{$moduleVO->id}_alias" value="{i18n:$moduleVO->pageType}" icon="icon-circle-blank" adm:acl="*" adm:aclPageTypes="{$moduleVO->id},{$moduleVO->id }_delete" select="*">
    <glz:Page pageType="$classPath.views.Admin" id="$moduleVO->id" value="{i18n:MW_SM_SHOW_LIST}" />
    <glz:Page pageType="$classPath.views.Admin" id="{$moduleVO->id}_delete" value="{i18n:Cancella modulo}" visible="{php:\$user->acl(\'{$moduleVO->id}\',\'all\')}" url="{$moduleVO->id}?action=deleteModule" />
</glz:Page>
EOD;

        $moduleVO->canDuplicated = false;

        $modulePath = __Paths::get( 'APPLICATION_TO_ADMIN' ).'classes/userModules/'.$moduleNameSuffix.'/';

        @mkdir($modulePath);
        @mkdir($modulePath.'config');
        @mkdir($modulePath.'locale');
        @mkdir($modulePath.'models');
        @mkdir($modulePath.'views');

        $this->createRouting($modulePath, $moduleVO);
        $this->createLocale($moduleName, $modulePath, $moduleVO, $fieldsAttributes);
        $this->createModelFile($modulePath, $moduleVO, $elements, $fieldsAttributes);
        $this->createAdminFile($modulePath, $moduleVO, $htmlElements);
        $this->createFrontEndFile($moduleNameSuffix, $modulePath, $moduleVO, $elements);
        $this->createModuleFile($modulePath, $moduleVO);
        $this->createSkins($moduleNameSuffix, $modulePath, $moduleVO, $elements);
        $this->addModuleToStartup($modulePath, $moduleVO);

        org_glizy_cache_CacheFile::cleanPHP();
    }

    protected function createRouting($modulePath, $moduleVO)
    {
        $filename = $modulePath.'config/routing.xml';

        $content = <<<EOD
<?xml version="1.0" encoding="utf-8"?>
<glz:Routing>
    <glz:Route name="{$moduleVO->classPath}" value="{pageId={$moduleVO->pageType}}/{static=state=show}/{integer=document_id}/{value=catalogdetail_title}" />
</glz:Routing>
EOD;
        @file_put_contents($filename, $content);
    }

    protected function createLocale($moduleName, $modulePath, $moduleVO, $fieldsAttributes)
    {
        $filename = $modulePath.'locale/it.php';

        $labelsMapping = '';
        foreach ($fieldsAttributes as $fieldName => $fieldAttributes) {
            if ($fieldAttributes['label']) {
                $labelsMapping .= '    "'.$fieldName.'" => "'.$fieldAttributes['label'].'",'.PHP_EOL;
            }
        }

        $content = <<<EOD
<?php
\$strings = array (
    "{$moduleVO->pageType}" => "$moduleName",
$labelsMapping
);
org_glizy_locale_Locale::append(\$strings);
EOD;
        //echo($filename); echo($content); die;
        @file_put_contents($filename, $content);
    }

    protected function createModelFile($modulePath, $moduleVO, $elements, $fieldsAttributes)
    {
        $filename = $modulePath.'models/Model.xml';

        $modelFields = $this->makeModel($elements, $fieldsAttributes);

        $content = <<<EOD
<?xml version="1.0" encoding="utf-8"?>
<model:Model
    xmlns:glz="http://www.glizy.org/dtd/1.0/"
    xmlns:model="http://www.glizy.org/dtd/1.0/model/"
    model:tableName="{$moduleVO->classPath}" model:usePrefix="true" model:type="document">

    <model:Script parent="model">
    <![CDATA[
    function loadFromArray(\$values, \$useSet=false)
    {
        parent::loadFromArray(\$values, \$useSet);

        // carica i valori delle schede collegate
        foreach (\$this->data as \$k => \$v) {
            \$field = \$this->getField(\$k);
            if (\$field->option) {
                \$subField = \$this->\$k->{'__'.\$k};
                foreach ((array)\$subField as \$referred) {
                    \$ar = org_glizy_objectFactory::createModel(\$field->option);
                    \$ar->load(\$referred->id);
                    \$referred->values = \$ar->getValuesAsArray();
                }
            }
        }
    }
    ]]>
    </model:Script>

    <model:Define>
        <model:Field name="fulltext" type="string" index="fulltext" onlyIndex="true" />
        <model:Field name="thesaurus" type="text" />
$modelFields
    </model:Define>
</model:Model>
EOD;
        @file_put_contents($filename, $content);
    }

    protected function makeModel($elements, $fieldsAttributes)
    {
        $output = '';

        foreach ($elements as $element) {
            $output .= $this->makeModelField($element, $fieldsAttributes);
        }

        return $output;
    }

    protected function makeModelField($element, $fieldsAttributes)
    {
        $elementName = $element['name'];
        $option = '';
        $indeField = '';

        if ($fieldsAttributes[$elementName]['authorityFile']) {
            $option = 'option="'.$fieldsAttributes[$elementName]['authorityFile']['model'].'"';
        }

        if ($fieldsAttributes[$elementName]['index'] || $elementName=='TSK' || $elementName=='OGTD') {
            $indeField = 'index="true"';
        }

        if ($element['children']) {
            $element['minOccurs'] = $element['required'] === 'true' ? 1 : 0;

            // se è un campo ripetibile
            if (!($element['minOccurs'] == 1 && $element['maxOccurs'] == 1) || $element['maxOccurs'] > 1 || $element['maxOccurs'] == 'unbounded') {
                $output .=  '<model:Field name="'.$elementName.'" type="object" readFormat="false" '.$option.' '.$indeField.'/>'.PHP_EOL;
            } else {
                foreach ($element['children'] as $child) {
                    $output .= $this->makeModelField($child, $fieldsAttributes);
                }
            }
        } else {
            $output = '<model:Field name="'.$elementName.'" type="string" length="'.$element['maxLength'].'" '.$indeField.'/>'.PHP_EOL;
        }

        return $output;
    }

    protected function createAdminFile($modulePath, $moduleVO, $htmlElements)
    {
        $filename = $modulePath.'views/Admin.xml';

        $content = <<<EOD
<?xml version="1.0" encoding="utf-8"?>
<mvc:Page id="Page"
    xmlns:glz="http://www.glizy.org/dtd/1.0/"
    xmlns:cms="org.glizycms.views.components.*"
    xmlns:mvc="org.glizy.mvc.components.*"
    xmlns:r="org.glizycms.roleManager.views.*"
    xmlns:pico="museoweb.modules.pico.views.components.*"
    defaultEditableRegion="content"
    templateType="php"
    templateFileName="Page.php">

    <glz:Import src="_common.xml" />

     <mvc:State name="index">
        <glz:Link label="{i18n:GLZ_ADD_NEW_RECORD}" cssClass="{config:glizycms.form.actionLink.cssClass}" icon="icon-plus" routeUrl="actionsMVCAdd" editableRegion="actions" acl="*,new"/>
        <glz:DataGridAjax id="dataGrid" recordClassName="{$moduleVO->classPath}.models.Model" cssClass="table table-bordered table-striped">
            <glz:DataGridColumn columnName="OGTD" headerText="{i18n:Definizione}" renderCell="org.glizycms.contents.views.renderer.DocumentTitle" />
            <glz:DataGridColumn columnName="TSK" headerText="{i18n:Tipo scheda}" renderCell="org.glizycms.contents.views.renderer.DocumentTitle" />
            <glz:DataGridColumn columnName="document_id" sortable="false" searchable="false" renderCell="org.glizycms.contents.views.renderer.CellEditDeleteVisible" />
        </glz:DataGridAjax>
    </mvc:State>

    <mvc:State name="edit">
        <cms:FormEdit id="editForm" newCode="true" controllerName="org.glizycms.contents.controllers.moduleEdit.*">
            <glz:Hidden id="__id" />
            <glz:Hidden id="__model" value="{$moduleVO->classPath}.models.Model"/>

            <pico:Thesaurus2 id="thesaurus" label="{i18n:Pico Thesaurus}" />

$htmlElements

            <glz:Import src="_permissions.xml" />

            <cms:FormButtonsPanel>
                <glz:HtmlButton label="{i18n:GLZ_SAVE}" type="button" cssClass="btn btn-primary js-glizycms-save" data="action=save" />
                <glz:HtmlButton label="{i18n:GLZ_SAVE_CLOSE}" type="button" cssClass="btn js-glizycms-save" data="action=saveClose" />
                <glz:HtmlButton label="{i18n:GLZ_CANCEL}" type="button" routeUrl="link" cssClass="btn js-glizycms-cancel" data="action=close" />
            </cms:FormButtonsPanel>
        </cms:FormEdit>
    </mvc:State>

    <mvc:State name="delete">
        <glz:Hidden controllerName="org.glizycms.contents.controllers.moduleEdit.*" />
    </mvc:State>
    <mvc:State name="deleteModule">
        <glz:LongText><![CDATA[ Sei sicuro di vole cancellare il modulo?<br />Verranno cancellati i file del modulo e la pagina nella struttura del sito.]]></glz:LongText>
        <glz:Form id="myForm" removeGetValues="false" controllerName="museoweb.modulesBuilder.controllers.DeleteModule">
            <glz:Panel cssClass="formButtons">
                <glz:HtmlButton label="{i18n:Cancella modulo}" id="next" value="next" cssClass="btn" />
            </glz:Panel>
        </glz:Form>
    </mvc:State>
	<mvc:State name="togglevisibility">
		<glz:Hidden controllerName="org.glizycms.contents.controllers.moduleEdit.*" />
	</mvc:State>
</mvc:Page>
EOD;

        //echo($filename); echo($content); die;
        @file_put_contents($filename, $content);
    }

    protected function createModuleFile($modulePath, $moduleVO)
    {
        $filename = $modulePath.'Module.php';

        $canDuplicated = $moduleVO->canDuplicated ? 'true' : 'false';

        $content = <<<EOD
<?php
class {$moduleVO->id}_Module
{
    static function registerModule()
    {
        glz_loadLocale('$moduleVO->classPath');

        \$moduleVO = org_glizy_Modules::getModuleVO();
        \$moduleVO->id = '$moduleVO->id';
        \$moduleVO->name = __T('$moduleVO->name');
        \$moduleVO->description = '$moduleVO->description';
        \$moduleVO->version = '$moduleVO->version';
        \$moduleVO->classPath = '$moduleVO->classPath';
        \$moduleVO->pageType = '$moduleVO->pageType';
        \$moduleVO->model = '{$moduleVO->classPath}.models.Model';
        \$moduleVO->author = '$moduleVO->author';
        \$moduleVO->authorUrl = '$moduleVO->authorUrl';
        \$moduleVO->pluginUrl = '$moduleVO->pluginUrl';
        \$moduleVO->siteMapAdmin = '$moduleVO->siteMapAdmin';
        \$moduleVO->canDuplicated = $canDuplicated;

        org_glizy_Modules::addModule( \$moduleVO );
    }
}
EOD;
        @file_put_contents($filename, $content);
    }

    protected function createFrontEndFile($moduleNameSuffix, $modulePath, $moduleVO, $elements)
    {
        $filename = $modulePath.'views/FrontEnd.xml';

        $content = <<<EOD
<?xml version="1.0" encoding="utf-8"?>
<glz:Page id="Page"
    xmlns:glz="http://www.glizy.org/dtd/1.0/"
    xmlns:c="{$moduleVO->classPath}.views.components.*"
    xmlns:cms="org.glizycms.views.components.*"
    templateType="php"
    templateFileName="page.php"
    defaultEditableRegion="content"
    adm:editComponents="text">
    <glz:Import src="Common.xml" />
    <glz:DataProvider id="ModuleDP" recordClassName="{$moduleVO->classPath}.models.Model" order="OGTD" />
    <glz:StateSwitch defaultState="list" rememberState="false">
        <glz:State name="list">
            <glz:LongText id="text" label="{i18n:MW_PARAGRAPH_TEXT}" forceP="true" adm:rows="20" adm:cols="75" adm:htmlEditor="true" />
            <glz:SearchFilters id="filters" cssClass="search">
                <glz:Input id="filterTitle" label="{i18n:Definizione}" bindTo="OGTD" value="{filters}" />
                <glz:Panel cssClass="formButtons">
                    <glz:HtmlButton label="{i18n:MW_SEARCH}" value="SEARCH" target="{filters}" cssClass="submitButton" />
                    <glz:HtmlButton label="{i18n:MW_NEW_SEARCH}" value="RESET" target="{filters}" cssClass="submitButton" />
                </glz:Panel>
            </glz:SearchFilters>

            <glz:RecordSetList id="list" dataProvider="{ModuleDP}" routeUrl="{$moduleVO->classPath}" title="{i18n:MW_SEARCH_RESULT}" filters="{filters}" paginate="{paginate}" skin="mwcms_{$moduleNameSuffix}_list.html" />
            <glz:PaginateResult id="paginate" cssClass="pagination" />
        </glz:State>
        <glz:State name="show">
            <glz:Modifier target="pagetitle" attribute="visible" value="false" />
            <glz:RecordDetail id="entry" dataProvider="{ModuleDP}" idName="document_id" skin="mwcms_{$moduleNameSuffix}_entry.html"/>
            <glz:Link id="backbtn" editableRegion="afterContent" cssClass="moreLeft" label="{i18n:MW_BACK_TO_SEARCH}" />
        </glz:State>
    </glz:StateSwitch>
</glz:Page>
EOD;
        @file_put_contents($filename, $content);
    }

    public function createSkins($moduleNameSuffix, $modulePath, $moduleVO, $elements)
    {
        $this->createListSkin($moduleNameSuffix, $modulePath, $moduleVO);
        $this->createEntrySkin($moduleNameSuffix, $modulePath, $moduleVO, $elements);
    }

    public function createListSkin($moduleNameSuffix, $modulePath, $moduleVO)
    {
        $filename = __Paths::get('STATIC_DIR').'museoweb/templates/Default/skins/mwcms_'.$moduleNameSuffix.'_list.html';

        $content = <<<EOD
<div class="searchResults" tal:condition="php: !is_null(Component.records)">
    <h3 tal:content="structure Component/title"/>
    <span tal:omit-tag="" tal:condition="php: Component.records.count() > 0">
        <div tal:repeat="item Component/records" tal:attributes="class item/__cssClass__">
            <div class="right">
                <h4><a href="" tal:attributes="href item/__url__; title item/OGTD" tal:content="structure item/OGTD"></a></h4>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </span>
    <span tal:omit-tag="" tal:condition="php: Component.records.count() == 0">
        <div class="around" >
            <p tal:content="php:__T('Definizione')"></p>
        </div>
    </span>
    <div class="clear"></div>
</div>
EOD;
        @file_put_contents($filename, $content);
    }

    protected function makeFrontEndSkinElements($elements)
    {
        $output = '';

        foreach ($elements as $element) {
            $output .= $this->makeFrontEndSkinElement($element);
        }

        return $output;
    }

    protected function makeFrontEndSkinElement($element, $parentComponent='Component', $level=0)
    {
        $elementName = $element['name'];
        $attributes = array('id' => $elementName);
        $indent = str_repeat('  ', $level);

        if ($element['children']) {
            // se è un campo ripetibile
            if (!($element['minOccurs'] == 1 && $element['maxOccurs'] == 1) || $element['maxOccurs'] > 1 || $element['maxOccurs'] == 'unbounded') {

                $output .= $indent.'<span tal:omit-tag="" tal:repeat="'.$elementName.' '.$parentComponent.'/'.$elementName.'">'.PHP_EOL;

                foreach ($element['children'] as $child) {
                    $output .= $this->makeFrontEndSkinElement($child, $elementName, $level+1);
                }

                $output .= $indent.'</span>'.PHP_EOL;
            }
            else {
                if ($elementName == 'DTZ') {
                }
                foreach ($element['children'] as $child) {
                    $output .= $this->makeFrontEndSkinElement($child, $parentComponent, $level);
                }
            }
        } else {
            if ($element['maxOccurs'] > 1 || $element['maxOccurs'] == 'unbounded') {
                $attributesInput = array(
                    'id' => $elementName.'-element',
                );

                $content = PHP_EOL.'  '.org_glizy_helpers_Html::renderTag('glz:Text', $attributesInput).PHP_EOL;
                //$output = org_glizy_helpers_Html::renderTag('glz:Repeater', $attributes, true, $content).PHP_EOL;
            } else {
                $output .= <<<EOD
$indent<span tal:omit-tag="" tal:condition="php: $parentComponent.$elementName != ''">
$indent  <dt tal:content="structure php: __T('$elementName')"></dt>
$indent  <dd tal:content="structure $parentComponent/$elementName"></dd>
$indent</span>
EOD;
                $output .= PHP_EOL;
            }
        }

        return $output;
    }

    public function createEntrySkin($moduleNameSuffix, $modulePath, $moduleVO, $elements)
    {
        $filename = __Paths::get('STATIC_DIR').'museoweb/templates/Default/skins/mwcms_'.$moduleNameSuffix.'_entry.html';

        $skinElements = $this->makeFrontEndSkinElements($elements);

        $content = <<<EOD
$skinElements
EOD;

        @file_put_contents($filename, $content);
    }

    protected function addModuleToStartup($modulePath, $newModuleVO)
    {
        $sitemapCustom = __Paths::get( 'APPLICATION_TO_ADMIN' ).'startup/modules_custom.php';
		if ( file_exists( $sitemapCustom ) )
		{
			$output = file_get_contents( $sitemapCustom );
		}
		else
		{

			$output = <<<EOD
<?php
\$application = org_glizy_ObjectValues::get('org.glizy', 'application' );
if (\$application) {
    if (!\$application->isAdmin()) {
        __Paths::addClassSearchPath( __Paths::get( 'APPLICATION_CLASSES' ).'userModules/' );
    }
//modules_custom.php
}
EOD;
		}
		// cancella entry già presenti
		$output = preg_replace( "/\/\/\sstart\s".$newModuleVO->id."\/\/([^\/])*\/\/\send\s".$newModuleVO->id."\/\//i", "", $output );

		// aggiunge la nuova entry
		$output = str_replace( '//modules_custom.php', '// start '.$newModuleVO->id.'//'.GLZ_COMPILER_NEWLINE2.$newModuleVO->id.'_Module::registerModule();'.GLZ_COMPILER_NEWLINE2.'// end '.$newModuleVO->id.'//'.GLZ_COMPILER_NEWLINE2.'//modules_custom.php', $output );

		$r = file_put_contents( $sitemapCustom, $output );
	}
}