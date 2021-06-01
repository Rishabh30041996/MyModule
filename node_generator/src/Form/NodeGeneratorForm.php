<?php

namespace Drupal\node_generator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\node\Entity\Node;

class NodeGeneratorForm extends FormBase {

    /**
     * {@inheritdoc}
     */

    public function getFormId() {
        return 'node_generator';
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
            '#title' => $this->t('Content Type'),
            '#options' => $option,
            '#required' => TRUE,
        ];

        $form['nodes'] = [
            '#type' => 'number',
            '#title' => $this->t('How many nodes you wish to generate'),
            '#min' => 2,
            '#max' => 10,
            '#required' => TRUE,
        ];

        $form['text_area'] = [
            '#type' => 'textarea',
            '#title' => $this->t('Body'),
        ];

        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Generate'),
        ];
        return $form;

    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
        $nodeno = $form_state->getvalue('nodes');
        if ($nodeno < 2 || $nodeno > 10 ) {
            $form_state->setErrorByName('nodes','Min Value of node is 2 and Max is 10');        
        }
    }


    /**
     * {@inheritdoc}
     */


    public function submitForm(array &$form, FormStateInterface $form_state) {
         $nodeno = $form_state->getvalue('nodes');
         if (intval($nodeno) >=2 && intval($nodeno) <= 10 ) {
            for ($i=0; $i < intval($nodeno) ; $i++) { 

                $nodes = Node::create(['type' => $form_state->getvalue('content')]);
                $nodes->set('title' , $form_state->getvalue('title'));
                $nodes->set('body' , [
                    'value' => $form_state->getvalue('text_area'),
                    'format' => 'basic_html',
                    ]);
                $nodes->enforceIsNew();
                $nodes->save();

             }
         }
         drupal_set_message($nodeno." Nodes Successfully Generated");
        
    }
          
  
}