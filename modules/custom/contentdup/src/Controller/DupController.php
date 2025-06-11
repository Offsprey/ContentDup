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
    $exemptFields = ['nid', 'vid', 'type', 'uuid', 'langcode', 'revision_uid', 'revision_log',
    'revision_default', 'revision_timestamp', 'isDefaultRevision', 'status', 'uid', 'created',
    'changed', 'promote', 'sticky'];
    //lookup parent ndoe from nid    
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
$node->set('title', $newTitle);

// Save the node.
$node->save();
$nid = $node->id();
$edit_url = Url::fromRoute('entity.node.edit_form', ['node' => $nid]);
$link = Link::fromTextAndUrl('Edit this node', $edit_url)->toString();
    /* return [
  '#markup' => t('Node created "%title" - %nid. @edit_link', [
    '%title' => $newTitle,
    '%nid' => $nid,
    '@edit_link' => $link,
  ]),
]; */
  return new RedirectResponse($edit_url->toString());
  }
}