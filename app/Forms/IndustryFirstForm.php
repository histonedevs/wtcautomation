<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class IndustryFirstForm extends Form
{
    public function buildForm()
    {
        $this->add('sms_type', 'select',
            [
                'choices' => [
                    'sms1' => 'Text 1 : Inform about our website',
                    'sms2' => 'Text 2 : 15 Minute Overview Call Appointment Confirmation',
                    'sms3' => 'Text 3 : 1 Hour Dress Rehearsal Call Appointment Confirmation',
                    'sms4' => 'Text 4 : Tim is calling Shortly',
                    'smsFree' => 'Free SMS',
                ],
                'empty_value' => 'Select SMS',
                'rules' => 'required'
            ],
            [
                'id' => 'sms_type'
            ]
        );

        $this->add('sms_text', 'textarea', ['rules' => 'required']);
        $this->add('recipient' , 'text', ['rules' => 'required']);
        $this->add('sender' , 'text', ['rules' => 'required', 'value' => '647-628-4592']);
        $this->add('Send', 'submit');
    }
}
