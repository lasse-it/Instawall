<?PHP
    include 'config.php';
	$tag = $_GET[tag];
	$input = file_get_contents("https://api.instagram.com/v1/tags/{$tag}/media/recent?access_token={$access_token}");
	$edit = json_decode($input, TRUE);
	$output = $edit['data'];
	print json_encode($output);
?>