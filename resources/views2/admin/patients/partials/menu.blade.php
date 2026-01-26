@can('anesthesiste', \App\Models\Patient::class)
    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Menu
        <span class="caret"></span></button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('premedication_adaptation.index', $patient->id) }}" title="Traitement à l'hospitalisation / adaptation au traitement personnel" class="btn btn-success mb-1">
                <i class="fas fa-eye"></i>
                Prémédications
            </a>
        </li>
        
        <li>
            <a href="{{ route('consultations.index', $patient->id) }}" class="btn btn-success mb-1">
                <i class="fas fa-eye"></i>
                Consultations Chirurgicales
            </a>
        </li>
        <li>
            <a href="{{ route('observations_medicales.index', $patient->id) }}" class="btn btn-primary mb-1">
                <i class="far fa-plus-square"></i>
                Observations Médicales
            </a>
        </li>
        <li>
            <a href="{{ route('surveillance_score.index', $patient->id) }}" class="btn btn-success">
                <i class="far fa-plus-square"></i>
                Surveillance D'Aptitude >= 9/10
            </a>
        </li>
    </ul>

    <button type="button" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#SpostAnesth"
            title="Surveillance post anesthésique" data-whatever="@mdo">
        <i class="far fa-plus-square"></i> Surveillance Post Anesthésique
    </button>



    <!-- Fiches de consommables -->
    <a href="{{ route('fiche_consommable.index', $patient->id) }}" class="btn btn-info">
        <i class="far fa-plus-square"></i>
        FICHES DE CONSOMMABLES
    </a>
    
@endcan
@can('chirurgien', \App\Models\Patient::class)
    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Menu
        <span class="caret"></span></button>
    <ul class="dropdown-menu">
        <button type="button" class="btn btn-primary mb-1" data-bs-toggle="modal"
                data-bs-target="#FicheInterventionAnesthesiste"
                title="Ajouter une fiche d'intervention" data-whatever="@mdo">
            <i class="far fa-plus-square"></i>
            Fiche d'Intervention
        </button>
        
        <li>
            <button type="button" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#SpostAnesth"
                    title="Surveillance post anesthésique" data-whatever="@mdo">
                <i class="far fa-plus-square"></i> Surveillance Post Anesthésique
            </button>
        </li>
        <li>
            <a href="{{ route('surveillance_score.index', $patient->id) }}" class="btn btn-success">
                <i class="far fa-plus-square"></i>
                Surveillance d'Aptitude >= 9/10
            </a>
        </li>
    </ul>

{{--    LISTE DES ELEMENTS HORS MENU --}}
    <a href="{{ route('ordonance.create', $patient->id) }}" title="Nouvelle ordonnance médicale"
    class="btn btn-primary">
        <i class="far fa-plus-square"></i>
        Ordonnances
    </a>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#ordonanceModal"
            title="Prescrire un examen complémentaire" data-whatever="@mdo">
        <i class="far fa-plus-square"></i> Examens Complémentaires
    </button>
    <a href="{{ route('observations_medicales.index', $patient->id) }}" class="btn btn-primary">
        <i class="far fa-plus-square"></i>
        Observations Médicales
    </a>
{{--    <a href="{{ route('fiche_consommable.index', $patient->id) }}" class="btn btn-info">--}}
{{--        <i class="far fa-plus-square"></i>--}}
{{--        FICHES DE CONSOMMABLES--}}
{{--    </a>--}}
{{--    FIN DE LA LISTE DES ELEMENTS HORS MENU --}}
@endcan

@can('infirmier', \App\Models\Patient::class)
    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Menu
        <span class="caret"></span></button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('premedication_adaptation.index', $patient->id) }}" title="Traitement à l'hospitalisation / adaptation au traitement personnel" class="btn btn-success mb-1">
                <i class="fas fa-eye"></i>
                Prémédications
            </a>
        </li>
        
        <li>
            <a href="{{ route('consultations.index', $patient->id) }}" class="btn btn-success mb-1">
                <i class="fas fa-eye"></i>
                Consultations chirurgicales
            </a>
        </li>
        
        <li>
            <a href="{{ route('surveillance_score.index', $patient->id) }}" class="btn btn-success">
                <i class="far fa-plus-square"></i>
                Surveillance d'aptitude >= 9/10
            </a>
        </li>
    </ul>

    {{--    LISTE DES ELEMENTS HORS MENU --}}
    <a href="{{ route('observations_medicales.index', $patient->id) }}" class="btn btn-primary">
        <i class="far fa-plus-square"></i>
        Observations médicales
    </a>
    <a href="{{ route('fiche_consommable.index', $patient->id) }}" class="btn btn-info">
        <i class="far fa-plus-square"></i>
        FICHES DE CONSOMMABLES
    </a>
    {{--    FIN DE LA LISTE DES ELEMENTS HORS MENU --}}
@endcan
