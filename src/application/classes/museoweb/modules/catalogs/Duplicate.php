<?php
class museoweb_modules_catalogs_Duplicate extends GlizyObject
{
    protected $origModuleName = 'Catalog';
    protected $origId = 'museoweb_Catalogs';
    protected $origFolder = 'catalogs';

	function __construct(org_glizy_ModuleVO $moduleVO)
	{
        $userModulesPath = __Paths::get( 'APPLICATION_TO_ADMIN' ).'classes/userModules';

        if ($this->checkPermissions($userModulesPath)) {
            $moduleName = __Request::get('moduleName');
            $moduleName = glz_sanitizeUrlTitle( str_replace(array(' ', '.'), '', $moduleName));
            $newModuleVO = new org_glizy_ModuleVO();
            $newModuleVO->id = 'userModule_'.$moduleName;
            $newModuleVO->name = $moduleName;
            $newModuleVO->classPath = 'userModules.'.$moduleName;
            $newModuleVO->pageType = 'userModules.'.$moduleName.'.views.FrontEnd';

            $modulePath = $userModulesPath.'/'.$newModuleVO->name;

            if (file_exists($modulePath)) {
                $this->logAndMessage( __T( 'Modulo già presente: '.$modulePath), null, true );
                return false;
            }

            $this->copyModule($modulePath, $moduleVO, $newModuleVO);
            $this->fixRouting($modulePath, $newModuleVO);
            $this->fixModel($modulePath, $newModuleVO);
            $this->fixPagetype($modulePath, $newModuleVO);
            $this->fixAdminPagetype($modulePath, $newModuleVO);
            $this->fixRegisterModule($modulePath, $newModuleVO);
            $this->addModuleToStartup($modulePath, $newModuleVO);

            org_glizycms_roleManager_services_RoleService::addModule($newModuleVO->id);

            org_glizy_cache_CacheFile::cleanPHP();

            $this->logAndMessage( __T( 'Modulo duplicato con successo' ) );
        }
	}

    protected function copyModule($modulePath, $moduleVO, $newModuleVO)
    {
        $from = __Paths::get( 'APPLICATION_TO_ADMIN' ).'classes/'.str_replace('.', '/', $moduleVO->classPath);
        org_glizy_helpers_Files::copyDirectory($from, $modulePath);
        @unlink($modulePath.'Duplicate.php');
    }

    protected function fixRouting($modulePath, $newModuleVO)
    {
        $filename = $modulePath.'/config/routing.xml';
        $content = file_get_contents($filename);
        $content = preg_replace('/{pageId=([^}])*}/', '{pageId='.$newModuleVO->pageType.'}', $content);
        $content = preg_replace('/name="([^"])*"/', 'name="'.$newModuleVO->id.'"', $content);
        file_put_contents($filename, $content);
    }

    protected function fixModel($modulePath, $newModuleVO)
    {
        $filename = $modulePath.'/models/Model.xml';
        $content = file_get_contents($filename);
        $content = preg_replace('/model:tableName=".+?"/', 'model:tableName="'.$newModuleVO->id.'"', $content);
        file_put_contents($filename, $content);
    }

    protected function fixRegisterModule($modulePath, $newModuleVO)
    {
        $filename = $modulePath.'/Module.php';
        $content = file_get_contents($filename);
        $classPathUnderscore = str_replace('.', '_', $newModuleVO->classPath);

        $search = array(
            'museoweb_modules_'.$this->origFolder.'_Module',
            $this->origId,
            'museoweb.modules.'.$this->origFolder.'.views.Admin',
            '__T(\''.addslashes($this->origModuleName).'\')',
            '{i18n:'.addslashes($this->origModuleName).'}',
            'museoweb.modules.'.$this->origFolder,
            '$moduleVO->canDuplicated = true',
            'org_glizy_Modules::addModule'
        );

        $replace = array(
            $classPathUnderscore.'_Module',
            $newModuleVO->id,
            $newModuleVO->classPath.'.views.Admin',
            '\''.$newModuleVO->name.'\'',
            '{i18n:'.$newModuleVO->name.'}',
            $newModuleVO->classPath,
            '$moduleVO->canDuplicated = false',
            'org_glizy_locale_Locale::append(array(\''.$newModuleVO->classPath.'.views.FrontEnd\' => \''.$newModuleVO->name.'\'));org_glizy_Modules::addModule'
        );

        $content = str_replace($search, $replace, $content);
        file_put_contents($filename, $content);
    }

    protected function fixPagetype($modulePath, $newModuleVO)
    {
        $filename = $modulePath.'/views/FrontEnd.xml';
        $content = file_get_contents($filename);
        $content = str_replace('museoweb.modules.'.$this->origFolder.'.models.Model', $newModuleVO->classPath.'.models.Model', $content);
        $content = str_replace($this->origId, $newModuleVO->id, $content);
        file_put_contents($filename, $content);
    }

    protected function fixAdminPagetype($modulePath, $newModuleVO)
    {
        $filename = $modulePath.'/views/Admin.xml';
        $content = file_get_contents($filename);
        $content = str_replace('museoweb.modules.'.$this->origFolder.'.models.Model', $newModuleVO->classPath.'.models.Model', $content);
        file_put_contents($filename, $content);
    }

    protected function addModuleToStartup($modulePath, $newModuleVO)
    {
		$startup = __Paths::get( 'APPLICATION_TO_ADMIN' ).'startup/modules_custom.php';
		if ( file_exists( $startup ) )
		{
			$output = file_get_contents( $startup );
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

        $classPathUnderscore = str_replace('.', '_', $newModuleVO->classPath);

        $output .= GLZ_COMPILER_NEWLINE2.$classPathUnderscore.'_Module::registerModule();';

		file_put_contents( $startup, $output );
    }

    protected function checkPermissions($path)
    {
        if (!is_writeable($path)) {
            $this->logAndMessage( __T( 'Rendere scrivibile la cartella: '.$path), null, true );
            return false;
        }

        return true;
    }
}
