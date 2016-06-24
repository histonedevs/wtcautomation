<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class EditAccountForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('company_name', 'text', ['rules' => 'required'])
            ->add('contact_person', 'text', ['rules' => 'required'])
            ->add('website', 'text', ['rules' => 'required'])
            ->add('contact_email', 'text', ['rules' => 'required'])
            ->add('video_link_pos_response', 'text', [
                'label' => 'Add iframe for Video Link in Positive Response',
                'value' => ''
            ])
            ->add('video_link_neg_response', 'text', [
                'label' => 'Add iframe for Video Link in Negative Response',
                'value' => ''
            ]);

        if($model = $this->getModel()){
            if($model->logo) {
                $this->add('Exiting Logo', 'static', [
                    'tag' => 'div', // Tag to be used for holding static data,
                    'attr' => ['class' => 'form-control-static'], // This is the default
                    'value' => "<img src='{$model->logo}'>" // If nothing is passed, data is pulled from model if any
                ]);
            }
        }

        $this->add('logo' , 'file')
        ->add('Save', 'submit')
    ;
    }
}
