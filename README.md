<img src="http://i.imgur.com/PEWaWLJ.png" alt="Colours" align="left" height="60" />

# Colours *for Craft CMS*

> This plugin is no longer maintained. I'm committing to Craft 3 development only. Feel free to use the source code as you like. If you're looking for a Craft 3 version of this plugin, it's likely I've merged parts or all of this plugin into my [Helpers module.](https://github.com/marknotton/craft-module-helpers)

Query colours to do all manner of useful things.

## Table of Contents

- [Theme](#theme)
- [Hex To RGBA](#hex-to-rgba)
- [Light](#light)
- [Dark](#dark)
- [Light or Dark](#light-or-dark)

## Theme

Adds a theme fieldtype that allows a predefined colour to be selected. Colours are set by adding comma delimited hex codes into the fieldtypes settings. Each colour will automatically be given a name using [Chirag Mehta's Name That Color](http://chir.ag/projects/ntc).

<img src="http://i.imgur.com/qUK6tod.jpg" alt="Colours" height="205" />  

## Hex To RGBA

Twig filter that converts a Hex colour to RGBA

```
{{ '#990000'|hexToRgba }}
```

You can also pass in opacity too

```
{{ '#990000'|hexToRgba(0.5) }}
```

## Light

Twig filter that returns ```true``` if a given hex colour is considered to be light.

```
{{ '#990000'|light }}
```

## Dark

Twig filter that returns ```true``` if a given hex colour is considered to be dark.

```
{{ '#FFF000'|dark }}
```

## Light or Dark

Twig filter that returns a light of dark colour depending on the brightness of the first parameter.

```
{{ entry.backgroundColour|light_or_dark('#FFFFFF', '#000000') }}
```
