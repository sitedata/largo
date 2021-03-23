Setting up a complete Largo dev environment
===========================================

**This recipe has been updated, please see an older version of the docs for the previous setup methods.**

This recipe will walk you through setting up a fresh WordPress install using `Laravel's Valet CLI <https://laravel.com/docs/8.x/valet>`_.

We'll walk you through the overall setup of the WordPress directory, and then we'll walk you through setting up Largo and its development requirements.

Software to install first
-------------------------
Make sure you have these items installed locally on your machine before proceeding:

- Home Brew
- Composer
- php
- MySQL
- wp-cli

Let's walk through these steps first, starting with Home Brew.

1. Install `Home Brew <https://www.digitalocean.com/community/tutorials/how-to-install-and-use-homebrew-on-macos>`_, open terminal of your choice and type or paste in
    curl -fsSL -o install.sh https://raw.githubusercontent.com/Homebrew/install/master/install.sh
2. Once that is finished you can install Composer
    brew install composer
3. Now we can add php in
    brew install php
3a. Once Composer is installed an update to your PATH may need to happen once php is installed you can try
    export PATH=$PATH:~/.composer/vendor/bin
4. Now you can install Laravel/Valet the program that will do all the heavy lifting to setup Largo project locally.
    composer global require laravel/valet
5. Now we can install valet
    valet install
6. Lets get WP-CLI installed so we can use that to get WordPress
    brew install wp-cli
6a. Now lets get WordPress core downloaded into a new directory first
    mkdir <what-ever-you-name-it>
    cd <what-ever-you-name-it>
6b. Now we can use WP-CLI to download WordPress core
    wp core download

Now if your not using `MAMP <https://www.mamp.info/en/mac/>`_ or some other database GUI you will need some way to manage mySQL for Wordpress. We recommend using what you feel at home with.
Here we can run through using Home Brew to install Mysql
    brew install mysql

Once that is complete you can create a Wordpress Database to use locally while you develop, Brew will print instructions for accessing Mysql server.

Now that everything is installed, we can move on to getting a local dev environment setup and running Largo Theme.
Valet has a great set of cli tools to help speed up provisioning a working Wordpress installation.
From getting a working URL to securing that URL with an SSL cert, valet will handle this all in a couple of commands.
With the same terminal open change directory to where you want Wordpress to be installed. From there run these commands

7. Lets navigate to WordPress themes folder and install the largo theme
    cd wp-content/themes
8. Using Git we can download the state of trunk, we then create a new branch to start working from
    git clone -b trunk https://github.com/WPBuddy/largo.git
9. Navigate to the largo theme directory and create a new branch
    git checkout -b <branch name>
10. Navigate to the base of the install and create the valet site link using this command (note: this will create a URL with the name of the directory you created, in this case it will be largo.test)
    valet link
11. Lets secure this new URL using (note: we specify the site here using just the first part of the URL)
    vale secure largo
12. From here you will want to the visit the link created, ours was largo.test, to finish installing Wordpress normally, we will pick up after you have completed this and can login to your local site.


Setting up Largo
----------------

1. Download the current release from Github, `Largo Theme <https://github.com/WPBuddy/largo/releases>`_
2. Login to your local Wordpress site and click Appearance in the left side menu, then click Add New in the top of screen (blue outlined button) or the very large plus sign.
3. Upload the zipped file you downloaded from Github once that is done you will now have a fresh Wordpress installation along with our most current version of Largo theme

