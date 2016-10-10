<img src="http://i.imgur.com/PEWaWLJ.png" alt="Colours" align="left" height="60" />

# Colours *for Craft CMS*

Query colours or colours in images to do all manner of useful things.

##Table of Contents

- [Theme](#theme)
- [Hex To RGBA](#brightness)
- [Light](#object)
- [Dark](#entry)
- [Light or Dark](#category)
- [Brightness](#tag)

## Theme

Adds a theme fieldtype that allows a predefined colour to be selected. Colours are set by adding comma delimited hex codes into the fieldtypes settings. Each colour will automatically be given a name using [Chirag Mehta's Name That Color](http://chir.ag/projects/ntc).

<img src="http://i.imgur.com/qUK6tod.jpg" alt="Colours" align="left" height="205" />

hexToRgba($color, $opacity = false) {
light($color)	{
dark($color)	{
light_or_dark( $color, $light = '#FFFFFF', $dark = '#000000' ) {
_light_or_dark( $color ) {
lighten($hex, $amount)	{
darken($hex, $amount)	{
brightness($hex, $steps) {
