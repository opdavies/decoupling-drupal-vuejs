# Setting up the Front-End Vue.js Application

The Vue.js front-end for my Blue Conf 2019 talk - [Decoupling Drupal with Vue.js](https://www.oliverdavies.uk/talks/decoupling-drupal-vuejs). It is a [Vue CLI](https://cli.vuejs.org) application, and uses [Tailwind CSS](https://tailwindcss.com) for styling.

## Prerequisites

* [npm](https://docs.npmjs.com/cli/npm)
* [yarn](https://yarnpkg.com) (optional)

## Setup instructions

1. Install the npm dependencies using either `npm` or `yarn`.

    ```bash
    cd vuejs

    # Using npm
    npm install

    # Using yarn
    yarn
    ```

1. Change the URL to the Drupal back-end if needed in `.env`.

1. Use `yarn serve` to start a local web server.

1. Visit the URL (usually `http://localhost:8080`) to view the front-end application.
