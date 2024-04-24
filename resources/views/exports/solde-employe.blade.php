<table>
    <thead>
        <tr>
            <td colspan="10"style="height:35px"></td>
        </tr>
        <tr>
            <td colspan="2" style="height:35px"></td>
            <td colspan="3" style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">Client : {{$employe->client->nom}}</td>
            <td colspan="2" style="height:35px"></td>
            <td colspan="3" style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">Employé : {{$employe->nom. ' '. $employe->prenoms}}</td>
        </tr>
        <tr>
            <td colspan="10"style="height:35px"></td>
        </tr>
    </thead>
     <tbody>
        <tr>
            <td colspan="2" style="height:35px"></td>
            <td colspan="4" style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">Données</td>
            <td colspan="4" style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">Montant</td>
        </tr>
         <tr>
            <td colspan="2" style="height:35px"></td>
             <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">Salaire mensuel</td>
             <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$salaireMensuel}}</td>
         </tr>
         <tr>
            <td colspan="2" style="height:35px"></td>
             <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">Treizième mois</td>
             <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$treiziemeMois}}</td>
         </tr>
         <tr>
            <td colspan="2" style="height:35px"></td>
             <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">Nombre de jours de congés payés dû</td>
             <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$nbJoursCongesPayes}}</td>
         </tr>
         <tr>
            <td colspan="2" style="height:35px"></td>
             <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">Préavis</td>
             <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$preavis}}</td>
         </tr>
         <tr>
            <td colspan="2" style="height:35px"></td>
             <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">Avance sur salaire</td>
             <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$avances}}</td>
         </tr>
         <tr>
            <td colspan="2" style="height:35px"></td>
             <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">Prêt entreprise</td>
             <td colspan="4" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$prets}}</td>
         </tr>
         <tr>
            <td colspan="2" style="height:35px"></td>
             <td colspan="4" style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">Total</td>
             <td colspan="4" style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">{{$total}}</td>
         </tr>
     </tbody>
 </table>
