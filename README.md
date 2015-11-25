# === Summarize ===

CONTRIBUTORS: Radu Vaduva

TAGS: recent posts, recent entries, summary, latest posts, latest entires, shorcode, hatom, microformats, sandbox, excerpt

REQUIRES AT LEAST: 2.5

TESTED UP TO: 2.6

STABLE TAG: 0.1

Summarize produces a list of the latest blog post excerpts with the shortcode `[summarize]`.

== Description ==

Summarize produces a list of latest blog entries with excerpts, dates, and comments links that is generated with the shortcode `[summarize]` on any post or page.
Shortcode attributes are available to customize the output as well as specify number of entries to show.

== Installation ==

1. Extract the `/summarize/` folder from the archive and upload this folder to `../wp-contents/plugins/`
2. Activate the plugin in *Dashboard > Plugins*
3. Use the shortcode `[summarize]` on any page/post

== Use ==

After activating this plugin, simply use the shortcode `[summarize]` wherever you want a list of recent entries.
The following optional attributes are parsed by this shortcode to customize the output:

* `count` - Number of recent entries to show. Default is 5.
* `grouptag` - HTML element to wrap all recent entries. Default is `ol`.
* `entrytag` - HTML element to wrap each entry. Default is `li`.
* `titletag` - HTML element to wrap each entry title. Default is `h4`.
* `datetag` - HTML element to wrap each entry date. Default is `span`.
* `commentstag` - HTML element to wrap each entry comments link. Default is `span`.
* `summarytag` - HTML element to wrap each entry summary. Default is `div`.

You may specify all or some of the attributes above. Attributes are optional and can be given in any order.

`[summarize count="3" titletag="h2" datetag="p" commentstag="div"]`

