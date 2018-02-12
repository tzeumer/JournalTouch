<?php
/*
$this->release_note;
$this->release_filesMove;
$this->release_foldersDelete;
*/

$this->release_note =
'Version 0.5
New: xxxMajorFeaturexxx
xxx


New
- Introduced xxx
- Added option xxx


Changes
- Moved admin/upgrade/history to data/upgraded because folder needs writing permission (Version 0.4 missed this requirement in the installation instructions)


Improvements
- No more errors if new versions of JournalTouch provide new settings. They now always get loaded from default settings.
- CrossRef: Switched to api for getting data


Fixes
- opening the cart via the "send articles" button in the lower right no longer leads to a cart with missing buttons
- some more spelling fixes
- JournalTocs: get journal title from a different field (seems to have changed)
- Removed button linking to JournalTocs page for journal in an iframe (https://github.com/bibliocoll/JournalTouch/issues/96)
- Removed RSS links support (for now)
- Some minor fixes


Known Issues
- The cover update does not work if you use the JournalTocs Premium update. JournalTocs now provides covers via api. Since I got no premium account, I can\'t modify admin/services/getLatestJournalTocPremium.php accordingly.
- Sometimes the log is not outputted to the Journal Update page (likely because browser times out); you can manually check data/journals/LastUpdateLog.html or open it from the admin menu


Added 3rd party ressources
- updated ZURB Foundation 5 to most recent version (5.5.3)


Credits
- @realsobek for painstakingly reporting every issue he ran into during installation. thanks a bunch!
- @realsobek, @MPIKGLibrary and @reicheltmediadesign for their bug reports and comments
';


/**
 * @Note    Files that must be moved. Don't use trailing slashes.
 *          Use * (many chars) or ? (one character) as wildcards for source ('from').
 *          If you use wildcards for the source, set a * at the end of the target ('to')
 *
 *          If you want to copy a single file, spell it out in 'from' and 'to'
*/
$this->release_filesMove['from'][]  = 'admin/upgrade/history/*';
$this->release_filesMove['to'][]    = 'data/upgraded/*';


/**
 * Delete these folder on update
 */
$this->release_foldersDelete = array (
    'admin/upgrade/history'
);


?>