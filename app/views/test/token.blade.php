<!doctype html>
<html class="no-js" lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<base href="<?php echo URL::to('/'); ?>">
	<script>
		window.location.href = 'mailto:?body=<?php echo URL::route('token.index', ['token'=>$token]); ?>';

		function sleep(millis, callback) {
			setTimeout(function()
				{ window.close(); }
				, millis);
		}

		sleep(1000);
	</script>
</head>
<body>
<p>Token {{ $token }}</p>
</body>
</html>
