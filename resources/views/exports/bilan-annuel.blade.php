@php
    $totalSalaireAnnuelBrut = 0;
    $totalSalaireAnnuelNet = 0;
    $totalA = 0;
    $totalB = 0;
    $totalC = 0;
    $totalMisAPiedConservatoire = 0;
    $totalMisAPiedDisciplinaire = 0;
    $totalJoursCongesAcquis = 0;
    $totalJoursCongesJouis = 0;
    $totalJoursCongesDus = 0;

@endphp
<table>
    <thead>
    <tr>
        <td colspan="2" style="height:45px"></td>
        <td colspan="3"
            style="background-color: #3498db;color: #ffffff;height:45px;vertical-align:middle;font-weight:bold;text-align:center">
            Nom/Prénoms
        </td>
        <td colspan="3"
            style="background-color: #3498db;color: #ffffff;height:45px;vertical-align:middle;font-weight:bold;text-align:center">
            Salaire annuel brut
        </td>
        <td colspan="3"
            style="background-color: #3498db;color: #ffffff;height:45px;vertical-align:middle;font-weight:bold;text-align:center">
            Salaire annuel net
        </td>
        <td colspan="3"
            style="background-color: #3498db;color: #ffffff;height:45px;vertical-align:middle;font-weight:bold;text-align:center">
            Total A = Total CNSS employé(3,6%)
        </td>
        <td colspan="3"
            style="background-color: #3498db;color: #ffffff;height:45px;vertical-align:middle;font-weight:bold;text-align:center">
            Total B = Total ITS
        </td>
        <td colspan="3"
            style="background-color: #3498db;color: #ffffff;height:45px;vertical-align:middle;font-weight:bold;text-align:center">
            Total des charges A+B
        </td>
        <td colspan="6"
            style="background-color: #3498db;color: #ffffff;height:45px;vertical-align:middle;font-weight:bold;text-align:center">
            Nombre de jours de congés payés
        </td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:45px;vertical-align:middle;font-weight:bold;text-align:center">
            Mises à pied (montant de la pénalité si pénalité)
        </td>
        <td colspan="3"
            style="background-color: #3498db;color: #ffffff;height:45px;vertical-align:middle;font-weight:bold;text-align:center">
            Statut du contrat (en cours ou clôt) Si clôt préciser démission ou licenciement
        </td>
    </tr>
    <tr>
        <td colspan="2" style="height:35px;"></td>
        <td colspan="18"
            style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db;border-top:0px;"></td>
        <td colspan="2" style="height:40px;vertical-align:middle;text-align:center;border:2px solid #3498db">Acquis</td>
        <td colspan="2" style="height:40px;vertical-align:middle;text-align:center;border:2px solid #3498db">Jouis</td>
        <td colspan="2" style="height:40px;vertical-align:middle;text-align:center;border:2px solid #3498db">dûs</td>
        <td colspan="2" style="height:40px;vertical-align:middle;text-align:center;border:2px solid #3498db">
            Conservatoire
        </td>
        <td colspan="2" style="height:40px;vertical-align:middle;text-align:center;border:2px solid #3498db">
            Disciplinaire
        </td>
        <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db"></td>
    </tr>
    </thead>
    <tbody>
    @foreach($employees as $employee)
        @php
            $nbJoursCongesJouis = 0;
            $nbJoursCongesDus = 0;
            $nbJoursCongesAcquis = 0;
            $a = 0;
            $b = 0;
            $c = 0;
            $misAPiedConservatoire = 0;
            $misAPiedDisciplinaire = 0;
            $salaireBrutTotal = 0;
            $salaireNetTotal = 0;

