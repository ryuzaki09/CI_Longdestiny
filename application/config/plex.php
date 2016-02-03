<?php



$config['methods'] = array("play" => "plex/playback",
							// "previous" => "plex/playback",
							// "shuffle" => "plex/playback",
							"search" => "search",
							"hkdrama" => "download/HkDramaDownload",
							"jdrama" => "download/JdramaDownload",
							"download" => "download/torrent"
					);

$config['category'] = array("music", "movies", "series", "movie");

$config['getKeywords'] = array("servers", "devices", "search", "serverDetails");
