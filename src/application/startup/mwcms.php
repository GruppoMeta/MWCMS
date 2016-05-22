<?php
org_glizycms_Glizycms::init();
glz_loadLocale('museoweb');

museoweb_modules_blog_Module::registerModule();
museoweb_modules_mountings_Module::registerModule();
museoweb_modules_competitions_Module::registerModule();
museoweb_modules_events_Module::registerModule();
museoweb_modules_glossary_Module::registerModule();
museoweb_modules_merchandising_Module::registerModule();
museoweb_modules_exhibitions_Module::registerModule();
museoweb_modules_regulations_Module::registerModule();
museoweb_modules_news_Module::registerModule();
museoweb_modules_catalogs_Module::registerModule();
museoweb_modules_catalogsMultimedia_Module::registerModule();
museoweb_modules_catalogsArchive_Module::registerModule();
museoweb_modules_catalogsIcono_Module::registerModule();
museoweb_modules_touristRoutes_Module::registerModule();
museoweb_modules_projects_Module::registerModule();
museoweb_modules_pressRooms_Module::registerModule();
museoweb_modules_publications_Module::registerModule();
museoweb_modules_examinations_Module::registerModule();
museoweb_modules_routes_Module::registerModule();
museoweb_modules_ecommerce_Module::registerModule();
museoweb_modules_mag_Module::registerModule();
museoweb_modules_newsletter_Module::registerModule();
museoweb_modules_iccd_Module::registerModule();
museoweb_modules_schedaAUT_Module::registerModule();
museoweb_modules_schedaBIB_Module::registerModule();
museoweb_modules_schedaDSC_Module::registerModule();
museoweb_modules_schedaRCG_Module::registerModule();

glz_loadLocale('it.gruppometa.metacms.modules.solr');
museoweb_modules_solr_Module::registerModule();

org_glizy_plugins_PluginManager::addPlugin('org.glizy.plugins.Search', 'museoweb.search.Content');


function MW_addImageInsideParagraph($par, $image, $cssClass='left')
{
    $img = $image['__html__'];
    if (preg_match('/class="(.*)"/', $img))
    {
        $img = preg_replace('/class="(.*)"/', 'class="'.$cssClass.'"', $img);
    }
    else
    {
        $img = preg_replace('/img\s/', 'img class="'.$cssClass.'" ', $img);
    }
    $par = preg_replace('/(<p[^>]*>)/', '$1'.$img, $par, 1);
    return $par;
}
