<?php
namespace Craft;

class ColoursPlugin extends BasePlugin {
  public function getName() {
    return Craft::t('Colours');
  }

  public function getVersion() {
    return '0.1';
  }

  public function getSchemaVersion() {
    return '0.1';
  }

  public function getDescription() {
    return 'Query colours or colours in images to do all manner of useful things.';
  }

  public function getDeveloper() {
    return 'Yello Studio';
  }

  public function getDeveloperUrl() {
    return 'http://yellostudio.co.uk';
  }

  public function getDocumentationUrl() {
    return 'https://github.com/marknotton/craft-plugin-colours';
  }

  public function getReleaseFeedUrl() {
    return 'https://raw.githubusercontent.com/marknotton/craft-plugin-colours/master/colours/releases.json';
  }

  public function addTwigExtension() {
    Craft::import('plugins.colours.twigextensions.brightness');
    return new brightness();
  }

  public function init() {
    if ( craft()->request->isCpRequest() && craft()->userSession->isLoggedIn())  {
      craft()->templates->includeJsResource('colours/name-that-color.js');
    }
  }
}
