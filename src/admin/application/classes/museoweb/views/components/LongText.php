<?php 

class museoweb_views_components_LongText extends org_glizy_components_LongText
{
    function init()
    {
        // define the custom attributes
        $this->defineAttribute('textFromSession',    false,     '',    COMPONENT_TYPE_STRING);
        $this->defineAttribute('textFromRequest',    false,     '',    COMPONENT_TYPE_STRING);

        // call the superclass for validate the attributes
        parent::init();
    }


    function process()
    {
        parent::process();

        $textList = explode( ",", $this->getAttribute('textFromSession','') );
        if( count( $textList ) > 0 )
        {
            $tagContent = trim( $this->getText() );
            foreach( $textList as $text )
            {
                if( __Session::exists( $text ) )
                {
                    $tagContent = str_replace( '##'.$text.'##', __Session::get( $text ), $tagContent );
                }
            }
            $this->setText( $tagContent );
        }
        
        $textList = explode( ",", $this->getAttribute('textFromRequest','') );
        
        if( count( $textList ) > 0 )
        {
            $tagContent = trim( $this->getText() );
            foreach( $textList as $text )
            {
                if( __Request::exists( $text ) )
                {
                    $tagContent = str_replace( '##'.$text.'##', __Request::get( $text ), $tagContent );
                }
            }
            $this->setText( $tagContent );
        }
    }
}
?>
