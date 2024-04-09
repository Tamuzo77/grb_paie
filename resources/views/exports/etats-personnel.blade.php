@php
                                $sommeSalaire = 0;
                                $sommeCnss = 0;
                                $sommeIrpp = 0;
                                $sommeSalaireNet = 0;
                                $sommeVps = 0;
                                $sommeMasseSalariale = 0;
@endphp


                    <table style="border:2px solid  #3498db;">
                        <thead className='text-center bg-primary'>
                        <tr rowspan="3">
                            <th colspan="32" style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;text-align:center">ETAT DES SALAIRES ET ACCESOIRES DU PERSONNEL DU CABINET CMFD</th>
                        </tr>

                        </thead>

                        <tbody >
                            <tr>
                                <td colspan="2" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> N°  </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> Nom et Prénoms </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> Fonction </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> Nombre d'enfant à charge </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> Salaire Brut(Base +primes) </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> CNSS(3,6%) </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> IRPP-TS </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> Salaire net </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> Versement patronale (VPS) </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> Masse salariale </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> Signature et PI </td>
                            </tr>
                        @forelse($employees as $employee)
                            @php
                            $cnss = $employee->tauxCnss ? $employee->salaire * $employee->tauxCnss : $employee->salaire * 0.036;
                            $irpp = $employee->salaire * $employee->tauxIts;
 @endphp
                            <tr>
                                <td colspan="2" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{ $loop->iteration }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;font-weight:500;text-align:center;border:2px solid #3498db">{{ $employee->nom . ' '. $employee->prenoms }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;font-weight:500;text-align:center;border:2px solid #3498db">{{ $employee->fonctions()->first()?->nom }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{ $employee->nb_enfants }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{ $employee->salaire }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{ $cnss }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{ $irpp }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{ (new \App\Actions\CalculerSalaireMensuel)->handle($employee)}}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{ $employee->salaire * 0.23 }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{ $employee->payroll_mass?? 0 }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{ $employee->signature }}</td>
                            </tr>
                            @php

                                $sommeSalaire = $sommeSalaire + $employee->salaire;
                                $sommeCnss = $sommeCnss + $cnss;
                                $sommeIrpp = $sommeIrpp + $irpp;
                                $sommeSalaireNet = $sommeSalaireNet + (new \App\Actions\CalculerSalaireMensuel)->handle($employee);
                                $sommeVps = $sommeVps + ($employee->salaire * 0.23);
                                $sommeMasseSalariale = $sommeMasseSalariale + $employee->payroll_mass??0;
                            @endphp
                        @empty
                            <tr>
                                <td colSpan="3" className="text-center">Aucun enregistrement trouvé</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colSpan="11" style="height:35px;vertical-align:middle;font-weight:500;text-align:center;border:2px solid #3498db">Total</td>
                            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$sommeSalaire}}</td>
                            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$sommeCnss}}</td>
                            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$sommeIrpp}}</td>
                            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$sommeSalaireNet}}</td>
                            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$sommeVps}}</td>
                            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$sommeMasseSalariale}}</td>
                            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{' '}}</td>
                        </tr>
                        <tr >
                            <td colspan="16" style="border:2px solid #3498db;font-weight:500;height:50px;vertical-align:middle;font-size:15px;text-align:center">xxxxxxxx</td>

                            <td style="border:2px solid #3498db;font-weight:500;height:50px;font-size:15px;text-align:center;vertical-align:middle" colspan="16">La Directrice</td>
                        </tr>
                        <tr>
                            <td colspan="16" style="height:50px;vertical-align:middle;font-size:15px;border:2px solid #3498db;font-weight:500;text-align:center">xxxxxxxx</td>
                            <td style="height:50px;vertical-align:middle;border:2px solid #3498db;font-weight:500;font-size:15px;text-align:center" colspan="16">xxxxxxxxx</td>
                        </tr>
                        </tbody>
                    </table>
