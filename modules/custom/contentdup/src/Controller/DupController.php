<?php

/**
 * @file
 * Contains \Drupal\contentdup\Controller\DupController.
 */
namespace Drupal\contentdup\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

class DupController extends ControllerBase {
  public function duplicate($title, $nid) {
    //exclude internal / metadata fields
    $exemptFields = ['nid', 'vid', 'uuid', 'title', 'type', 'langcode', 'revision_uid', 'revision_log',
    'revision_default', 'revision_timestamp', 'isDefaultRevision', 'status', 'uid', 'created',
    'changed', 'promote', 'sticky'];

    //lookup origin node from nid    
    $pnode = Node::load($nid);
    
    //create new node with same type as origin node
    $newTitle = 'Copy of ' . $title;
    $node = Node::create([
      'type' => $pnode->getType(), // Specify the content type
      'title' => $newTitle, // Set the new title
    ]);

    //iterate origin node fields and copy to new node, ignoring exempt fields
    foreach($pnode->getFields() as $field){
      $fieldName = $field->getName();
      if(!in_array($fieldName, $exemptFields)) {
        $node->set($fieldName,$field->getValue());
      }  
    }

    // Save the node.
    $node->save();
    $newNid = $node->id();

    //build redirect response to edit form of new node
    $edit_url = Url::fromRoute('entity.node.edit_form', ['node' => $newNid]);    
    $response = new RedirectResponse($edit_url->toString());
    $response->send();
    return $response;
  }
}
