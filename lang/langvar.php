<?php
// serendipity 2.4-alpha5 -> 2.4-alpha6: moving the mail strings into separate variables
// all the serendipity_langvar_xx files are to be created automatically with this script
// from the serendipity_lang_xx files, so only one set of files has to be taken care of.
// after doing changes in the lang files which affect the strings listed below,
// remove the safety block and run 'php -f langvar.php all' from the console 
// in the /lang directory

// safety block
//exit;

function getDef($line) {
    $matches = array();
    $def = preg_match("#@define\\('([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*)',#", $line, $matches);
    if (empty($matches[1])) { 
        return false;
    }
    return $matches[1];
}

function getVal($line) {
    $matches = array();
    $val = preg_match("#,(.+)\\);#", $line, $matches);
    if (empty($matches[1])) return false;
    return ' ' . trim($matches[1]);
}

function checkIgnore($line) {
    if ( empty($line) || 
        substr($line, 0, 1) == '/' || 
        substr($line, 0, 1) == '#' || 
        substr($line, 0, 5) == '<?php' ||
        substr($line, 0, 2) == '?>' ) { 
            return true;
    } else { return false; }
}

function maillang($dir, $lancode) {
    // load target language
    $tarlang = file_get_contents( $dir . 'serendipity_lang_' . $lancode . '.inc.php');

    if ($tarlang === false) {
        echo "Error: cannot load target file\n";
        exit;
    }

    // explode file into lines
    $tararray = explode("\n", $tarlang);

    // get first definition line
    foreach ($tararray as $key => $value) {
        if ( strpos($value, "@define('LANG_CHARSET',")  !== false ) {
            $tarstart = $key;
            break;
        }
    }

    $mailstrings = array(
        'LANG_CHARSET',
        'CONFIRMATION_MAIL_SUBSCRIPTION',
        'CONFIRMATION_MAIL_TITLE',
        'CONFIRMATION_MAIL_BLOGSUBSCRIPTION',
        'CONFIRMATION_MAIL_ALWAYS',
        'CONFIRMATION_MAIL_ONCE',
        'SUBSCRIPTION_MAIL_INTRO',
        'SUBSCRIPTION_MAIL_OUTRO',
        'SUBSCRIPTION_NEW_ARTICLE',
        'NEW_COMMENT_TO_SUBSCRIBED_ENTRY',
        'SUBSCRIPTION_MAIL',
        'SUBSCRIPTION_TRACKBACK_MAIL',
        'SIGNATURE',
        'A_NEW_COMMENT_BLAHBLAH',
        'A_NEW_TRACKBACK_BLAHBLAH',
        'YOU_HAVE_THESE_OPTIONS',
        'NEW_TRACKBACK_TO',
        'NEW_COMMENT_TO',
        'REQUIRES_REVIEW',
        'LINK_TO_ENTRY',
        'WEBLOG',    
        'LINK_TO_REMOTE_ENTRY',
        'EXCERPT',
        'THIS_TRACKBACK_NEEDS_REVIEW',
        'VIEW_ENTRY',
        'DELETE_TRACKBACK',
        'APPROVE_TRACKBACK',
        'IP_ADDRESS',
        'NAME',
        'EMAIL',
        'HOMEPAGE',
        'REFERER',
        'COMMENTS',
        'THIS_COMMENT_NEEDS_REVIEW',
        'VIEW_COMMENT',
        'DELETE_COMMENT',
        'APPROVE_COMMENT',  
        'YES',
        'NO',
        'VIEW_EXTENDED_ENTRY',
        'POSTED_BY',
        'ON',
        'DATE_FORMAT_SHORT',
        );
    
    $mailkeys = array(
        "    'CHARSET'                           =>",
        "    'CONFIRMATION_MAIL_SUBSCRIPTION'    =>",
        "    'CONFIRMATION_MAIL_TITLE'           =>",
        "    'CONFIRMATION_MAIL_BLOGSUBSCRIPTION'=>",
        "    'CONFIRMATION_MAIL_ALWAYS'          =>",
        "    'CONFIRMATION_MAIL_ONCE'            =>",
        "    'SUBSCRIPTION_MAIL_INTRO'           =>",
        "    'SUBSCRIPTION_MAIL_OUTRO'           =>",
        "    'SUBSCRIPTION_NEW_ARTICLE'          =>",
        "    'NEW_COMMENT_TO_SUBSCRIBED_ENTRY'   =>",
        "    'SUBSCRIPTION_MAIL'                 =>",
        "    'SUBSCRIPTION_TRACKBACK_MAIL'       =>",
        "    'SIGNATURE'                         =>",
        "    'A_NEW_COMMENT_BLAHBLAH'            =>",
        "    'A_NEW_TRACKBACK_BLAHBLAH'          =>",
        "    'YOU_HAVE_THESE_OPTIONS'            =>",
        "    'NEW_TRACKBACK_TO'                  =>",
        "    'NEW_COMMENT_TO'                    =>",
        "    'REQUIRES_REVIEW'                   =>",
        "    'LINK_TO_ENTRY'                     =>",
        "    'WEBLOG'                            =>",    
        "    'LINK_TO_REMOTE_ENTRY'              =>",
        "    'EXCERPT'                           =>",
        "    'THIS_TRACKBACK_NEEDS_REVIEW'       =>",
        "    'VIEW_ENTRY'                        =>",
        "    'DELETE_TRACKBACK'                  =>",
        "    'APPROVE_TRACKBACK'                 =>",
        "    'IP_ADDRESS'                        =>",
        "    'NAME'                              =>",
        "    'EMAIL'                             =>",
        "    'HOMEPAGE'                          =>",
        "    'REFERER'                           =>",
        "    'COMMENTS'                          =>",
        "    'THIS_COMMENT_NEEDS_REVIEW'         =>",
        "    'VIEW_COMMENT'                      =>",
        "    'DELETE_COMMENT'                    =>",
        "    'APPROVE_COMMENT'                   =>",  
        "    'YES'                               =>",
        "    'NO'                                =>",
        "    'VIEW_EXTENDED_ENTRY'               =>",
        "    'POSTED_BY'                         =>",
        "    'ON'                                =>",
        "    'DATE_FORMAT_SHORT'                 =>",
        );
        
    $arr = array_combine($mailstrings, $mailkeys);
    
    $mailarray = array();
    $mailarray[] = '<?php';
    $mailarray[] = '/* EMAIL STRINGS */';
    $mailarray[] = '';
    $mailarray[] = '$serendipity_langvar[\'' . $lancode . '\'] = array(';
    
 
    $tardefs = array();
    for ($i = $tarstart; $i < count($tararray); $i++) {
        $line = $tararray[$i];
        if (checkIgnore($line)) continue;
        if (preg_match("#@define( +)\\(( +)'[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*'( +),#", $value) !== 0 ) {
            echo "line " . ($key + 1) . " contains additional spaces\r\n";
            exit;
        }
        $def = getDef($line, $i);
        if ($def === false) {
            echo "no definition found in line " . ($i + 1) . ": " . $line . "\r\n";
            exit;
        }
        $val = getVal($line, $i);
        if ($val === false) {
            echo "no value found in line " . ($i + 1) . ": " . $line . "\r\n";
            exit;
        }
        
        if (array_key_exists($def, $arr)) {
            $mailarray[] = $arr[$def] . $val . ',';
        }

    }
    
    $mailarray[] = "    );";
    $mailarray[] = '';
    $mailarray[] = "?>";
    $mailarray[] = '';

    file_put_contents( $dir . 'serendipity_langvar_' . $lancode . '.inc.php', implode("\n", $mailarray));
}

// argument = language code of the file to be converted
$lancode = $argv[1];

// process single file
if ($lancode != 'all') {
    if (empty($argv[2])) {
        maillang('', $lancode);
    } elseif ($argv[2] == 'UTF-8') {
        maillang('UTF-8/', $lancode);
    }
} else {
    // batch processing all files in folder
    $d = @opendir('./');

    if (!$d) {
        die('Failure');
    }
        
    while(($file = readdir($d)) !== false) {
        $matches = array();
        preg_match('@serendipity_lang_([a-z]{2}[_]*[A-Z]*)\.inc\.php@', $file, $matches);
        if (empty($matches[1])) continue;     
        echo "syncing language {$matches[1]}\r\n========================\r\n";
        maillang('', $matches[1]);
    }
    
    $d = @opendir('UTF-8');

    if (!$d) {
        die('Failure');
    }

    while(($file = readdir($d)) !== false) {
        $matches = array();
        preg_match('@serendipity_lang_([a-z]{2}[_]*[A-Z]*)\.inc\.php@', $file, $matches);
        if (empty($matches[1])) continue;
        echo "syncing language {$matches[1]}\r\n========================\r\n";
        maillang('UTF-8/', $matches[1]);
    }
}
echo "DONE\r\n";
