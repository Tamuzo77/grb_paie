import React from "react";
export default function Fiche(){
    return (
            <section className=''>
              <div className='container m-auto'>
                <div className='flex flex-wrap'>
                  <div className='w-full '>
                    <h3 className="text-center py-8 font-bold"></h3>
                    <div className='max-w-full '>
               <table className='table'>
                        <thead className='text-center bg-primary'>
                        <th colSpan={11}>
                        ETAT DES SALAIRES ET ACCESOIRES DU PERSONNEL DU CABINET CMFD
                        </th>
                        </thead>

                        <tbody className="text-end">
                          <tr className="title">

                          <td > N°  </td>
                            <td > Nom et Prénoms </td>
                            <td > Fonction </td>
                            <td > Nombre d'enfant à charge </td>
                            <td > Salaire Brut(Base +primes) </td>
                            <td > CNSS(3,6%) </td>
                            <td > IRPP-TS </td>
                            <td > Salaire net </td>
                            <td > Veserment patronale (VPS) </td>
                            <td > Masse salariale </td>
                            <td > Signature et PI </td>
                          </tr>
                            <tr>
                                <td >01</td>
                                <td >xxxxx</td>
                                <td >xxxxx</td>
                                <td >xxxxx</td>
                                <td >xxxxx</td>
                                <td >xxxxx</td>
                                <td >xxxxx</td>
                                <td >xxxxx</td>
                                <td >xxxxx</td>
                                <td >xxxxx</td>
                                <td >xxxxx</td>
                            </tr>
                          <tr>
                            <td colSpan={4}>Total</td>
                            <td >xxxxx</td>
                            <td >xxxxx</td>
                            <td >xxxxx</td>
                            <td >xxxxx</td>
                            <td >xxxxx</td>
                            <td >xxxxx</td>
                            <td >xxxxx</td>
                        </tr>
                        <tr className="title">
                          <td colSpan={5}>xxxxxxxx</td>

                          <td  colSpan={6}>La Directrice</td>
                        </tr>
                        <tr>
                          <td colSpan={5}>xxxxxxxx</td>
                          <td colSpan={6}>xxxxxxxxx</td>
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
