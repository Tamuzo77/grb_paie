import React, { useState } from 'react';
import { useForm } from '@inertiajs/inertia-react';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { get } from '@inertiajs/inertia';

const TwoFactor = ({ status }) => {
    const { data, setData, errors, post, processing } = useForm();

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

    const handleResend = () => {
        get(route('verify.resend'), {
            onSuccess: () => {
                // Handle success, maybe show a success message
            },
        });
    };

    return (
        <GuestLayout>
            <div>
                <p>{status}</p>
            </div>

            <form onSubmit={handleSubmit}>
                <div className='m-auto mb-3 w-full'>
                    <InputLabel htmlFor="two_factor_code" value="Code" />
                    <TextInput className='w-full'
                        id="two_factor_code"
                        type="text"
                        name="two_factor_code"
                        value={data.two_factor_code || ''}
                        onChange={(e) => setData('two_factor_code', e.target.value)}
                        required
                        autoFocus
                    />
                    <InputError message={errors.two_factor_code} />
                </div>

                <div className='flex items-center justify-end mt-4'>
                    <PrimaryButton type="submit" disabled={processing}>
                        Submit
                    </PrimaryButton>
                    
                </div>
            </form>

            <div className='flex items-center justify-end mt-4'>
                <button onClick={handleResend}>Resend Code</button>
            </div>
        </GuestLayout>
        
    );
};

export default TwoFactor;