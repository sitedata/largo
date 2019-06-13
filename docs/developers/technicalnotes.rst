About the ``inc/`` directory
----------------------------

When you download the theme you'll notice that the /inc folder contains most of the add-on functionality for the parent theme and all of these files are then loaded up via functions.php

Pluggable (overridable) Largo functions
---------------------------------------

Many of Largo's core functions are pluggable so you can write your own version of them by using the same function name in a child theme's ``functions.php``.

You can read up on how that works in the `WordPress codex section about child themes <https://codex.wordpress.org/Child_Themes>`_.

See: `Function Reference <../api/index.html>`_.

Theme Options and the Options Framework
---------------------------------------

Largo uses the `Options Framework <https://wordpress.org/plugins/options-framework/>`_ for the Appearance > Theme Options menu pages.

If you need to access a Theme Options value, use ``of_get_option()`` instead of the usual ``get_option()``. The theme options pages themselves can be customized from ``options.php`` in the main theme folder.

Homepage Templates
------------------

See `Homepage layouts <https://github.com/INN/Largo-Sample-Child-Theme/tree/master/homepages>`_ from our `Largo-Sample-Child-Theme repository <https://github.com/INN/Largo-Sample-Child-Theme>`_.

LESS and CSS
------------

The Largo parent theme uses `LESS CSS <http://lesscss.org/>`_ to generate the stylesheets including a number of elements borrowed and tweaked from `Twitter Bootstrap <http://getbootstrap.com/2.3.2/>`_.

You will notice that the theme's main style.css is empty except for the header block because we enqueue our styles from ``css/style.css`` (the output of /less/style.less when it's compiled), overriding the WordPress default behavior of including the ``style.css`` file in the root of the theme directory.

Compiling translation files
---------------------------

To rebuild the translation files, run the following commands: ::

	grunt pot
	msgmerge -o lang/es_ES.po.merged lang/es_ES.po lang/largo.pot
	mv lang/es_ES.po.merged lang/es_ES.po
	grunt po2mo

Images
------

See the `Largo User Guide for Administrators Theme Images page <https://largo.inn.org/guides/administrators/theme-options/theme-images/>`_ to see the list of image types and sizes you'll need to get your site up and running.

**More on image sizes:**

- `Largo Image Sizes and Constants <imagesizes.html>`_

.. toctree::
    :maxdepth: 2

    imagesizes

