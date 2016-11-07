<?php
namespace Craft;

class ColoursVariable {

  public function random($handle = null) {
		return craft()->colours->random($handle);
	}

  public function all($handle = null) {
    return craft()->colours->all($handle);
  }

}
