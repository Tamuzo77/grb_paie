<table className='w-full table-auto border-collapse border border-slate-600 '>
    <thead className='text-center bg-primary'>
    <tr>
        <th className="border border-slate-400 p-1"> N°</th>
        <th className="border border-slate-400 p-1"> Nom et Prénoms</th>
        <th className="border border-slate-400 p-1"> Fonction</th>
        <th className="border border-slate-400 p-1"> Nombre d'enfant à charge</th>
        <th className="border border-slate-400 p-1"> Salaire Brut(Base +primes)</th>
        <th className="border border-slate-400 p-1"> CNSS(3,6%)</th>
        <th className="border border-slate-400 p-1"> IRPP-TS</th>
        <th className="border border-slate-400 p-1"> Salaire net</th>
        <th className="border border-slate-400 p-1"> Veserment patronale (VPS)</th>
        <th className="border border-slate-400 p-1"> Masse salariale</th>
        <th className="border border-slate-400 p-1"> Signature et PI</th>
    </tr>

    </thead>

    <tbody className="text-end">
    @forelse($this->record->employees as $employee)
        <tr>
            <td className="border-2 border-slate-400 p-2">{{ $loop->iteration }}</td>
            <td className="border-2 border-slate-400 p-2">{{ $employee->nom }}</td>
            <td className="border-2 border-slate-400 p-2">{{ $employee->fonctions()->first()?->nom }}</td>
            <td className="border-2 border-slate-400 p-2">{{ $employee->nb_enfants }}</td>
            <td className="border-2 border-slate-400 p-2">{{ $employee->salaire }}</td>
            <td className="border-2 border-slate-400 p-2">{{ $employee->cnss }}</td>
            <td className="border-2 border-slate-400 p-2">{{ $employee->salaire * (1-$employee->its) }}</td>
            <td className="border-2 border-slate-400 p-2">{{ (new \App\Actions\CalculerSalaireMensuel)->handle($employee)}}</td>
            <td className="border-2 border-slate-400 p-2">{{ $employee->salaire * 0.23 }}</td>
            <td className="border-2 border-slate-400 p-2">{{ $employee->payroll_mass?? 0 }}</td>
            <td className="border-2 border-slate-400 p-2">{{ $employee->signature }}</td>
        </tr>
    @empty
        <tr>
            <td colSpan={11} className="text-center">No records found</td>
        </tr>
    @endforelse
    <tr>
        <td className="border-2 border-slate-400 p-2">01</td>
        <td className="border-2 border-slate-400 p-2">xxxxx</td>
        <td className="border-2 border-slate-400 p-2">xxxxx</td>
        <td className="border-2 border-slate-400 p-2">xxxxx</td>
        <td className="border-2 border-slate-400 p-2">xxxxx</td>
        <td className="border-2 border-slate-400 p-2">xxxxx</td>
        <td className="border-2 border-slate-400 p-2">xxxxx</td>
        <td className="border-2 border-slate-400 p-2">xxxxx</td>
        <td className="border-2 border-slate-400 p-2">xxxxx</td>
        <td className="border-2 border-slate-400 p-2">xxxxx</td>
        <td className="border-2 border-slate-400 p-2">xxxxx</td>
    </tr>
    <tr>
        <td colSpan={4} className="p-2 text-center border border-slate-400">Total</td>
        <td className="p-2 border-2 border-slate-400">xxxxx</td>
        <td className="p-2 border-2 border-slate-400">xxxxx</td>
        <td className="p-2 border-2 border-slate-400">xxxxx</td>
        <td className="p-2 border-2 border-slate-400">xxxxx</td>
        <td className="p-2 border-2 border-slate-400">xxxxx</td>
        <td className="p-2 border-2 border-slate-400">xxxxx</td>
        <td className="p-2 border-2 border-slate-400">xxxxx</td>
    </tr>
    <tr>
        <td colSpan={5}>xxxxxxxx</td>

        <td colSpan={5}>La Directrice</td>
    </tr>
    <tr>
        <td colSpan={5}>xxxxxxxx</td>
        <td colSpan={5}>xxxxxxxxx</td>
    </tr>
    </tbody>
</table>


<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoices as $invoice)
        <tr>
            <td>{{ $invoice->name }}</td>
            <td>{{ $invoice->email }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
