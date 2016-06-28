<?php
header('Content-Type:image/png');
Header("Location: https://api.lwl12.com/img/proxy/get/?src=" . $_GET["src"]);