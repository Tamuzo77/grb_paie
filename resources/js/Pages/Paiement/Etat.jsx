import React from "react";

const TdStyle = {
  ThStyle: `w-1/6 min-w-[160px] border-l border-transparent py-4 px-3 text-lg font-medium text-white lg:py-7 lg:px-4`,
  TdStyle: `text-dark border-b border-l border-[#E8E8E8] bg-[#F3F6FF] dark:bg-dark-3 dark:border-dark dark:text-dark-7 py-5 px-2 text-center text-base font-medium`,
  TdStyle2: `text-dark border-b border-[#E8E8E8] bg-white dark:border-dark dark:bg-dark-2 dark:text-dark-7 py-5 px-2 text-center text-base font-medium`,
  TdButton: `inline-block px-6 py-2.5 border rounded-md border-primary text-primary hover:bg-primary hover:text-white font-medium`,
}



export default function Fiche(){
    return (
            <section className='bg-white dark:bg-dark py-20 lg:py-[120px]'>
              <div className='container m-auto'>
                <div className='flex flex-wrap'>
                  <div className='w-full '>
                    <h3 className="text-center py-8 font-bold">ETAT DES SALAIRES ET ACCESOIRES DU PERSONNEL DU CABINET CMFD</h3>
                    <div className='max-w-full '>
               <table className='w-full table-auto border-collapse border border-slate-600 '>
                        <thead className='text-center bg-primary'>

                            <th className="border border-slate-400 p-1"> N°  </th>
                            <th className="border border-slate-400 p-1"> Nom et Prénoms </th>
                            <th className="border border-slate-400 p-1"> Fonction </th>
                            <th className="border border-slate-400 p-1"> Nombre d'enfant à charge </th>
                            <th className="border border-slate-400 p-1"> Salaire Brut(Base +primes) </th>                         
                            <th className="border border-slate-400 p-1"> CNSS(3,6%) </th>
                            <th className="border border-slate-400 p-1"> IRPP-TS </th>
                            <th className="border border-slate-400 p-1"> Salaire net </th>
                            <th className="border border-slate-400 p-1"> Veserment patronale (VPS) </th>
                            <th className="border border-slate-400 p-1"> Masse salariale </th>
                            <th className="border border-slate-400 p-1"> Signature et PI </th>
                        </thead>
        
                        <tbody className="text-end">
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
                    </div>
                  </div>
                </div>
              </div>
            </section>
        )
    }    