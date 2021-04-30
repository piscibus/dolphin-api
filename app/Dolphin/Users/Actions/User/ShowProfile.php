<?php

namespace App\Dolphin\Users\Actions\User;

use App\Dolphin\Http\Action;
use App\Dolphin\Users\Models\User;
use App\Dolphin\Users\Repositories\ProfileRepository;
use App\Dolphin\Users\Requests\ShowProfileRequest;
use App\Dolphin\Users\Resources\ProfileResource;

class ShowProfile implements Action
{
    /**
     * @var ShowProfileRequest
     */
    private ShowProfileRequest $request;

    /**
     * @var ProfileRepository
     */
    private ProfileRepository $profiles;

    /**
     * ShowProfile constructor.
     * @param  ShowProfileRequest  $request
     * @param  ProfileRepository  $profiles
     */
    public function __construct(ShowProfileRequest $request, ProfileRepository $profiles)
    {
        $this->request = $request;
        $this->profiles = $profiles;
    }

    /**
     * Executes the requested action
     *
     * @return ProfileResource
     */
    public function execute(): ProfileResource
    {
        /** @var User $user */
        $user = $this->request->user();
        $profile = $user->getProfile();
        return new ProfileResource($profile);
    }
}
