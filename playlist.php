<?php
header("Content-Type: application/vnd.apple.mpegurl");

require ('channels.php');
require ('req_protocol.php');

$channels = getChannelList();

$host = $_SERVER['HTTP_HOST'];
$dir = dirname($_SERVER['SCRIPT_NAME']);
$id = $_GET['id'];

echo <<<HEADER
#EXTM3U
#EXTM3U x-tvg-url="https://github.com/mitthu786/tvepg/releases/download/latest/epg.xml.gz"
HEADER;

foreach ($channels as $channel)
{
$id = $channel['channel_id'];
$genre = $GENRE_MAP[$channel['channelCategoryId']];
$language = $LANG_MAP[$channel['channelLanguageId']];
$logo = $channel['logoUrl'];
$name = $channel['channel_name'];

echo <<<CONTENT
#EXTINF:-1 tvg-id="$id" group-title="$genre" tvg-language="$language" tvg-logo="https://jiotv.catchup.cdn.jio.com/dare_images/images/$logo", $name
$protocol://%s%s/autoq.php?id=%s" . PHP_EOL . PHP_EOL, $_SERVER['HTTP_HOST'], dirname($_SERVER['SCRIPT_NAME']), $channel['channel_id']);
CONTENT;
}
?>
