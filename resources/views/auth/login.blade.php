<!DOCTYPE HTML>
<html>

<!--
    Ceci est une page de connexion personnalisé 
    
    Par : FUZZ
    Créé le : 03/10/15
-->

<head>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('/css/login.css') }}">
</head>

<body>
    <div class="jumbotron">

        <div class="container">
            <form method="POST" action="/auth/login">
                {!! csrf_field() !!}

                <h2>Authentification</h2>

                <div class="form-group">
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control input-lg" placeholder="Courriel">
                </div>

                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Mot de passe">
                </div>

                <div class="form-group">
                    <input type="checkbox" name="remember"> Se souvenir de moi
                </div>

                <div>
                    <button type="submit" class="btn btn-success btn-lg btn-block">Connexion <span class="glyphicon glyphicon-lock" aria-hidden="true"></span></button>
                    <span class="pull-right">
                        <a href="#">S'inscrire</a>
                            </span><span>
                        <a href="#">Besoin d'aide?</a>
                    </span>
                </div>

            </form>
        </div>
    </div>
</body>
</html>

