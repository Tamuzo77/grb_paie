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
        'December' => 'Décembre',
    ];
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
            colspan="4">{{ $employee->client->nom }}</td>
        <td style="height:50px;border:2px solid #3498db;vertical-align:middle;font-weight:bold;text-align:center;"
            colspan="10"></td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:50px;border:2px solid #3498db;text-align:center;vertical-align:middle;font-weight:bold;text-align:center;"
            colspan="4">Numéro IFU :{{$employee->client->ifu}}</td>
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
            <h3>Fait le {{ now()->locale('fr')->format('d ') . $mois[now()->format('F')] . ' ' . now()->year }}
            </h3>
    </tr>
    <tr>
        <td style="height:30px"></td>
        <td style="height:30px" colspan="9"></td>
        <td style="height:30px;vertical-align:middle;border:2px solid #3498db" colspan="5" class='py-3'>
            Periode: {{ $mois[now()->format('F')] . ' ' . now()->year }}</td>
    </tr>
    {{--        <tr class=""> --}}
    {{--            <td style="height:30px;"></td> --}}
    {{--            <td style="height:30px;vertical-align:middle;border:2px solid #3498db" colspan="9"></td> --}}
    {{--            <td style="height:30px;vertical-align:middle;border:2px solid #3498db" colspan="5">xxxxx</td> --}}
    {{--        </tr> --}}
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
            : {{ $employee->employee->nom }}</td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;">
            Prénoms:
        </td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;">
            {{ $employee->employee->prenoms }}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td colspan="6"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">
            Fonction : {{ $employee->fonction?->nom ?? ' ' }}</td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">
            Catégorie:
        </td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">
            {{ $employee->category?->nom }}</td>
    </tr>

    <tr>
        <td style="height:35px"></td>
        <td colspan="6"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">
            Situation matrimoniale : {{ $employee->employee->situation_matrimoniale }}</td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">
            Nombre
            d'enfants: {{ $employee->employee->nb_enfants }}</td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">
        </td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td colspan="6"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">
            Position hiérachique: xxxxx</td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">
            Date d'ancienneté: {{ DateTime::createFromFormat('l d F Y', $employee->date_debut)  }}</td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">
        </td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td colspan="6"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">
            Numéro IFU: {{$employee->employee->ifu}}</td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">
        </td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:>35px;vertical-align:middle;font-weight:bold;">
        </td>
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
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;text-align:center" colspan="4">
            {{ $employee->salaire_brut }}</td>

    </tr>
    <tr class="">
        <td style="height:50px"></td>
        <td style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;"
            colspan="2"></td>
        <td style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;"
            colspan="8">SALAIRE BRUT MENSUEL
        </td>
        <td style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;text-align:center"
            colspan="4">{{ $employee->salaire_brut }}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="10">RETENUES OBLIGATOIRES
        </td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;text-align:center" colspan="4">
            {{ $retenueObligatoire == 0 ? ' ' : $retenueObligatoire }}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="10">C.N.S.S</td>
        @php
            $cnss = $employee->client->tauxCnss ? $employee->salaire_brut * $employee->client->tauxCnss : $employee->salaire_brut * 0.036;
            $montantIts = $employee->salaire_brut * $employee->tauxIts;
            $totalRetenu = $cnss + $montantAvance + $montantIts + $retenueObligatoire;
        @endphp
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;text-align:center" colspan="4">
            {{ $cnss }}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="10">I.P.T.S</td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;text-align:center" colspan="4">
            {{ $montantIts }}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="10">Convention
            collective
        </td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;text-align:center" colspan="4">
        </td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="10">AVANCE SUR SALAIRE
        </td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;text-align:center" colspan="4">
            {{ $montantAvance == 0 ? '' : $montantAvance }}</td>
    </tr>
    <tr class="">
        <td style="height:50px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;background-color: #3498db;"
            colspan="2"></td>
        <td style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;"
            colspan="8">TOTAL RETENUES OBLIGATOIRES
        </td>
        <td style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;text-align:center"
            colspan="4">{{ $totalRetenu }}</td>
    </tr>
    {{-- <tr>
    <td style="height:35px"></td>
    <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="14" class='py-3'></td>
</tr> --}}
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="10">Salaire net 20 jours
        </td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;text-align:center" colspan="4">
            {{ $salaireForTwentyDays }}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="10">Mise à
            pied: {{ $misApiedsJours }} jour(s)
        </td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;text-align:center" colspan="4">
            {{ $misApieds }}</td>
    </tr>

    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="10">
            Congés restants
        </td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;text-align:center" colspan="4">
        </td>
    </tr>

    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="10">
            Absences
        </td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;text-align:center" colspan="4">
        </td>
    </tr>
    @if (isset($primes) && !empty($primes))
        <tr>
            <td style="height:35px"></td>
            <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="10">Primes
            </td>
            <td style="height:35px;vertical-align:middle;border:2px solid #3498db;text-align:center"
                colspan="4">{{ $primes }}</td>
        </tr>
    @endif
    <tr class="">
        <td style="height:50px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;background-color: #3498db;"
            colspan="2"></td>
        <td style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;"
            colspan="8">SALAIRE NET A PAYER
        </td>
        <td style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;text-align:center;"
            colspan="4">{{ $totalNet }}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;font-weight:bold" colspan="14">
            MODE DE
            REGLEMENT DE:
        </td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db;font-weight:bold" colspan="14">
            {{ ucwords($montantLettre) }}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="2">Caisse</td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="12">
            {{ $paiement->modePaiement->nom == 'Caisse' ? 'X' : '' }}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="2">Chèque</td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="12">
            {{ $paiement->modePaiement->nom == 'Chèque' ? 'X' : '' }}</td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="2">Virement</td>
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="12">
            {{ $paiement->modePaiement->nom == 'Virement' ? 'X' : '' }}</td>
    </tr>
    <tr>
        <td style="height:50px"></td>
        <td style="height:50px;vertical-align:middle;border:2px solid #3498db;font-weight:bold;text-align:center;"
            colspan="14">DANS VOTRE INTERET ET POUR VALIDER VOS DROITS, VEILLER CONSERVER CETTE FICHE DE PAIE
            SANS
            LIMITATION DE DUREE. AUCUN DUPLICATA NE SERA DÉLIVRÉ.
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
        <td style="height:35px;vertical-align:middle;border:2px solid #3498db" colspan="14" class='py-3'>
        </td>
    </tr>
    <tr>
        <td style="height:50px;"></td>
        <td style="height:50px;vertical-align:middle;border-top:1px solid white;border-bottom:1px solid white"
            colspan="11"></td>
        <td style="height:100px;vertical-align:middle;border-bottom:1px solid white;border-left:1px solid white;border-top:1px solid white;font-weight:bold;text-align:center"
            colspan="3">
            @if ($company->signature)
                <img src="storage/{{ $company->signature }}" alt="" srcset="" width="80px"
                     height="80px">
            @else
                <img src="image/image-null.png" alt="" srcset="">
            @endif
        </td>
    </tr>

    </tbody>
</table>
