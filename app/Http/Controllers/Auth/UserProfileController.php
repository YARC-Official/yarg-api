<?php

namespace App\Http\Controllers\Auth;

use App\Models\Band\Difficulty;
use App\Models\Band\Instrument;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Http\Controllers\Inertia\Concerns\ConfirmsTwoFactorAuthentication;
use Laravel\Jetstream\Jetstream;
use Squire\Models\Country;

class UserProfileController extends Controller
{
    use ConfirmsTwoFactorAuthentication;

    /**
     * Show the general profile settings screen.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function show(Request $request)
    {
        $this->validateTwoFactorAuthenticationState($request);

        // TODO: cache instruments call

        return Jetstream::inertia()->render($request, 'Profile/Show', [
            'confirmsTwoFactorAuthentication' => Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm'),
            'sessions' => $this->sessions($request)->all(),
            'countries' => Country::get(['id', 'flag', 'name']),
            'instruments' => Instrument::all(),
            'difficulties' => Difficulty::all(),
        ]);
    }

    /**
     * Get the current sessions.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection
     */
    public function sessions(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                ->where('user_id', $request->user()->getAuthIdentifier())
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function ($session) use ($request) {
            $agent = $this->createAgent($session);

            return (object)[
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param mixed $session
     * @return \Jenssegers\Agent\Agent
     */
    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }
}
