<?php
namespace Craft;

use Twig_Extension;

class brightness extends \Twig_Extension {

	public function getName()	{
		return Craft::t('Brightness');
	}

	public function getFunctions() {
		return array(
			'darken'  		=> new \Twig_Function_Method($this, 'darken'),
			'lighten' 		=> new \Twig_Function_Method($this, 'lighten'),
			'isDark' 	    => new \Twig_Function_Method($this, 'isDark'),
			'isDight'     => new \Twig_Function_Method($this, 'isDight'),
			'lightOrDark' => new \Twig_Function_Method($this, 'lightOrDark'),
		);
	}

	// Returns true if the colour is light, false if dark
	// {{ isLight('#0000ff') }}
	public function isLight($color)	{
		return $this->_light_or_dark($color);
	}

	// Returns true is the colour is dark, false if light
	// {{ isDark('#0000ff') }}
	public function isDark($color)	{
		return !$this->_light_or_dark($color);
	}

	// If colour is light, return second param (white by default). Dark and return third param (black by default)
	// {{ lightOrDark('#0000ff', 'black', 'white') }}
	public function lightOrDark( $color, $light = '#FFFFFF', $dark = '#000000' ) {
		return $this->_light_or_dark($color) ? $dark : $light;
	}

	// Lighten a hex colour
	// {{ lighten('#0000FF', 20) }}
	public function lighten($hex, $amount)	{
		$amount = $amount < 1 ? 0 : $amount > 100 ? 100 : $amount * 2.55;
		return $this->_brightness($hex, $amount);
	}

	// Darken a hex colour
	// {{ darken('#0000FF', 20) }}
	public function darken($hex, $amount)	{
		$amount = $amount < 1 ? 0 : $amount > 100 ? 100 : $amount * 2.55;
		$amount = -1 * abs($amount);
		return $this->_brightness($hex, $amount);
	}

	// Private

	// Checks if a colour is light or dark
	private function _light_or_dark( $color ) {

		$hex = str_replace( '#', '', $color );

		$c_r = hexdec( substr( $hex, 0, 2 ) );
		$c_g = hexdec( substr( $hex, 2, 2 ) );
		$c_b = hexdec( substr( $hex, 4, 2 ) );

		$brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

		return $brightness > 155;
	}

	// Manipulates a colours brightnes/darkness
	private function _brightness($hex, $steps) {
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
