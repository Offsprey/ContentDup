<?php

/**
 * @file
 * Contains \Drupal\contentdup\Controller\DupController.
 */

namespace Drupal\contentdup\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Link;
use Drupal\Core\Url;


class DupController extends ControllerBase {
  public function duplicate($title, $nid) {
    //exclude internal / metadata fields
    $exemptFields = ['nid', 'vid', 'type', 'uuid', 'title', 'langcode', 'revision_uid', 'revision_log',
    'revision_default', 'revision_timestamp', 'isDefaultRevision', 'status', 'uid', 'created',
    'changed', 'promote', 'sticky'];

    //lookup origin node from nid    
    $pnode = Node::load($nid);
    $newTitle = 'Copy of ' . $title;
    $node = Node::create([
      'type' => 'article', // Specify the content type
      'title' => $newTitle, // Set the title
]);
    //iterate origin node fields and copy to new node, ignoring exempt fields
    foreach($pnode->getFields() as $field){
        $fieldName = $field->getName();
        if(!in_array($fieldName, $exemptFields)){
        //dpm($field->getValue());
          $node->set($fieldName,$field->getValue());
      }  
    }

    // Save the node.
    $node->save();
    $newNid = $node->id();

    //build response
    $edit_url = Url::fromRoute('entity.node.edit_form', ['node' => $newNid]);
    $link = Link::fromTextAndUrl('Edit this node', $edit_url)->toString();
        /* return [
      '#markup' => t('Node created "%title" - %nid. @edit_link', [
        '%title' => $newTitle,
        '%nid' => $newNid,
        '@edit_link' => $link,
      ]),
    ]; */
      //return new RedirectResponse($edit_url->toString());
      
      $response = new RedirectResponse($edit_url->toString());
      $response->send();
      return $response;
    }
}
