import React from 'react';
import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm';
import LogoutOtherBrowserSessions from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm';
import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm';
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm';
import useTypedPage from '@/Hooks/useTypedPage';
import SectionBorder from '@/Components/SectionBorder';
import AppLayout from '@/Layouts/AppLayout';
import { Session, Country, Instrument, Difficulty } from '@/types';
import ConnectedAccountsForm from '@/Pages/Profile/Partials/ConnectedAccountsForm';
import SetPasswordForm from '@/Pages/Profile/Partials/SetPasswordForm';


interface Props {
    sessions: Session[];
    confirmsTwoFactorAuthentication: boolean;

    countries: Country[];
    instruments: Instrument[];
    difficulties: Difficulty[];
}

export default function Show({
                                 sessions,
                                 confirmsTwoFactorAuthentication,
                                 countries,
                                 instruments,
                                 difficulties,
                             }: Props) {
    const page = useTypedPage();

    const canUpdatePassword = page.props.jetstream.canUpdatePassword && page.props.socialstream.hasPassword;
    return (
        <AppLayout
            title={'Profile'}
            renderHeader={() => (
                <h2 className='font-semibold text-xl text-gray-800 leading-tight'>
                    Profile
                </h2>
            )}
        >
            <div>
                <div className='max-w-7xl mx-auto py-10 sm:px-6 lg:px-8'>
                    {page.props.jetstream.canUpdateProfileInformation ? (
                        <div>
                            <UpdateProfileInformationForm
                                user={page.props.auth.user!}
                                countries={countries}
                                difficulties={difficulties}
                                instruments={instruments} />

                            <SectionBorder />
                        </div>
                    ) : null}

                    <div className='mt-10 sm:mt-0'>
                        {canUpdatePassword ? <UpdatePasswordForm /> : <SetPasswordForm />}
                        <SectionBorder />
                    </div>
                    <div className='mt-10 sm:mt-0'>
                        <ConnectedAccountsForm />

                        <SectionBorder />
                    </div>

                    {page.props.jetstream.canManageTwoFactorAuthentication ? (
                        <div className='mt-10 sm:mt-0'>
                            <TwoFactorAuthenticationForm
                                requiresConfirmation={confirmsTwoFactorAuthentication}
                            />

                            <SectionBorder />
                        </div>
                    ) : null}

                    <div className='mt-10 sm:mt-0'>
                        <LogoutOtherBrowserSessions sessions={sessions} />
                    </div>

                    {page.props.jetstream.hasAccountDeletionFeatures ? (
                        <>
                            <SectionBorder />

                            <div className='mt-10 sm:mt-0'>
                                <DeleteUserForm />
                            </div>
                        </>
                    ) : null}
                </div>
            </div>
        </AppLayout>
    );
}
