<?php
namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;

class brightness extends \Twig_Extension {

	public function getName()	{
		return Craft::t('Brightness');
	}

	public function getFunctions() {
		return array(
			'darken'  => new \Twig_Function_Method($this, 'darken'),
			'lighten' => new \Twig_Function_Method($this, 'lighten'),
			'dark' 	  => new \Twig_Function_Method($this, 'dark'),
			'light'   => new \Twig_Function_Method($this, 'light'),
			'light_or_dark' => new \Twig_Function_Method($this, 'light_or_dark'),
			'rgba'    => new \Twig_Function_Method($this, 'hexToRgba'),
			'colour'  => new \Twig_Function_Method($this, 'hexToRgba')
		);
	}

  public function getFilters() {
    return array(
      'light_or_dark' => new Twig_Filter_Method( $this, 'light_or_dark' )
    );
  }


	// Convert Hex to RGBA
	// http://mekshq.com/how-to-convert-hexadecimal-color-code-to-rgb-or-rgba-using-php/
	public function hexToRgba($color, $opacity = false) {

		//Return default if no color provided
		if(empty($color)) {
	    return false;
		}

		//Sanitize $color if "#" is provided
    if ($color[0] == '#' ) {
    	$color = substr( $color, 1 );
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
      $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
      $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
      return false;
    }

    //Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if($opacity){
    	$opacity = abs($opacity) > 1 ? 1.0 : $opacity;
    	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
    } else {
    	$output = 'rgb('.implode(",",$rgb).')';
    }

	  //Return rgb(a) color string
	  return $output;
	}

	// Returns true is the colour is light, false if dark
	// {{ light('#0000ff') }}
	public function light($color)	{
		return $this->_light_or_dark($color);
	}

	// Returns true is the colour is dark, false if light
	// {{ dark('#0000ff') }}
	public function dark($color)	{
		return !$this->_light_or_dark($color);
	}

	// If colour is light, return second param (white by default). Dark and return third param (black by default)
	// {{ light_or_dark('#0000ff', 'black', 'white') }}
	public function light_or_dark( $color, $light = '#FFFFFF', $dark = '#000000' ) {
		if ( gettype($light) == 'boolean' ) {
			return $this->_light_or_dark($color) ? 'light' : 'dark';
		} else {
			return $this->_light_or_dark($color) ? $dark : $light;
		}
	}

	// Checks if a colour is light or dark
	private function _light_or_dark( $color ) {

    $hex = str_replace( '#', '', $color );

    $c_r = hexdec( substr( $hex, 0, 2 ) );
    $c_g = hexdec( substr( $hex, 2, 2 ) );
    $c_b = hexdec( substr( $hex, 4, 2 ) );

    $brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

    return $brightness > 155;
  }

	// Lighten a hex colour
	// {{ lighten('#0000FF', 20) }}
	public function lighten($hex, $amount)	{
		$amount = $amount < 1 ? 0 : $amount > 100 ? 100 : $amount * 2.55;
		return $this->brightness($hex, $amount);
	}

	// Darken a hex colour
	// {{ darken('#0000FF', 20) }}
	public function darken($hex, $amount)	{
		$amount = $amount < 1 ? 0 : $amount > 100 ? 100 : $amount * 2.55;
		$amount = -1 * abs($amount);
		return $this->brightness($hex, $amount);
	}

	// Manipulates a colours brightnes/darkness
	private function brightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return = '#';

    foreach ($color_parts as $color) {
        $color   = hexdec($color); // Convert to decimal
        $color   = max(0,min(255,$color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }

    return $return;
	}

}
