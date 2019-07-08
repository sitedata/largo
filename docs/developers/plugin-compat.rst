Plugin compatibility testing
============================

Largo aims to maintain compatibility with a number of plugins. This file includes a list of those plugins, and things that developers should test with those plugins when the plugin introduces breaking changes or when Largo makes changes to how it interfaces with those plugins.

To add plugins or testing items to this list, edit ``docs/developers/plugin-compat.rst``.

Co-Authors Plus
---------------

Co-Authors Plus and Largo are integrated in the following ways:

- The Largo_Byline class and its inheritors and users check to see if CAP is active and if posts have CAP metadata.
- Largo registers several additional metadata fields for CAP guest authors.
- CAP user metadata is output on CAP author archive pages.

A fuller list of things to test:

- post with WordPress author
- post with mixed authorship

   - order of WP_User/Co-Author set in post editor is preserved in byline output
   - names are joined by commas or 'and' as appropriate

- post with solely co-authors

   - order of WP_User/Co-Author set in post editor is preserved in byline output
   - names are joined by commas or 'and' as appropriate

- co-author author archive

    - co-author thumbnail/bio/social are displayed as with WordPress users
    - no posts not associated with the co-author are displayed
    - https://github.com/INN/largo/issues/1539 does not occur

Yoast WordPress SEO
-------------------

Largo includes by defauly some functionality for Search Engine Optimization, like improved ``<title>`` tags, Open Graph tags, and Twitter Card tags.

Things to test:

- That the functionality in Largo to not enqueue ``largo_opengraph()`` on the ``wp_head`` hook still works
