<?php
class museoweb_modulesBuilder_builder_d04DeleteThesaurus extends museoweb_modulesBuilder_builder_AbstractCommand
{
	function execute()
	{
		$moduleName = $this->parent->getTableName();

		$ar = @org_glizy_objectFactory::createModel('museoweb.modules.iccd.models.ICCDThesaurus');

		if ($ar) {
		    $ar->delete(array('iccd_theasaurs_module' => $moduleName));
		}

		return true;
	}
}