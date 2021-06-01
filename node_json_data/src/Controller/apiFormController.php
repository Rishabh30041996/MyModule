<?php

namespace Drupal\node_json_data\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\jsonResponse;


class apiFormController extends ControllerBase {

    public function UniqueKey($apikey, NodeInterface $nodeid) {

        $value = \Drupal::entityQuery('node')->condition('nid', $nodeid)->execute();
        $nodeid = !empty($value);
        $userapikey = \Drupal::config('node_json_data.userapikey')->get('userinputapikey');
        if ($apikey == $userapikey && $nodeid) {
            return new jsonResponse(
                [
                    '#type' => 'markup',
                    '#markup' => $this->t('User input API Key is:  '. $userapikey),
                    'data' => $this->result(),
                    'method' => 'GET',
                ]
            );
        }
        else {
            return (
                [
                    '#type' => 'markup',
                    '#markup' => $this->t('This API Key Does not exist:'),
                ]
            );
        }
  
    }

    private function result() {
        return [
                ["id" => 1, "Animal" => "Giant Panda", "Species" => 'Endangered'],
                ["id" => 2, "Animal" => "Red panda", "Species" => 'Rare'],
                ["id" => 3, "Animal" => "Gorilla", "Species" => 'Endangered'],
                ["id" => 4, "Animal" => "Wolly Mammoth", "Species" => 'Extinct'],
            ];
    }
        
}