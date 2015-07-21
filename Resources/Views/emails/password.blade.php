<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ trans('kotoba::email.welcome_to') }}{{ Config::get('kagi.site_name') }}</h2>

		<div>


<!-- resources/views/emails/password.blade.php -->

Click here to reset your password: {{ url('password/reset/'.$token) }}


		</div>

	</body>
</html>
