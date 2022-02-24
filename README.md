## Zumba Public Engineering Site

This repo contains a [Jekyll](https://github.com/mojombo/jekyll) templated site made
to deploy on Github's Pages.

## Requirements

* Jekyll 1.0+
* Nodejs 0.10+
* Grunt 0.4+
* Compass 0.12+

## Install

1. Install Jekyll: `gem install jekyll bundler`
1. Install required ruby gems: `bundle install`
1. Install Grunt CLI: `npm install -g grunt-cli`
1. Install NodeJS dependencies: `npm install`

### Run

```shell
grunt
```

This will build the files, attach a watch to the files for changes, and serve to `http://localhost:4000`.

### Styling

To update the CSS, edit the `.scss` files in the `sass` directory, then run `grunt compass` to compile.

In order for these styles to display on Github pages, you'll need to commit your final build css files in the css directory.
