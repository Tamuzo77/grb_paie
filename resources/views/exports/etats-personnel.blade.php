@php
                                $sommeSalaire = 0;
                                $sommeCnss = 0;
                                $sommeIrpp = 0;
                                $sommeSalaireNet = 0;
                                $sommeVps = 0;
                                $sommeChargePatronale = 0;
                                $sommeMasseSalariale = 0;
@endphp


                    <table style="border:2px solid  #3498db;">
                        <thead className='text-center bg-primary'>
                        <tr rowspan="3">
                            <th colspan="38" style="background-color: #3498db;color: #ffffff;height:50px;vertical-align:middle;font-weight:bold;text-align:center">ETAT DES SALAIRES ET ACCESSOIRES DU PERSONNEL DE {{$client->nom}}</th>
                        </tr>

                        </thead>

                        <tbody >
                            <tr>
                                <td colspan="2" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> N°  </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> Nom et Prénoms </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> Fonction </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> Nombre d'enfant à charge </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> Salaire Brut(Base +primes) </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> CNSS </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> IRPP-TS </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> Salaire net </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> Versement patronale (VPS) </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center">Charge patronale(19,4 %) </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> Masse salariale </td>
                                <td colspan="3" style=" text-align: center; border:2px solid #3498db;font-weight:500;height:35px;vertical-align:middle;text-align:center"> Signature </td>
                            </tr>
                        @forelse($employees as $employee)
                            @php
                            $salaireBrut = $employee->salaire_brut + $employee->primes()->sum('montant');
                            $cnss = $client->tauxCnss ? $employee->salaire_brut * $client->tauxCnss : $employee->salaire_brut * 0.036;
                            $irpp = $employee->salaire_brut * $employee->tauxIts;

                            $salaireMen = (new \App\Actions\CalculerSalaireMensuel)->handle($employee);
                            $vps = $employee->salaire_brut * 0.23;
                            $chargePatronale = $employee->salaire_brut * 0.194;
                            $masseSalariale = $salaireMen + $vps + $chargePatronale;

 @endphp
                            <tr>
                                <td colspan="2" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{ $loop->iteration }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;font-weight:500;text-align:center;border:2px solid #3498db">{{ $employee->employee->nom . ' '. $employee->employee->prenoms }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;font-weight:500;text-align:center;border:2px solid #3498db">{{ $employee->fonction->nom }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{ $employee->employee->nb_enfants }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{ $employee->salaire_brut }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{ $cnss }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{ $irpp }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{ (new \App\Actions\CalculerSalaireMensuel)->handle($employee)}}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{ $employee->salaire_brut * 0.23 }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{$employee->salaire_brut * 0.194}}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{ $masseSalariale }}</td>
                                <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;text-align:center;border:2px solid #3498db">{{ $employee->signature }}</td>
                            </tr>
                            @php

                                $sommeSalaire = $sommeSalaire + $employee->salaire_brut;
                                $sommeCnss = $sommeCnss + $cnss;
                                $sommeIrpp = $sommeIrpp + $irpp;
                                $sommeSalaireNet = $sommeSalaireNet + (new \App\Actions\CalculerSalaireMensuel)->handle($employee);
                                $sommeVps = $sommeVps + ($employee->salaire_brut * 0.23);
                                $sommeChargePatronale = $sommeChargePatronale + ($employee->salaire_brut * 0.194);
                                $sommeMasseSalariale = $sommeMasseSalariale + $masseSalariale;
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
                            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$sommeChargePatronale}}</td>
                            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{$sommeMasseSalariale}}</td>
                            <td colspan="3" style="height:35px;vertical-align:middle;text-align:center;border:2px solid #3498db">{{' '}}</td>
                        </tr>
                        <tr >
                            <td colspan="16" style="border:2px solid #3498db;font-weight:500;height:50px;vertical-align:middle;font-size:15px;text-align:center">xxxxxxxx</td>

                            <td style="border:2px solid #3498db;font-weight:500;height:50px;font-size:15px;text-align:center;vertical-align:middle" colspan="19">La Directrice</td>
                        </tr>
                        <tr>
                            <td colspan="19" style="height:100px;vertical-align:middle;font-size:15px;border-top:2px solid #3498db ;font-weight:500;text-align:center">xxxxxxxx</td>
                            <td colspan="8" style="border-top:2px solid #3498db;height:100px;"></td>
                            <td style="height:100px;vertical-align:middle;border-top:2px solid #3498db ;border-right:2px solid white;border-left:2px solid white ;font-weight:500;font-size:15px;text-align:center" colspan="2">
                                @if($company->signature)
                                <img src="storage/{{$company->signature}}" width="80px" height="80px" alt="" srcset="">
                                @else
                                <img src="image/image-null.png" alt="" srcset="">
                                @endif
                            </td>
                            <td colspan="6" style="border-top:2px solid #3498db;height:100px;"></td>
                        </tr>
                        </tbody>
                    </table>
