import React, { useState } from 'react';
import ActionSection from '@/Components/ActionSection';
import useTypedPage from '@/Hooks/useTypedPage';
import ConnectedAccount from '@/Components/ConnectedAccount';
import { ConnectedAccountType } from '@/types';
import DialogModal from '@/Components/DialogModal';
import SecondaryButton from '@/Components/SecondaryButton';
import PrimaryButton from '@/Components/PrimaryButton';
import classNames from 'classnames';
import { useForm } from '@inertiajs/react';
import useRoute from '@/Hooks/useRoute';

export default function ConnectedAccountsForm() {
    const page = useTypedPage();
    const route = useRoute();
    const form = useForm({
        _method: 'DELETE',
        bag: 'removeConnectedAccount',
    });

    const [isConfirmingRemove, setIsConfirmingRemove] = useState(false);
    const [accountId, setAccountId] = useState<number>();

    function removeConnectedAccount(id: ConnectedAccountType['id']) {
        form.post(route('connected-accounts.destroy', { id }), {
            preserveScroll: true,
            onSuccess: () => {
                setIsConfirmingRemove(false);
            },
        });
    }

    function hasAccountForProvider(provider: string) {
        return (
            page.props.socialstream.connectedAccounts.some(
                account => account.provider === provider,
            )
        );
    }

    function getAccountForProvider(provider: string) {
        if (hasAccountForProvider(provider)) {
            return page.props.socialstream.connectedAccounts
                .find(account => account.provider === provider);
        }
    }


    function confirmRemove(id: ConnectedAccountType['id']) {
        setAccountId(id);
        setIsConfirmingRemove(true);
    }


    const socialStream = page.props.socialstream;
    console.debug({ socialStream });

    return (
        <ActionSection
            title={'Connected Accounts'}
            description={'Manage and remove your connected accounts.'}
        >
            {
                page.props.socialstream.connectedAccounts.length === 0 ?
                    <h3 className='text-lg font-medium text-gray-900'>
                        You have no connected accounts.
                    </h3> :
                    <h3 className='text-lg font-medium text-gray-900'>
                        Your connected accounts.
                    </h3>
            }
            <div className='mt-3 ax-w-xl text-sm text-gray-600'>
                You are free to connect any social accounts to your profile and may remove any connected accounts at any
                time. If you feel any of your connected accounts have been compromised, you should disconnect them
                immediately and change your password.
            </div>

            <div className='mt-5 space-y-6'>
                {
                    socialStream.providers.map(provider => {
                        const connectedAccount = socialStream.connectedAccounts.find(account => {
                            return account.provider === provider;
                        });

                        const canRemoveConnectedAccount = page.props.socialstream.connectedAccounts.length > 1
                            || page.props.socialstream.hasPassword;

                        function onRemoveAccount(provider: string) {
                            const account = getAccountForProvider(provider);

                            if (account) {
                                return confirmRemove(account.id);
                            }
                        }


                        if (connectedAccount) {
                            return <ConnectedAccount
                                isConnected={true}
                                provider={provider}
                                connectedAccount={connectedAccount}
                                canRemoveConnectedAccount={canRemoveConnectedAccount}
                                onRemoveAccount={onRemoveAccount}
                            />;
                        }

                        return <ConnectedAccount
                            isConnected={false}
                            provider={provider}
                            canRemoveConnectedAccount={canRemoveConnectedAccount}
                            onRemoveAccount={onRemoveAccount}
                        />;
                    })
                }
            </div>

            <DialogModal isOpen={isConfirmingRemove} onClose={() => setIsConfirmingRemove(false)}>
                <DialogModal.Content title='Remove Connected Account'>
                    Please confirm your removal of this account - this action cannot be undone.
                </DialogModal.Content>
                <DialogModal.Footer>
                    <SecondaryButton onClick={() => setIsConfirmingRemove(false)}>Nevermind</SecondaryButton>
                    <PrimaryButton
                        className={classNames('ml-2', form.processing && 'opacity-25')}
                        disabled={form.processing}
                        onClick={() => {
                            if (accountId) {
                                removeConnectedAccount(accountId);
                            }
                        }
                        }>
                        Remove Connected Account
                    </PrimaryButton>
                </DialogModal.Footer>
            </DialogModal>
        </ActionSection>
    );
}


/*

<DialogModal :show="confirmingRemove" @close="confirmingRemove = false">
                <template #title>

                </template>

                <template #content>
                </template>

                <template #footer>
                    <SecondaryButton @click="confirmingRemove = false">
                        Nevermind
                    </SecondaryButton>

                    <PrimaryButton class="ml-2" @click="removeConnectedAccount(accountId)"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Remove Connected Account
                    </PrimaryButton>
                </template>
            </DialogModal>
 */
