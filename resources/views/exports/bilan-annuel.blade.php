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
        <td colspan="2" style="height:40px;vertical-align:middle;text-align:center;border:2px solid #3498db">Conservatoire</td>
        <td colspan="2" style="height:40px;vertical-align:middle;text-align:center;border:2px solid #3498db">Disciplinaire</td>
        <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db"></td>
    </tr>
    </thead>
    <tbody>
    @foreach($employees as $employee)
        @php
        $a = $employee->soldeComptes->where('donnees', \App\Models\SoldeCompte::SALAIRE_MENSUEL)->sum('montant') * 0.036;
        $b = $employee->soldeComptes->where('donnees', \App\Models\SoldeCompte::SALAIRE_MENSUEL)->sum('montant') * $employee->tauxIts;
        $c = $a + $b;
 @endphp
        <tr>
            <td colspan="2" style="height:35px"></td>
            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
                {{$employee->nom . ' ' . $employee->prenoms}}
            </td>
            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$employee->salaire * 12}}
            </td>
            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
                {{$employee->soldeComptes->where('donnees', \App\Models\SoldeCompte::SALAIRE_MENSUEL)->sum('montant')}}
            </td>
            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
                {{$a}}
            </td>
            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
                {{$b}}
            </td>
            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$c}}</td>
            <td colspan="2" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">0</td>
            <td colspan="2" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">0</td>
            <td colspan="2" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">0</td>
            <td colspan="2" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">0</td>
            <td colspan="2" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">0</td>

            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">35555
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan="2" style="height:35px"></td>
        <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">Total
            (sommes)
        </td>
        <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db"></td>
        <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db"></td>
        <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db"></td>
        <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db"></td>
        <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db"></td>
        <td colspan="2" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">0</td>
        <td colspan="2" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">0</td>
        <td colspan="2" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">0</td>
        <td colspan="2" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">0</td>
        <td colspan="2" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">0</td>
        <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db"></td>
    </tr>
    </tbody>
</table>
