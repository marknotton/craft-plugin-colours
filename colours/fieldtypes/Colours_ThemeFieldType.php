<?php
namespace Craft;

class Colours_ThemeFieldType extends BaseFieldType {

  public function getName() {
      return Craft::t('Theme');
  }

  public function defineContentAttribute() {
    return array(AttributeType::String, 'column' => ColumnType::Text);
  }

  protected function defineSettings() {
    return array(
      'colours' => array(AttributeType::String)
    );
  }

  public function prepSettings($settings){

    // Convert array
    $colours = explode(',', $settings['colours']);

    // Remove any white spacing in each array item
    $colours = array_filter(array_map('trim', $colours));

    // Remove any duplicates
    $colours = array_unique($colours);

    // Create an empty array
    $newColours = array();

    // Loop through each array item, check if it's a hexidecimal number with a #
    foreach ($colours as $colour) {
      if(preg_match('/^#[a-f0-9]{6}$/i', $colour)) {
        //Check for a hex color string '#c1c2b4'
        array_push($newColours, $colour);
      } else if(preg_match('/^[a-f0-9]{6}$/i', $colour)) {
        //Check for a hex color string without hash 'c1c2b4'
        array_push($newColours, '#'.$colour);
      }
    }

    // Update with new string
    $settings['colours'] = implode(', ', $newColours);

    // Return results
    return $settings;
  }

  public function getSettingsHtml() {
    return craft()->templates->render('colours/settings', array(
      'settings' => $this->getSettings()
    ));
  }

  public function getInputHtml($name, $value) {
    return craft()->templates->render('colours/input', array(
      'name'  => $name,
      'value' => $value,
      'settings' => $this->getSettings()
    ));
  }
}
