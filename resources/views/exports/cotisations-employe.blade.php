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
            <td colspan="2" style="height:35px"></td>
            <td colspan="12" style="background-color:#3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">{{ $mois[$cotisations[0]->mois] }}</td>
        </tr>
        <tr><td colspan="14" style="height:35px"></td></tr>
    </thead>
     <tbody>
        <tr>
            <td colspan="2" style="height:35px"></td>
            <td colspan="3" style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">Agent</td>
            <td colspan="3" style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">CNSS</td>
            <td colspan="3" style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">ITS</td>
            <td colspan="3" style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">Total</td>
        </tr>
     @foreach($cotisations as $cotisation)

         <tr>
             <td colspan="2" style="height:35px"></td>
             <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">
                 {{$cotisation->agent}}</td>
             <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$cotisation->cnss}}</td>
             <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$cotisation->its}}</td>
             <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$cotisation->total}}</td>
         </tr>
     @endforeach

     </tbody>
 </table>
