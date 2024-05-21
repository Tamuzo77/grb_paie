<table>
    <thead>
    <tr>
        <td style="height:35px"></td>
        <td style="height:50px;border:2px solid #3498db;vertical-align:middle;font-weight:bold;" colspan="10">Nom du
            Client : {{ $facturation->client->nom }}</td>
        <td style="height:50px;"></td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:50px;border:2px solid #3498db;vertical-align:middle;font-weight:bold;" colspan="10">
            Contact : {{ $facturation->client->email . ' | ' . $facturation->client->telephone }}
        </td>
        <td style="height:50px;"></td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td style="height:50px;border:2px solid #3498db;vertical-align:middle;font-weight:bold;" colspan="10">
            Numéro IFU : {{ $facturation->client->ifu }}
        </td>
    </tr>
    <tr style="height:35px">
        <td style="height:35px"></td>
        <td colspan="10"></td>
    </tr>
    <tr>
        <td colspan=""
            style="height:50px;border:2px solid #3498db;text-align:center;vertical-align:middle;font-weight:bold;text-align:center;">
        </td>
        <td style="height:50px;border:2px solid #3498db;text-align:center;vertical-align:middle;font-weight:bold;text-align:center;"
            colspan="10">Facture
        </td>
    </tr>
    <tr>
        <td colspan="" style="height:35px"></td>
        <td style="height:50px;border:2px solid #3498db;text-align:center;vertical-align:middle;font-weight:bold;text-align:center;"
            colspan="10">Période : {{ $facturation->getPeriode() }}
        </td>
    </tr>
    <tr>
        <td colspan="" style="height:35px"></td>
        <td style="height:50px;border:2px solid #3498db;text-align:center;vertical-align:middle;font-weight:bold;text-align:center;"
            colspan="10">Liste des employés
        </td>
    </tr>
    <tr style="height:35px">
        <td style="height:35px"></td>
        <td colspan="10"></td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="height:35px"></td>
        <td colspan="3"
            style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">
            Nom et Prénoms
        </td>
        <td colspan="3"
            style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">
            Fonctions
        </td>
        <td colspan="4"
            style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">
            Salaire Brut
        </td>
    </tr>

    @foreach ($employees as $employee)
        <tr>
            <td style="height:35px"></td>
            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
                {{ $employee->employee->nom . ' ' . $employee->employee->prenoms }}
            </td>
            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
                {{ $employee->fonction->nom }}
            </td>
            <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
                {{ $employee->salaire_brut }}
            </td>
        </tr>
    @endforeach
    <tr>
        <td style="height:35px">
        </td>
        <td colspan="6" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
            Total
        </td>
        <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
            {{ $facturation->total_salaire_brut }}
        </td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td colspan="6" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
            Taux appliqués
        </td>
        <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
            {{ $facturation->taux . ' %' }}
        </td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td colspan="6" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
            Montant facturé
        </td>
        <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
            {{ $facturation->montant_facture }} FCFA
        </td>
    </tr>
    <tr>
        <td style="height:35px"></td>
        <td colspan="6" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
            Montant en lettre
        </td>
        <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
            {{ $montantLettre }} Francs CFA
        </td>
    </tr>
    </tbody>
</table>
