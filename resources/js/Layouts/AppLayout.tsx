import { Head } from '@inertiajs/react';
import React, { PropsWithChildren } from 'react';
import Banner from '@/Components/Banner';
import Navbar from '@/Components/Layout/Navigaton/Navbar';

interface Props {
    title: string;

    renderHeader?(): JSX.Element;
}

export default function AppLayout({ title, renderHeader, children }: PropsWithChildren<Props>) {

    return (
        <div>
            <Head title={title} />

            <Banner />

            <div className='min-h-screen bg-gray-100'>
                <Navbar />

                {/* <!-- Page Heading --> */}
                {renderHeader ? (
                    <header className='bg-white shadow'>
                        <div className='max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8'>
                            {renderHeader()}
                        </div>
                    </header>
                ) : null}

                {/* <!-- Page Content --> */}
                <main>{children}</main>
            </div>
        </div>
    );
}
