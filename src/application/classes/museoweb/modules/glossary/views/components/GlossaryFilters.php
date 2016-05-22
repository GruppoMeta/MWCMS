<?php
class museoweb_modules_glossary_views_components_GlossaryFilters extends org_glizy_components_SearchFilters
{
    var $term;
    var $char;
    var $letters;
    var $mode;

    /**
     * Return the component information
     *
     * @return  array   component informaton.
     * @access  public
     * @static
     */
    function getInfo()
    {
        $info                   = parent::info();
        $info['name']           = 'GlossaryFilters';
        $info['class']          = 'org.minervaeurope.museoweb.GlossaryFilters';
        $info['package']        = 'Museo&Web CMS';
        $info['version']        = '1.0.0';
        $info['author']         = 'Daniele Ugoletti, Gruppo Meta';
        $info['author-email']   = 'daniele.ugoletti@gruppometa.it';
        $info['url']            = 'http://www.minervaeurope.org';
        return $info;
    }


    function process()
    {
        $this->sessionEx    = new org_glizy_SessionEx($this->getId());
        // verify if there is a term to searh or a term to show

        if ( org_glizy_Request::get('glossarydetail_term2', '')!='' )
        {
            org_glizy_Request::set( 'glossarydetail_term', urldecode( org_glizy_Request::get( 'glossarydetail_term2' ) ) );
        }

        if (org_glizy_Request::get('glossarydetail_term', '')!='' && org_glizy_Request::get('glossary_id', '')=='')
        {
            // search the term
            // $ar = &org_glizy_ObjectFactory::createModel('museoweb.modules.glossary.models.Model');
            // $ar->glossarydetail_term = org_glizy_Request::get('glossarydetail_term', '');
            // $ar->find();

            // // set the values in Request class
            // // these values need for build the right URLs
            // org_glizy_Request::set('glossary_id', $ar->glossary_id);
            // org_glizy_Request::set('filterTerm', $ar->glossarydetail_term{0});
            // org_glizy_Request::set('filterCategory',  $this->sessionEx->get('glossarydetail_category', ''));
        }
        if(org_glizy_Request::get('glossary_id', '')!='' && org_glizy_Request::get('filterTerm', '') == '')
        {
            org_glizy_Request::set('filterTerm', $this->sessionEx->get('filterTerm', ''));
        }

        $category = org_glizy_Request::get('filterCategory', '');
        // draw the letters
        $this->letters = array();
        for ($i=65;$i<91;$i++)
        {
            $this->letters[chr($i)] = chr($i);
        }
        $this->letters[__T('MW_GLOSSARY_OTHER')] = __T('MW_GLOSSARY_OTHER');


        $it = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.glossary.models.Model')
            ->load('glossaryIndex');
        foreach($it as $ar) {
            if (array_key_exists($ar->glossarydetail_term, $this->letters)) {
                $this->letters[$ar->glossarydetail_term] = org_glizy_helpers_Link::makeLink('museoweb_GlossaryLetter',
                                                                                    array(  'title' => $ar->glossarydetail_term,
                                                                                            'filterTerm' => $ar->glossarydetail_term,
                                                                                            'filterCategory' => $category));
            }
        }

        // set the right query to perform
        $dp = &$this->getComponentById('ModuleDP');
        if (is_object($dp))
        {
            if (org_glizy_Request::get('filterTerm', '')=='' && $category!='')
            {
                $this->mode = 'glossaryCategory';
            }
            else if (($category!='' || org_glizy_Request::get('filterTerm', '')!='') && $category=='')
            {
                $this->mode = 'glossaryTerm';
            }
            else
            {
                $this->mode = 'glossary';
            }

            $dp->setAttribute('query', $this->mode);
        }
        else
        {
            // TODO
            // show the error and die
        }

        parent::process();
    }

    function render_html()
    {
        $output = '<ul class="glossary"><li>'.implode($this->letters, '</li><li>').'</li></ul><div style="clear: both;"></div>';
        $this->addOutputCode($output);
    }

    function getFilters()
    {
        if (org_glizy_Request::get('filterTerm', '')=='' &&
            org_glizy_Request::get('glossarydetail_term', '')=='' &&
            org_glizy_Request::get('filterCategory', '')=='' &&
            org_glizy_Request::get('glossary_id', '')=='')
        {
            return array();
        }
        else if ($this->mode == 'glossaryTerm')
        {
            return array($this->_filters['glossarydetail_term']);
        }
        else if ($this->mode == 'glossaryCategory')
        {
            return array($this->_filters['glossarydetail_category']);
        }
        else
        {
            return $this->_filters;
        }
    }
}
