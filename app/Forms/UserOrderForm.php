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
           ])
            ->add('fromDate', 'text', ['rules'=>'required'

            ])
            ->add('toDate', 'text',['rules'=>'required'])
            ->add('Download','submit',['label'=>'Download']);
    }
}
