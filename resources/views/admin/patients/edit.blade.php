@can('infirmier_secretaire', \App\Models\Patient::class)
<div class="card">
    <div class="card-body">
        <h3 class="card-title">Modifier les informations du patient {{ $patient->name }} {{ $patient->prenom }}</h3>
        <!--  -->
        <!--  -->

        <form action="{{ route('patients.update', $patient->id) }}" method="POST">
            @csrf @method('PATCH')

            <table class="table table-user-information ">
                <tbody>
                <tr>
                    <td>
                        <b>Nom du patient :</b>
                    </td>
                    <td>
                        <input name="name" type="text" value='{{ $patient->name }}'>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Assurance :</b>
                    </td>
                    <td>
                        <Input name="assurance" type="text" value='{{ $patient->assurance }}'>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Numéro d'assurance :</b>
                    </td>
                    <td>
                        <Input name="numero_assurance" type="text" value='{{ $patient->numero_assurance }}'>
                    </td>
                </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href="{{ route('dossiers.create', $patient) }}" class="btn btn-info float-end">Completer le dossier</a>
        </form>
    </div>
</div>
@endcan
