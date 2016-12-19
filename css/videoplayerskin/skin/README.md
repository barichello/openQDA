<h1 align="center">Video.js Polyzor Skin (for video.js 5)</h1>


####Customizable skin for video.js v.5
[See the demo](http://codepen.io/enygmatik/pen/NGJWRY?editors=010)

### Preview

   ![Video.js skin image](http://s12.postimg.org/grhy59p4d/Screenshot_2015_11_17_16_19_53_copy.png)
   
   ![video.js skin preview](http://s12.postimg.org/hiaob1rhp/Screenshot_2015_11_17_16_20_15_copy.png)

### Usage
  1. Place `polyzor-skin.min.css/polyzor-skin.css` after default video.js styles
  2. Add class  `vjs-polyzor-skin` to `<video>` tag
```html

    <link rel="stylesheet" href="video-js.css">
    <link rel="stylesheet" href="polyzor-skin.min.css">
    
    <video class='video-js vjs-polyzor-skin'></video>

```

### Settings
```scss

/Global Skin Settings

//SKIN COLORS
//------------------------------------------------------
$primary-foreground-color: #36c183; // #fff default

$primary-background-color: #2B333F;  // #2B333F default

//color for video progress indicator
$progress-indicator-color: #fcfaff; //skin default #fff

//color for mute/vol-0 icon
$mute-icon-color: red;

//color for time text
$time-color: #fff; //skin default  #fff

//color for big play button
$center-big-play-button-color: $primary-foreground-color;
$center-big-play-button-hover-color: #fff;

// Make a slightly lighter version of the main background
// for the slider background.
$slider-bg-color: lighten($primary-background-color, 33%);


//SKIN SIZE SETTINGS
//----------------------------
//Video control container
$video-container-height: 4em;

//Video progress bar
$progress-bar-height: .5em;
$progress-bar-indicator: $progress-bar-height * 2;
//When user is inactive progress bar move to bottom of the player
$show-progress-bar: true; //skin default true

//Play button size
//align center play button
$center-play-button: false;
$play-button-size: $video-container-height / 1.4;

//All controls size
$control-buttons-size: $video-container-height - 1;

//Big play button
$center-big-play-button: true; // true default
/* 1.5em = 45px default */
$big-play-size: 6em;
$big-play-width: 1em;
$big-play-height: 1em;

//SPECIAL CONDITION
@if $video-container-height < 3 {
    $play-button-size: $video-container-height;
    $control-buttons-size: $video-container-height ;
}

```




#### Notice:
	Skin version 0.2.0
