import React from 'react';
import useTypedPage from '@/Hooks/useTypedPage';
import useRoute from '@/Hooks/useRoute';
import GithubIcon from '@/Components/SocialstreamIcons/GithubIcon';
import { Providers } from '@/types';
import TwitterIcon from '@/Components/SocialstreamIcons/TwitterIcon';
import DiscordIcon from '@/Components/SocialstreamIcons/DiscordIcon';

const socialsIcons = {
    github: <GithubIcon className="h-6 w-6 mx-2"/>,
    "twitter-oauth-2": <TwitterIcon className="h-6 w-6 mx-2"/>,
    discord: <DiscordIcon className="h-6 w-6 mx-2"/>
} satisfies Record<Providers, JSX.Element>

export default function Socialstream() {
    const page = useTypedPage();
    const route = useRoute();
    console.log(page);
    return (
        <div>
            <div className='flex flex-row items-center justify-between py-4 text-gray-600'>
                <hr className='w-full mr-2' />
                Or
                <hr className='w-full ml-2' />
            </div>
            <div className='flex items-center justify-center'>
                {page.props.socialstream.providers.map((provider) => {
                    return (
                        <div>
                            <a href={route('oauth.redirect', provider)}>
                                { socialsIcons[provider] }
                                <span className="sr-only">{ provider }</span>
                            </a>
                        </div>
                    );
                })}
            </div>

        </div>
    );
}
