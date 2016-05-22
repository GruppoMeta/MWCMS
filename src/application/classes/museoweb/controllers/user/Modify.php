<?php
class museoweb_controllers_user_Modify extends org_glizy_mvc_core_Command
{
    protected $submit;

    function __construct( $view=NULL, $application=NULL )
    {
        parent::__construct( $view, $application );
        $this->submit = strtolower( __Request::get( 'submit', '' ) ) == 'submit';
    }

    public function execute()
    {
        if ($this->user->isLogged() && !$this->submit) {
            $ar = org_glizy_ObjectFactory::createModel('org.glizy.models.User');
            $ar->load($this->user->id);

            __Request::set('name',          $ar->user_firstName);
            __Request::set('surname',       $ar->user_lastName);
            __Request::set('company',       $ar->user_companyName);
            __Request::set('jobtitle',      $ar->user_title);
            __Request::set('address',       $ar->user_address);
            __Request::set('city',          $ar->user_city);
            __Request::set('userstate',     $ar->user_state);
            __Request::set('zip',           $ar->user_zip);
            __Request::set('country',       $ar->user_country);
            __Request::set('email',         $ar->user_email);
            __Request::set('psw',           $ar->user_password);
            __Request::set('phone',         $ar->user_phone);
            __Request::set('mobile',        $ar->user_mobile);
            __Request::set('phone2',        $ar->user_phone2);
            __Request::set('web',           $ar->user_www);
            __Request::set('fax',           $ar->user_fax);
            __Request::set('newsletter',    $ar->user_wantNewsletter);
            __Request::set('mailinglist',   $ar->user_isInMailinglist);
        }
    }

    public function executeLater()
    {
        if ($this->user->isLogged() && $this->submit && $this->controller->validate()) {
            $ar = org_glizy_ObjectFactory::createModel('org.glizy.models.User');
            $ar->load($this->user->id);

            $email = org_glizy_Request::get('email', false, '');
            if ($email != $ar->user_loginId) {
                $ar2 = org_glizy_ObjectFactory::createModel('org.glizy.models.User');
                if ($ar2->find(array('user_loginId' => $email)) && $ar2->user_id!=$ar->user_id) {
                    $this->view->validateAddError('L\'email è già presente nel database, usare un\'altra email');
                    return;
                }
            }

            $ar->user_firstName       = org_glizy_Request::get('name', false, '');
            $ar->user_lastName        = org_glizy_Request::get('surname', false, '');
            $ar->user_companyName     = org_glizy_Request::get('company', false, '');
            $ar->user_title           = org_glizy_Request::get('jobtitle', false, '');
            $ar->user_address         = org_glizy_Request::get('address', false, '');
            $ar->user_city            = org_glizy_Request::get('city', false, '');
            $ar->user_state           = org_glizy_Request::get('userstate', false, '');
            $ar->user_zip             = org_glizy_Request::get('zip', false, '');
            $ar->user_country         = org_glizy_Request::get('country', false, '');
            $ar->user_email           = $email;
            $ar->user_loginId         = $email;
            $ar->user_password        = org_glizy_Request::get('psw', false, '');
            $ar->user_phone           = org_glizy_Request::get('phone', false, '');
            $ar->user_mobile          = org_glizy_Request::get('mobile', false, '');
            $ar->user_phone2          = org_glizy_Request::get('phone2', false, '');
            $ar->user_www             = org_glizy_Request::get('web', false, '');
            $ar->user_fax             = org_glizy_Request::get('fax', false, '');
            $ar->user_wantNewsletter  = org_glizy_Request::get('newsletter', false, '')=='1' ? 1 : 0;
            $ar->user_isInMailinglist = org_glizy_Request::get('mailinglist', false, '')=='1' ? 1 : 0;

            $ar->save();
            $this->changeAction('modifyConfirm');
        }
    }
}