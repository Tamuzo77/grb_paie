// import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
// import { Head } from "@inertiajs/react";
// import { Link } from "@inertiajs/inertia-react";
// import ApplicationLogo from "@/Components/ApplicationLogo";

// export default function Dashboard({ auth }) {
//     return (
//         <>
//             <div className="hidden dark:block bg-gray-900 h-screen">
//                 <div className="flex items-center justify-center h-96">
//                 <ApplicationLogo className="" />
//                 </div>
//                 <a
//                     href="/admin"
//                     className="font-semibold text-gray-500 hover:text-gray-200 flex text-center items-center justify-center"
//                 >
//                     Admin
//                 </a>
//             </div>
//             <div className="dark:hidden bg-slate-50 h-screen">
//                 <div>
//                 <ApplicationLogo className="flex justify-center items-center h-96" />
//                 </div>
//                 <a
//                     href="/admin"
//                     className="font-semibold text-gray-600 hover:text-gray-800  flex text-center items-center justify-center"
//                 >
//                     Admin
//                 </a>
//             </div>
//         </>
//     );
// }


import React from "react";
import { Link } from "@inertiajs/inertia-react";
import ApplicationLogo from "@/Components/ApplicationLogo";

export default function BienvenuePage({ auth }) {
    return (
        <div className="h-screen flex flex-col justify-center items-center dark:bg-gray-900 bg-slate-50">
            <div className="text-center">
                <div className="flex justify-center items-center my-16">
                <ApplicationLogo className="" />
                </div>
                <h1 className="text-4xl font-bold mb-2 dark:text-cyan-600 text-blue-800">Bienvenue, {auth.user.name} !</h1>
                <p className="text-lg mb-8 text-slate-800 dark:text-slate-400">
                    Nous sommes ravis de vous voir. Que voulez-vous faire ensuite ?
                </p>

                <div className="space-y-4">
                    <a
                        href="/admin"
                        className="block py-2 px-4 text-lg bg-cyan-600 font-bold text-white rounded hover:bg-blue-600 transition"
                    >
                        Aller au Dashboard
                    </a>
                    <Link
                        href={route('logout')}
                        method="post"
                        as="button"
                        className="w-full block py-2 px-4 font-bold text-lg bg-red-500 text-white rounded hover:bg-red-600 transition"
                    >
                        Déconnexion
                    </Link>
                </div>
            </div>
        </div>
    );
}
