<?php

	$query= strip_tags(stripslashes(($_POST['query'])));
	$data = file_get_contents('https://en.wikipedia.org/w/api.php?action=parse&page='.$query.'&prop=wikitext&format=json');
	$data = json_decode($data, true);
	$data = $data['parse']['wikitext']['*'];

	preg_match_all('/^\s*\|\s*mma_([a-z]+)win\s*=\s*(\d*)/m', $data, $matches, PREG_SET_ORDER);

	$wins = array();
	foreach($matches as $match) {
	    $wins[$match[1]] = (int)$match[2];
	}

	$parsedText = "While conventional search engines ranked 
	results by counting how many times the search terms appeared 
	on the page, the two theorized about a better system that analyzed 
	the relationships between websites. They called this new technology
	PageRank; it determined a website's relevance by the number of pages, and 
	the importance of those pages, that linked back to the original site.";

	function sentenceParser($parsedText) {
	    $offset = 0;
	    $arrayCounter = 0;
	    $periodPosition = 0;

	    while (strrpos($parsedText, ".") + 1 !== $offset) {
	    	$periodPosition = strpos($parsedText, ".", $offset);
	    	$parsedTextSentences[$arrayCounter] = substr($parsedText, $offset, $periodPosition);
	    	$offset = $periodPosition + 1;
	        echo "<br/>";
	        echo $parsedTextSentences[$arrayCounter];
	    }
	}

$parsedTextSenteces = sentenceParser($parsedText);
	
?>
<h1>Nick Diaz's Wins</h1>
<table border="1">
    <tr><th>Means</th><th>Wins</th></tr>
    <tr><td>Knockout</td><td><?php echo $wins['ko']; ?></td></tr>
    <tr><td>Submission</td><td><?php echo $wins['sub']; ?></td></tr>
    <tr><td>Decision</td><td><?php echo $wins['dec']; ?></td></tr>
    <tr><td>Disqualification</td><td><?php echo $wins['dq']; ?></td></tr>
    <tr><td>Other</td><td><?php echo $wins['other']; ?></td></tr>
    <tr><td><strong>Total</strong></td><td><strong><?php echo array_sum($wins); ?></strong></td></tr>
</table>