@if (explode('/', $devis['categorie'])[14] == 'K BLOC')
    <tr>
        <td><b>{{ explode('/', $devis['categorie'])[14] }}</b></td>
        <td colspan="2" class="text-center">Sous-total</td>
        <td class="text-end"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><small><b>{{ explode('/', $devis['produit'])[14] }}</b></small></td>
        <td class="text-end">{{ explode('/', $devis['prix'])[14] }}</td>
    </tr>
    @if (explode('/', $devis['categorie'])[13] == 'K BLOC')
        <tr>
            <td></td>
            <td></td>
            <td class="text-end"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><small><b>{{ explode('/', $devis['produit'])[13] }}</b></small></td>
            <td class="text-end">{{ explode('/', $devis['prix'])[13] }}</td>
        </tr>
    @endif
    @if (explode('/', $devis['categorie'])[14] == 'K BLOC')
        <tr>
            <td></td>
            <td></td>
            <td class="text-end"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><small><b>{{ explode('/', $devis['produit'])[14] }}</b></small></td>
            <td class="text-end">{{ explode('/', $devis['prix'])[14] }}</td>
        </tr>
    @endif
    @if (explode('/', $devis['categorie'])[15] == 'K BLOC')
        <tr>
            <td></td>
            <td></td>
            <td class="text-end"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><small><b>{{ explode('/', $devis['produit'])[15] }}</b></small></td>
            <td class="text-end">{{ explode('/', $devis['prix'])[15] }}</td>
        </tr>
    @endif
    @if (explode('/', $devis['categorie'])[16] == 'K BLOC')
        <tr>
            <td></td>
            <td></td>
            <td class="text-end"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><small><b>{{ explode('/', $devis['produit'])[16] }}</b></small></td>
            <td class="text-end">{{ explode('/', $devis['prix'])[16] }}</td>
        </tr>
    @endif
    @if (explode('/', $devis['categorie'])[17] == 'K BLOC')
        <tr>
            <td></td>
            <td></td>
            <td class="text-end"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><small><b>{{ explode('/', $devis['produit'])[17] }}</b></small></td>
            <td class="text-end">{{ explode('/', $devis['prix'])[17] }}</td>
        </tr>
    @endif
    @if (explode('/', $devis['categorie'])[18] == 'K BLOC')
        <tr>
            <td></td>
            <td></td>
            <td class="text-end"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><small><b>{{ explode('/', $devis['produit'])[18] }}</b></small></td>
            <td class="text-end">{{ explode('/', $devis['prix'])[18] }}</td>
        </tr>
    @endif
    @if (explode('/', $devis['categorie'])[19] == 'K BLOC')
        <tr>
            <td></td>
            <td></td>
            <td class="text-end"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><small><b>{{ explode('/', $devis['produit'])[19] }}</b></small></td>
            <td class="text-end">{{ explode('/', $devis['prix'])[19] }}</td>
        </tr>
    @endif
@endif

