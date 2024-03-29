<?php

namespace App\Actions;

class GenereCode
{
    public function handle($model, $format = 'MT')
    {
        $annee_actuelle = date('y');
        $indicatif = $format;
        $id_1 = '';
        // récupérer le dernier enregistrement
        $last_numero = $model::orderBy('id', 'desc')->first();

        if ($last_numero == null) {
            $last_id = '';
        } else {
            $last_id = $last_numero->code;
        }

        if (! empty($last_id)) {
            $delete_bu = substr($last_id, -8);
            // delete YEAR
            $correct_code = substr($delete_bu, 0, 6);
            $id_1 = $correct_code;
        } else {
            $id_1 = '000000';
        }

        // récupérer le numéro à incrémenter sur la position 2 du tableau $id_1
        if (! empty($last_id)) {
            //vérifier si nous somme dans une nouvelle année pour réinitialiser le compteur
            $get_date = substr($last_id, -2);
            if ($annee_actuelle > $get_date) {
                // code...
                $numero = '000000';
            } else {
                // code...
                //$str = "BU111111122";
                // delete BU
                $delete_bu = substr($last_id, -8);
                // delete YEAR
                $correct_code = substr($delete_bu, 0, 6);
                $numero = $correct_code;
            }
        } else {
            $numero = '000000';
        }

        $numero_user = $numero + 1;

        $numero_user_formatted = str_pad($numero_user, 6, '0', STR_PAD_LEFT);
        $code = $indicatif.$numero_user_formatted.$annee_actuelle;

        return $code;
    }
}
