<?php
namespace Craft;

class ThemeService extends BaseApplicationComponent {

  private function _getThemeFields($handle = null) {

    if (!is_null($handle)) {
      // Get all fields with a given handle, so long as it's a themes fieldtype
      $field = craft()->fields->getFieldByHandle($handle);
      if ($field->type == "Colour_Theme") {
        return $field;
      }
    } else {
      // If no handle is given, return the first instance of themes fieldtype.
      $fields = craft()->fields->getAllFields();
      foreach ($fields as $field) {
        if ($field->type == "Colour_Theme") {
          return $field;
        }
      }
    }
  }

  // Pass in the handle of the specific Theme fieldtype you want to get a random colour from.
  public function random($handle = null) {

    $colours = $this->_getThemeFields($handle);

    $settings = explode(',', $colours->settings['colours']);

    shuffle($settings);

    return $settings[0];
  }
}
