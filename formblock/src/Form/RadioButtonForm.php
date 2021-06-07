<?php

namespace Drupal\formblock\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class RadioButtonForm extends FormBase {

    /**
     * {@inheritdoc}
     */

    public function getFormId() {
        return 'formblock';
    }

    /**
     * {@inheritdoc}
     */
    
    public function buildForm(array $form, FormStateInterface $form_state) {

        $form['name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Name'),
        ];

        $form['radio'] = [
            '#type' => 'radios',
            '#title' => $this->t('Feedback'),
            '#default_value' => 4,
            '#options' => array(1 => $this->t('Poor'),
                                2 => $this->t('Bad'),
                                3 => $this->t('Average'),
                                4 => $this->t('Good'),
                                5 => $this->t('Excellent'),
                            ),
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
        $conn = \Drupal\Core\Database\Database::getConnection();
        $conn->insert('formblock')
          ->fields(array:[
            'name' => $form_state->getvalue('name'),
            'feedback' => $form_state->getvalue('radio'),
            'created' => REQUEST_TIME,
            ])
            ->execute();
        drupal_set_message("Your Response is successfully submitted, Thank You");
    }
}
