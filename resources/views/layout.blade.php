<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title>Gestion d'événements sportifs</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
		@yield('stylesheet')
		<script src="//code.jquery.com/jquery.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="{{ asset('js/script.js') }}"></script>
	    <!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>
	<body>
		<div class="container">
			<div class="masthead">
        		<h1 class="text-muted">Événement Sportif</h1>
        		<ul class="nav nav-justified">
					<?php $route = explode('.', Route::currentRouteName())[0] ?>
          			<li<?php if ($route == "") { ?> class="active"<?php } ?>><a href="{{ action('HomeController@index') }}">Accueil</a></li>
         			<li<?php if ($route == "sports") { ?> class="active"<?php } ?>><a href="{{ action('SportsController@index') }}">Sports</a></li>
          			<li<?php if ($route == "epreuves") { ?> class="active"<?php } ?>><a href="{{ action('EpreuvesController@index') }}">Épreuves</a></li>
          			<li<?php if ($route == "participants") { ?> class="active"<?php } ?>><a href="{{ action('ParticipantsController@index') }}">Participants</a></li>
                    <li<?php if ($route == "terrains") { ?> class="active"<?php } ?>><a href="{{ action('TerrainsController@index') }}">Terrains</a></li>
          			<li<?php if ($route == "resultats") { ?> class="active"<?php } ?>><a href="{{ action('ResultatsController@index') }}">Résultats</a></li>
          			<li<?php if ($route == "benevoles") { ?> class="active"<?php } ?>><a href="{{ action('BenevolesController@index') }}">Bénévoles</a></li>
          			<li<?php if ($route == "arbitres") { ?> class="active"<?php } ?>><a href="{{ action('ArbitresController@index') }}">Arbitres</a></li>
					<li<?php if ($route == "roles") { ?> class="active"<?php } ?>><a href="{{ action('RolesController@index') }}">Rôles</a></li>
          			<?php if (Auth::user() == "") { ?>
          			<li><a href="{{ action('Auth\AuthController@getLogin') }}">Connexion</a></li>
          			<li><a href="{{ action('Auth\AuthController@getLogin') }}">Inscription</a></li>
          			<?php } else { ?>
          			<li><a href="{{ action('Auth\AuthController@getLogout') }}">Déconnexion [{{ Auth::user()->username }}]</a></li>
					<?php } ?>
          		</ul>
     		</div>
      		
			@yield('content')

      		<!-- Site footer -->
      		<div class="footer">
        		<p></p>
      		</div>
			@yield('script')
    	</div> <!-- /container -->
	</body>
</html>
