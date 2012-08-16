<?php
	$templateXml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				 	<images>
						####IMAGE_LISTING####
					</images>
					";
					
	$templateImg = "<image>
						<id>####IMAGE_ID####</id>
    					<name>####IMAGE_NAME####</name>
						<path>####IMAGE_PATH####</path>
						<approved>####IMAGE_APPROVED####</approved>
					</image>
					";

	$dbAddress = "cias.rit.edu";
	$username = "nostalgia";
	$password = "miniM3K0dom";
	$database = "nostalgia";
	
	$imageTable = "images";
	$imageId = "ImageID";
	$imageName = "Filename";
	$imagePath = "Filename";
	$imageApproved = "Approved";
	$imageDeleted = "deleted";
	
	$tagsTable = "tags";
	$tagsTable_tagId = "TagID";
	$tagsTable_tagText = "tag_text";
	
	$imageTagTable = "image_tags";
	$imageTagTable_imageId = "ImageID";
	$imageTagTable_tagId = "TagID";
	$imageTagTable_imageTagId = "imageTagID";
	$imageTagTable_weight = "weight";

	$tweetTable = "tweets";
	$tweetTableText = "tweet";
	$tweetTableDate = "tdate";

	$wordTable = "word_list";
	$wordTable_word = "Word";
	$wordTable_wordId = "WordID";
	
	$relationTable = "word_relation"; 
	$relationTable_IDA = "ID_A";
	$relationTable_IDB = "ID_B";

	class twitter_class {

		function twitter_class() {

			$this->realNamePattern = '/\((.*?)\)/';
			$this->searchURL = 'http://search.twitter.com/search.atom?&q=';
			$this->intervalNames = array('second', 'minute', 'hour', 'day', 'week', 'month', 'year');
			$this->intervalSeconds = array( 1, 60, 3600,   86400, 604800, 2630880, 31570560);

			$this->badWords = array('ahole','anus','ash0le','ash0les','asholes',
					'ass','Ass Monkey','Assface','assh0le','assh0lez',
					'asshole','assholes','assholz','asswipe','azzhole',
					'bassterds','bastard','bastards','bastardz',
					'basterds','basterdz','Biatch','bitch','bitches',
					'Blow Job','boffing','butthole','buttwipe',
					'c0ck','c0cks','c0k','Carpet Muncher','cawk',
					'cawks','Clit','cnts','cntz','cock','cockhead',
					'cock-head','cocks','CockSucker','cock-sucker',
					'crap','cum','cunt','cunts','cuntz','dick',
					'dild0','dild0s','dildo','dildos','dilld0',
					'dilld0s','dominatricks','dominatrics',
					'dominatrix','dyke','enema','f u c k',
					'f u c k e r','fag','fag1t','faget','fagg1t',
					'faggit','faggot','fagit','fags','fagz',
					'faig','faigs','fart','flipping the bird',
					'fuck','fucker','fuckin','fucking','fucks',
					'Fudge Packer','fuk','Fukah','Fuken',
					'fuker','Fukin','Fukk','Fukkah','Fukken',
					'Fukker','Fukkin','g00k','gay','gayboy',
					'gaygirl','gays','gayz',
					'God-damned','h00r','h0ar',
					'h0re','hells','hoar','hoor','hoore','jackoff',
					'jap','japs','jerk-off','jisim','jiss','jizm',
					'jizz','knob','knobs','knobz','kunt','kunts',
					'kuntz','Lesbian','Lezzian','Lipshits',
					'Lipshitz','masochist','masokist','massterbait',
					'masstrbait','masstrbate','masterbaiter',
					'masterbate','masterbates','Motha Fucker',
					'Motha Fuker','Motha Fukkah','Motha Fukker',
					'Mother Fucker','Mother Fukah','Mother Fuker',
					'Mother Fukkah','Mother Fukker','mother-fucker',
					'Mutha Fucker','Mutha Fukah','Mutha Fuker',
					'Mutha Fukkah','Mutha Fukker','n1gr','nastt',
					'nigger;','nigur;','niiger;','niigr;','orafis',
					'orgasim;','orgasm','orgasum','oriface','orifice',
					'orifiss','packi','packie','packy','paki',
					'pakie','paky','pecker','peeenus','peeenusss',
					'peenus','peinus','pen1s','penas','penis',
					'penis-breath','penus','penuus','Phuc',
					'Phuck','Phuk','Phuker','Phukker','polac',
					'polack','polak','Poonani','pr1c','pr1ck',
					'pr1k','pusse','pussee','pussy','puuke','puuker',
					'queer','queers','queerz','qweers','qweerz',
					'qweir','recktum','rectum','retard','sadist',
					'scank','schlong','screwing','semen','sex',
					'sexy','Sh!t','sh1t','sh1ter','sh1ts',
					'sh1tter','sh1tz','shit','shits','shitter',
					'Shitty','Shity','shitz','Shyt','Shyte','Shytty',
					'Shyty','skanck','skank','skankee','skankey',
					'skanks','Skanky','slut','sluts','Slutty','slutz',
					'son-of-a-bitch','tit','turd','va1jina','vag1na',
					'vagiina','vagina','vaj1na','vajina','vullva',
					'vulva','w0p','wh00r','wh0re','whore','xrated',
					'xxx','b!+ch','bitch','blowjob','clit','arschloch',
					'fuck','shit','ass','asshole','b!tch','b17ch',
					'b1tch','bastard','bi+ch','boiolas','buceta',
					'c0ck','cawk','chink','cipa','clits','cock','cum',
					'cunt','dildo','dirsa','ejakulate','fatass','fcuk',
					'fuk','fux0r','hoer','hore','jism','kawk','l3itch',
					'l3i+ch','lesbian','masturbate','masterbat*',
					'masterbat3','motherfucker','s.o.b.','mofo','nazi',
					'nigga','nigger','nutsack','phuck','pimpis',
					'pusse','pussy','scrotum','sh!t','shemale','shi+',
					'sh!+','slut','smut','teets','tits','boobs',
					'b00bs','teez','testical','testicle','titt',
					'w00se','jackoff','wank','whoar','whore','*damn',
					'*dyke','*fuck*','*shit*','@$$','amcik',
					'andskota','arse*','assrammer','ayir','bi7ch',
					'bitch*','bollock*','breasts','butt-pirate',
					'cabron','cazzo','chraa','chuj','Cock*','cunt*',
					'd4mn','daygo','dego','dick*','dike*','dupa',
					'dziwka','ejackulate','Ekrem*','Ekto','enculer',
					'faen','fag*','fanculo','fanny','feces','feg',
					'Felcher','ficken','fitt*','Flikker','foreskin',
					'Fotze','Fu(*','fuk*','futkretzn','gay','gook',
					'guiena','h0r','h4x0r','hell','helvete','hoer*',
					'honkey','Huevon','hui','injun','jizz','kanker*',
					'kike','klootzak','kraut','knulle','kuk',
					'kuksuger','Kurac','kurwa','kusi*','kyrpa*',
					'lesbo','mamhoon','masturbat*','merd*','mibun',
					'monkleigh','mouliewop','muie','mulkku','muschi',
					'nazis','nepesaurio','nigger*','orospu','paska*',
					'perse','picka','pierdol*','pillu*','pimmel',
					'piss*','pizda','poontsee','poop','porn','p0rn',
					'pr0n','pula','pule','puta','puto','qahbeh',
					'queef*','rautenberg','schaffer','scheiss*',
					'schlampe','schmuck','screw','sh!t*','sharmuta',
					'sharmute','shipal','shiz','skribz','skurwysyn',
					'sphencter','spic','spierdalaj','splooge','suka',
					'b00b*','testicle*','titt*','twat','vittu','wank*',
					'wetback*','wichser','wop*','yed','zabourah');
		}

		function getTweets($q, $limit=15) {
			$output = '';
			// get the seach result
			$ch= curl_init($this->searchURL . urlencode($q));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
			$response = curl_exec($ch);

			if( $response != false ) {
				$xml = simplexml_load_string($response);
				$output = '';
				$tweets = 0;

				for($i=0; $i<count($xml->entry); $i++) {
					$crtEntry = $xml->entry[$i];
					$account  = $crtEntry->author->uri;
					$image    = $crtEntry->link[1]->attributes()->href;
					$tweet    = str_replace('<a href=', '<a target="_blank" href=', $crtEntry->content);

					// skip tweets containing banned words
					/*$foundBadWord = false;
					
					foreach ($this->badWords as $badWord) {
						if(stristr($tweet, $badWord) !== false) {
							$foundBadWord = true;
							break;
						}
					}

					// skip this tweet containing a banned word
					if ($foundBadWord) {
						continue;
					}*/
					
					// don't process any more tweets if at the limit
					if ($tweets==$limit)
						break;
					$tweets++;

					// name is in this format "acountname (Real Name)"
					preg_match($this->realNamePattern, $crtEntry->author->name, $matches);
					$name = $matches[1];

					// get the time passed between now and the time of tweet, don't allow for negative
					// (future) values that may have occured if server time is wrong

					$time = 'just now';
					$secondsPassed = time() - strtotime($crtEntry->published);

					if ($secondsPassed>0) {
						// see what interval are we in
						for($j = count($this->intervalSeconds)-1; ($j >= 0); $j--) {
							$crtIntervalName = $this->intervalNames[$j];
							$crtInterval = $this->intervalSeconds[$j];
							if ($secondsPassed >= $crtInterval) {
								$value = floor($secondsPassed / $crtInterval);
								if ($value > 1)
									$crtIntervalName .= 's';
								$time = $value . ' ' . $crtIntervalName . ' ago';
								break;
							}
						}
					}

					$output .= '####DELIMITER####' . strip_tags($tweet);
				}
			}

			curl_close($ch);
			return explode('####DELIMITER####', $output);
		}

	}
	
	$dbLink;
	function dbConnect() {
		global $dbLink;
		global $dbAddress, $username, $password, $database;
		if( !$dbLink ) {
			$dbLink = mysql_connect( $dbAddress, $username, $password ) or die( mysql_error() );
		}
		mysql_select_db( $database ) or die( mysql_error() );
	}
	
	function dbClose() {
		mysql_close();
	}
	
	function getImagesWithQuery( $query ) {
		global $imageTable, $imageId, $imageName, $imagePath, $imageApproved;
		global $templateImg, $templateXml;
		$result = mysql_query( $query ) or die( mysql_error() );
		$xmlText = $templateXml;
	
		$count = 0;
		$imgTagFull = "";
		while( $row = mysql_fetch_array( $result ) ) {
			$imgTag = $templateImg;
			$imgTag = str_replace( "####IMAGE_ID####", $row[$imageId], $imgTag, $count );
			$imgTag = str_replace( "####IMAGE_NAME####", $row[$imageName], $imgTag, $count );
			$imgTag = str_replace( "####IMAGE_PATH####", $row[$imagePath], $imgTag, $count );
			$imgTag = str_replace( "####IMAGE_APPROVED####", $row[$imageApproved], $imgTag, $count );
			$imgTagFull = $imgTagFull.$imgTag;
		}
	
		$xmlText = str_replace( "####IMAGE_LISTING####", $imgTagFull, $xmlText, $count );
		return $xmlText;
	}
	
	function writeXML_withAllImages() {
		global $imageTable, $imageId, $imageName, $imagePath, $imageApproved, $imageDeleted;
		$query = "select $imageId, 
						 $imageName, 
						 $imagePath, 
						 $imageApproved 
				  from $imageTable
				  where $imageDeleted is null
				  order by timestamp desc";
		$xmlText = getImagesWithQuery($query);
		echo $xmlText;
	}
	
	function writeXML_withAppImages() {
		global $imageTable, $imageId, $imageName, $imagePath, $imageApproved, $imageDeleted;
		$query = "select $imageId, 
						 $imageName, 
						 $imagePath, 
						 $imageApproved 
				  from $imageTable 
				  where $imageDeleted is null and
				  		$imageApproved = 1
				  order by timestamp desc";
		$xmlText = getImagesWithQuery($query);
		echo $xmlText;
	}

	function writeXML_withNotAppImages() {
		global $imageTable, $imageId, $imageName, $imagePath, $imageApproved, $imageDeleted;
		$query = "select $imageId, 
						 $imageName, 
						 $imagePath, 
						 $imageApproved 
				  from $imageTable 
				  where $imageDeleted is null and 
				  		$imageApproved = 0
				  order by timestamp desc";
		$xmlText = getImagesWithQuery($query);
		echo $xmlText;
	}
	
	function writeXML_singleApproved() {
		global $imageTable, $imageId, $imageName, $imagePath, $imageApproved, $imageDeleted;
		$query = "select $imageId, 
						 $imageName, 
						 $imagePath, 
						 $imageApproved 
				  from $imageTable 
				  where $imageDeleted is null and 
				  		$imageApproved = 1 limit 1";
		$xmlText = getImagesWithQuery($query);
		echo $xmlText;
	}
	
	function writeXML_imageWithId( $id ) {
		global $imageTable, $imageId, $imageName, $imagePath, $imageApproved, $imageDeleted;		
		$query = "select $imageId, 
						 $imageName, 
						 $imagePath, 
						 $imageApproved 
				  from $imageTable 
				  where $imageDeleted is null and
				  		$imageId = $id";
		$xmlText = getImagesWithQuery($query);
		echo $xmlText;
	}
	
	function updateImageInDb( $id, $approvedFlag ) {
		global $imageTable, $imageId, $imageName, $imagePath, $imageApproved, $imageDeleted;
		$query = "update $imageTable 
				  set $imageApproved = $approvedFlag 
				  where $imageId=$id";
		mysql_query( $query ) or die( mysql_error() );
		echo "OK";
	}
	
	function deleteImage( $id ) {
		global $imageTable, $imageId, $imageName, $imagePath, $imageApproved, $imageDeleted;
		$query = "update $imageTable 
				  set $imageDeleted = true 
				  where $imageId=$id";
		mysql_query( $query ) or die( mysql_error() );
		echo "OK";
	}
		
	function checkImageIdTagId( $imageId, $tagId ) {
		global $imageTagTable, $imageTagTable_imageId, $imageTagTable_tagId, $imageTagTable_imageTagId, $imageTagTable_weight;
		
		$query = "select $imageTagTable_imageTagId 
				  from $imageTagTable 
				  where $imageTagTable_imageId = $imageId and 
				  		$imageTagTable_tagId = $tagId";
		$result = mysql_query( $query ) or die( mysql_error() );
		
		$existingImageIdTagId = -1;
		while( $row = mysql_fetch_array( $result ) ) {
			$existingImageIdTagId = $row[$imageTagTable_imageTagId];
		}
		return $existingImageIdTagId;
	}
	
	function getIdForTagText( $tag ) {
		global $tagsTable, $tagsTable_tagId, $tagsTable_tagText;
		
		$query = "select $tagsTable_tagId 
				  from $tagsTable 
				  where $tagsTable_tagText = '$tag'";
		$result = mysql_query( $query ) or die( mysql_error() );
		
		$existingTagId = -1;
		while( $row = mysql_fetch_array( $result ) ) {
			$existingTagId = $row[$tagsTable_tagId];
		}
		return $existingTagId;
	}
	
	function insertTag( $id, $tag ) {
		global $tagsTable, $tagsTable_tagId, $tagsTable_tagText;
		global $imageTagTable, $imageTagTable_imageId, $imageTagTable_tagId, $imageTagTable_imageTagId, $imageTagTable_weight;
				
		// insert into the tag table if the entry doesn't already exist
		$existingTagId = getIdForTagText($tag);
		if( $existingTagId == -1 ) {
			$query = "insert into $tagsTable values(0, '$tag')";
			mysql_query( $query ) or die( mysql_error() );
			$existingTagId = getIdForTagText($tag);
		}
		
		// insert into the image_Tags table if the entry doesn't already exist
		$existingImageIdTagId = checkImageIdTagId( $id, $existingTagId );
		if( $existingImageIdTagId == -1 ) { 
			$query = "insert into $imageTagTable values($id, $existingTagId, 1, 0)";
			mysql_query( $query ) or die( mysql_error() );
		}
		echo "OK";
	}

	function insertTweet( $tweet ) {
		if( $tweet == undefined || $tweet == '' ) {
			return;
		}
		global $tweetTable, $tweetTableText, $tweetTableDate;
		$today = date('Y-m-d');

		// check if tweet is already in table
		$eQuery = "select $tweetTableText from $tweetTable where $tweetTableText like '%$tweet%'";

		// echo $tweet . "<br/>" . $eQuery . " check<br/>";
		
		$eResults = mysql_query($eQuery) or die(mysql_error());

		//echo "result set count : " . mysql_num_rows($eResults) . "<br/>";

		if( mysql_num_rows($eResults) > 0 ) {
			//echo "tweet already exists<br/>";
			return;
		}

		$query = "insert into $tweetTable values('$tweet', $today)";
		// echo $query;
		mysql_query( $query ) or die( mysql_error() );
	}
	
	function getTagFromString ( $tagString ) {
		global $wordTable, $wordTable_word, $tagsTable, $tagsTable_tagText;
		$splittedText = @split(" ", $tagString);
		$theChosenOne = rand(0, count($splittedText)-1);
		$word = $splittedText[$theChosenOne];
		$counter = 0;
		
		while ( strpos($word, '#') != FALSE && $counter < 10 )
		{
			$word = $splittedText[$theChosenOne];
			$theChosenOne = rand(0, count($splittedText)-1);
			$counter = $counter + 1;
		}
		
		$tagID = getIdForTagText($word);
		
		return $tagID;
	}

	function getWordIdFromWord ( $word ) {
		global $wordTable, $wordTable_word, $wordTable_wordId;
		$wID = -1;
		$query = "select $wordTable_wordId 
				  from $wordTable 
				  where $wordTable_word = '$word'";
		echo $query;
		$result = mysql_query( $query ) or die ( mysql_error() );
		
		while ( $row = mysql_fetch_array( $result ) ) {
			$wID = $row[$wordTable_wordId];
		}
		
		return $wID;
	}

	function getWordFromWordId ( $wordId ) {
		global $wordTable, $wordTable_word, $wordTable_wordId;
		$word = "";
		$query = "select $wordTable_word 
				  from $wordTable 
				  where $wordTable_wordId = $wordId";
		$result = mysql_query( $query ) or die ( mysql_error() );
		
		while ( $row = mysql_fetch_array( $result ) ) {
			$word = $row[$wordTable_word];
		}
		
		return $word;
	}
	

	function getRelatedWordId ( $word ) {
		global $relationTable, $relationTable_IDA, $relationTable_IDB;
		$relatedID = -1;

		$wID = getWordIdFromWord( $word );
		
		if ( $wID == -1 )
			return $relatedID;

		$query = "select * 
				  from $relationTable 
				  where $relationTable_IDA = $wID or $relationTable_IDB = $wID";
		$result = mysql_query( $query ) or die (mysql_error());

		$numRows = mysql_num_rows( $result );
		
		if ( $numRows > 0 ) 
		{	
			$theChosenOne = rand ( 0, $numRows-1 );
			while ( $theChosenOne >= 0 )
			{
				$row = mysql_fetch_array( $result );
				$theChosenOne = $theChosenOne - 1;
			}
		
			$relatedID = $row[$relationTable_IDA];
			if ( $relatedID == $wID )
				$relatedID = $row[$relationTable_IDB];	
		}

		echo $relatedID;
		return $relatedID;
	}

	function getRelatedWordIdFromId ( $wordId )
	{
		return getRelatedWordId( getWordFromWordId( $wordId ) );
	}

	function getImagePathFromTagID( $tag ) {
		global $imageTagTable, $imageTagTable_imageId, $imageTagTable_tagId, $imageTagTable_imageTagId, $imageTagTable_weight;
		global $imageTable, $imageId, $imageName, $imagePath, $imageApproved, $imageDeleted;
		$returnPath = "";
		$query = "select *
				 from $imageTagTable
				 where $imageTagTable_tagId = $tag";
		$result = mysql_query( $query ) or die ( mysql_error() );
		
		$imID = -1;
		$totalWeight = 0;
		
		while ( $row = mysql_fetch_array( $result ) )
		{
			$totalWeight = $totalWeight + $row[$imageTagTable_weight];
		}
		
		if ( $totalWeight == 0 ) 
			return $returnPath;
			
		$cWeight = rand( 1, $totalWeight );
		mysql_data_seek( $result, 0 );
		$counter = 0;
		while ( $row = mysql_fetch_array( $result ) && $counter < $cWeight)
		{
			$imID = $row[$imageTagTable_imageTagId];
			$counter = $counter + $row[$imageTagTable_weight];
		}
		
		if ( $imID != -1 )
		{
			$query = "select * 
					 from $imageTable
					 where $imageId = $imID 
					 ORDER BY RAND() LIMIT 0,1;";
			$result = mysql_query( $query ) or die ( mysql_error() );
			
			while ( $row = mysql_fetch_array( $result ) )
			{
					$returnPath = $row[$imagePath];
			}
		}
		return $returnPath;
	}

	function getNewImagePath ($time) {
		global $tweetTable, $tweetTableText, $tweetTableDate, $imageTable;
		
		$timestamp = @date('Y-m-d', $time);
		$returnPath = "";
		$query = "select * from $tweetTable";
						
		$result = mysql_query( $query ) or die ( mysql_error() );
		
		$row = mysql_fetch_array( $result );
		/*
		if ( $row )
		{
			$attempts = 0;
			while ( $returnPath == "" && $attempts < 10 )
			{
				$tweet = $row[$tweetTableText];
				debug($tweet);
				$tagToUse = getTagFromString($tweet);
				debug($tagToUse);
				$tagToUse = strtolower($tagToUse);
				$tagToUse = getRelatedWordIdFromId($tagToUse);
				debug($tagToUse);
				$returnPath = getImagePathFromTagID($tagToUse);
				$attempts = $attempts + 1;

			}
			
			if ( attempts == 10 && $returnPath == "" )
				$returnPath = getRandomImage();
		}
		
		else 
		{
			$returnPath = getRandomImage();
			//$returnPath = getTotallyRandomImageFunction()
		}
		*/
					$returnPath = getRandomImage();

		echo $returnPath;
		//return $returnPath . " HERE";	
	}
	
	function getRandomTweet(){
		global $tweetTable, $tweetTableText;
		
		$returnPath = "";
		$query = "select * from $tweetTable ORDER BY RAND() LIMIT 0,1;";
		
		$result = mysql_query( $query ) or die ( mysql_error() );
		$row = mysql_fetch_array( $result );

			if ( $row )
			{
				$returnPath = $row[$tweetTableText];
			}
			
		echo $returnPath;
	}
	
	function getRandomImage(){
		global $imageTable, $imageName;

		$returnPath = "";

		$query = "select * from $imageTable WHERE Approved =1 ORDER BY RAND() LIMIT 0,1;";
			$result = mysql_query( $query ) or die ( mysql_error() );
			$row = mysql_fetch_array( $result );

			if ( $row )
			{
				$returnPath = $row[$imageName];
			}
			
		return $returnPath;
	
	}
	
	function getSpecificImage($number){
		global $imageTable, $imageName;

		$returnPath = "";

		//$query = "select * from $imageTable WHERE Approved =1 ORDER BY timestamp desc LIMIT $number,1;";
			$query = "select * from $imageTable WHERE Approved =1 ORDER BY RAND() LIMIT 0,1;";

			$result = mysql_query( $query ) or die ( mysql_error() );
			$row = mysql_fetch_array( $result );

			if ( $row )
			{
				$returnPath = $row[$imageName];
			}
			
		return $number;
	}
	
	function fakeReturn($value){
		global $imageTable, $imageName;
		
		$returnPath = "";
		$query = "select * from $imageTable WHERE Approved = 1 ORDER BY timestamp desc LIMIT $value,1;";		
		
		$result = mysql_query( $query ) or die ( mysql_error() );
		$row = mysql_fetch_array( $result );

			if ( $row )
			{
				$returnPath = $row[$imageName];
			}
			
		echo $returnPath;
	
	}
	
	


	$cmd = $_GET["cmd"];
	dbConnect();
	switch( $cmd) {
		case "show_all":
			writeXML_withAllImages();
			break;
		case "get_image":
			getNewImagePath('000:00:00');
			break;
		case "get_x_image":
			fakeReturn($_GET["number"]);
			break;
		case "random_tweet":
			getNewImagePath('000:00:00');
			break;	
		case "show_app":
			writeXML_withAppImages();
			break;
		case "show_napp":
			writeXML_withNotAppImages();
			break;
		case "show_one":
			writeXML_singleApproved();
			break;
		case "update":
			$id = $_GET["id"];
			$approveFlag = $_GET["app_flag"];
			updateImageInDb( $id, $approveFlag );
			break;
		case "get_by_id":
			$id = $_GET["id"];
			writeXML_imageWithId($id);
			break;
		case "ins_tag":
			$id = $_GET["id"];
			$tag = $_GET["tag"];
			insertTag($id, $tag);
			break;
		case "ins_tweet":
			$tweet = $_GET["tweet"];
			insertTweet( $tweet );
			break;
		case "del":
			$id = $_GET["id"];
			deleteImage($id);
			break;
		case "tag_from_string":
			$string = $_GET["string"];
			getTagFromString($string);
			break;
		case "wid_from_word":
			$word = $_GET["word"];
			getWordIdFromWord($word);
			break;
		case "word_from_wid":
			$wID = $_GET["id"];
			getWordFromWordId($wID);
			break;
		case "related":
			$word = $_GET["word"];
			getRelatedWordId($word);
			break;
		case "fetch_tweets":
			$twitter = new twitter_class();
			$q = ' ';
			$output = $twitter->getTweets($q, 10);
			foreach( $output as $o ) {
				echo $o . "<br/>";
				insertTweet( $o );
			}
			echo "OK";
			break;
		default:
			echo $cmd + ": invalid command";
	}
	dbClose();
?>