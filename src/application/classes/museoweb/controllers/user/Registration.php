<?php
class museoweb_controllers_user_Registration extends org_glizy_mvc_core_Command
{
    protected $submit;

    function __construct( $view=NULL, $application=NULL )
    {
        parent::__construct( $view, $application );
        $this->submit = strtolower( __Request::get( 'submit', '' ) ) == 'submit';
    }

    public function executeLater()
    {
        if ($this->submit && $this->controller->validate()) {
            $email = org_glizy_Request::get('email', false, '');
            $ar = org_glizy_ObjectFactory::createModel('org.glizy.models.User');
            if ($ar->find(array('user_loginId' => $email))) {
                $this->view->validateAddError('L\'email è già presente nel database, usare un\'altra email o richiedere la password');
                return;
            }

            $record = array();
            $record['user_firstName']       = org_glizy_Request::get('name', false, '');
            $record['user_lastName']        = org_glizy_Request::get('surname', false, '');
            $record['user_companyName']     = org_glizy_Request::get('company', false, '');
            $record['user_title']           = org_glizy_Request::get('jobtitle', false, '');
            $record['user_address']         = org_glizy_Request::get('address', false, '');
            $record['user_city']            = org_glizy_Request::get('city', false, '');
            $record['user_state']           = org_glizy_Request::get('userstate', false, '');
            $record['user_zip']             = org_glizy_Request::get('zip', false, '');
            $record['user_country']         = org_glizy_Request::get('country', false, '');
            $record['user_email']           = $email;
            $record['user_loginId']         = $email;
            $record['user_password']        = org_glizy_Request::get('psw', false, '');
            $record['user_phone']           = org_glizy_Request::get('phone', false, '');
            $record['user_mobile']          = org_glizy_Request::get('mobile', false, '');
            $record['user_phone2']          = org_glizy_Request::get('phone2', false, '');
            $record['user_www']             = org_glizy_Request::get('web', false, '');
            $record['user_fax']             = org_glizy_Request::get('fax', false, '');
            $record['user_wantNewsletter']  = org_glizy_Request::get('newsletter', false, '')=='1' ? 1 : 0;
            $record['user_isInMailinglist'] = org_glizy_Request::get('mailinglist', false, '')=='1' ? 1 : 0;
            $record['user_dateCreation']    = date('Y-m-d H:i:s');
            $record['user_FK_usergroup_id'] = 4;
            $record['user_isActive']        = __Config::get( 'USER_DEFAULT_ACTIVE_STATE' );

            $ar->save($record);
            $this->changeAction('registrationConfirm');
        }
    }
}