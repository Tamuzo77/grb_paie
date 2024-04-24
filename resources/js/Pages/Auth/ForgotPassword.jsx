import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, useForm } from '@inertiajs/react';
import { Link } from '@inertiajs/inertia-react';
export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('password.email'));
    };

    return (
        <GuestLayout>
            <Head title="Forgot Password" />

            <div className="mb-4 text-gray-600 dark:text-gray-400 text-lg">
                Mot de passe oublié ? Pas de problème. Indiquez simplement votre adresse e-mail et nous vous enverrons un lien de réinitialisation de mot de passe par e-mail, ce qui vous permettra d'en choisir un nouveau.
            </div>
            <Link href="http://127.0.0.1:8000/login"
                            className="underline text-blue-600 dark:text-cyan-600 hover:text-blue-700 dark:hover:text-cyan-700"
                        >
                            retour à la connexion
                        </Link>
            {status && <div className="mb-4 font-medium text-sm text-green-600 dark:text-green-400">{status}</div>}

            <form onSubmit={submit} className='mt-5'>
                <TextInput
                    id="email"
                    type="email"
                    name="email"
                    value={data.email}
                    className="mt-1 block w-full"
                    isFocused={true}
                    onChange={(e) => setData('email', e.target.value)}
                />

                <InputError message={errors.email} className="mt-2" />

                <div className="flex items-center justify-end mt-4">
                    <PrimaryButton className="ms-4" disabled={processing}>
                    Envoyer le lien de réinitialisation de mot de passe par e-mail
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
