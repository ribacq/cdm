<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $title; ?> — CDM</title>
		<style type="text/css">
			body{
				max-width: 900px;
				margin: 20px auto;
				font-size: 14pt;
				border: 1px solid black;
				padding: 10px;
				font-family: sans-serif;
			}
			h1, h2, h3 {
				text-align: center;
			}
			div.component {
			}

			.alert-component {
				animation: fadeout 2s linear;
				opacity: 0;
				height: 0;
				overflow: hidden;
				padding: 10px;
				margin: 10px 0;
				background: red;
				color: white;
				box-shadow: -5px -5px 5px rgba(0, 0, 0, .5) inset;
				border-radius: 5px;
			}

			@keyframes fadeout {
				0%, 50% {
					opacity: 1;
					height: 100%;
				}

				100% {
					opacity: 0;
					height: 0;
				}
			}
		</style>
	</head>
	<body>
		<h1><?php echo $title; ?> — CDM</h1>
