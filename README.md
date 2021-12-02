# Webtor Wordpress Plugin

Embeds webtor player to WordPress with a shortcode

## How to Install

Go to the [releases](https://github.com/webtor-io/wordpress-plugin/releases) section of the repository and download the most recent release.

Then, from your WordPress administration panel, go to `Plugins > Add New` and click the `Upload Plugin` button at the top of the page.

## Examples

The very simple example:
```
[webtor src="magnet:?xt=urn:btih:08ada5a7a6183aae1e09d831df6748d566095a10&dn=Sintel"]
```

More serious one with custom subtitles and title.
```
[webtor src="magnet:?xt=urn:btih:08ada5a7a6183aae1e09d831df6748d566095a10&dn=Sintel" data-title="Sintel" track-en-src="https://raw.githubusercontent.com/andreyvit/subtitle-tools/master/sample.srt" track-en-default="true" track-en-label="English"]
```

Full list of attributes can be found [here](https://github.com/webtor-io/embed-sdk-js#video-element-attributes-streaming).
