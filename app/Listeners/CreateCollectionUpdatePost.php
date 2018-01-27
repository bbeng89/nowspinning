<?php

namespace App\Listeners;

use App\Events\UserDiscogsCollectionSynced;

class CreateCollectionUpdatePost
{
    /**
     * The number of releases to show the title/artist(s) of in the post.
     * Anything over this will be shown as " and {x} more."
     */
    const NEW_RELEASE_DISPLAY_LIMIT = 3;

    /**
     * Handle the event.
     *
     * @param  UserDiscogsCollectionSynced  $event
     * @return void
     */
    public function handle(UserDiscogsCollectionSynced $event)
    {
        if($event->newReleasesAdded())
        {
            $user = $event->getUser();
            $newReleaseCount = $event->getNumberOfReleasesAdded();

            $pluralized = $newReleaseCount == 1 ? 'release' : 'releases';
            $content = "I added {$newReleaseCount} new {$pluralized} to my collection: ";
            $content .= $this->getNewReleaseDisplayText($user, $newReleaseCount);
            $user->addPost($content, false);
        }
    }

    protected function getNewReleaseDisplayText($user, $newReleaseCount)
    {
        $remainder = $newReleaseCount - self::NEW_RELEASE_DISPLAY_LIMIT;
        $numToTake = $remainder > 0 ? self::NEW_RELEASE_DISPLAY_LIMIT : $newReleaseCount;
        $newReleases = $user->releases()->orderBy('created_at', 'desc')->take($numToTake)->get();
        $glue = $newReleaseCount == 2 ? ' and ' : ', ';

        $text = $newReleases->map(function($release){
            return $release->title . ' by ' . $release->artists_display;
        })->implode($glue);

        if($remainder > 0)
        {
            $text .= ", and {$remainder} more.";
        }
        else
        {
            $text .= '.';
        }

        return $text;
    }
}
