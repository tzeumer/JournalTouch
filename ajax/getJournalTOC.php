<?php
/**
 * Query the JournalTOCs RESTful API (XML)
 * Output HTML snippet
 *
 * includes SimpleCart js css classes (see below)
 * CAVEAT: be careful to change the HTML layout (linked to jQuery Selectors)
 * 
 * Time-stamp: "2014-04-10 15:03:26 zimmel"
 *
 * @author Daniel Zimmel <zimmel@coll.mpg.de>
 * @copyright 2014 MPI for Research on Collective Goods, Library
 * @license http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
 */
// do not show system errors, these should be handled in js or below
error_reporting(0);

$config = parse_ini_file('../config/config.ini', TRUE);
$apiUserKey = $config['journaltocs']['apiUserKey'];
// $toAddress = $config['mailer']['toAddress'];
$alink = $config['toc']['alink'];
$issn = $_GET['issn'];

function myget ($query,$xpath) {
  $result=array();

  foreach ($xpath->query($query) as $item) {
    if (!empty($item->nodeValue)) { $result[]=trim($item->nodeValue);} 
  }
	
  switch (sizeof($result)) {
  case 0: return ""; break; // if empty
  case 1: return $result[0]; break; // single
  default: return $result; // multiple
  }
}

$x = "http://www.journaltocs.ac.uk/api/journals/".$issn."?output=articles&user=".$apiUserKey;

$neuDom = new DOMDocument;

$neuDom->load($x);
$xpath = new DOMXPath( $neuDom ); 

$rootNamespace = $neuDom->lookupNamespaceUri($neuDom->namespaceURI); 
$xpath->registerNamespace('x', $rootNamespace); 

/* $xpath->registerNamespace("rdf","http://www.w3.org/1999/02/22-rdf-syntax-ns#"); */
/* $xpath->registerNamespace("prism","http://prismstandard.org/namespaces/1.2/basic/"); */
/* $xpath->registerNamespace("dc","http://purl.org/dc/elements/1.1/"); */
/* $xpath->registerNamespace("mn","http://usefulinc.com/rss/manifest/"); */

// get the title (plain, without vol/no)
// $journalTitle = myget("//x:channel/x:title",$xpath);
// get the title second option (incl. vol/no = snatch from first item & cut pages) (beware!)
$journalTitle = myget("//x:item[1]/dc:source",$xpath);
$journalTitle = preg_replace('/pp\..+/','',$journalTitle);
if (empty($journalTitle)) { $journalTitle = myget("//x:channel/x:title",$xpath); }  // more robust
$records = $xpath->query("//x:item");
$toc = array();
 
foreach ( $records as $item ) {
	$newDom = new DOMDocument;
	$newDom->appendChild($newDom->importNode($item,true));
 
	$xpath = new DOMXPath( $newDom ); 
	$rootNamespace = $newDom->lookupNamespaceUri($newDom->namespaceURI); 
	$xpath->registerNamespace('x', $rootNamespace); 
	$xpath->registerNamespace("dc","http://purl.org/dc/elements/1.1/");

	$title = myget("//x:title",$xpath);
	$link = myget("//x:link",$xpath);
	$source = myget("//dc:source",$xpath);
    $author = myget("//dc:creator",$xpath); // not always good data (2. field is sometimes surname, sometimes second author...)
    /* do some clean up (MIT journals: authors are in brackets, other?) */
    preg_match_all("/\((.*?)\)/", $author, $matches);
    $author = ($matches[1] ? $matches[1] : $author);
    $abstract = myget("//x:description",$xpath);
  
	$toc[] = array(
        'title' => $title, 
        'link' => $link,
        'source' => $source,
        'author' => $author,
        'abstract' => strip_tags($abstract)); // strip any HTML to avoid errors
}
	
if (empty($toc)) {
    /* write something we can read from our caller script */
    echo '<span id="noTOC"/>';
	echo '<div data-alert class="alert-box info"><span id="tocAlertText">No table of contents found! Are you interested in this title?</span>';
    echo '<a class="button radius" href="checkout.php?action=contact&message=The%20table%20of%20contents%20for%20this%20journal%20seems%20to%20be%20missing%20(ISSN:%20'.$issn.')"><i class="fi-comment"></i> Please notify us!</a>';
    echo '</div>';
} else {
	$no_records = count($toc);
	//	echo "<br/>Found " .$no_records . " current articles from <strong>".$journalTitle."</strong>:<br/><br/>";
	echo '<h5>'.$journalTitle.'</h5>';    
// debugging:
//    echo '<h4 style="background-color:yellow">debuggin info: JournalTOCs</h4>';

    foreach ( $toc as $item ) {
        //print "<br>";print_r($item); print "<br>";
        
        if (!empty($item['title'])) {

            echo '<div class="simpleCart_shelfItem row">';

            echo '<div class="small-6 medium-7 large-9 columns textbox">';
            echo '<div class="toctitle">';
            if ($alink == true) {
                echo "<a href=\"".$item['link']."\" class=\"item_name\">";
            } else {
                echo "<span class=\"item_name\">";
            }
            if (is_array($item['author'])) {
                echo (!empty($item['author'][0]) ? $item['author'][0].", " : "") . (!empty($item['author'][1]) ? $item['author'][1].": " :  "");
            } else { 
                echo (!empty($item['author']) ? $item['author'].": " : "");
            }
            if ($alink == true) {
                echo $item['title']."</a>";
            } else {
                echo $item['title']."</span>";
            }
            echo '</div>';
            /* get extra options, set class to invisible (change in css) */
            echo "<span class=\"item_link invisible\">".$item['link']."</span>";
            echo "<span class=\"item_source invisible\">".$item['source']."</span>";
            echo '</div>';
            echo '<div class="small-6 medium-5 large-3 columns buttonbox">';
            /* abstract button: let us assume that strlen>300 == abstract */
            echo (strlen($item['abstract'])>300 ? '<a class="button medium abstract">Abstract</a>&nbsp;' : '');
            /* add button */
            echo "<a class=\"item_add button medium\" href=\"javascript:;\"><i class=\"fi-plus\"></i> </a>&nbsp;";
            echo '</div>';

            echo (!empty($item['abstract']) ? "<div class=\"abstract invisible\"><span>".$item['abstract']."</span></div>" : "");

            echo '</div>';
            
        }
    }


    
    
}


?>

