<?php
/**
 * @file
 * Contains \Drupal\site_api_key\Controller\SiteApiKeyController.
 */
namespace Drupal\site_api_key\Controller;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
class SiteApiKeyController{
    /**
     * @param $site_api_key - the API key parameter
     * @param NodeInterface $node - the node built from the node id parameter
     * @return JsonResponse
     */
    public function content($site_api_key, NodeInterface $node){
        // Site API Key configuration value
         $config = \Drupal::service('config.factory')->getEditable('system.site');                     
          $site_api_key_saved = $config->get('site_api_key');
        // ensure the supplied node is a page, the configuration key is set and matches the supplied key
        if($node->getType() == 'page' && !empty($site_api_key_saved) && $site_api_key_saved == $site_api_key){
            // Respond with the json representation of the node
            return new JsonResponse($node->toArray(), 200, ['Content-Type'=> 'application/json']);
        }
        // Respond with access denied
        return new JsonResponse(array("error" => "access denied"), 401, ['Content-Type'=> 'application/json']);
    }
}   