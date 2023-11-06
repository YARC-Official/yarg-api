import AppLayout from '@/Layouts/AppLayout';
import React from 'react';
import { User } from '@/types';
import useTypedPage from '@/Hooks/useTypedPage';

export default function PublicProfile({ user }: { user: User }) {
    const page = useTypedPage();

    return (
        <AppLayout title={'Fodase'} renderHeader={() => (
            <h2 className='font-semibold text-xl text-gray-800 leading-tight'>
                Profile {user.username}
            </h2>
        )}>
            <div className='py-12'>
                <div className='max-w-7xl mx-auto sm:px-6 lg:px-8'>
                    <div className='bg-white overflow-hidden shadow-xl sm:rounded-lg'>

                        <p>{user.instrument?.name ?? 'No instrument'}</p>
                        <img
                            className="h-8 w-8 rounded-full object-cover"
                            src={page.props.auth.user?.profile_photo_url}
                            alt={page.props.auth.user?.name}
                        />
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
