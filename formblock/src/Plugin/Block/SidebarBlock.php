<?php

/**
 * @file
 * contains\Drupal\formblock\Plugin\Block\SidebarBlock
 */

namespace Drupal\formblock\Plugin\Block;
 
use Drupal\Core\Block\BlockBase;



/**
 * Provides 'Block' in sidebar
 * @Block(
 *  id = "formblock",
 *  admin_label = @Translation("Sidebar Block"),
 * )
 */


class SidebarBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */

    public function build() {

        $form = \Drupal::formBuilder()->getForm('Drupal\formblock\Form\RadioButtonForm');
 
        return $form;
      }

} 