<tbody style="display: none;" id="myDIV">
<tr>
    <td>
        <b>NOM ET PRENOM DU PATIENT :</b>
    </td>
    <td>{{ $patient->name }} {{ $patient->prenom }}</td>
</tr>
<tr>
    <td>
        <b>NUMERO DE DOSSIER :</b>
    </td>
    <td>{{ $patient->numero_dossier }}</td>
</tr>
<tr>
    <td>
        <b>FRAIS DE {{ strtoupper($patient->details_motif) ?? 'CONSULTATION' }} :</b>
    </td>
    <td>{{ $patient->montant }} FCFA</td>
</tr>
@foreach ($patient->dossiers as $dossier)

    <tr>
        <td>
            <b>GENRE :</b>
        </td>
        <td>{{ $dossier->sexe }}</td>
    </tr>
    <tr>
        <td>
            <b>PROFESSION :</b>
        </td>
        <td>{{ $dossier->profession }}</td>
    </tr>
    <tr>
        <td>
            <b>ADRESSE :</b>
        </td>
        <td>{{ $dossier->adresse }}</td>
    </tr>
    <tr>
        <td>
            <b>PORTABLE :</b>
        </td>
        <td>
            {{ $dossier->portable_1 }}<br>
            {{ $dossier->portable_2 }}
        </td>
    </tr>
    <tr>
        <td>
            <b>FAX :</b>
        </td>
        <td>{{ $dossier->fax }}</td>
    </tr>
    <tr>
        <td>
            <b>EMAIL :</b>
        </td>
        <td>{{ $dossier->email }}</td>
    </tr>
    <tr>
        <td>
            <b>LIEU DE NAISSANCE :</b>
        </td>
        <td>{{ $dossier->lieu_naissance }}</td>
    </tr>
    <tr>
        <td>
            <b>DATE DE NAISSANCE :</b>
        </td>
        <td>{{ $dossier->date_naissance }}</td>
    </tr>
    <!-- <tr>
        <td>
            <b>PERSONNE DE CONFIANCE :</b>
        </td>
        <td>{{ $dossier->personne_confiance }}</td>
    </tr>
    <tr>
        <td>
            <b>TELEPHONE PERSONNE DE CONFIANCE :</b>
        </td>
        <td>{{ $dossier->tel_personne_confiance }}</td>
    </tr> -->
    <tr>
        <td>
            <b>PERSONNE A CONTACTER :</b>
        </td>
        <td>{{ $dossier->personne_contact }}</td>
    </tr>
    <tr>
        <td>
            <b>TELEPHONE PERSONNE A CONTACTER :</b>
        </td>
        <td>{{ $dossier->tel_personne_contact }}</td>
    </tr>
@endforeach
</tbody>
