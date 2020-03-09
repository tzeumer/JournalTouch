# About
JournalTouch provides a touch-optimized, responsive interface for browsing current journal table-of-contents.

## Official version
The official version (0.4.5) of JournalTouch is maintained at [github.com/bibliocoll/JournalTouch](https://github.com/bibliocoll/JournalTouch).

## This non official version
This version is a hybrid of a private effort and the version used at the [University Library (TUB HH)](http://www.tub.tuhh.de/) of the Hamburg University of Technology (TUHH).

JournalTouch is not actively maintained by me. But occasionally I get notes on errors and problems that I then might or might not try to fix. The master branch gets what I consider to be safe changes. If you are really interested, you might check the latest development branch - it might be a step further.

### Changelog
2018-02
* JournalTocs: get journal title from a different field (seems to have changed)
* CrossRef: Switched to api for getting data
* Removed button linking to JournalTocs page for journal in an iframe (https://github.com/bibliocoll/JournalTouch/issues/96)
* Removed RSS links support (for now)
* Some minor fixes

### Known Issues
* Sometimes people ask how to add thousands of journals. Frankly, this is not the intended use of JournalTouch - the idea is a showcase of some of your most valued journals for casual (serendipity) browsing by visitors. If you really require more and are ready to pay money, maybe you should check out [browzine.com](https://browzine.com/). For example the [ETH Zürich is using browzine](https://www.ethz.ch/studierende/de/news/studierenden-news/2017/01/browzine-das-tool-zur-intuitiven-zeitschriftenrecherche.html), as well as the [University Duisburg-Essen](https://www.uni-due.de/ub/browzine.php). Since 2020-03 [vub | Paperboy](https://www.vubpaperboy.de) seems to be a new commercial service doing something similar.
* JournalTocs sometimes provides no information about publication dates (this has always been the case; JournalTouch tries to do some guesswork)
* JournalTouch has always primarily relied on JournalTocs. CrossRef always only was a fallback. But since switching to the CrossRef api, I noticed that dates (and probably authors and other fields) are much more reliably found there. Yet CrossRef offers no abstracts (which are part of JournalTouch's fun) and it can't simply be queried for the "articles of the latest issue". So for now I stick to JournalToc as primary source, while some mixing might be a good option in the future.



# Installation
## Prerequisites
1. Make sure you have Apache and PHP available. Nothing else is needed
2. Be aware that much of the fun is with showing covers. But we don't (really) know freely available sources. JournalTocs Premium offers cover links, yet is not free. With version 0.5 JournalTouch introduces a way to easily download covers. But make sure to read the disclaimer in the admin menu very carefully - you might lack legal rights to use it at all.

## Quick Start
1. Create a free [JournalTocs account](http://www.journaltocs.ac.uk/index.php?action=register). While not strictly required, it is highly recommended.
2. Download JournalTouch (e.g. by clicking "Download ZIP", upper right on this page).
3. Extract to your Apache webfolder. Make sure the data folder and its subfolders are writable by the webserver (e.g. the user/group www-data under Ubuntu).
4. Go to http://myinstallation.net/admin and set enter your JournalTocs mail there (you also should make sure this folder is secured, e.g. by using a htaccess).
5. Edit data/cover/journals.csv (text editor or e.g. Libre Office calc). In a text editor each semicolon represents a column separator. Print-ISSNs must be in column six (five semicolons before), E-ISSN go in column 6 (six semicolons before). There are no column headers, but you can refer to the config.php file and check the $cfg->csv_col variables to see what goes where. Yet, you only really need the ISSNs to get started, although we recommend adding the journal title too, e.g. if it can't be found online.
6. Go again to http://myinstallation.net/admin. Under "Update options" click "Start" and wait. You journals.csv will get updated.
7. Go to http://myinstallation.net/ and be happy
8. IF you are happy, set a cronjob to call http://myinstallation.net/admin/updateTocs.php?optRecent=on&upd=true daily or use http://myinstallation.net/admin/updateTocs.php?optRecent=on&optCovers=on&upd=true if you want to update covers too (Settings menu or release infos for 0.4 for more infos)
  1. Example Cronjob: wget -O - -q -t 1 "http://myinstallation.net/admin/updateTocs.php?optRecent=on&optCovers=on&upd=true" >/dev/null 2>&1

## Translations
- If you want to change translations you can use [Poedit](https://poedit.net/) - it's free.
- As of version 0.4 many thing can be translated in the Settings menu in the admin panel :)

# License
@copyright 2015-2016 MPI for Research on Collective Goods, Library
(Contact: fruehauf@coll.mpg.de and krug@coll.mpg.de)

@author Alexander Krug <krug@coll.mpg.de> (Maintainer)

@author Tobias Zeumer <tzeumer@verweisungsform.de>

@author Daniel Zimmel <dnl@mailbox.org>

License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher

# Dependencies
- PHP 5.3 or newer ([http://www.php.net]), please use the most up-to-date version you have available
- API key for JournalTocs ([http://www.journaltocs.ac.uk])
