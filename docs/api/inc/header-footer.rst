inc/header-footer.php
=====================

.. php:function:: largo_header()

   Output the site header image or the text-only header

   :since: 0.1

.. php:function:: largo_copyright_message()

   Print the copyright message in the footer

   :since: 0.3

.. php:function:: inn_logo()

   Output the INN logo, used in the footer

   If you want to use a light background with a dark image, simply replace this function in the child theme with one that references get_template_directory_uri() . "/img/inn_dark.svg"

   :since: 0.5.2

.. php:function:: largo_social_links()

   Outputs a list of social media links (as icons) from theme options

   :since: 0.3

.. php:function:: largo_shortcut_icons()

   Adds shortcut icons to the header

   :since: 0.3

.. php:function:: largo_seo()

   Various meta tags to help Google crawl our sites more easily

   :since: 0.3

.. php:function:: largo_post_metadata()

   Schema.org article metadata we include in the header of each single post

   :since: 0.4