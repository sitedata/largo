inc/open-graph.php
==================

.. php:function:: largo_opengraph()

   Adds appropriate open graph, twittercards, and google publisher tags
   to the header based on the page type displayed

   :uses: largo_twitter_url_to_username()

   :since: 0.3

.. php:function:: largo_wp_title_parts_filter()

   Filter wp_title() to add our custom metadata

   :since: 0.6

   :link: https://github.com/INN/largo/issues/1470
   :param Array $parts: An array of title parts.

   :returns: Array.