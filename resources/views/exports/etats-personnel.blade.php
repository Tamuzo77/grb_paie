@php
                                $sommeSalaire = 0;
                                $sommeCnss = 0;
                                $sommeIrpp = 0;
                                $sommeSalaireNet = 0;
                                $sommeVps = 0;
                                $sommeMasseSalariale = 0;
@endphp


                    <table style="border: 1px solid  #ccc;">
                        <thead className='text-center bg-primary'>
                        <tr style="height:50px" rowspan="3">
                            <th colspan="3" style="background-color: #3498db; color: #ffffff; text-align: center; border: 1px solid #ccc; padding: 10px;font-weight: bold"> N°  </th>
                            <th colspan="3" style="background-color: #3498db; color: #ffffff; text-align: center; border: 1px solid #ccc; padding: 10px;font-weight: bold"> Nom et Prénoms </th>
                            <th colspan="3" style="background-color: #3498db; color: #ffffff; text-align: center; border: 1px solid #ccc; padding: 10px;font-weight: bold"> Fonction </th>
                            <th colspan="3" style="background-color: #3498db; color: #ffffff; text-align: center; border: 1px solid #ccc; padding: 10px;font-weight: bold"> Nombre d'enfant à charge </th>
                            <th colspan="3" style="background-color: #3498db; color: #ffffff; text-align: center; border: 1px solid #ccc; padding: 10px;font-weight: bold"> Salaire Brut(Base +primes) </th>
                            <th colspan="3" style="background-color: #3498db; color: #ffffff; text-align: center; border: 1px solid #ccc; padding: 10px;font-weight: bold"> CNSS(3,6%) </th>
                            <th colspan="3" style="background-color: #3498db; color: #ffffff; text-align: center; border: 1px solid #ccc; padding: 10px;font-weight: bold"> IRPP-TS </th>
                            <th colspan="3" style="background-color: #3498db; color: #ffffff; text-align: center; border: 1px solid #ccc; padding: 10px;font-weight: bold"> Salaire net </th>
                            <th colspan="3" style="background-color: #3498db; color: #ffffff; text-align: center; border: 1px solid #ccc; padding: 10px;font-weight: bold"> Veserment patronale (VPS) </th>
                            <th colspan="3" style="background-color: #3498db; color: #ffffff; text-align: center; border: 1px solid #ccc; padding: 10px;font-weight: bold"> Masse salariale </th>
                            <th colspan="3" style="background-color: #3498db; color: #ffffff; text-align: center; border: 1px solid #ccc; padding: 10px;font-weight: bold"> Signature et PI </th>
                        </tr>

                        </thead>

                        <tbody >
                        @forelse($employees as $employee)
                            <tr>
                                <td colspan="3" style="border:2px solid  #000000;">{{ $loop->iteration }}</td>
                                <td colspan="3">{{ $employee->nom }}</td>
                                <td colspan="3">{{ $employee->fonctions()->first()?->nom }}</td>
                                <td colspan="3">{{ $employee->nb_enfants }}</td>
                                <td colspan="3">{{ $employee->salaire }}</td>
                                <td colspan="3">{{ $employee->cnss }}</td>
                                <td colspan="3">{{ $employee->salaire * (1-$employee->its) }}</td>
                                <td colspan="3">{{ (new \App\Actions\CalculerSalaireMensuel)->handle($employee)}}</td>
                                <td colspan="3">{{ $employee->salaire * 0.23 }}</td>
                                <td colspan="3">{{ $employee->payroll_mass?? 0 }}</td>
                                <td colspan="3">{{ $employee->signature }}</td>
                            </tr>
                            @php
                                
                                $sommeSalaire = $sommeSalaire + $employee->salaire;
                                $sommeCnss = $sommeCnss + $employee->cnss;
                                $sommeIrpp = $sommeIrpp + $employee->salaire * (1-$employee->its);
                                $sommeSalaireNet = $sommeSalaireNet + (new \App\Actions\CalculerSalaireMensuel)->handle($employee);
                                $sommeVps = $sommeVps + $employee->salaire * 0.23;
                                $sommeMasseSalariale = $sommeMasseSalariale + $employee->payroll_mass??0;
                            @endphp
                        @empty
                            <tr>
                                <td colSpan="3" className="text-center">No records found</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colSpan="6">Total</td>
                            <td colspan="3">xxxxx</td>
                            <td colspan="3">xxxxx</td>
                            <td colspan="3">xxxxx</td>
                            <td colspan="3">{{$sommeSalaire}}</td>
                            <td colspan="3">{{$sommeCnss}}</td>
                            <td colspan="3">{{$sommeIrpp}}</td>
                            <td colspan="3">{{$sommeSalaireNet}}</td>
                            <td colspan="3">{{$sommeVps}}</td>
                            <td colspan="3">{{$sommeMasseSalariale}}</td>
                        </tr>
                        <tr >
                            <td colspan="16 
                            ">xxxxxxxx</td>

                            <td style="text-align: end;" colspan="17">La Directrice</td>
                        </tr>
                        <tr>
                            <td colspan="16">xxxxxxxx</td>
                            <td style="text-align:end;" colspan="17">xxxxxxxxx</td>
                        </tr>
                        </tbody>
                    </table>
