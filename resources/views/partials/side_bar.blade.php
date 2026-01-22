
<!-- Sidebar Holder -->
<nav id="sidebar">
    <div class="sidebar-header">
        <h1>
            {{-- <a href="#">{{ config('app.name') }}</a>--}}
        </h1>
        <span>M</span>
    </div>
    <img src="{{ asset('admin/images/logo.jpg') }}" class="profile-bg img-fluid" style="width: 100%">
    <ul class="list-unstyled components">
        <li class="active">
            <a href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                Tableau de bord
            </a>
        </li>

        @can('update', \App\Models\User::class)
        {{--@can('changeOwner')--}}
        <li>
            <a href="#usersSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                <i class="fas fa-user-friends"></i>
                Utilisateurs
                <i class="fas fa-angle-down float-end"></i>
            </a>
            <ul class="collapse list-unstyled" id="usersSubmenu">
                <li>
                    <a href="{{ route('users.index') }}">
                        <i class="fas fa-address-book"></i>
                        Liste des utilisateurs
                    </a>
                </li>
                <li>
                    <a href="{{ route('roles.index') }}">
                        <i class="fas fa-user-shield"></i>
                        Roles
                    </a>
                </li>
            </ul>
        </li>
        {{--@endcan--}}
        @endcan

        @can('update', \App\Models\Patient::class)
        <li>
            <a href="#patientsSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                <i class="fas fa-user-injured"></i>
                Patients
                <i class="fas fa-angle-down float-end"></i>
            </a>
            <ul class="collapse list-unstyled" id="patientsSubmenu">
                <li>
                    <a href="{{ route('patients.index') }}">
                        <i class="fas fa-clipboard-list"></i>
                        Liste des patients
                    </a>
                </li>
                @can('medecin', \App\Models\Patient::class)
                <li>
                    <a href="{{ route('patients.suivis') }}">
                        <i class="fas fa-user-check"></i>
                        Mes patients suivis
                    </a>
                </li>
                @endcan

                <!-- @can('show', \App\Models\User::class)
                    <li>
                        <a href="{{ route('examens.index') }}">
                            <i class="fas fa-search"></i>
                            Examens medicaux
                        </a>
                    </li>
                    @endcan -->

                @can('anesthesiste', \App\Models\Patient::class)
                <li>
                    <a href="{{ route('produits.anesthesiste') }}">
                        <i class="fas fa-syringe"></i>
                        Produits anesthésiste
                    </a>
                </li>
                @endcan
            </ul>
        </li>

        <!--
            @can('view', \App\Models\User::class)
            <li>
                <a href="{{-- route('clients.index') --}}">
                    <i class="fas fa-list-ul"></i>
                    Clients Externes
                </a>
            </li>
            @endcan
        -->

        @endcan

        @can('create', \App\Models\Produit::class)
        <li>
            <a href="#pageSubmenu1" data-bs-toggle="collapse" aria-expanded="false">
                <i class="fas fa-pills"></i>
                Gestion des produits
                <i class="fas fa-angle-down float-end"></i>
            </a>
            <ul class="collapse list-unstyled" id="pageSubmenu1">
                <li>
                    <a href="{{ route('produits.index') }}">
                        <i class="fas fa-boxes"></i>
                        Produits en stock
                    </a>
                </li>
                <li>
                    <a href="{{ route('produits.pharmaceutique') }}">
                        <i class="fas fa-capsules"></i>
                        Produits pharmaceutiques
                    </a>
                </li>
                <li>
                    <a href="{{ route('materiels.pharmaceutique') }}">
                        <i class="fas fa-x-ray"></i>
                        Produits matériels
                    </a>
                </li>
                <li>
                    <a href="{{ route('produits.anesthesiste') }}">
                        <i class="fas fa-syringe"></i>
                        Produits anesthésiste
                    </a>
                </li>
            </ul>
        </li>
        @endcan

        @can('create', \App\Models\chambre::class)
        <li>
            <a href="{{ route('chambres.index') }}">
                <i class="fas fa-procedures"></i>
                Chambres
            </a>
        </li>
        @endcan

        @can('view', \App\Models\Event::class)
        <li>
            <a href="{{ route('events.index') }}">
                <i class="fas fa-calendar-check"></i>
                Rendez-vous
            </a>
        </li>
        @endcan

        @can('create', \App\Models\Fiche::class)
        <li>
            <a href="{{ route('fiches.index') }}">
                <i class="fas fa-smile"></i>
                Fiches de satisfaction
            </a>
        </li>
        @endcan

        @can('view', \App\Models\User::class)
        <li>
            <a href="{{ route('factures.consultation') }}">
                <i class="fas fa-file-invoice-dollar"></i>
                Facture
            </a>
        </li>
        @endcan

        @can('view', \App\Models\Devi::class)
        <li>
            <a href="{{ route('devis.index') }}">
                <i class="fas fa-file-contract"></i>
                Devis
            </a>
        </li>
        @endcan
    </ul>
</nav>
