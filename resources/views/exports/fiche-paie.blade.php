@php
    $mois = [
        'January' => 'Janvier',
        'February' => 'Février',
        'March' => 'Mars',
        'April' => 'Avril',
        'May' => 'Mai',
        'June' => 'Juin',
        'July' => 'Juillet',
        'August' => 'Août',
        'September' => 'Septembre',
        'October' => 'Octobre',
        'November' => 'Novembre',
        'December' => 'Décembre'
    ]
@endphp
<table>
    <thead>
    <tr>
        <td style="height:35px"></td>
        <td style="height:50px;border:2px solid #3498db;vertical-align:middle;font-weight:bold;text-align:center;"
            colspan="14">REPUBLIQUE DU BENIN
        </td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:50px;border:2px solid #3498db;text-align:center;vertical-align:middle;font-weight:bold;text-align:center;"
            colspan="4">{{$employee->client->nom}}</td>
        <td style="height:50px;border:2px solid #3498db;vertical-align:middle;font-weight:bold;text-align:center;"
            colspan="10"></td>
    </tr>

    <tr>
        <td style="height:35px"></td>
        <td style="height:50px;vertical-align:middle;border:2px solid #3498db;text-align:center;font-size:18px;font-weight:bold;"
            colspan="14">FICHE DE PAIE
        </td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:30px;vertical-align:middle;border:2px solid #3498db" colspan="9"></td>
        <td style="height:30px;vertical-align:middle;border:2px solid #3498db" colspan="5">
            <h3>Fait le {{ now()->locale('fr')->format('d ') . $mois[now()->format('F')] . ' ' . now()->year }} </h3>
    </tr>
    <tr>
        <td style="height:30px"></td>
        <td style="height:30px" colspan="9"></td>
        <td style="height:30px;vertical-align:middle;border:2px solid #3498db" colspan="5" class='py-3'>
            Periode: {{ $mois[now()->format('F')] . ' ' . now()->year }}</td>
    </tr>
    {{--        <tr class="">--}}
    {{--            <td style="height:30px;"></td>--}}
    {{--            <td style="height:30px;vertical-align:middle;border:2px solid #3498db" colspan="9"></td>--}}
    {{--            <td style="height:30px;vertical-align:middle;border:2px solid #3498db" colspan="5">xxxxx</td>--}}
    {{--        </tr>--}}
    <tr class="">
        <td style="height:35px"></td>
        <td style="height:35px" colspan="9"></td>
        <td style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;"
            colspan="5">Cotonou Rép.Du Bénin
        </td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="14" class='py-3'></td>
    </tr>
    </thead>

    <tbody>
    <tr>
        <td style="height:35px"></td>
        <td colspan="6"
            style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;">Nom
            : {{$employee->nom}}</td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;">
            Prénoms:
        </td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;">{{$employee->prenoms}}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td colspan="6"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">
            Fonction : {{$employee->fonctions()->first()->nom ?? ' '}}</td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">
            Catégorie:
        </td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">{{$employee->category?->nom}}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td colspan="6"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">
            Situation matrimoniale : {{ $employee->situation_matrimoniale }}</td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">Nombre
            d'enfants: {{$employee->nb_enfants}}</td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;"></td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="14" class='py-3'></td>
    </tr>
    {{-- <td >


        <tr>d'enfants: xxxxxxx</tr>
      </td>
      <td colSpan={2} className=''>


        <tr>
      <tr colSpan={5} className='py-3'></tr>
    </tr>
      </td> --}}
    <tr class="">
        <td style="height:50px"></td>
        <td style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;"
            colspan="10">Eléments
        </td>
        <td style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;text-align:center"
            colspan="4">Montants
        </td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="10">SALAIRES BRUTES</td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;text-align:center"
            colspan="4">{{$employee->salaire}}</td>

    </tr>
    <tr class="">
        <td style="height:50px"></td>
        <td style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;"
            colspan="2"></td>
        <td style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;"
            colspan="8">SALAIRE BRUT MENSUEL
        </td>
        <td style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;text-align:center"
            colspan="4">{{$employee->salaire}}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="10">RETENUES OBLIGATOIRES</td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;text-align:center" colspan="4"></td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="10">C.N.S.S</td>
        @php
            $cnss = $employee->tauxCnss ? $employee->salaire * $employee->tauxCnss : $employee->salaire * 0.036;
            $montantIts = $employee->salaire * $employee->tauxIts;
            $totalRetenu = $cnss + $montantAvance + $montantIts;
        @endphp
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;text-align:center"
            colspan="4">{{$cnss}}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="10">I.P.T.S</td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;text-align:center"
            colspan="4">{{ $montantIts }}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="10">AVANCE SUR SALAIRE</td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;text-align:center"
            colspan="4">{{ $montantAvance ==0 ? '': $montantAvance }}</td>
    </tr>
    <tr class="">
        <td style="height:50px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;background-color: #3498db;"
            colspan="2"></td>
        <td style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;"
            colspan="8">TOTAL RETENUES OBLIGATOIRES
        </td>
        <td style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;text-align:center"
            colspan="4">{{$totalRetenu}}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="14" class='py-3'></td>
    </tr>
    <tr class="">
        <td style="height:50px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;background-color: #3498db;"
            colspan="2"></td>
        <td style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;"
            colspan="8">SALAIRE NET A PAYER
        </td>
        <td style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;text-align:center;"
            colspan="4">{{ $salaireMensuel }}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;font-weight:bold" colspan="14">MODE DE
            REGLEMENT DE:
        </td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;font-weight:bold"
            colspan="14">{{ucwords($montantLettre)}}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="2">Caisse</td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db"
            colspan="12">{{ $paiement->modePaiement->nom == 'Caisse' ? 'X' : '' }}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="2">Chèque</td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db"
            colspan="12">{{ $paiement->modePaiement->nom == 'Chèque' ? 'X' : '' }}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="2">Virement</td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db"
            colspan="12">{{ $paiement->modePaiement->nom == 'Virement'  ? 'X' : '' }}</td>
    </tr>
    <tr>
        <td style="height:50px"></td>
        <td style="height:50px;vertical-align:middle;border:2px solid #3498db;font-weight:bold;text-align:center;"
            colspan="14">DANS VOTRE INTERET ET POUR VALIDER VOS DROITS, VEILLER CONSERVER CETTE FICHE DE PAIE SANS
            LIMITATION DE DUREE
        </td>
    </tr>
    <tr>
        <td style="height:50x;"></td>
        <td style="height:50px;vertical-align:middle;border:2px solid #3498db" colspan="9"></td>
        <td style="height:50px;vertical-align:middle;border:2px solid #3498db;text-align:center" colspan="5">La
            Directrice Générale
        </td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="14" class='py-3'></td>
    </tr>
    <tr>
        <td style="height:50px;"></td>
        <td style="height:50px;vertical-align:middle;border:2px solid #3498db" colspan="9"></td>
        <td style="height:50px;vertical-align:middle;border:2px solid #3498db;font-weight:bold;text-align:center"
            colspan="5">
            @if($company->signature)
                <img src="storage/{{$company->signature}}" alt="" srcset="">
            @else
                <img src="" alt="" srcset="">
            @endif        </td>
    </tr>
    </tbody>
</table>
