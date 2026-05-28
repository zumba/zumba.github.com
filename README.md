## Zumba Public Engineering Site

This repo contains a [Jekyll](https://github.com/mojombo/jekyll) templated site made
to deploy on Github's Pages.

## Requirements

* Ruby / Bundler
* Jekyll 4.0+

## Install

1. Install required gems: `bundle install`

### Run

```shell
npm start
```

This will build the files, attach a watch to the files for changes, and serve to `http://localhost:4000`.

### Styling

To update the CSS, edit the `.scss` files in the `sass` directory, then run:

```shell
npm run build:css
```

In order for these styles to display on Github pages, you'll need to commit your final build css files in the css directory.
