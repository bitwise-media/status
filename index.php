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

	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 840 204">
  		<g fill="#fff">
   			<path d="m466 165 16-70 4-17c0-2 2-3 3-3h31l-35 129h-38l-24-89-24 89h-37L327 75h32l3 3 19 83 1 6 25-92h33l25 91 1-1zM840 145h-80c-3 16 7 29 22 30 12 1 22-2 31-10l5-5 9 11 9 12-9 8a72 72 0 0 1-74 6c-16-7-24-21-28-37a99 99 0 0 1 1-51c7-24 26-39 51-41 10 0 20 1 29 5 21 9 30 26 33 47l1 25zm-37-21c0-11-1-20-10-26-8-5-16-4-24 1-8 6-10 15-10 25h44zM599 181l21-21 4 3c10 10 22 14 35 12a21 21 0 0 0 6-1 11 11 0 0 0 7-11c0-5-3-8-7-9l-19-3-18-5c-14-5-23-15-25-31s4-29 18-38c11-8 24-9 38-8 17 0 32 6 44 20l-21 19 1 2-5-4c-9-7-18-10-29-9-7 1-11 4-12 10 0 6 3 10 10 12l23 4a68 68 0 0 1 10 3c14 4 24 13 26 29s-4 28-16 38a64 64 0 0 1-44 11c-19-1-34-9-47-23zM541 75h35v129h-35V75zM579 40c0 14-6 20-21 20s-20-6-20-20c0-15 6-21 21-21 14 0 20 7 20 21zM88 103h29v72H88zM159 0h29v33h-29zM159 90h29v114h-29zM0 0h29v175H0zM233 0h29v175h-29zM0 175h88v29H0z" class="cls-1"/>
   			<path d="M0 74h88v29H0zM212 74h93v29h-93zM262 175h43v29h-43zM138 73h50v29h-50z" class="cls-1"/>
  		</g>
	</svg>

	<div class="wrapper">
		<?php
			foreach ($websites as $title => $url) {
					echo '<div class="website">';
						echo '<h2>' . $title . '</h2>';

						// read the database
						$database = new Database($title);
						$data = $database->read();

						// get only last 20
						$data = array_slice($data, -20);

						echo '<div class="pings">';

							foreach ($data as $timestamp) {
								$class = 'is-' . upOrDown($timestamp);
								$newTime = strtotime('-15 minutes');
								echo '<div class="ping ' . $class . '" title="' . date('Y-m-d H:i:s', $newTime); . '"></div>';
							}

						echo '</div>';
					echo '</div>';
			}
		?>
	</div>
</body>
</html>
