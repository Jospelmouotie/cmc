@if (explode('/', $devis['categorie'])[3] == 'CS ANESTHESIE')
    <tr>
        <td><b>{{ explode('/', $devis['categorie'])[3] }}</b></td>
        <td colspan="2" class="text-center">Sous-total</td>
        <td class="text-end"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><small><b>{{ explode('/', $devis['produit'])[3] }}</b></small></td>
        <td class="text-end">{{ explode('/', $devis['prix'])[3] }}</td>
    </tr>
@endif

@if (explode('/', $devis['categorie'])[4] == 'CS ANESTHESIE')
    <tr>
        <td><b>{{ explode('/', $devis['categorie'])[4] }}</b></td>
        <td colspan="2" class="text-center">Sous-total</td>
        <td class="text-end"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><small><b>{{ explode('/', $devis['produit'])[4] }}</b></small></td>
        <td class="text-end">{{ explode('/', $devis['prix'])[4] }}</td>
    </tr>
@endif

@if (explode('/', $devis['categorie'])[5] == 'CS ANESTHESIE')
    <tr>
        <td><b>{{ explode('/', $devis['categorie'])[5] }}</b></td>
        <td colspan="2" class="text-center">Sous-total</td>
        <td class="text-end"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><small><b>{{ explode('/', $devis['produit'])[5] }}</b></small></td>
        <td class="text-end">{{ explode('/', $devis['prix'])[5] }}</td>
    </tr>
@endif
