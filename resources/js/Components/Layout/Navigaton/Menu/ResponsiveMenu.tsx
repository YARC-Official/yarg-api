import classNames from 'classnames';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';
import React, { Dispatch, SetStateAction, useState } from 'react';
import useRoute from '@/Hooks/useRoute';
import useTypedPage from '@/Hooks/useTypedPage';
import { logout, switchToTeam } from '@/Utils/navbarUtils';

export default function ResponsiveMenu({
                                           showingNavigationDropdown,
                                           setShowingNavigationDropdown,
                                       }: { showingNavigationDropdown: boolean, setShowingNavigationDropdown: Dispatch<SetStateAction<boolean>> }) {
    const route = useRoute();
    const page = useTypedPage();

    return (
        <div className={classNames('sm:hidden', {
            block: showingNavigationDropdown,
            hidden: !showingNavigationDropdown,
        })}>
            <div className='pt-2 pb-3 space-y-1'>
                <ResponsiveNavLink
                    href={route('dashboard')}
                    active={route().current('dashboard')}
                >
                    Dashboard
                </ResponsiveNavLink>
            </div>
            <div className='pt-2 pb-3 space-y-1'>
                <ResponsiveNavLink
                    href={route('test')}
                    active={route().current('test')}
                >
                    Dashboard
                </ResponsiveNavLink>
            </div>

            {/* <!-- Responsive Settings Options --> */}
            <div className='pt-4 pb-1'>
                <div className='flex items-center px-4'>
                    {page.props.jetstream.managesProfilePhotos ? (
                        <div className='flex-shrink-0 mr-3'>
                            <img
                                className='h-10 w-10 rounded-full object-cover'
                                src={page.props.auth.user?.profile_photo_url}
                                alt={page.props.auth.user?.name}
                            />
                        </div>
                    ) : null}

                    <div>
                        <div className='font-medium text-base text-white'>
                            {page.props.auth.user?.name}
                        </div>
                        <div className='font-medium text-sm text-gray-500'>
                            {page.props.auth.user?.email}
                        </div>
                    </div>
                </div>

                <div className='mt-3 space-y-1'>
                    <ResponsiveNavLink
                        href={route('profile.show')}
                        active={route().current('profile.show')}
                    >
                        Profile
                    </ResponsiveNavLink>

                    {page.props.jetstream.hasApiFeatures ? (
                        <ResponsiveNavLink
                            href={route('api-tokens.index')}
                            active={route().current('api-tokens.index')}
                        >
                            API Tokens
                        </ResponsiveNavLink>
                    ) : null}

                    {/* <!-- Authentication --> */}
                    <form method='POST' onSubmit={logout}>
                        <ResponsiveNavLink as='button'>Log Out</ResponsiveNavLink>
                    </form>

                    {/* <!-- Team Management --> */}
                    {page.props.jetstream.hasTeamFeatures ? (
                        <>


                            <div className='block px-4 py-2 text-xs text-gray-400'>
                                Manage Team
                            </div>

                            {/* <!-- Team Settings --> */}
                            <ResponsiveNavLink
                                href={route('teams.show', [
                                    page.props.auth.user?.current_team!,
                                ])}
                                active={route().current('teams.show')}
                            >
                                Team Settings
                            </ResponsiveNavLink>

                            {page.props.jetstream.canCreateTeams ? (
                                <ResponsiveNavLink
                                    href={route('teams.create')}
                                    active={route().current('teams.create')}
                                >
                                    Create New Team
                                </ResponsiveNavLink>
                            ) : null}


                            {/* <!-- Team Switcher --> */}
                            <div className='block px-4 py-2 text-xs text-gray-400'>
                                Switch Teams
                            </div>
                            {page.props.auth.user?.all_teams?.map(team => (
                                <form onSubmit={e => switchToTeam(e, team)} key={team.id}>
                                    <ResponsiveNavLink as='button'>
                                        <div className='flex items-center'>
                                            {team.id ==
                                                page.props.auth.user?.current_team_id && (
                                                    <svg
                                                        className='mr-2 h-5 w-5 text-green-400'
                                                        fill='none'
                                                        strokeLinecap='round'
                                                        strokeLinejoin='round'
                                                        strokeWidth='2'
                                                        stroke='currentColor'
                                                        viewBox='0 0 24 24'
                                                    >
                                                        <path
                                                            d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'></path>
                                                    </svg>
                                                )}
                                            <div>{team.name}</div>
                                        </div>
                                    </ResponsiveNavLink>
                                </form>
                            ))}
                        </>
                    ) : null}
                </div>
            </div>
        </div>
    );
}
