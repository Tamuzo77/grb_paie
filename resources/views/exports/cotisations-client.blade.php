<table>
    <thead>
    <tr>
        <td colspan="2" style="height:35px"></td>
        <td colspan="9"
            style="background-color:#3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">
            {{$cotisations[0]->client->nom}}
        </td>
    </tr>
    <tr>
        <td colspan="11" style="height:35px"></td>
    </tr>

    </thead>
    <tbody>
    <tr>
        <td colspan="2" style="height:35px"></td>
        <td colspan="3"
            style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">
            AGENT
        </td>
        <td colspan="3"
            style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">
            Total des salaires brutes
        </td>
        <td colspan="3"
            style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">
            23%
        </td>
    </tr>
    <tbody>
    @foreach($cotisations as $cotisation)
        <tr>
            <td colspan="2" style="height:35px "></td>
            <td colspan="3"
            style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db;">{{$cotisation->agent == 'Total' ? 'TOTAL ANNUEL' : $cotisation->agent}}</td>
            <td colspan="3"
                style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db;">{{$cotisation->somme_salaires_bruts}}</td>
            <td colspan="3"
                style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db;">{{$cotisation->somme_cotisations}}</td>
        </tr>
    @endforeach

    {{--         <tr>--}}
    {{--            <td colspan="2" style="height:35px"></td>--}}
    {{--             <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">May</td>--}}
    {{--             <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">35555</td>--}}
    {{--             <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">855220</td>--}}
    {{--         </tr>--}}
    {{--         <tr>--}}
    {{--            <td colspan="2" style="height:35px"></td>--}}
    {{--             <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">Juin</td>--}}
    {{--             <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">35555</td>--}}
    {{--             <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">855220</td>--}}
    {{--         </tr>--}}
    {{--         <tr>--}}
    {{--            <td colspan="2" style="height:35px"></td>--}}
    {{--             <td colspan="3" style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">TRIMESTRE 1</td>--}}
    {{--             <td colspan="3" style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">35555</td>--}}
    {{--             <td colspan="3" style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">855220</td>--}}
    {{--         </tr>--}}
    {{--         <tr>--}}
    {{--            <td colspan="2" style="height:35px"></td>--}}
    {{--             <td colspan="3" style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">TOTAL ANNUEL</td>--}}
    {{--             <td colspan="3" style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">SOMME</td>--}}
    {{--             <td colspan="3" style="background-color: #3498db;color: #ffffff;height:35px;vertical-align:middle;font-weight:bold;text-align:center">SOMME</td>--}}
    {{--         </tr>--}}
    </tbody>
</table>
