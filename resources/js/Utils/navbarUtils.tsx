import React from 'react';
import { Team } from '@/types';
import { router } from '@inertiajs/core';
import useRoute from '@/Hooks/useRoute';


export const switchToTeam = (e: React.FormEvent, team: Team) => {
    e.preventDefault();
    const route = useRoute();

    router.put(
        route('current-team.update'),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        },
    );
};

export const logout = (e: React.FormEvent) => {
    const route = useRoute();
    e.preventDefault();
    router.post(route('logout'));
};
