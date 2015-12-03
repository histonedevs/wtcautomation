<?php

namespace App\Forms;

use App\Http\Requests\Request;
use Kris\LaravelFormBuilder\Form;

class SmsTextUpdate extends Form
{
    public function buildForm()
    {
       $this
            ->add('value', 'text', [
                                    'label' => 'SMS Text',
                                    'rules' => 'required',
                                    'value' => $this->getData('text'),
                                    ])
            ->add('Update', 'submit', ['label' => 'Submit', 'attr' => ['class' => 'btn btn-default form-group col-md-2']]);
    }
}
