<?php

/**
 * @file
 * Contains \Drupal\contentdup\Controller\DupController.
 */
namespace Drupal\contentdup\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

class DupController extends ControllerBase {

  /**
   * Duplcates node and redirects to edit form.
   * @param string $title
   * @param int $nid
   * 
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   * 
   */
  public function duplicate($title, $nid) {
    //exclude internal / metadata fields
    $excludedFields = ['nid', 'vid', 'uuid', 'title', 'type', 'langcode', 'revision_uid', 'revision_log',
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
      if(!in_array($fieldName, $excludedFields)) {
        $node->set($fieldName,$field->getValue());
      }
    }

    $node->setUnpublished();

    // Save the node.
    $node->save();
    $newNid = $node->id();

    // Add a message to the user.
    $this->messenger()->addStatus($this->t('The node %title has been copied.', ['%title' => $node->getTitle()]));


    //build redirect response to edit form of new node
    $edit_url = Url::fromRoute('entity.node.edit_form', ['node' => $newNid]);
    $response = new RedirectResponse($edit_url->toString());
    $response->send();
    return $response;
  }
}
