@extends('layouts.admin') @section('title', 'CMCU | Modifier un utilisateur') @section('content')

<body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
        @include('partials.side_bar')

        <!-- Page Content Holder -->
        @include('partials.header')
        <!--// top-bar -->
        <div class="container">
            <h1 class="text-center">MODIFIER UN UTILISATEUR</h1>
            <hr>

            <div class="card mx-auto" style="max-width: 60rem; margin-left: 160px; ">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        <small class="text-info" title="Les champs marqués par une étoile rouge sont obligatoire">Les champs marqués par une étoile rouge sont obligatoire</small>
                        <!--  -->
                    </div>
                    <form class="mb-3" action="{{ route('users.update', $user->id) }}" method="POST">
                        {{method_field('PATCH')}} {{csrf_field()}}
                        <div class="col-12">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input name="name" class="form-control" value="{{ $user->name }}" type="text" placeholder="Nom" required>
                                </div>
                                <div class=" col-md-6">
                                    <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input name="prenom" class="form-control" value="{{ $user->prenom }}" type="text" placeholder="Prénom">
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="sexe" class="form-label">Sexe <span class="text-danger">*</span></label>
                                    <div >
                                        <div class="form-check form-check-inline me-3">
                                            <input class="form-check-input" type="radio" name="sexe" id="homme" value="Homme"  @if($user->sexe == 'Homme') checked @endif required>
                                            <label class="form-check-label" for="homme">Homme</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sexe" id="femme" value="Femme"  @if($user->sexe == 'Femme') checked @endif required>
                                            <label class="form-check-label" for="femme">Femme</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="telephone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                                    <input name="telephone" id="telephone" type="tel" value="{{ $user->telephone }}" class="form-control" placeholder="Téléphone" required>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="lieu_naissance" class="form-label">Lieu De Naissance <span class="text-danger">*</span></label>
                                    <input name="lieu_naissance" value="{{ $user->lieu_naissance }}" class="form-control" placeholder="Lieu de naissance" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="date_naissance" class="form-label">Date De Naissance <span class="text-danger">*</span></label>
                                    <input name="date_naissance" type="date" value="{{ $user->date_naissance }}" class="form-control" placeholder="Date de naissance" required>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="roles">Rôle <span class="text-danger">*</span></label>
                                    <select name="roles" class="form-select" id="roles">
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="login" class="form-label">Login <span class="text-danger">*</span></label>
                                    <input name="login" class="form-control" value="{{ $user->login }}" type="text" placeholder="Login" required>
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Nouveau Mot De Passe <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Confirmer Mot De Passe <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input name="password" type="password" class="form-control" id="password" placeholder="Nouveau Mot De Passe" required>
                                </div>
                            <div class="col-md-6 position-relative">
                                    <div class="d-flex">
                                        <input id="confirm_password" type="password" class="form-control" name="password_confirmation" placeholder="Confirmer Mot De Passe" required>
                                        <button class="btn btn-outline-secondary ms-2" type="button" onclick="show_password()"><i id="show_pass" class="fas fa-eye"></i></button>
                                    </div>
                                    <span id='message' class="d-block mt-1"></span>
                                </div>
                            </div>
                            
                            <hr class="my-4">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="submit" class="w-100 btn btn-primary btn-lg" title="Valider votre enregistrement" value="Ajouter">
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('users.index') }}" class="w-100 btn btn-warning btn-lg text-decoration-none d-block text-center pt-2" title="Retour à la liste des utilisateurs">Annuler</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <script src="{{ asset('vendor/js/jquery-3.2.1.slim.min.js') }}"></script>
    <script type="text/javascript">
        $('#password, #confirm_password').on('keyup', function() {
            if (($('#password').val() == $('#confirm_password').val()) && $('#password').val()) {
                $('#message').html('<i class="fas fa-check fa-2x"></i>').css('color', 'green');
            } else
                $('#message').html('<i class="fas fa-times fa-2x"></i>').css('color', 'red');
        });

        function show_password() {
            var x = document.getElementById("password");
            var y = document.getElementById("confirm_password");
            if (x.type === "password" | y.type === "password") {
                x.type = "text";
                y.type = "text";
                $('#show_pass').removeClass('fa-eye');
                $('#show_pass').addClass('fa-eye-slash');
            } else {
                x.type = "password";
                y.type = "password";
                $('#show_pass').removeClass('fa-eye-slash');
                $('#show_pass').addClass('fa-eye');
            }
        }

        $("#roles").change(function() {
            if ($(this).val() == '2') {
                $('#otherFieldDiv').show();
                $('#specialite').attr('required', '');
                $('#onmc').attr('required', '');
            } else {
                $('#otherFieldDiv').hide();
                $('#specialite').removeAttr('required');
                $('#onmc').removeAttr('required');
            }
        });
        //$("#roles").trigger("change");
    </script>
</body>

@stop