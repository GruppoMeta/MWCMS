<?php
class museoweb_controllers_form_Index extends org_glizy_mvc_core_Command
{
    public function execute()
    {
        if (__Request::exists('formBuilderInfo')) {
            $content = $this->view->getContent();

            $formBuilderInfo = json_decode(__Request::get('formBuilderInfo'));
            if ($formBuilderInfo) {
                $msg = '';
                $attach = array();
                foreach($formBuilderInfo as $item) {
                    if ($item->type=='UPLOAD')
                    {
                        $file       = $_FILES[$item->id];
                        if ($file['tmp_name']) {
                            $attach[]   = array('fileName' => $file['tmp_name'], 'originalFileName' => $file['name']);
                        }
                    } else {
                        $msg .= $item->label.': '.__Request::get($item->id, '').'<br />';
                    }
                }

                org_glizy_helpers_Mail::sendEmail(
                                                array(  'name' => $content->toEMail,
                                                        'email' => $content->toEMail),
                                                array(  'name' => org_glizy_Config::get('SMTP_SENDER'),
                                                        'email' => org_glizy_Config::get('SMTP_EMAIL')),
                                                'email: '.$content->title,
                                                $msg,
                                                $attach);

                $this->changeAction('confirm');
            }
        }
    }
}