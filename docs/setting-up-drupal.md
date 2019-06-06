# Setting up the Back-End Drupal Application

The Drupal back-end for my Blue Conf 2019 talk - [Decoupling Drupal with Vue.js](https://www.oliverdavies.uk/talks/decoupling-drupal-vuejs). This was used alongside the Vue.js front-end application for viewing and submitting fictional talk proposals that were stored in Drupal.

## Prerequisites

* [Docksal](https://docksal.io)
* [VirtualBox](https://www.virtualbox.org/wiki/Downloads) (can be changed to use Docker natively)

## Setup instructions

1. Run `fin init` to initialise the project, including installing all of the Composer dependencies, installing Drupal and importing the original configuration and creating some test content.

    ```bash
    cd drupal

    fin init
    ```

1. Visit `http://blueconf.docksal` to view the Drupal website, or run `fin drush status` to ensure that everything is running.

1. Run `fin drush uli` to generate a one-time login link in order to access the site.
