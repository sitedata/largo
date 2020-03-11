Upgrading Largo
===============

We do our best to make sure that the update process for any version of Largo is as smooth as possible. However, you should always test a Largo update before upgrading your live site.

The questions you'll need answers to before you update your live site:

.. conotents::
   :local:

What is the new Largo version?
------------------------------

The latest Largo release is always listed at https://github.com/INN/largo/releases

Make a note of the version number given there.

What version of Largo does your site use now?
---------------------------------------------

There are several ways to determine what version of Largo you're using.

Using the Dashboard
~~~~~~~~~~~~~~~~~~~

Log into your site's WordPress Dashboard and visit **Appearance > Themes**. Find Largo in the list and make a note of the version number displayed. 

While you're in here, make a note of which theme is the active theme. If you're not using Largo, but the active theme has a note like "This is a child theme of Project Largo - Base Theme," then you're using a child theme.

Using code inspection
~~~~~~~~~~~~~~~~~~~~~

1. Go to the site's homepage, and use your browser's tools to "View source". In Chrome, a handy way to do this is to prefix the url ``https://example.org`` with ``view-source:`` like so: ``view-source:https://example.org``
2. Search in the source code (control/command F) for the string ``themes/largo``. Example results:
	- Case 1: ``https://31lz132jjnab134mc12u4xg5-wpengine.netdna-ssl.com/wp-content/themes/largo/lib/navis-slideshows/css/slides.css?ver=1.0`` on the site ``https://example.org``
	- Case 2: ``https://example.org/wp-content/themes/largo/js/load-more-posts.min.js?ver=0.5.5.2``
	- Case 3: ``https://example.org/wp-content/themes/largo-0.5.5.2/js/load-more-posts.min.js?ver=0.5.5.2``
3. Determine the base URL of the Largo theme.
	- Case 1 above shows that the site ``https://example.org`` is using a CDN to deliver some assets. Replace ``https://31lz132jjnab134mc12u4xg5-wpengine.netdna-ssl.com`` with ``https://example.org`` to form the URL ``https://example.org/wp-content/themes/largo/lib/navis-slideshows/css/slides.css?ver=1.0``, and proceed the Default Case below.
	- Case 2 shows a URL ending in ``?ver=0.5.5.2``, and ``0.5.5.2`` is a version number from the list of tagged releases found at https://github.com/INN/largo/tags. This is a strong signal that the site's version of Largo is 0.5.5.2, but should be confirmed by following the Default Case below.
	- Case 3 shows a theme directory of ``/largo-0.5.5.2/``, which is not a good indication of the version number. Sites that were installed using a specific version of Largo in a theme directory that contained the version number in the directory name must install subsequent upgrades to that same directory name, such that a site running Largo 0.6.1 might have a URL ``https://example.org/wp-content/themes/largo-0.5.5.2/js/load-more-posts.min.js?ver=0.6.2``. If the version number in the theme directory name matches the version number at the end of the query string, as is the case with ``https://example.org/wp-content/themes/largo/js/load-more-posts.min.js?ver=0.5.5.2``, this is a strong signal that the theme version is that number. However, this should be confirmed by following the default case instructions below.
	- Default Case: take the URL ``https://example.org/wp-content/themes/largo/lib/navis-slideshows/css/slides.css?ver=1.0`` and remove everything after the Largo directory name. The base theme URL is ``https://example.org/wp-content/themes/largo/``
4. Now that you have the theme base URL, append ``style.css``. ``https://example.org/wp-content/themes/largo/`` becomes ``https://example.org/wp-content/themes/largo/style.css``. You should see a label ``Version:`` followed by a number.
	- ``Version: 0.1`` This is really early Largo, or `v0.1 <https://github.com/INN/largo/blob/v0.1/style.css>`_, or `v0.2 <https://github.com/INN/largo/blob/v0.2/style.css>`_, `v0.3 <https://github.com/INN/largo/blob/v0.3/style.css>`_, or a version of 0.3 on the ``v0.3-maintenance`` branch: https://github.com/INN/largo/blob/v0.3-maintenance/style.css
	- ``Version: 0.2`` Doesn't exist; tagged release ``v0.2`` had a version number of ``0.1``
	- ``Version: 0.3`` This may be an in-development version of Largo after ``v0.3`` was tagged, before ``v0.4`` was tagged.
	- Version numbers matching [a tagged release](https://github.com/INN/largo/releases): probably that version number.
	- ``Version: 0.X-prerelease`` Version numbers like this indicate the site is running a development build of Largo that preceded the ``0.X`` in the version number.
5. If ``style.css`` is not available, check ``readme.md`` or ``readme.txt`` or ``package.json``. Those typically contain the version number.

Using filesystem inspection
~~~~~~~~~~~~~~~~~~~~~~~~~~~

1. Connect to your site using a FTP, SFTP, or SSH client. (Contact your hosting provider to determine what they support.)
2. Navigate to your site's ``wp-content/themes/`` directory.
3. Search through the list of installed themes until you find the Largo theme folder.
4. Examine ``style.css`` as described above.

Using wp-cli
~~~~~~~~~~~~

See the documentation for the `wp theme command <https://developer.wordpress.org/cli/commands/theme/>`_ to learn more about how to use that command to get information about theme versions.

Does your site have a child theme?
----------------------------------

By Dashboard inspection
~~~~~~~~~~~~~~~~~~~~~~~

If you saw the note mentioned above, saying that your active theme was a child theme of Largo, then yes, you have a child theme.

By website source code inspection
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

1. Return to the source code, and search for ``/themes/``. Make a note of any URLs that have a path other than ``/themes/largo``, such as ``/themes/largo-child/style.css``.
2. Follow the instructions given above to find the site's child theme's base URL, then check out its ``style.css`` or ``readme.txt`` or ``readme.md``.

Using wp-cli
~~~~~~~~~~~~

See the documentation for the `wp theme command <https://developer.wordpress.org/cli/commands/theme/>`_ to learn more how to use that command to get information about child themes.

Do you have a staging site?
---------------------------

Talk to your hosting provider if you are unsure whether you have a staging site.

- WP Engine: https://wpengine.com/support/staging/
- Flywheel: https://getflywheel.com/why-flywheel/staging-sites/
- Pantheon: https://pantheon.io/docs/pantheon-workflow/

How do you upgrade?
-------------------

If no staging site is available to you, you'll want to back up your site thoroughly before testing any Largo upgrade in your live site. Contact your host to learn more about what backups are available to you.

If a staging site is available to you, your process will be something like this:

1. Copy your live site to your staging site
2. Review the release notes for the new version of Largo. Release notes are found at https://github.com/INN/largo/releases and at https://labs.inn.org.
3. Replace the contents of the existing Largo folder in your staging site with the contents of the release .zip downloaded from https://github.com/INN/largo/releases
4. Log into your staging site and follow the instructions to update your site's database.
5. Review your newly-upgraded staging site for:
    - problems listed in the release notes
    - problems listed in https://github.com/INN/docs/blob/master/checklists/child-themes.md
6. Update your child theme as necessary for compatibility.
7. When you're sure your site is happily bug-free:
    1. Back up your live site.
    2. Copy the upgraded child theme and parent theme to your live site.
    3. Copy any configuration changes you made to your live site.

INN Labs would be happy to work with you on your site's upgrade process; contact us at support@inn.org for details.
