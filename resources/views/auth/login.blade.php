@extends('layouts.login_layout')
@section('content')
<div class="mid-class">
    <div class="art-contain-w3ls">
        <div class="art-right-w3ls">
            <h2>Connexion-CMCU</h2>
            <div class="welcome-text">
                <p>Entree vos information pour vous connecter</p>
            </div>
            <!--  -->
            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="main">
                    <div class="form-left-to-w3l">
                        <label for="login">Nom d'Utilisateur</label>
                        <input type="text" id="login" 
                        name="login" 
                        value="{{ old('login') }}"
                        placeholder="Nom d'Utilisateur" 
                        required="">
                    </div>
                    <div class="form-left-to-w3l password-container">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password"
                        placeholder="***************" required="required">
                        <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                        <div class="clear"></div>
                    </div>
                </div>
                <script>
                    document.getElementById('togglePassword').addEventListener('click', function
                    () {
                    const passwordField = document.getElementById('password');
                    const toggleIcon = this;
                    if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                    } else {
                    passwordField.type = 'password';
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                    }
                    });
                </script>
                <div class="form-footer">
                    <div class="left-side-forget">
                        <input type="checkbox" class="checked" name="remember" {{
                        old('remember') ? 'checked' : '' }}>
                        <span class="remenber-me">Se souvenir de moi</span>
                    </div>
                    <div class="right-side-forget">
                        <a href="#">Mot de passe oublier</a>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="btnn">
                    <button type="submit">Connexion</button>

                </div>
            </form>
            <div class="w3layouts_more-buttn">
                <h3>Problème de connexion ?
                    <a href="#">Contact</a>
                </h3>
            </div>
        </div>
        <div class="art-left-w3ls">
            <img class="header-w3ls img" src="{{ asset('admin/images/logo.jpg') }}">
            <p class="text-center">
                <h1 align="center">CENTRE MEDICO-CHIRURGICAL d'UROLOGIE et de CHIRURGIE MINI-
                INVASIVE</h1>
                <h3 align="center">VALLEE MANGA BELL</h3>
                <h3 align="center">DOUALA-BALI</h3>
                <h4 align="center">TEL: (+ 237) 233 423 389 / 674 068 988 / 698 873 945</h4>
                <h4 align="center">www.cmcu-cm.com</h4>
            </p>
        </div>
    @include('flash::message')
    </div>
</div>
@endsection 