<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class UserOrderForm extends Form
{
    public function buildForm()
    {

        $this
            ->add('users', 'select', [
                'choices' => $this->getData('options'),
                'empty_value' => 'Select Users',
                'rules' => 'required'
            ], ['id' => 'users'])
            ->add('fromDate', 'text', ['rules' => 'required'

            ])
            ->add('toDate', 'text', ['rules' => 'required'])
            ->add('Download', 'submit', ['label' => 'Download', 'attr' => ['class' => 'btn btn-default form-group col-md-2']]);
    }
}
