

import React, { useState, useRef } from 'react';
import { useForm, Link } from '@inertiajs/inertia-react';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { get } from '@inertiajs/inertia';

const TwoFactor = ({ status }) => {
    const { data, setData, errors, post, processing } = useForm();
    const [codeInputs, setCodeInputs] = useState(Array(6).fill(''));
    const inputRefs = useRef([]);

    const handleChange = (index, value) => {
        if (/^\d*$/.test(value) && value.length <= 1) {
            const newInputs = [...codeInputs];
            newInputs[index] = value;
            setCodeInputs(newInputs);
            const code = newInputs.join('');
            setData('two_factor_code', code);

            if (value && index < codeInputs.length - 1) {
                // Focus sur la case suivante
                inputRefs.current[index + 1].focus();
            }
        }
    };

    const handleKeyDown = (index, e) => {
        if (e.key === 'Backspace' && !codeInputs[index] && index > 0) {
            // Supprimer le contenu de la case précédente et focus sur celle-ci
            const newInputs = [...codeInputs];
            newInputs[index - 1] = '';
            setCodeInputs(newInputs);
            const code = newInputs.join('');
            setData('two_factor_code', code);

            inputRefs.current[index - 1].focus();
        }
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('verify.store'), {
            data: {
                two_factor_code: data.two_factor_code,
            },
            onSuccess: () => {
                // Handle success, maybe redirect or show a success message
            },
        });
    };

    return (
        <GuestLayout>
            <div>
                {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}
            </div>
            <div className="mb-4 font-medium text-center text-sm text-blue-950 dark:text-gray-200">Veuillez consulter votre mail pour
                récupérer votre code de connexion.
            </div>


            <form onSubmit={handleSubmit}>
                <div className='m-auto mb-3 w-full flex justify-center'>
                    {codeInputs.map((value, index) => (
                        <TextInput
                            key={index}
                            className='w-12 mx-1 text-center border-b-2 border-gray-400 focus:border-indigo-500'
                            id={`code_${index}`}
                            type="text"
                            name={`code_${index}`}
                            value={value}
                            onChange={(e) => handleChange(index, e.target.value)}
                            onKeyDown={(e) => handleKeyDown(index, e)}
                            maxLength={1}
                            required
                            ref={(ref) => (inputRefs.current[index] = ref)} // Référence à l'élément TextInput
                        />
                    ))}
                </div>
                <InputError message={errors.two_factor_code}/>

                <div className='flex items-center justify-center mt-4'>
                    <PrimaryButton type="submit" disabled={processing}>
                        Soumettre
                    </PrimaryButton>
                </div>
            </form>

            <div className='flex items-center justify-center mt-4'>
                <Link
                    href={route('verify.resend')}
                    className="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none"
                >
                    Renvoyez le code
                </Link>
            </div>
        </GuestLayout>
    );
};

export default TwoFactor;
