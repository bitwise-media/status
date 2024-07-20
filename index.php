<?php
require(__dir__ . '/database.php');

$websites = parse_ini_file('websites.ini');

function upOrDown ($timestamp) {
	if ($timestamp == 1) {
		return 'up';
	} else if ($timestamp == 0) {
		return 'down';
	}
}
?>
<!doctype html>
<html lang="sv-SE">
<head>
	<meta charset="UTF-8" />
	<title>Status - bitwise</title>

	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="theme-color" content="#000" />

	<meta name="description" content="" />
	<meta name="keywords" content="" />

	<meta name="author" content="bitwise media (https://bitwise.media)" />
	<meta name="copyright" content="&copy; 2024" />

	<link rel="stylesheet" href="./stylesheet.css?<?php echo time(); ?>" />
</head>
<body>

	<div class="wrapper">
		<?php
			foreach ($websites as $title => $url) {
				echo '<h2>' . $title . '</h2>';

				// read the database
				$database = new Database($title);
				$data = $database->read();

				// get only last 20
				$data = array_slice($data, -20);

				echo '<div class="website">';

					foreach ($data as $timestamp) {
						$class = 'is-' . upOrDown($timestamp);
						echo '<div class="square ' . $class . '"></div>';
					}

				echo '</div>';
			}
		?>
	</div>
</body>
</html>
