// import React, { useState } from 'react';
// import { useForm,Link } from '@inertiajs/inertia-react';
// import GuestLayout from '@/Layouts/GuestLayout';
// import InputError from '@/Components/InputError';
// import InputLabel from '@/Components/InputLabel';
// import PrimaryButton from '@/Components/PrimaryButton';
// import TextInput from '@/Components/TextInput';
// import { get } from '@inertiajs/inertia';


// const TwoFactor = ({ status }) => {
//     const { data, setData, errors, post, processing } = useForm();

//     const handleSubmit = (e) => {
//         e.preventDefault();
//         post(route('verify.store'), {
//             data: {
//                 two_factor_code: data.two_factor_code,
//             },
//             onSuccess: () => {
//                 // Handle success, maybe redirect or show a success message
//             },
//         });
//     };

//     // const handleResend = (e) => {
//     //     get(route('verify.resend'), {
//     //         onSuccess: () => {
//     //             // Handle success, maybe show a success message
//     //         },
//     //     });
//     // };

//     return (
//         <GuestLayout>
//             <div>
//             {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

//             </div>

//             <form onSubmit={handleSubmit}>
//                 <div className='m-auto mb-3 w-full'>
//                     <InputLabel htmlFor="two_factor_code" value="Code" />
//                     <TextInput className='w-full'
//                         id="two_factor_code"
//                         type="text"
//                         name="two_factor_code"
//                         value={data.two_factor_code || ''}
//                         onChange={(e) => setData('two_factor_code', e.target.value)}
//                         required
//                         autoFocus
//                     />
//                     <InputError message={errors.two_factor_code} />
//                 </div>

//                 <div className='flex items-center justify-end mt-4'>
//                     <PrimaryButton type="submit" disabled={processing}>
//                         Submit
//                     </PrimaryButton>
                    
//                 </div>
//             </form>
// {/* 
//             <div className='flex items-center justify-end mt-4'>
//                 <button onClick={handleResend}>Resend Code</button>
//             </div> */}
//             <Link
//                         href={route('verify.resend')}
//                         className="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
//                     >
//                         Resend Code
//                     </Link>
//         </GuestLayout>
        
//     );
// };

// export default TwoFactor;








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
                <InputError message={errors.two_factor_code} />

                <div className='flex items-center justify-center mt-4'>
                    <PrimaryButton type="submit" disabled={processing}>
                        Submit
                    </PrimaryButton>
                </div>
            </form>

            <div className='flex items-center justify-center mt-4'>
                <Link
                    href={route('verify.resend')}
                    className="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Resend Code
                </Link>
            </div>
        </GuestLayout>
    );
};

export default TwoFactor;
