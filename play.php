<?php
require ('req_protocol.php');

$host = $_SERVER['HTTP_HOST'];
$dir = dirname($_SERVER['SCRIPT_NAME']);
$id = $_GET['id'];

echo <<<CONTENT
<html>
<head>
<script src="https://cdn.jsdelivr.net/npm/hls.js@1.1.4/dist/hls.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/plyr@3.6.12/dist/plyr.css"/>
<script src="https://cdn.jsdelivr.net/npm/plyr@3.6.12/dist/plyr.min.js"></script>
<style>
html {
font-family: sans-serif;
background: #000;
}
.plyr {
height: 100%;
width :100%;
}
:root {
--plyr-color-main: #d9230f;
}
</style>
</head>
<body>
<div>
<video autoplay controls crossorigin playsinline>
<source type="application/vnd.apple.mpegurl" src="$protocol://$host$dir/autoq.php?id=$id">
</video>
</div>
</body>
<script>
document.addEventListener("DOMContentLoaded", () => {
const e = document.querySelector("video"),
n = e.getElementsByTagName("source")[0].src,
o = {};
if(Hls.isSupported()) {
var config = {
maxMaxBufferLength: 100,
};
const t = new Hls(config);
t.loadSource(n), t.on(Hls.Events.MANIFEST_PARSED, function(n, l) {
const s = t.levels.map(e => e.height);
o.controls = ['play-large', 'play', 'mute', 'volume', 'settings', 'fullscreen'];
o.quality = {
default: s[0],
options: s,
forced: !0,
onChange: e => (function(e) {
window.hls.levels.forEach((n, o) => {
n.height === e && (window.hls.currentLevel = o)
})
})(e)
};
new Plyr(e, o)
}), t.attachMedia(e), window.hls = t
} else {
new Plyr(e, o)
}
});
</script>
</body>
</html>
CONTENT
?>
