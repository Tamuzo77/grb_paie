import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { Link } from "@inertiajs/inertia-react";
import ApplicationLogo from "@/Components/ApplicationLogo";

export default function Dashboard({ auth }) {
    return (
        <>
            <div className="hidden dark:block bg-gray-900 h-screen">
                <div className="flex items-center justify-center h-96">
                <ApplicationLogo className="" />
                </div>
                <a
                    href="/admin"
                    className="font-semibold text-gray-500 hover:text-gray-200 flex text-center items-center justify-center"
                >
                    Admin
                </a>
            </div>
            <div className="dark:hidden bg-slate-50 h-screen">
                <div>
                <ApplicationLogo className="flex justify-center items-center h-96" />
                </div>
                <a
                    href="/admin"
                    className="font-semibold text-gray-600 hover:text-gray-800  flex text-center items-center justify-center"
                >
                    Admin
                </a>
            </div>
        </>
    );
}
