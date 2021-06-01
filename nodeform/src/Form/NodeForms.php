<?php

namespace Drupal\nodeform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\node\Entity\Node;

class NodeForms extends FormBase {
    /**
     * {@inheritdoc}
     */

    public function getFormId() {
        return 'nodeform';
    }
    

    /**
     * {@inheritdoc}
     */
    
    public function buildForm(array $form, FormStateInterface $form_state) {
        $n_types = \Drupal\node\Entity\NodeType::loadMultiple();
        $option = array();
        foreach ($n_types as $node_type) {
            $option[$node_type->id()] = $node_type->label();
        }
        $form['title'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Title'),
            '#required' => TRUE,
        ];

        $form['content'] = [
            '#type' => 'select',
            '#options' => $option,
            '#title' => $this->t('Content Type'),
            '#required' => TRUE,
        ];

        $form['nodes'] = [
            '#type' => 'number',
            '#title' => $this->t('Select number of Nodes'),
            '#required' => TRUE,
        ];

        $form['text_area'] = [
            '#type' => 'textarea',
            '#title' => $this->t('Body'),
        ];

        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Create'),
        ];
        return $form;

    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
        $nodeno = $form_state->getvalue('nodes');
        if ($nodeno > 5 ) {
            $form_state->setErrorByName('nodes','Node Value should not exceed 5');        
        }
    }


    /**
     * {@inheritdoc}
     */


    public function submitForm(array &$form, FormStateInterface $form_state) {
         $nodeno = $form_state->getvalue('nodes');
         if (intval($nodeno) <= 5 ) {
            for ($i=0; $i < intval($nodeno) ; $i++) { 

                $node = Node::create(['type' => $form_state->getvalue('content')]);
                $node->set('title' , $form_state->getvalue('title'));
                $node->set('body' , [
                    'value' => $form_state->getvalue('text_area'),
                    'format' => 'basic_html',
                    ]);
                $node->enforceIsNew();
                $node->save();

             }
         }
         drupal_set_message($nodeno." Nodes Successfully Generated");
        
    }
          
  
}