//            $a = $employee->soldeComptes->where('donnees', \App\Models\SoldeCompte::SALAIRE_MENSUEL)->sum('montant') * 0.036;
            foreach ($employee->contrats as $contrat) {
                $a += $contrat->soldeComptes->where('donnees', \App\Models\SoldeCompte::SALAIRE_MENSUEL)->sum('montant') * $contrat->client->tauxCnss;
                $b += $contrat->soldeComptes->where('donnees', \App\Models\SoldeCompte::SALAIRE_MENSUEL)->sum('montant') * $contrat->tauxIts;
                $c += $a + $b;
                $salaireBrutTotal += $contrat->salaire_brut;
                $salaireNetTotal += $contrat->soldeComptes->where('donnees', \App\Models\SoldeCompte::SALAIRE_MENSUEL)->sum('montant');
                $totalSalaireAnnuelNet += $contrat->soldeComptes->where('donnees', \App\Models\SoldeCompte::SALAIRE_MENSUEL)->sum('montant');

                         $misAPiedConservatoire += $contrat->misAPieds->where('type', \App\Models\MisAPied::CONSERVATOIRE)->sum('montant');
            $misAPiedDisciplinaire += $contrat->misAPieds->where('type', \App\Models\MisAPied::DISCIPLINAIRE)->sum('montant');
            $nbJoursCongesAcquis += $contrat->nb_jours_conges_acquis;

             foreach ($contrat->demandeConges as $demandeConge) {
                $start = new DateTime($demandeConge->date_debut);
                $end = new DateTime($demandeConge->date_fin);
                $nbJoursCongesJouis += $start->diff($end)->days;
             }

            }

            $totalSalaireAnnuelBrut += $employee->contrats()->sum('salaire_brut');
//            $totalSalaireAnnuelNet += $employee->soldeComptes->where('donnees', \App\Models\SoldeCompte::SALAIRE_MENSUEL)->sum('montant');

            $totalA += $a;
            $totalB += $b;
            $totalC += $c;


            $totalMisAPiedConservatoire += $misAPiedConservatoire;
            $totalMisAPiedDisciplinaire += $misAPiedDisciplinaire;


            $nbJoursCongesDus += $nbJoursCongesAcquis - $nbJoursCongesJouis;
            $totalJoursCongesAcquis += $nbJoursCongesAcquis;
            $totalJoursCongesJouis += $nbJoursCongesJouis;
            $totalJoursCongesDus += $nbJoursCongesDus;
        @endphp
        <tr>
            <td colspan="2" style="height:35px"></td>
            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
                {{$employee->nom . ' ' . $employee->prenoms}}
            </td>
            <td colspan="3"
                style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$salaireBrutTotal}}
            </td>
            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
                {{$salaireNetTotal}}
            </td>
            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
                {{$a}}
            </td>
            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
                {{$b}}
            </td>
            <td colspan="3"
                style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$c}}</td>
            <td colspan="2"
                style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$nbJoursCongesAcquis}}</td>
            <td colspan="2"
                style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$nbJoursCongesJouis}}</td>
            <td colspan="2"
                style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$nbJoursCongesDus}}</td>
            <td colspan="2"
                style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$misAPiedConservatoire}}</td>
            <td colspan="2"
                style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$misAPiedDisciplinaire}}</td>

            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
                {{$employee->contrats()->latest()->first()->statut }}
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan="2" style="height:35px"></td>
        <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">Total
            (sommes)
        </td>
        <td colspan="3"
            style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$totalSalaireAnnuelBrut}}</td>
        <td colspan="3"
            style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$totalSalaireAnnuelNet}}</td>
        <td colspan="3"
            style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$totalA}}</td>
        <td colspan="3"
            style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$totalB}}</td>
        <td colspan="3"
            style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$totalC}}</td>
        <td colspan="2"
            style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$totalJoursCongesAcquis}}</td>
        <td colspan="2"
            style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$totalJoursCongesJouis}}</td>
        <td colspan="2"
            style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$totalJoursCongesDus}}</td>
        <td colspan="2"
            style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$totalMisAPiedConservatoire}}</td>
        <td colspan="2"
            style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$totalMisAPiedDisciplinaire}}</td>
        <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db"></td>
    </tr>
    </tbody>
</table>
