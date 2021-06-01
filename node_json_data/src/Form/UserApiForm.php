<?php

namespace Drupal\node_json_data\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class UserApiForm extends ConfigFormBase {

    /**
    * {@inheritdoc}
    */

    protected function getEditableConfigNames() {
        return [
            'node_json_data.userapikey',
        ];
    }



    /**
     * {@inheritdoc}
     */

    public function getFormId() {
        return 'userinputapikey';
    }

    /**
     * {@inheritdoc}
     */
    
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config('node_json_data.userapikey');
        $form['userinputapikey'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Generate your API Key:'),
            '#size' => 16,
            '#maxlength' => 16,
            '#description' => $this->t('Your Api Key will be stored here.'),
            '#default_value' => $config->get('userinputapikey'),
        ];

        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
        ];

        return $form;

    }

    /**
     * {@inheritdoc}
     */
    
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $this->config('node_json_data.userapikey')->set('userinputapikey', $form_state->getValue('userinputapikey'))->save();
        drupal_set_message("Your api key is successfully generated.");
    }
}