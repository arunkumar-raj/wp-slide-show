# wp-slide-show
Admin-Side:

Create an admin-side settings page.
Provide an interface to add/remove images from plugin settings page.
User must be able to change order of uploaded image. (Hint: Use http://jqueryui.com/demos/sortable/#connect-lists )

Front-end:

Create provision for a shortcode like [myslideshow]
When you add shortcode [myslideshow] to any page, it will be replaced by a slideshow of images uploaded from admin-side.
You can use any jQuery slideshow library/plugin.

## WPCLI

wp wpss-slide create_slideshow will add the images to the table from the folder wpss-assets/images/sliders

## PHP UNIT TEST

use phpunit test to run the tests 

## Simple custom block added under media as My Slideshow

- file for custom block is in wpss-assets/js/wpss-custom-block.js

## Constants

- constants file in wpss-config/constants.php
- Holds the constants for the file and table name 

## Slider and uploader used

- For Slider https://skitter-slider.net/install.html#google_vignette
- For Uploader https://christianbayer.github.io/image-uploader/#options
- For Design Bootstrap is used
