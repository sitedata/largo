Creating Child Themes
---------------------

In order to make it easier to upgrade to future versions of the Largo parent theme, you will want to add any customizations that are unique to your site by creating a child theme. WordPress has a `tutorial you can follow <https://codex.wordpress.org/Child_Themes>`_ that explains how to create and configure a child theme.

NEVER modify the Largo parent theme directly, even to make small changes. It will make your life much harder when we release a new version because your changes are highly likely to be overwritten.

To create a child theme, at a minimum you will need to create a new theme folder (call it something like "largo-child" in your wp-content/themes directory and add one file to it called style.css. That file would be used to add any custom CSS unique to your child theme, but it also tells WordPress where to find the parent theme.

At the very top of the file you need to add at least the following:

.. code::

    /*
    Theme Name:     Your Child Theme's Name
    Theme URI:      Your Site URL
    Description:    Your Theme Description
    Author:         Your Name
    Author URI:     Your Author URL
    Template:       largo
    Version:        0.1.0
    \*/

The line starting with "Template" must include the name of the folder that contains the parent theme files (this should be "largo" unless you name the parent theme folder something different).

If you would prefer, we have created `an example child theme <https://github.com/INN/Largo-Sample-Child-Theme>`_ that you can start from where we document our preferred structure and how to modify the behavior, look and feel of Largo, create custom templates, etc.

To use this child theme, `simply download and unzip it <https://github.com/INN/Largo-Sample-Child-Theme/archive/master.zip>`_ just as you did the Largo parent theme above, modify the header block in the style.css as described above and then upload the folder to your wp-content/themes directory along with the Largo parent theme. The sample child theme contains a number of additional files and documentation that you may not need so you might consider removing the elements you do not intend to use.

Now that you have a child theme created, login to your WordPress site and go to Appearance > Themes. Find your child theme, click "activate" and then you should see your new child theme in action on your site and can begin customizing.


