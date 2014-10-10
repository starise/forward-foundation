# [Forward Foundation](https://github.com/starise/forward-foundation)
[![devDependency Status](https://david-dm.org/starise/forward-foundation/dev-status.svg)](https://david-dm.org/starise/forward-foundation#info=devDependencies)

Forward Foundation is a WordPress starter theme based on [HTML5 Boilerplate](http://html5boilerplate.com/) & [Foundation](http://foundation.zurb.com/). The project starts as a fork of [Roots](https://github.com/roots/roots).

* Source: [https://github.com/starise/forward-foundation](https://github.com/starise/forward-foundation)
* Author Homepage: [http://stari.se/](http://stari.se/)

## Features

* [Gulp](http://gulpjs.com/) for compiling SASS to CSS, checking for JS errors, live reloading, concatenating and minifying files, versioning assets, and generating lean Modernizr builds
* [Bower](http://bower.io/) for front-end package management
* [HTML5 Boilerplate](http://html5boilerplate.com/)
  * The latest [jQuery](http://jquery.com/) via Google CDN, with a local fallback
  * The latest [Modernizr](http://modernizr.com/) build for feature detection, with lean builds with Gulp
  * An optimized Google Analytics snippet
* [Foundation](http://foundation.zurb.com/)
* Organized file and template structure
* ARIA roles and microformats
* [Theme activation](http://roots.io/roots-101/#theme-activation)
* [Theme wrapper](http://roots.io/an-introduction-to-the-roots-theme-wrapper/)
* Cleaner HTML output of navigation menus
* Posts use the [hNews](http://microformats.org/wiki/hnews) microformat
* [Multilingual ready](http://wpml.org/)

### Optional packages

* [Bedrock](https://github.com/roots/bedrock) — Wordpress stack that uses Composer and Capistrano
* [Soil](https://github.com/roots/soil) — Plugin to enable additional features like relative and nicer URLs, clean the output of `wp_head` and assets markup.

## Installation

[Download](https://githgithub.com/starise/forward-foundation/zipball/master) or Clone the git repo:

```
git clone git://github.com/starise/forward-foundation.git
```

Install [node.js](http://nodejs.org/download/) and npm using [Node Version Manager](https://github.com/creationix/nvm).

```
curl https://raw.githubusercontent.com/creationix/nvm/master/install.sh | bash
nvm install 0.10
```

Install `gulp` globally with:

```
npm install -g gulp
```

Navigate to the theme directory, then run `npm install`. npm will look at `package.json` and automatically install the necessary dependencies. It will also automatically run `bower install`, which installs front-end packages defined in `bower.json`.

If you don't use [Bedrock](https://github.com/roots/bedrock), you may need to add the following to your `wp-config.php` on your development installation:

```php
define('WP_ENV', 'development');
```

### Available Gulp commands

* `gulp dev` — Compile SASS to CSS, concatenate and validate JS
* `gulp watch` — Compile assets when file changes are made
* `gulp build` — Create minified assets that are used on non-development environments

## Theme activation

Once you activate Forward Foundation from the WordPress admin you’ll be taken to the activation options which is handled by `lib/activation.php`:

* **Create static front page** — Create a page called Home and set it to be the static front page. This is normally handled from the Reading settings.
* **Change permalink structure** — Change permalink structure to `/%postname%/`. This is normally handled from the Permalinks settings.
* **Create navigation menu** — Create the Primary Navigation menu and set the location. This is normally handled from the Menus section under Appearance.
* **Add pages to menu** — Add all published pages to the Primary Navigation. On a fresh install, this will add the new Home page and existing Sample Page to the navigation.

## Configuration

Edit `lib/config.php` to enable or disable theme features and to define a Google Analytics ID.

Edit `lib/init.php` to setup navigation menus, post thumbnail sizes, post formats, and sidebars.

Edit `lib/extras.php` to setup custom functions, remove unused dashboard widgets, metaboxes, menus.

## Documentation

* [Roots 101](http://roots.io/roots-101/) — A guide to installing Roots, the files, and theme organization
* [Theme Wrapper](http://roots.io/an-introduction-to-the-roots-theme-wrapper/) — Learn all about the theme wrapper

## Contributing

Everyone is welcome to contribute and improve this project. You can:

* Report [issues](https://github.com/starise/forward-foundation/issues) or fix them
* Suggesting new features
