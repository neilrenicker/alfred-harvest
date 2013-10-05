## [Harvest][1] workflow for [Alfred][2]

Let [Alfred][2] help you track your time. This workflow gives you complete access to your [Harvest][1] time-tracking:

* view today's timers
* start / stop a timer
* view and add notes
* launch your Harvest web app

### [View releases and download](https://github.com/neilrenicker/alfred-harvest/releases)

## How to use:

**Setup:**

* Type `hv` to view all available triggers
* Type `hv setup` to enter your Harvest subdomain, email, and password. **Note:** THIS_PART_IS_YOUR_SUBDOMAIN.harvestapp.com

**Start a new timer:**

1. Type `hv new` to list your current projects
2. Press `enter` to select a project and list available tasks
3. Press `enter` to begin the timer

**Toggle today's timers**

1. Type `hv toggle` to list today's timers
2. Press `enter` to select a timer and toggle it on / off

**Add a note:**

1. Type `hv note` to list today's timers
2. Press `enter` to select a timer
3. Enter your note and press `enter`

**Modifier keys:**

* **Start a new timer, and immediately add a note:** *hold `command` while completing the second step of `hv new`*
* **Delete one of today's timer entries:** *hold `option` while completing `hv toggle`*

## Fun facts:

* All text portions of the listings throughout the workflow are filterable. You can start typing within any of the workflows to filter items by project, task, client, and even note content!
* If you haven't started a project for today, running `hv toggle` or `hv note` will display a shortcut to add a new timer.

[1]: http://www.getharvest.com/
[2]: http://www.alfredapp.com/

---

**Please note:** Passwords and project caching are stored in Alfred's "Workflow Data" folder. This means your Harvest login info isn't encrypted, although it is tucked away in a deep dark system folder.

### Credits:

"Pencil" icon courtesy [http://www.visualpharm.com/](http://www.visualpharm.com/) via [Creative Commons Attribution-NoDerivs 3.0 Unported](http://icons8.com/license/).