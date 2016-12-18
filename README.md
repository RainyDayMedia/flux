# flux

[![Stories in Ready](https://badge.waffle.io/RainyDayMedia/flux.svg?label=backlog&title=Backlog)](http://waffle.io/RainyDayMedia/flux)
[![Stories in Ready](https://badge.waffle.io/RainyDayMedia/flux.svg?label=ready&title=Ready)](http://waffle.io/RainyDayMedia/flux)
[![Stories in Ready](https://badge.waffle.io/RainyDayMedia/flux.svg?label=In%20Progress&title=In%20Progress)](http://waffle.io/RainyDayMedia/flux)

Its a WordPress theme based on [Bourbon](http://bourbon.io/) and [Bourbon Neat](http://neat.bourbon.io/)!

Its essentially a blank theme that's meant for hacking and customizing. It will give you a quick start, with a basic header, footer, and index templates, as well as some of our basic functions and our growing WordPress library. We've also included [Modernizr](http://modernizr.com/) (the development version) and [Normalize.css](https://necolas.github.io/normalize.css/) (the Sass version), two really great libraries for building modern cross-browser websites.

You also get some basic sass partials and classes to get you started.

It also includes our typical gulpfile for improving the workflow. But don't think you have to use Gulp. We like it. We use it. But you do whatever you like.

Drink up!

## Requirements

* [Ruby](https://www.ruby-lang.org/en/) (required for Sass)
* [Sass](http://sass-lang.com/)
* [Bower](http://bower.io/)

### Required for Gulp support

* [Node](http://nodejs.org/)
* [NPM](https://www.npmjs.com/) (comes pre-bundled with Node)
* [Gulp](http://gulpjs.com/)

## Installation

Download the latest release and unpack it. Copy it into your WordPress installation and name it whatever you like:

``` sh
$ cp -r flux /var/www/html/wordpress/wp-content/themes/your-theme-name
```

Complete the installation:

``` sh
$ cd /var/www/html/wordpress/wp-content/themes/your-theme-name
$ bower install
```

If you plan to use Gulp:

``` sh
$ npm install
```

You may want to edit the bower.json and/or package.json with your own project's information. You should definitely edit the style.scss with your theme's information.

Drink again!

## The SASS

We get you kicked off with a few basic partials and classes. The only requirements are what is needed to make WordPress work (the theme definition in `style.scss`). You can modify, remove, and add partials and classes as you like.

* `assets/scss/styles.scss` your WordPress theme definition. Edit it with your project specific info.
* `assets/scss/_settings.scss` the basic settings you can modify.
* `assets/scss/_mixins.scss` we've got a few mixins we like to use a lot (details below).
* `assets/scss/_colors.scss` everything related to your project's color palette.
* `assets/scss/_fonts.scss` the font loaders.
* `assets/scss/_typography.scss` a number of textual helper classes.
* `assets/scss/_grid.scss` helper classes for building content on the grid.
* `assets/scss/_layout.scss` helper classes for laying out your html elements.
* `assets/scss` the remaining Sass partials are all empty. They are there just as a organizational guide. You do what you like and drink up!

#### _settings.scss

We've included all of the available Bourbon/Neat settings and their default values are listed. We'll probably add more as the theme grows.

#### _mixins.scss

`@mixin full-bg([$horizontal, $vertical])` Makes the background image cover the whole element. You can provide two optional positional arguments. They default to center.

`@mixin font-size($size)` Provides the font size in rems, with a fallback in pixels for the browser that doesn't support rem. `$size` should be a pixel value, but a unitless value is accepted as well.

#### _colors.scss

Set up your color map here! Provides helper classes for each color defined in the map (eg for `black` in the color map, you get `.text-black`, `.bg-black`, `.border-black`). Also

`@function get-color($color)` Returns the hex value from the given `$color` key, which must be defined in the color map.

#### _fonts.scss

Define your `@font-face` fonts here. We've provided one example, with a template for adding more.

#### _typography.scss

You'll definitely want to pop in and hack away at this partial. Its mostly set up to get you started. We've provided our typical way of defining typography colors based on the background. We also have a starting point for sizing the typography, as well as positional classes `.text-center`, `.text-left`, and `.text-right`. We also have text styling with things like `.italic`, `.uppercase`, and `.bold`. Take a look at the file for the full list of helpers.

#### _grid.scss

Creates helper classes for building elements on the grid. For instance, `one column` creates a one column element, while `three columns` creates a three column element. `push-one` shifts the element to the right by one column. There's a column and push class for each available column. If you stray from the Neat default of 12 columns, you'll want to edit the column map here to ensure you get the correct number of helper classes.

We've also set up the `<section>` tag to act as a full width block, and we've provided the `.row` class to act as a `$max-width` wrapper with the `$gutter` on the left and right.

#### _layout.scss

There's some positional helper classes here. We adjust the `body` element to accommodate for the admin bar on smaller browser widths. `.padded-1` through `.padded-10` will pad the top and bottom of the element with the given modular-scale value. The same for `.v-margin-` for a top margin on the element. We also have `.to-left` and `.to-right` for floating left and right. Lastly, we've set up `.site` and `.site-footer` to act as a dynamically sized sticky footer. We've also provided the necessary javascript (`./assets/js/stickyfooter.js`) to complete the dynamic sticky footer solution.

## The Functions

You'll want to browse through `functions.php` and possibly make some changes. Its here you'll register your custom menus and sidebars, enable and disable features, enqueue additional scripts and styles, and add any theme specific functionality you need. We have included the free version of the excellent plugin [Advanced Custom Fields](http://www.advancedcustomfields.com/) already, but if you have the Pro version and want to include it as a required plugin, you'll need to enable it here as well.

We've also built a number of library functions you can use.

* `flux_admin_menu_separator( $position )` adds a separator at the given integer position.
* `__the_field( $key[, $method, $post_id] )` escapes ACF field output, using the given method. (`$method` and `$post_id` are optional and default to 'esc_html' and the current post, respectively)
* `__the_sub_field( $key[, $method, $post_id] )` escapes ACF sub field output, using the given method. (`$method` and `$post_id` are optional and default to 'esc_html' and the current post, respectively)
* `flux_output_favicons()` outputs the html for the favicons generated with [Real Favicon Generator](http://realfavicongenerator.net)
* `flux_show_featured_image( [$id, $add_link] )` outputs a post's featured image, or the fallback image if there isn't one (fallback should be `/assets/img/blog-fallback.png`). set `$add_link` to true to include a link to the full sized image (`$id` and `$add_link` are optional and default to the current post and false, respectively)
* `flux_enqueue_responsive_background( $selector, $image_id )` adds a media library image to the responsive background queue. $selector is the HTML selector (ideally use the id attribute), and `$image_id` is the WordPress media library id of the image

The following are enabled and disabled via the `functions.php` file. Comment or Uncomment the actions and filters as needed.

* `flux_add_alt_tags()` automatically adds alt tags to images in content, unless they already have one. defaults to enabled
* `flux_trim_excerpt()` an excerpt trimmer that doesn't strip out the &lt;p&gt; tags. defaults to enabled
* `flux_output_responsive_backgrounds()` outputs the javascript for each responsive background image that has been queued with `flux_enqueue_responsive_background()`. defaults to disabled

## The Gulpfile

We've included an extensive Gupfile that improves our own workflow. Using gulp is entirely optional, but we would highly recommend using a task runner of some sort if you don't like gulp.

In order to start using gulp, you'll need to make a quick modification to the top of `gulpfile.js`:

``` javascript
// REQUIRED SETTINGS
var siteUrl = 'example.dev';
```

We've included several tasks that streamline workflow and take care of some tedious tasks.

* **BrowserSync** live browser reloader.
* **Javascript** concatenates and minifies your javascript. includes sourcemaps and a linter.
* **Sass** compiles all that lovely Sass into one file and minifies it. includes an autoprefixer and sourcemaps.
* **Bower Components** automatically grabs all the js, css, and fonts from your bower components, then concatenates and minifies them.

And it does all this on the fly. Every time you change a sass or js file in your project, it'll perform the required task again. This is why Gulp is great.

## Issues

Feel free to post any issues you have on the GitHub repo's [Issue tracker](https://github.com/RainyDayMedia/flux/issues). Let us know if you'd like to see a feature, function, mixin, or something better documented. We're always looking to improve!

## The Future

This theme, our function and mixin libraries, and our skills as developers are constantly growing and changing. We're looking into the future of the web and web development with [Web Components](http://webcomponents.org/) and the [Polymer](https://www.polymer-project.org/1.0/) project, and are excited to see things evolve. We may begin including a Web Component library in flux as well, when we're sure its ready.

## License

You'll find it among the source as [License](https://github.com/RainyDayMedia/flux/blob/master/LICENSE).
