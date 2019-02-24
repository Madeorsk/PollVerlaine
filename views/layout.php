<?php require __DIR__ . "/../config/app.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Poll Verlaine<?= isset($title) ? " - ".$title : "" ?></title>
	<link rel="stylesheet" type="text/css" href="<?= $VERLAINE["app_url"] ?>/static/css/main.css" />
<?php if(isset($head)): ?>
<?= $head ?>
<?php endif; ?>
</head>
<body>
<?= $body_content ?>
<footer>
  <a href="https://git.cant.at/Madeorsk/PollVerlaine" target="_blank">Here is my code!</a>
</footer>
</body>
</html>