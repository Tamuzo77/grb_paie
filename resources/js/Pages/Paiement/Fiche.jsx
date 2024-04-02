import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import React from "react";
const TdStyle = {
    TitleStyle: `bg-blue-900 font-semibold text-white p-1 text-[17px] pl-5`,
    TdStyle: `text-dark border-b border-l border-[#E8E8E8] bg-[#F3F6FF] dark:bg-dark-3 dark:border-dark dark:text-dark-7 px-2 text-base font-medium`,
    TdStyle2: `text-dark border-b border-[#E8E8E8] bg-white dark:border-dark dark:bg-dark-2 dark:text-dark-7 px-2 text-center text-base font-medium text-start`,
    TdButton: `inline-block px-6 border rounded-md border-primary text-primary hover:bg-primary hover:text-white font-medium`,
  }

  
export default function Fiche({auth}){
return (

<section className='bg-white dark:bg-dark py-20 lg:py-[120px]'>
      <div className='md:container m-auto bg-[#F3F6FF] p-5'>
        <h3 className='text-center font-bold'>REPUBLIQUE DU BENIN</h3>
        <h3>CMFD Sarl</h3>
        <h2 className='text-center text-xl font-extrabold'>FICHE DE PAIE</h2>
        <div className=''>
          <div >
            <div className='max-w-full overflow-x-auto '>
               <table className='w-full table-auto'>
                {/* <thead className='text-center bg-primary'>
                  <tr>
                    <th className={TdStyle.ThStyle}> TDH </th>
                    <th className={TdStyle.ThStyle}> Duration </th>
                    <th className={TdStyle.ThStyle}> Registration </th>
                    <th className={TdStyle.ThStyle}> Renewal </th>
                    <th className={TdStyle.ThStyle}> Transfer </th>
                  </tr>
                </thead> */}

                <tbody>
                  <tr className='pl-3'>
                    <td colSpan={3} ></td>
                    <td colSpan={2}>
                      <h3>Fait le 12 mars 2024</h3>
                  
   INFO  Creating a filament user with Super Admin Role...  
    <h3>Période : 22 février au 24 mars 2024</h3>
                      <h3 className={TdStyle.TitleStyle}>Cotonou Rép.Du Bénin</h3>
                    </td>
                  </tr>
                  <tr>
                    <td colSpan={5} className='py-3'></td>
                  </tr>
                  <tr className={TdStyle.TitleStyle}>
                    <td colSpan={2}>
                      <tr >Nom : xxxxxxx</tr>
                      <tr>Fonction : xxxxxxx</tr>
                      <tr>Situation matrimoniale</tr>
                    </td>
                    <td colSpan={2}>
                      <tr>Prénoms:</tr>
                      <tr>Catégorie: </tr>
                      <tr>d'enfants: xxxxxxx</tr>
                    </td>
                    <td colSpan={2} className=''>
                      <tr>xxxxxxx</tr>
                      <tr>Agent d'Exécution</tr>
                      <tr>
                    <tr colSpan={5} className='py-3'></tr>
                  </tr>
                    </td>

                  </tr>
                  <tr>
                    <td colSpan={5} className='py-3'></td>
                  </tr>
                  <tr className={TdStyle.TitleStyle}>
                    <td >Eléments</td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td className='text-center'>Montants</td>

                  </tr>
                  <tr>
                    <td colSpan={4} >SALAIRES BRUTES</td>
                    <td className='text-center'>74060</td>

                  </tr>
                  <tr className={TdStyle.TitleStyle}>
                    <td ></td>
                    <td colSpan={3} >SALAIRE BRUT MENSUEL</td>
                    <td className='text-center'>74060</td>
                  </tr>
                  <tr>
                    <td colSpan={4} >RETENUES OBLIGATOIRES</td>
                    <td className='text-center'>XXXXX</td>
                  </tr>
                  <tr>
                    <td colSpan={4} >C.N.S.S</td>
                    <td className='text-center'>XXXXX</td>
                  </tr>
                  <tr>
                    <td colSpan={4} >I.P.T.S</td>
                    <td className='text-center'>XXXXX</td>
                  </tr>
                  <tr>
                    <td colSpan={4} >AVANCE SUR SALAIRE</td>
                    <td className='text-center'>XXXXX</td>
                  </tr>
                  <tr className={TdStyle.TitleStyle}>
                    <td ></td>
                    <td colSpan={3}>TOTAL RETENUES OBLIGATOIRES</td>
                    <td className='text-center' >4066</td>
                  </tr>
                  <tr>
                    <td colSpan={5} className='py-3'></td>
                  </tr>
                  <tr className={TdStyle.TitleStyle}>
                    <td ></td>
                    <td colSpan={2} >SALAIRE NET A PAYER</td>
                    <td ></td>
                    <td className='text-center'>70000</td>
                  </tr>
                  <tr>
                    <td colSpan={5} >
                      <h3>MODE DE RÈGLEMENT DE: <br />
                      </h3>
                      <p>SOIXANTE DIX MILLE</p>
                    </td>



                  </tr>
                  <tr>
                    <td >Caisse</td>
                    <td colSpan={4} ></td>
                  </tr>
                  <tr>
                    <td >Chèque</td>
                    <td colSpan={4}>X</td>
                  </tr>
                  <tr>
                    <td >Virement</td>
                    <td colSpan={4}></td>
                  </tr>
                </tbody>
              </table>
              <h3 className='text-center mb-5 font-semibold'> DANS VOTRE INTERET ET POUR VALIDER VOS DROITS, VEILLER CONSERVER CETTE FICHE DE PAIE SANS LIMITATION DE DUREE</h3>

            </div>
          </div>
        </div>
        <div className='text-center space-y-10'>
          <h3>La Directrice Générale</h3>
          <p>xxxxxxxxxxxxx</p>
        </div>
      </div>
    </section>


  
)
}