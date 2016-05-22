<?php
class museoweb_modulesBuilder_builder_03CreateModule extends museoweb_modulesBuilder_builder_AbstractCommand
{
	function execute()
	{
		$moduleName = $this->parent->getModuleName();
		$tableName = $this->parent->getTableName();
		$modelName = $tableName.'.models.Model';
		$modifyUrl = 'modulebuilder?state=step3&amp;mod=1&amp;mbTable='.str_replace( '&', '&amp;', rawurlencode( $tableName ) ).'&amp;mbName='.rawurlencode( $moduleName );
		$deleteUrl = $tableName.'?action=deleteModule';

		$output = <<<EOD
<?php
class {$tableName}_Module
{
    static function registerModule()
    {
        glz_loadLocale('$tableName');
        \$moduleVO = org_glizy_Modules::getModuleVO();
        \$moduleVO->id = '$tableName';
        \$moduleVO->name = __T('$tableName');
        \$moduleVO->description = '';
        \$moduleVO->version = '1.0.0';
        \$moduleVO->classPath = '$tableName';
        \$moduleVO->pageType = '{$tableName}.views.FrontEnd';
        \$moduleVO->model = '{$tableName}.models.Model';
        \$moduleVO->author = '';
        \$moduleVO->authorUrl = '';
        \$moduleVO->pluginUrl = 'http://www.museowebcms.it';
        \$moduleVO->siteMapAdmin = '<glz:Page id="{$tableName}_alias" value="{i18n:$tableName}" icon="icon-circle-blank" adm:acl="*" adm:aclPageTypes="{$tableName},{$tableName}_delete,{$tableName}_modify" select="*">'.
                                    '<glz:Page pageType="$tableName.views.Admin" id="$tableName" value="{i18n:MW_SM_SHOW_LIST}" />'.
                                    '<glz:Page pageType="$tableName.views.Admin" id="{$tableName}_modify" value="{i18n:Modifica modulo}" visible="{php:\$user->acl(\'{$tableName}\',\'all\')}" url="$modifyUrl" />'.
                                    '<glz:Page pageType="$tableName.views.Admin" id="{$tableName}_delete" value="{i18n:Cancella modulo}" visible="{php:\$user->acl(\'{$tableName}\',\'all\')}" url="$deleteUrl" />'.
                                    '</glz:Page>';
        \$moduleVO->canDuplicated = false;
        org_glizy_Modules::addModule(\$moduleVO);
    }
}
EOD;

		file_put_contents( $this->parent->getCustomModulesFolder().'/Module.php', $output );
		return true;
	}
}
