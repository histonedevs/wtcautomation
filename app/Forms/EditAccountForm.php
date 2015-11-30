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
            ->add('website', 'text', ['rules' => 'required']);

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
