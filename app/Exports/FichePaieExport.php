<?php

namespace App\Exports;

use AllowDynamicProperties;
use App\Actions\CalculerSalaireMensuel;
use App\Models\Company;
use App\Models\Paiement;
use App\Models\SoldeCompte;
use DateTime;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Rmunate\Utilities\SpellNumber;

#[AllowDynamicProperties] class FichePaieExport implements FromView
{
    public function __construct(Paiement $paiement)
    {
        $this->paiement = $paiement;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $donnes = [SoldeCompte::SALAIRE_MENSUEL, SoldeCompte::TREIZIEME_MOIS, SoldeCompte::NOMBRE_DE_JOURS_DE_CONGES_PAYES_DU, SoldeCompte::PREAVIS, SoldeCompte::AVANCE_SUR_SALAIRE, SoldeCompte::PRET_ENTREPRISE, SoldeCompte::TOTAL];
        $solde = SoldeCompte::where('employee_id', $this->paiement->employee_id)->where('mois', now()->format('F'));
        $salaireMensuel = SoldeCompte::where('employee_id', $this->paiement->employee_id)->where('mois', now()->format('F'))->where('donnees', \App\Models\SoldeCompte::SALAIRE_MENSUEL)->get('montant');
        $montantAvance = SoldeCompte::where('employee_id', $this->paiement->employee_id)->where('mois', now()->format('F'))->where('donnees', \App\Models\SoldeCompte::AVANCE_SUR_SALAIRE)->get('montant');
        $montantPrete = SoldeCompte::where('employee_id', $this->paiement->employee_id)->where('mois', now()->format('F'))->where('donnees', \App\Models\SoldeCompte::PRET_ENTREPRISE)->get('montant');
        $montantConges = SoldeCompte::where('employee_id', $this->paiement->employee_id)->where('mois', now()->format('F'))->where('donnees', \App\Models\SoldeCompte::NOMBRE_DE_JOURS_DE_CONGES_PAYES_DU)->get('montant');
        $totalNet = $solde->where('donnees', \App\Models\SoldeCompte::TOTAL)->get('montant');
        $montantLettre = SpellNumber::value($totalNet[0]['montant'])->locale('fr')->toLetters();
        $retenueObligatoire = 0;
        $nb_jours_absences = 0;
        foreach ($this->paiement->employee->absences()->where('date_debut', '>=', now()->startOfMonth())->whereDeductible(true)->get() as $absence) {
            $startDate = new DateTime($absence->date_debut);
            $endDate = new DateTime($absence->date_fin);
            $nb_jours_absences += date_diff($startDate, $endDate)->days;
        }
        $nb_jours_travaille = 20 - $nb_jours_absences;

        $nb_jours_conges_paye = 0;
        foreach ($this->paiement->employee->demandeConges()->where('date_debut', '>=', now()->startOfMonth())->where('statut', 'paye')->get() as $conge) {
            $startDate = new DateTime($conge->date_debut);
            $endDate = new DateTime($conge->date_fin);
            $nb_jours_conges_paye += date_diff($startDate, $endDate)->days;
        }

        $misApieds = 0;
        $misApiedsJours = 0;
        foreach ($this->paiement->employee->misAPieds as $misAPied) {
            $misApiedsJours += $misAPied->nbre_jours;
            $misApieds += $misAPied->montant * $misAPied->nbre_jours;
        }
        $salaire = $this->paiement->employee->salaire * (1 - $this->paiement->employee->tauxIts - $this->paiement->employee->tauxCnss);

        $retenueObligatoire += $nb_jours_absences * $salaire / 20;
        $retenueObligatoire += $montantPrete[0]['montant'];

        $company = Company::first();

        return view('exports.fiche-paie', [
            'paiement' => $this->paiement,
            'employee' => $this->paiement->employee,
            'solde' => $solde,
            'montantAvance' => $montantAvance[0]['montant'],
            'salaireMensuel' => $salaireMensuel[0]['montant'],
            'montantLettre' => $montantLettre,
            'company' => $company,
            'totalNet' => $totalNet[0]['montant'],
            'retenueObligatoire' => $retenueObligatoire,
            'salaireForTwentyDays' => $salaire,
            'nb_jours_absences' => $nb_jours_absences,
            'misApieds' => $misApieds,
            'nb_jours_travaille' => $nb_jours_travaille,
            'nb_jours_conges_paye' => $nb_jours_conges_paye,
            'misApiedsJours' => $misApiedsJours,
        ]);
    }
}
