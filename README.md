[![Build Status](https://travis-ci.com/DiscipleTools/disciple-tools-starter-plugin-template.svg?branch=master)](https://travis-ci.com/DiscipleTools/disciple-tools-starter-plugin-template)

# Disciple Tools - Starter Plugin Template

__Kick start your Disciple.Tools plugin project with this template!__

## Purpose

A team, organization, or movement effort might love Disciple.Tools, but __wish it had one more thing.__

We know that even though we have a common commission to make disciples of all nations, yet our assignments
on how to do that differ greatly or even if we share similar values our stages in movement differ. Either way,
we know we can't create everything everyone needs.

Instead of waiting for us, you can run ahead on your own. This
plugin includes all our best practices and starter codes for the most commonly developed extensions.

We have included starter code for a new post-type, a new REST API endpoint, a new admin page, or a new metrics chart.
The template also provides code quality and code style tools, Travis-CI integration, multi-language support, activation and
deactivation functions, and more. In truth it's likely more than your project needs, so we'll
guide you through removing the elements your project does not need.)

__This plugin is for developers__ who want to extend the Disciple.Tools system for their movement effort.

## Usage

#### Includes

 1. Wordpress style requirements
 1. Travis Continueous Integration
 1. Disciple Tools Theme presence check
 1. Remote upgrade system for ongoing updates outside the Wordpress Directory
 1. Multilingual ready
 1. PHP Code Sniffer support (composer) @use /vendor/bin/phpcs and /vendor/bin/phpcbf
 1. Starter Admin menu and options page with tabs.

#### Doesn't Include

- __Does not facilitate integrations to other systems.__



## Installing

- Composer
-


## Requirements



## Contribution

Contributions welcome. You can report issues and bugs in the
[Issues](https://github.com/DiscipleTools/disciple-tools-list-exports/issues) section of the repo. You can present ideas
in the [Discussions](https://github.com/DiscipleTools/disciple-tools-list-exports/discussions) section of the repo. And
code contributions are welcome using the [Pull Request](https://github.com/DiscipleTools/disciple-tools-list-exports/pulls)
system for git. For a more details on contribution see the [contribution guidelines](https://github.com/DiscipleTools/disciple-tools-list-exports/blob/master/CONTRIBUTING.md).


## Screenshots


### The starter plugin is equipped with:


### Refactoring this plugin as your own:
1. Refactor all occurrences of the name `Starter_Plugin`, `starter_plugin`, `starter-plugin`, and `Starter Plugin` with you're own plugin
name for the `disciple-tools-starter-plugin.php and admin-menu-and-tabs.php files.
1. Update the README.md and LICENSE
1. Update the translation strings inside `default.pot` file with a multilingual software like POEdit, if you intend to make your plugin multilingual.

### Installing Code Quality
At your command line prompt, inside the plugin folder root:
Run composer install. You will need composer installed into your system. The command below will install
required composer elements that provide code quality tools (phpcs).
```
$ composer install
```

Once composer install has run, you can run the `phpcbf` function out of the new vendor folder.
```
$ vendor/bin/phpcbf
```
If the `phpcbf` utility cannot auto correct a style issue, then use `phpcs` to print the code style
issues that need corrected.
```
$ vendor/bin/phpcs
```
