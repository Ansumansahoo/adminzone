<?php

// Include our composer libraries


// Configure the data store

$dir = __DIR__.'/data';

$config = new \JamesMoss\Flywheel\Config($dir, array(
    'formatter' => new \JamesMoss\Flywheel\Formatter\JSON,
));

$repo = new \JamesMoss\Flywheel\Repository('shouts', $config);

// Store the posted shout data to the data store

if(isset($_POST["name"]) && isset($_POST["comment"])) {

    $name = htmlspecialchars($_POST["name"]);
    $name = str_replace(array("\n", "\r"), '', $name);

    $comment = htmlspecialchars($_POST["comment"]);
    $comment = str_replace(array("\n", "\r"), '', $comment);

    // Storing a new shout

    $shout = new \JamesMoss\Flywheel\Document(array(
        'text' => $comment,
        'name' => $name,
        'createdAt' => time()
    ));

    $repo->store($shout);

}
?>
<?php



// If you want to delete old comments, make this true. We use it to clean up the demo.
$deleteOldComments = false;

// Setting up the data store

$dir = __DIR__.'/data';

$config = new \JamesMoss\Flywheel\Config($dir, array(
    'formatter' => new \JamesMoss\Flywheel\Formatter\JSON,
));

$repo = new \JamesMoss\Flywheel\Repository('shouts', $config);

// Delete comments which are more than 1 hour old if the variable is set to be true.

if($deleteOldComments) {

    $oldShouts = $repo->query()
                ->where('createdAt', '<', strtotime('-1 hour'))
                ->execute();

    foreach($oldShouts as $old) {
        $repo->delete($old->id);
    }

}

// Send the 20 latest shouts as json

$shouts = $repo->query()
        ->orderBy('createdAt ASC')
        ->limit(20,0)
        ->execute();

$results = array();

$config = array(
    'language' => '\RelativeTime\Languages\English',
    'separator' => ', ',
    'suffix' => true,
    'truncate' => 1,
);

$relativeTime = new \RelativeTime\RelativeTime($config);

foreach($shouts as $shout) {
    $shout->timeAgo = $relativeTime->timeAgo($shout->createdAt);
    $results[] = $shout;
}

header('Content-type: application/json');
echo json_encode($results);
?>