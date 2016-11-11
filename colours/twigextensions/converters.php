<?php
namespace Craft;

use Twig_Extension;

class converters extends \Twig_Extension {

	public function getName()	{
		return Craft::t('Converters');
	}

	public function getFunctions() {
		return array(
			'hexToRgba' => new \Twig_Function_Method($this, 'hexToRgba'),
			'rgba' 			=> new \Twig_Function_Method($this, 'hexToRgba'),
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

}
