## [Harvest][1] workflow for [Alfred][2]

Let [Alfred][2] help you track your time. This workflow gives you complete access to your [Harvest][1] time-tracking:

* view today's timesheet
* start / stop a timer

[View releases and download](/releases)

**Note:** Still work in progress. Don't share the workflow from within Alfred—unless you delete the `projects.txt` and `id.txt` within the workflow folder, you'll be sharing your projects and Harvest password with your friends.

## How to use:

* Type `hset` to enter your Harvest subdomain, email, and password. **Note:** THIS_PART_IS_YOUR_SUBDOMAIN.harvestapp.com
* Type `hv` to generate a list of your current projects
* Press `enter` on the current timer to toggle tracking on it
* Press `enter` on any other project to view available tasks, then press `enter` to begin tracking time on it
* Hold `option` on any of today's active projects to delete today's time on that project

## Features coming soon:
*In order of development, I think*

* More secure password / email handling
* <strike>Search filtering for on timers and toggling</strike>
* <strike>Speed up the workflow: cache projects, only making a request for daily timers</strike>
* Command to quickly add/subtract 5min, 10min, or custom amount from any timer (for those times when you step out for a pool game and forget to shut off your timer).
* Command to start a new timer with time already tracked to it (for those times when you're an hour into a project when you remember to start the timer).

[1]: http://www.getharvest.com/
[2]: http://www.alfredapp.com/