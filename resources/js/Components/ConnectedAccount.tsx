import React from 'react';
import { ConnectedAccountType, Providers } from '@/types';
import GithubIcon from './SocialstreamIcons/GithubIcon';
import TwitterIcon from '@/Components/SocialstreamIcons/TwitterIcon';
import DiscordIcon from '@/Components/SocialstreamIcons/DiscordIcon';
import useRoute from '@/Hooks/useRoute';
import ActionLink from '@/Components/ActionLink';
import DangerButton from '@/Components/DangerButton';

const socialIcons = {
    github: <GithubIcon className='h-6 w-6 mr-2' />,
    'twitter-oauth-2': <TwitterIcon className='h-6 w-6 mr-2' />,
    'discord': <DiscordIcon className='h-6 w-6 mr-2' />,
} satisfies Record<Providers, JSX.Element>;

type BasConnectedAccountProps = {
    provider: Providers
    canRemoveConnectedAccount: boolean
    onRemoveAccount: (provider: Providers) => void;
}

type ConnectedAccountProps = ({
    isConnected: false
} | {
    isConnected: true;
    connectedAccount: ConnectedAccountType;
}
    ) & BasConnectedAccountProps

export default function ConnectedAccount(props: ConnectedAccountProps) {
    const route = useRoute();

    return (
        <div>
            <div className='px-3 flex items-center justify-between'>
                <div className='flex items-center'>
                    {socialIcons[props.provider]}
                    <div>
                        <div className='text-sm font-semibold text-gray-600'>
                            {props.provider === 'twitter-oauth-2' ? 'Twitter' : props.provider.charAt(0).toUpperCase() + props.provider.slice(1)}
                        </div>

                        {props.isConnected ?
                            <div className='text-xs text-gray-500'>
                                Connected {props.connectedAccount.created_at}
                            </div> :
                            <div className='text-xs text-gray-500'>
                                Not connected.
                            </div>
                        }
                    </div>
                </div>
                {!props.isConnected ?
                    <ActionLink href={route('oauth.redirect', { provider: props.provider })}>
                        Connect
                    </ActionLink>
                    :
                    null

                }
                {
                    props.isConnected && props.canRemoveConnectedAccount ? <div className='flex items-center space-x-6'>
                        <DangerButton
                            onClick={() => props.onRemoveAccount(props.provider)}
                        >
                            Remove
                        </DangerButton>
                    </div> : null
                }
            </div>
        </div>
    );
}

<template v-if='hasAccountForProvider(provider)'>

</template>;
