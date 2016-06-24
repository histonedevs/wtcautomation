<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class EditAccountForm extends Form
{
    public function buildForm()
    {
        $account = $this->getData("account");

        $this
            ->add('company_name', 'text', ['rules' => 'required', 'value' => $account->company_name])
            ->add('contact_person', 'text', ['rules' => 'required', 'value' => $account->contact_person])
            ->add('website', 'text', ['rules' => 'required', 'value' => $account->website])
            ->add('contact_email', 'text', ['rules' => 'required', 'value' => $account->contact_email]);
            ->add('video_link_pos_response', 'text', [
                'label' => 'Add iframe for Video Link in Positive Response',
                'value' => $account->video_link_pos_response,
            ])
            ->add('video_link_neg_response', 'text', [
                'label' => 'Add iframe for Video Link in Negative Response',
                'value' => $account->video_link_neg_response,
            ]);

        if($account->logo) {
            $this->add('Exiting Logo', 'static', [
                'tag' => 'div', // Tag to be used for holding static data,
                'attr' => ['class' => 'form-control-static'], // This is the default
                'value' => "<img src='{$account->logo}'>" // If nothing is passed, data is pulled from model if any
            ]);
        }

        $this->add('logo' , 'file')
        ->add('Save', 'submit')
    ;
    }
}
